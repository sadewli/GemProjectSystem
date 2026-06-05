@extends('layouts.app')

@section('title', 'Companies')

@section('content')
    <div class="p-6 min-h-full">

        @if(session('success'))
            <div class="mb-4 bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm px-4 py-3 rounded-md shadow-sm">
                {{ session('success') }}
            </div>
        @endif
        @if($errors->any())
            <div class="mb-4 bg-red-50 border border-red-200 text-red-800 text-sm px-4 py-3 rounded-md shadow-sm">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- ===== BACK BUTTON ===== --}}
        <div class="mb-4">
            <a href="#"
                class="inline-flex items-center gap-1.5 text-sm text-slate-500 hover:text-slate-800 transition-colors duration-150 group">
                <svg class="w-4 h-4 group-hover:-translate-x-0.5 transition-transform" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Back
            </a>
        </div>

        {{-- ===== HEADER ROW ===== --}}
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-primary-700 tracking-tight">Companies</h1>
            <div class="flex items-center gap-3">
                <button type="button" id="openCreateModal"
                    class="inline-flex items-center gap-2 bg-primary-600 hover:bg-primary-700 text-white text-sm font-semibold px-4 py-2.5 rounded-md shadow-sm transition-all duration-150 active:scale-95">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Create new
                </button>
                <a href="{{ route('crm.companies.import') }}"
                    class="inline-flex items-center gap-2 border border-slate-300 bg-white hover:bg-slate-50 text-slate-700 text-sm font-medium px-4 py-2.5 rounded-md transition-all duration-150">
                    Import Companies
                </a>
            </div>
        </div>

        {{-- ===== FILTER SECTION ===== --}}
        <div class="bg-white rounded-md border border-slate-200 shadow-sm mb-5 p-5">
            <div class="flex items-center gap-2 mb-4">
                <svg class="w-4 h-4 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                </svg>
                <span class="text-sm font-semibold text-primary-600">Filter by</span>
            </div>

            <form method="GET" action="{{ route('crm.companies.index') }}" id="filterForm">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                    {{-- Company Type --}}
                    <div>
                        <label class="block text-xs font-medium text-slate-500 mb-1.5">Company type:</label>
                        <div class="relative" id="companyTypeWrapper">
                            <input type="hidden" name="company_type" id="companyTypeHidden"
                                value="{{ request('company_type') }}">
                            <button type="button" id="companyTypeBtn"
                                class="w-full flex items-center gap-2 pl-3 pr-8 py-2.5 text-sm text-slate-600 border-2 border-slate-200 rounded-md bg-white focus:outline-none focus:border-blue-500 cursor-pointer text-left hover:border-blue-400 transition-colors">
                                <svg class="w-4 h-4 text-slate-400 flex-shrink-0" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                <span id="companyTypeLabel">
                                    @php
                                        $ctMap = [];
                                        foreach ($companyTypes ?? [] as $ct) {
                                            $ctMap[$ct->value] = $ct->company_type;
                                        }
                                        echo request('company_type') ? ($ctMap[request('company_type')] ?? 'Select company type') : 'Select company type';
                                    @endphp
                                </span>
                            </button>
                            <div class="absolute inset-y-0 right-3 flex items-center pointer-events-none">
                                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </div>
                            {{-- Dropdown panel with gap --}}
                            <div id="companyTypePanel"
                                class="hidden absolute z-50 left-0 right-0 mt-2 bg-white border border-slate-200 rounded-md shadow-lg overflow-hidden">
                                <ul id="companyTypeList" class="py-1">
                                    <li class="ct-option flex items-center px-4 py-2.5 text-sm cursor-pointer {{ !request('company_type') ? 'bg-blue-600 text-white font-semibold' : 'text-slate-600 hover:bg-slate-50' }}"
                                        data-value="" data-label="Select company type">Select company type</li>
                                    @foreach($companyTypes ?? [] as $ct)
                                        <li class="ct-option flex items-center px-4 py-2.5 text-sm cursor-pointer {{ request('company_type') === $ct->value ? 'bg-blue-600 text-white font-semibold' : 'text-slate-600 hover:bg-slate-50' }}"
                                            data-value="{{ $ct->value }}" data-label="{{ $ct->company_type }}">
                                            {{ $ct->company_type }}
                                        </li>
                                    @endforeach
                                    <li class="ct-option flex items-center px-4 py-2.5 text-sm cursor-pointer {{ request('company_type') === 'all' ? 'bg-blue-600 text-white font-semibold' : 'text-slate-600 hover:bg-slate-50' }}"
                                        data-value="all" data-label="all">All</li>
                                </ul>
                            </div>

                        </div>
                    </div>

                    {{-- Status --}}
                    <div>
                        <label class="block text-xs font-medium text-slate-500 mb-1.5">Status:</label>
                        <div class="relative" id="statusWrapper">
                            <input type="hidden" name="status" id="statusHidden" value="{{ request('status') }}">
                            <button type="button" id="statusBtn"
                                class="w-full flex items-center gap-2 pl-3 pr-8 py-2.5 text-sm text-slate-600 border-2 border-slate-200 rounded-md bg-white focus:outline-none focus:border-blue-500 cursor-pointer text-left hover:border-blue-400 transition-colors">
                                <svg class="w-4 h-4 text-slate-400 flex-shrink-0" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                        d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                                </svg>
                                <span id="statusLabel">
                                    @php
                                        $stMap = ['active' => 'Active', 'inactive' => 'Inactive', 'pending' => 'Pending'];
                                        echo request('status') ? ($stMap[request('status')] ?? 'Select status') : 'Select status';
                                    @endphp
                                </span>
                            </button>
                            <div class="absolute inset-y-0 right-3 flex items-center pointer-events-none">
                                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </div>
                            <div id="statusPanel"
                                class="hidden absolute z-50 left-0 right-0 mt-2 bg-white border border-slate-200 rounded-md shadow-lg overflow-hidden">
                                <ul id="statusList" class="py-1">
                                    <li class="st-option flex items-center px-4 py-2.5 text-sm cursor-pointer {{ !request('status') ? 'bg-blue-600 text-white font-semibold' : 'text-slate-600 hover:bg-slate-50' }}"
                                        data-value="" data-label="Select status">Select status</li>
                                    <li class="st-option flex items-center px-4 py-2.5 text-sm cursor-pointer {{ request('status') === 'active' ? 'bg-blue-600 text-white font-semibold' : 'text-slate-600 hover:bg-slate-50' }}"
                                        data-value="active" data-label="Active">Active</li>
                                    <li class="st-option flex items-center px-4 py-2.5 text-sm cursor-pointer {{ request('status') === 'inactive' ? 'bg-blue-600 text-white font-semibold' : 'text-slate-600 hover:bg-slate-50' }}"
                                        data-value="inactive" data-label="Inactive">Inactive</li>
                                    <li class="st-option flex items-center px-4 py-2.5 text-sm cursor-pointer {{ request('status') === 'pending' ? 'bg-blue-600 text-white font-semibold' : 'text-slate-600 hover:bg-slate-50' }}"
                                        data-value="pending" data-label="Pending">Pending</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    {{-- Owner + Buttons --}}
                    <div class="flex gap-3">
                        <div class="flex-1">
                            <label class="block text-xs font-medium text-slate-500 mb-1.5">Owner:</label>

                            {{-- Searchable Owner Dropdown --}}
                            <div class="relative" id="ownerDropdownWrapper">

                                {{-- Hidden input that gets submitted with the form --}}
                                <input type="hidden" name="owner" id="ownerHiddenInput" value="{{ request('owner') }}">

                                {{-- Trigger button --}}
                                <button type="button" id="ownerDropdownBtn"
                                    class="w-full flex items-center gap-2 pl-3 pr-8 py-2.5 text-sm text-slate-600 border-2 border-slate-200 rounded-md bg-white focus:outline-none focus:border-blue-500 cursor-pointer text-left hover:border-blue-400 transition-colors">
                                    <svg class="w-4 h-4 text-slate-400 flex-shrink-0" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                            d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                                    </svg>
                                    <span id="ownerDropdownLabel" class="truncate">
                                        @php
                                            $selectedOwnerName = 'Select owner';
                                            if (request('owner')) {
                                                $found = collect($owners ?? [])->firstWhere('id', request('owner'));
                                                if ($found)
                                                    $selectedOwnerName = $found->name;
                                            }
                                        @endphp
                                        {{ $selectedOwnerName }}
                                    </span>
                                </button>

                                {{-- Chevron icon --}}
                                <div class="absolute inset-y-0 right-3 flex items-center pointer-events-none">
                                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7" />
                                    </svg>
                                </div>

                                {{-- Dropdown panel --}}
                                <div id="ownerDropdownPanel"
                                    class="hidden absolute z-50 mt-2 w-full bg-white border border-slate-200 rounded-md shadow-lg overflow-hidden">

                                    {{-- Search box --}}
                                    <div class="p-2 border-b border-slate-100">
                                        <input type="text" id="ownerSearchInput" placeholder="Search owner..."
                                            class="w-full px-3 py-2 text-sm border border-slate-200 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                            autocomplete="off">
                                    </div>

                                    {{-- Options list --}}
                                    <ul id="ownerOptionsList" class="py-1 max-h-48 overflow-y-auto w-full">
                                        @foreach($owners ?? [] as $owner)
                                            <li class="owner-option px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer {{ request('owner') == $owner->id ? 'bg-blue-50 text-blue-700 font-medium' : '' }}"
                                                data-value="{{ $owner->id }}" data-label="{{ $owner->name }}">
                                                {{ $owner->name }}
                                            </li>
                                        @endforeach
                                        <li id="ownerNoResults" class="hidden px-3 py-2 text-sm text-slate-400 italic">
                                            No owners found
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            {{-- End Searchable Owner Dropdown --}}

                        </div>

                        {{-- Reset + Apply --}}
                        <div class="flex items-end gap-2">
                            <a href="{{ route('crm.companies.index') }}" title="Reset filters"
                                class="w-10 h-10 flex items-center justify-center border border-slate-200 rounded-md bg-white text-slate-500 hover:text-primary-600 hover:border-primary-300 transition-all duration-150">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                </svg>
                            </a>
                            <button type="submit"
                                class="px-5 h-10 bg-primary-600 hover:bg-primary-700 text-white text-sm font-semibold rounded-md transition-all duration-150 active:scale-95">
                                Apply
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        {{-- ===== TABLE SECTION ===== --}}
        <div class="bg-white rounded-md border border-slate-200 shadow-sm overflow-hidden">

            {{-- Table Toolbar --}}
            <div class="flex items-center justify-between px-5 py-3.5 border-b border-slate-100">
                <div class="flex items-center gap-3">
                    <button
                        class="inline-flex items-center gap-2 border border-slate-200 text-slate-600 text-sm font-medium px-3.5 py-2 rounded-md hover:bg-slate-50 transition-all duration-150">
                        Manage Columns
                    </button>
                    <button title="Export"
                        class="w-9 h-9 flex items-center justify-center border border-slate-200 rounded-md text-slate-500 hover:bg-slate-50 hover:text-slate-700 transition-all duration-150">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                        </svg>
                    </button>
                </div>

                {{-- Search --}}
                <div class="relative">
                    <input type="text" name="search" form="filterForm" value="{{ request('search') }}"
                        placeholder="Search e.g. name, ref, etc"
                        class="w-64 pl-4 pr-10 py-2 text-sm border border-slate-200 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent placeholder-slate-400">
                    <button type="submit" form="filterForm"
                        class="absolute right-0 top-0 bottom-0 w-10 flex items-center justify-center bg-primary-600 text-white rounded-r-md hover:bg-primary-700 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-4.35-4.35M11 19a8 8 0 100-16 8 8 0 000 16z" />
                        </svg>
                    </button>
                </div>
            </div>

            {{-- Table --}}
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-100">
                            <th class="w-10 px-4 py-3">
                                <input type="checkbox"
                                    class="w-4 h-4 rounded-md border-slate-300 text-primary-600 focus:ring-primary-500 cursor-pointer">
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                Name</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                Reference #</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                Company type</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                Company email</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                Status</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                Owned by</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                Phone number</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                Country</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                State</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                Interactions</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                Inactive days</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($companies ?? [] as $company)
                            <tr class="hover:bg-slate-50 transition-colors duration-100 group">
                                <td class="px-4 py-3.5">
                                    <input type="checkbox"
                                        class="w-4 h-4 rounded-md border-slate-300 text-primary-600 focus:ring-primary-500 cursor-pointer">
                                </td>
                                <td class="px-4 py-3.5">
                                    <a href="#"
                                        class="btn-edit-company font-medium text-primary-600 hover:text-primary-800 hover:underline transition-colors"
                                        data-id="{{ $company->idtbl_create_company }}">
                                        {{ $company->name ?? '--' }}
                                    </a>
                                </td>
                                <td class="px-4 py-3.5 text-slate-600">{{ $company->reference ?? '--' }}</td>
                                <td class="px-4 py-3.5 text-slate-600 capitalize">
                                    {{ $company->company_type ? str_replace('_', ' ', $company->company_type) : '--' }}
                                </td>
                                <td class="px-4 py-3.5 text-slate-600">{{ $company->email ?? '--' }}</td>
                                <td class="px-4 py-3.5">
                                    @if($company->status === 'active')
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-700 border border-emerald-200">
                                            Active
                                        </span>
                                    @elseif($company->status === 'inactive')
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-red-100 text-red-700 border border-red-200">
                                            Inactive
                                        </span>
                                    @elseif($company->status === 'pending')
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-amber-100 text-amber-700 border border-amber-200">
                                            Pending
                                        </span>
                                    @else
                                        <span class="text-slate-400">--</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3.5 text-slate-600">{{ $company->owner?->name ?? '--' }}</td>
                                <td class="px-4 py-3.5 text-slate-600">{{ $company->phone ?? '--' }}</td>
                                <td class="px-4 py-3.5 text-slate-600">{{ $company->country ?? '--' }}</td>
                                <td class="px-4 py-3.5 text-slate-600">{{ $company->state ?? '--' }}</td>
                                <td class="px-4 py-3.5 text-slate-600">{{ $company->interactions_count ?? '--' }}</td>
                                <td class="px-4 py-3.5 text-slate-600">{{ $company->inactive_days ?? '--' }}</td>
                                <td class="px-4 py-3.5 text-slate-600">
                                    <div class="flex items-center gap-2">
                                        <a href="#"
                                            class="btn-edit-company text-slate-400 hover:text-primary-600 transition-colors"
                                            data-id="{{ $company->idtbl_create_company }}" title="Edit">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </a>
                                        <form action="{{ route('crm.companies.destroy', $company->idtbl_create_company) }}"
                                            method="POST"
                                            onsubmit="return confirm('Are you sure you want to delete this company?')"
                                            class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-slate-400 hover:text-red-600 transition-colors"
                                                title="Delete">
                                                <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="13" class="px-4 py-12 text-center">
                                    <div class="flex flex-col items-center gap-3 text-slate-400">
                                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                        </svg>
                                        <p class="text-sm font-medium">No companies found</p>

                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- ===== PAGINATION ===== --}}
            <div class="flex items-center justify-between px-5 py-3.5 border-t border-slate-100 bg-slate-50">
                <div class="flex items-center gap-2 text-sm text-slate-500">
                    <span>Show</span>
                    <select name="per_page" form="filterForm" onchange="document.getElementById('filterForm').submit()"
                        class="border border-slate-200 rounded-md px-2 py-1.5 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-primary-500">
                        <option value="10" {{ request('per_page', 10) == 10 ? 'selected' : '' }}>10</option>
                        <option value="25" {{ request('per_page', 10) == 25 ? 'selected' : '' }}>25</option>
                        <option value="50" {{ request('per_page', 10) == 50 ? 'selected' : '' }}>50</option>
                        <option value="100" {{ request('per_page', 10) == 100 ? 'selected' : '' }}>100</option>
                    </select>
                    <span>Items per page</span>
                </div>

                <div class="text-sm text-slate-500">
                    @if(isset($companies) && method_exists($companies, 'total'))
                        Showing results {{ $companies->firstItem() ?? 0 }} to {{ $companies->lastItem() ?? 0 }} of
                        {{ $companies->total() }} entries
                    @endif
                </div>

                <div class="flex items-center gap-1">
                    @if(isset($companies) && method_exists($companies, 'previousPageUrl'))
                        <a href="{{ $companies->previousPageUrl() }}"
                            class="px-3 py-1.5 text-sm rounded-md {{ $companies->onFirstPage() ? 'text-slate-300 cursor-not-allowed pointer-events-none' : 'text-slate-600 hover:bg-slate-200 transition-colors' }}">
                            Previous
                        </a>

                        @foreach($companies->getUrlRange(1, $companies->lastPage()) as $page => $url)
                                <a href="{{ $url }}" class="w-8 h-8 flex items-center justify-center text-sm rounded-md transition-colors
                                                                                                                                                                                                  {{ $page == $companies->currentPage()
                            ? 'bg-primary-600 text-white font-semibold'
                            : 'text-slate-600 hover:bg-slate-200' }}">
                                    {{ $page }}
                                </a>
                        @endforeach

                        <a href="{{ $companies->nextPageUrl() }}"
                            class="px-3 py-1.5 text-sm rounded-md {{ !$companies->hasMorePages() ? 'text-slate-300 cursor-not-allowed pointer-events-none' : 'text-slate-600 hover:bg-slate-200 transition-colors' }}">
                            Next
                        </a>
                    @endif
                </div>
            </div>
        </div>

    </div>
    {{-- ===== CREATE COMPANY MODAL ===== --}}
    <div id="createCompanyModal" class="fixed inset-0 hidden items-center justify-center"
        style="background:rgba(0,0,0,0.45); z-index:1100;">

        <div class="bg-white rounded-md shadow-2xl w-full max-w-2xl mx-4 flex flex-col" style="max-height:90vh;">

            {{-- Modal Header --}}
            <div class="flex items-center justify-between px-7 pt-6 pb-4 flex-shrink-0">
                <h2 class="text-xl font-bold text-slate-800">Create new company</h2>
                <button type="button" id="closeCreateModal"
                    class="w-8 h-8 flex items-center justify-center rounded-full hover:bg-slate-100 text-slate-400 hover:text-slate-700 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            {{-- Modal Body (scrollable) --}}
            <div class="overflow-y-auto flex-1 px-7 pb-4">
                <form id="createCompanyForm" action="{{ route('crm.companies.store') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="_method" id="formMethodSpoof" value="POST">

                    {{-- ---- Company Information ---- --}}
                    <div class="bg-slate-50 rounded-md px-5 py-3 mb-5">
                        <h3 class="text-sm font-bold text-slate-700">Company information</h3>
                    </div>

                    <div class="grid grid-cols-2 gap-x-5 gap-y-4 mb-5">

                        {{-- Company Name --}}
                        <div>
                            <label class="block text-xs font-medium text-slate-600 mb-1.5">
                                Company name<span class="text-red-500">*</span>:
                            </label>
                            <input type="text" name="name" placeholder="Enter company name"
                                class="w-full px-3 py-2.5 text-sm border border-slate-200 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>

                        {{-- Reference --}}
                        <div>
                            <label class="block text-xs font-medium text-slate-600 mb-1.5">Reference #:</label>
                            <input type="text" name="reference" readonly value="{{ $nextReference ?? 'Comp-101' }}"
                                class="w-full px-3 py-2.5 text-sm border border-slate-200 rounded-md bg-slate-50 text-slate-700 focus:outline-none cursor-default">

                        </div>

                        {{-- Company Type --}}
                        <div>
                            <label class="block text-xs font-medium text-slate-600 mb-1.5">Company type</label>
                            <div class="relative" id="modalCompanyTypeWrapper">
                                <input type="hidden" name="company_type" id="modalCompanyTypeHidden" value="">
                                <button type="button" id="modalCompanyTypeBtn"
                                    class="w-full flex items-center gap-2 pl-3 pr-8 py-2.5 text-sm text-slate-600 border border-slate-200 rounded-md bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 cursor-pointer text-left hover:border-blue-400 transition-colors">
                                    <span id="modalCompanyTypeLabel" class="truncate">All</span>
                                </button>
                                <div class="absolute inset-y-0 right-3 flex items-center pointer-events-none">
                                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7" />
                                    </svg>
                                </div>
                                <div id="modalCompanyTypePanel"
                                    class="hidden absolute z-50 left-0 right-0 mt-2 bg-white border border-slate-200 rounded-md shadow-lg overflow-hidden">
                                    <ul class="py-1 max-h-48 overflow-y-auto">
                                        <li class="modal-option-company_type flex items-center px-4 py-2.5 text-sm cursor-pointer text-slate-600 hover:bg-slate-50 bg-blue-600 text-white font-semibold"
                                            data-value="" data-label="All">All</li>
                                        @foreach($companyTypes ?? [] as $ct)
                                            <li class="modal-option-company_type flex items-center px-4 py-2.5 text-sm cursor-pointer text-slate-600 hover:bg-slate-50"
                                                data-value="{{ $ct->value }}" data-label="{{ $ct->company_type }}">
                                                {{ $ct->company_type }}
                                            </li>
                                        @endforeach

                                    </ul>
                                </div>
                            </div>
                        </div>

                        {{-- Email --}}
                        <div>
                            <label class="block text-xs font-medium text-slate-600 mb-1.5">Email:</label>
                            <input type="email" name="email" placeholder="Enter email"
                                class="w-full px-3 py-2.5 text-sm border border-slate-200 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>

                        {{-- Phone --}}
                        <div>
                            <label class="block text-xs font-medium text-slate-600 mb-1.5">Phone number</label>
                            <div class="flex gap-2">
                                <div class="relative w-32 flex-shrink-0" id="modalPhoneCodeWrapper">
                                    <input type="hidden" name="phone_code" id="modalPhoneCodeHidden" value="+94">
                                    <button type="button" id="modalPhoneCodeBtn"
                                        class="w-full flex items-center gap-2 pl-3 pr-8 py-2.5 text-sm text-slate-600 border border-slate-200 rounded-md bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 cursor-pointer text-left hover:border-blue-400 transition-colors">
                                        <span id="modalPhoneCodeLabel" class="truncate">🇱🇰 +94</span>
                                    </button>
                                    <div class="absolute inset-y-0 right-2 flex items-center pointer-events-none">
                                        <svg class="w-3 h-3 text-slate-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </div>
                                    <div id="modalPhoneCodePanel"
                                        class="hidden absolute z-50 left-0 right-0 mt-2 bg-white border border-slate-200 rounded-md shadow-lg overflow-hidden w-64">
                                        <div class="p-2 border-b border-slate-100">
                                            <input type="text" id="modalPhoneCodeSearch" placeholder="Search..."
                                                class="w-full px-3 py-2 text-sm border border-slate-200 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                                autocomplete="off">
                                        </div>
                                        <ul id="modalPhoneCodeList" class="py-1 max-h-48 overflow-y-auto w-full">
                                            @foreach($phoneCodes ?? [] as $pc)
                                                <li class="modal-option-phone_code flex items-center px-4 py-2.5 text-sm cursor-pointer {{ $pc->phone_code === '+94' ? 'bg-blue-600 text-white font-semibold' : 'text-slate-600 hover:bg-slate-50' }}"
                                                    data-value="{{ $pc->phone_code }}"
                                                    data-label="{{ $pc->flag_emoji }} {{ $pc->phone_code }}">
                                                    {{ $pc->flag_emoji }} {{ $pc->phone_code }} ({{ $pc->country_name }})
                                                </li>
                                            @endforeach
                                            <li class="hidden px-4 py-2.5 text-sm text-slate-400 italic no-results">No
                                                results found</li>
                                        </ul>
                                    </div>
                                </div>
                                <input type="text" name="phone" placeholder="Phone"
                                    class="flex-1 px-3 py-2.5 text-sm border border-slate-200 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            </div>
                        </div>

                        {{-- Profile Image --}}
                        <div class="col-span-2">
                            <label class="block text-xs font-medium text-slate-600 mb-1.5">
                                Profile image:
                                <span class="text-slate-400 font-normal">
                                    (Max file size is 1MB)
                                </span>
                            </label>
                            <input type="file" name="profile_image" accept="image/*"
                                class="w-full text-sm text-slate-500 border border-slate-200 rounded-md file:mr-3 file:py-2 file:px-3 file:rounded-l-md file:border-0 file:text-sm file:font-medium file:bg-slate-100 file:text-slate-700 hover:file:bg-slate-200 cursor-pointer">
                        </div>

                        {{-- Website (full width) --}}
                        <div class="col-span-2">
                            <label class="block text-xs font-medium text-slate-600 mb-1.5">Website</label>
                            <input type="url" name="website" placeholder="Enter website URL"
                                class="w-full px-3 py-2.5 text-sm border border-slate-200 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>

                        {{-- Status (hidden, default active) --}}
                        <input type="hidden" name="status" value="active">

                    </div>

                    {{-- ---- Address ---- --}}
                    <div class="bg-slate-50 rounded-md px-5 py-3 mb-5">
                        <h3 class="text-sm font-bold text-slate-700">Address</h3>
                    </div>

                    <div class="grid grid-cols-2 gap-x-5 gap-y-4 mb-4">

                        <div>
                            <label class="block text-xs font-medium text-slate-600 mb-1.5">Attention:</label>
                            <input type="text" name="attention" placeholder="Enter attention"
                                class="w-full px-3 py-2.5 text-sm border border-slate-200 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>

                        <div>
                            <label class="block text-xs font-medium text-slate-600 mb-1.5">Address (line 1):</label>
                            <input type="text" name="address_line1" placeholder="Add address line 1"
                                class="w-full px-3 py-2.5 text-sm border border-slate-200 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>

                        <div>
                            <label class="block text-xs font-medium text-slate-600 mb-1.5">Address (line 2):</label>
                            <input type="text" name="address_line2" placeholder="Add address line 2"
                                class="w-full px-3 py-2.5 text-sm border border-slate-200 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>

                        <div>
                            <label class="block text-xs font-medium text-slate-600 mb-1.5">Address (line 3):</label>
                            <input type="text" name="address_line3" placeholder="Add address line 3"
                                class="w-full px-3 py-2.5 text-sm border border-slate-200 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>

                        <div>
                            <label class="block text-xs font-medium text-slate-600 mb-1.5">Country:</label>
                            <div class="relative" id="modalCountryWrapper">
                                <input type="hidden" name="country" id="modalCountryHidden" value="">
                                <button type="button" id="modalCountryBtn"
                                    class="w-full flex items-center gap-2 pl-3 pr-8 py-2.5 text-sm text-slate-600 border border-slate-200 rounded-md bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 cursor-pointer text-left hover:border-blue-400 transition-colors">
                                    <span id="modalCountryLabel" class="truncate">Choose country</span>
                                </button>
                                <div class="absolute inset-y-0 right-3 flex items-center pointer-events-none">
                                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7" />
                                    </svg>
                                </div>
                                <div id="modalCountryPanel"
                                    class="hidden absolute z-50 left-0 right-0 mt-2 bg-white border border-slate-200 rounded-md shadow-lg overflow-hidden">
                                    <div class="p-2 border-b border-slate-100">
                                        <input type="text" id="modalCountrySearch" placeholder="Search..."
                                            class="w-full px-3 py-2 text-sm border border-slate-200 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                            autocomplete="off">
                                    </div>
                                    <ul id="modalCountryList" class="py-1 max-h-48 overflow-y-auto">
                                        <li class="modal-option-country flex items-center px-4 py-2.5 text-sm cursor-pointer text-slate-600 hover:bg-slate-50 bg-blue-600 text-white font-semibold"
                                            data-value="" data-label="Choose country">Choose country</li>
                                        @foreach($countries ?? [] as $co)
                                            <li class="modal-option-country flex items-center px-4 py-2.5 text-sm cursor-pointer text-slate-600 hover:bg-slate-50"
                                                data-value="{{ $co->value }}" data-label="{{ $co->country_name }}">
                                                {{ $co->country_name }}
                                            </li>
                                        @endforeach
                                        <li class="hidden px-4 py-2.5 text-sm text-slate-400 italic no-results">No results
                                            found</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-medium text-slate-600 mb-1.5">State:</label>
                            <div class="relative" id="modalStateWrapper">
                                <input type="hidden" name="state" id="modalStateHidden" value="">
                                <button type="button" id="modalStateBtn"
                                    class="w-full flex items-center gap-2 pl-3 pr-8 py-2.5 text-sm text-slate-600 border border-slate-200 rounded-md bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 cursor-pointer text-left hover:border-blue-400 transition-colors">
                                    <span id="modalStateLabel" class="truncate">Choose state</span>
                                </button>
                                <div class="absolute inset-y-0 right-3 flex items-center pointer-events-none">
                                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7" />
                                    </svg>
                                </div>
                                <div id="modalStatePanel"
                                    class="hidden absolute z-50 left-0 right-0 mt-2 bg-white border border-slate-200 rounded-md shadow-lg overflow-hidden">
                                    <div class="p-2 border-b border-slate-100">
                                        <input type="text" id="modalStateSearch" placeholder="Search..."
                                            class="w-full px-3 py-2 text-sm border border-slate-200 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                            autocomplete="off">
                                    </div>
                                    <ul id="modalStateList" class="py-1 max-h-48 overflow-y-auto">
                                        <li class="modal-option-state flex items-center px-4 py-2.5 text-sm cursor-pointer text-slate-600 hover:bg-slate-50 bg-blue-600 text-white font-semibold"
                                            data-value="" data-label="Choose state">Choose state</li>
                                        @foreach($states ?? [] as $st)
                                            <li class="modal-option-state flex items-center px-4 py-2.5 text-sm cursor-pointer text-slate-600 hover:bg-slate-50"
                                                data-value="{{ $st->value }}" data-label="{{ $st->state_name }}"
                                                data-country="{{ $st->country->value ?? '' }}">{{ $st->state_name }}</li>
                                        @endforeach
                                        <li class="hidden px-4 py-2.5 text-sm text-slate-400 italic no-results">No results
                                            found</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-medium text-slate-600 mb-1.5">Postal code:</label>
                            <input type="text" name="postal_code" placeholder="Add postal code"
                                class="w-full px-3 py-2.5 text-sm border border-slate-200 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>

                        <div class="flex items-center gap-2 pt-5">
                            <input type="checkbox" id="useDeliveryAddress" name="use_delivery_address"
                                class="w-4 h-4 rounded-md border-slate-300 text-blue-600 cursor-pointer">
                            <label for="useDeliveryAddress" class="text-sm font-semibold text-slate-700 cursor-pointer">
                                Use as delivery address
                            </label>
                        </div>

                    </div>

                    {{-- Delivery Address (hidden until checkbox ticked) --}}
                    <div id="deliveryAddressSection" class="hidden mb-5">
                        <div class="border-t border-slate-100 my-4"></div>
                        <div class="grid grid-cols-2 gap-x-5 gap-y-4">

                            <div>
                                <label class="block text-xs font-medium text-slate-600 mb-1.5">Attention:</label>
                                <input type="text" name="del_attention" placeholder="Enter attention"
                                    class="w-full px-3 py-2.5 text-sm border border-slate-200 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-slate-600 mb-1.5">Address (line 1):</label>
                                <input type="text" name="del_address_line1" placeholder="Add address line 1"
                                    class="w-full px-3 py-2.5 text-sm border border-slate-200 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-slate-600 mb-1.5">Address (line 2):</label>
                                <input type="text" name="del_address_line2" placeholder="Add address line 2"
                                    class="w-full px-3 py-2.5 text-sm border border-slate-200 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-slate-600 mb-1.5">Address (line 3):</label>
                                <input type="text" name="del_address_line3" placeholder="Add address line 3"
                                    class="w-full px-3 py-2.5 text-sm border border-slate-200 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-slate-600 mb-1.5">Country:</label>
                                <div class="relative" id="modalDelCountryWrapper">
                                    <input type="hidden" name="del_country" id="modalDelCountryHidden" value="">
                                    <button type="button" id="modalDelCountryBtn"
                                        class="w-full flex items-center gap-2 pl-3 pr-8 py-2.5 text-sm text-slate-600 border border-slate-200 rounded-md bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 cursor-pointer text-left hover:border-blue-400 transition-colors">
                                        <span id="modalDelCountryLabel" class="truncate">Choose country</span>
                                    </button>
                                    <div class="absolute inset-y-0 right-3 flex items-center pointer-events-none">
                                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </div>
                                    <div id="modalDelCountryPanel"
                                        class="hidden absolute z-50 left-0 right-0 mt-2 bg-white border border-slate-200 rounded-md shadow-lg overflow-hidden">
                                        <div class="p-2 border-b border-slate-100">
                                            <input type="text" id="modalDelCountrySearch" placeholder="Search..."
                                                class="w-full px-3 py-2 text-sm border border-slate-200 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                                autocomplete="off">
                                        </div>
                                        <ul id="modalDelCountryList" class="py-1 max-h-48 overflow-y-auto w-full">
                                            <li class="modal-option-country px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer text-slate-400 italic"
                                                data-value="" data-label="Choose country">Choose country</li>
                                            @foreach($countries ?? [] as $co)
                                                <li class="modal-option-country px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer"
                                                    data-value="{{ $co->value }}" data-label="{{ $co->country_name }}">
                                                    {{ $co->country_name }}
                                                </li>
                                            @endforeach
                                            <li class="hidden px-3 py-2 text-sm text-slate-400 italic no-results">No
                                                results
                                                found</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-slate-600 mb-1.5">State:</label>
                                <div class="relative" id="modalDelStateWrapper">
                                    <input type="hidden" name="del_state" id="modalDelStateHidden" value="">
                                    <button type="button" id="modalDelStateBtn"
                                        class="w-full flex items-center gap-2 pl-3 pr-8 py-2.5 text-sm text-slate-600 border border-slate-200 rounded-md bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 cursor-pointer text-left hover:border-blue-400 transition-colors">
                                        <span id="modalDelStateLabel" class="truncate">Choose state</span>
                                    </button>
                                    <div class="absolute inset-y-0 right-3 flex items-center pointer-events-none">
                                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </div>
                                    <div id="modalDelStatePanel"
                                        class="hidden absolute z-50 left-0 right-0 mt-2 bg-white border border-slate-200 rounded-md shadow-lg overflow-hidden">
                                        <div class="p-2 border-b border-slate-100">
                                            <input type="text" id="modalDelStateSearch" placeholder="Search..."
                                                class="w-full px-3 py-2 text-sm border border-slate-200 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                                autocomplete="off">
                                        </div>
                                        <ul id="modalDelStateList" class="py-1 max-h-48 overflow-y-auto">
                                            <li class="modal-option-del_state flex items-center px-4 py-2.5 text-sm cursor-pointer text-slate-600 hover:bg-slate-50 bg-blue-600 text-white font-semibold"
                                                data-value="" data-label="Choose state">Choose state</li>
                                            @foreach($states ?? [] as $st)
                                                <li class="modal-option-del_state flex items-center px-4 py-2.5 text-sm cursor-pointer text-slate-600 hover:bg-slate-50"
                                                    data-value="{{ $st->value }}" data-label="{{ $st->state_name }}"
                                                    data-country="{{ $st->country->value ?? '' }}">{{ $st->state_name }}</li>
                                            @endforeach
                                            <li class="hidden px-4 py-2.5 text-sm text-slate-400 italic no-results">No
                                                results found</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-slate-600 mb-1.5">Postal code:</label>
                                <input type="text" name="del_postal_code" placeholder="Add postal code"
                                    class="w-full px-3 py-2.5 text-sm border border-slate-200 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            </div>

                        </div>
                    </div>

                    {{-- ---- People (contacts) ---- --}}
                    <div class="bg-slate-50 rounded-md px-5 py-3 mb-5 flex items-center justify-between">
                        <h3 class="text-sm font-bold text-slate-700">People (contacts)</h3>
                        <button type="button" id="addContactBtn"
                            class="text-xs font-medium px-3 py-1.5 border border-slate-300 rounded-md bg-white hover:bg-slate-50 text-slate-700 transition-colors">
                            Add contact
                        </button>
                    </div>

                    <div id="contactsContainer">
                        {{-- First contact row --}}
                        <div class="contact-row grid grid-cols-2 gap-x-5 gap-y-4 mb-4">
                            <div>
                                <label class="block text-xs font-medium text-slate-600 mb-1.5">First name:</label>
                                <input type="text" name="contacts[0][first_name]" placeholder="Add first name"
                                    class="w-full px-3 py-2.5 text-sm border border-slate-200 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-slate-600 mb-1.5">Last name:</label>
                                <input type="text" name="contacts[0][last_name]" placeholder="Add last name"
                                    class="w-full px-3 py-2.5 text-sm border border-slate-200 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-slate-600 mb-1.5">Email:</label>
                                <input type="email" name="contacts[0][email]" placeholder="Add email"
                                    class="w-full px-3 py-2.5 text-sm border border-slate-200 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-slate-600 mb-1.5">Role:</label>
                                <div class="relative" id="modalContacts0RoleWrapper">
                                    <input type="hidden" name="contacts[0][role]" id="modalContacts0RoleHidden" value="">
                                    <button type="button" id="modalContacts0RoleBtn"
                                        class="w-full flex items-center gap-2 pl-3 pr-8 py-2.5 text-sm text-slate-600 border border-slate-200 rounded-md bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 cursor-pointer text-left hover:border-blue-400 transition-colors">
                                        <span id="modalContacts0RoleLabel" class="truncate">Select role</span>
                                    </button>
                                    <div class="absolute inset-y-0 right-3 flex items-center pointer-events-none">
                                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </div>
                                    <div id="modalContacts0RolePanel"
                                        class="hidden absolute z-50 left-0 right-0 mt-2 bg-white border border-slate-200 rounded-md shadow-lg overflow-hidden">
                                        <ul class="py-1 max-h-48 overflow-y-auto">
                                            <li class="modal-option-contacts0role flex items-center px-4 py-2.5 text-sm cursor-pointer text-slate-600 hover:bg-slate-50 bg-blue-600 text-white font-semibold"
                                                data-value="" data-label="Select role">Select role</li>
                                            @foreach($roles ?? [] as $role)
                                                <li class="modal-option-contacts0role flex items-center px-4 py-2.5 text-sm cursor-pointer text-slate-600 hover:bg-slate-50"
                                                    data-value="{{ $role->value }}" data-label="{{ $role->role_name }}">
                                                    {{ $role->role_name }}
                                                </li>
                                            @endforeach

                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-span-2 flex items-center gap-2">
                                <input type="checkbox" id="primaryContact0" name="contacts[0][primary]"
                                    class="w-4 h-4 rounded-md border-slate-300 text-blue-600 cursor-pointer">
                                <label for="primaryContact0" class="text-sm font-bold text-slate-700 cursor-pointer">
                                    Primary contact
                                </label>
                            </div>
                        </div>
                    </div>

                </form>
            </div>

            {{-- Modal Footer --}}
            <div class="flex items-center justify-between px-7 py-4 border-t border-slate-100 flex-shrink-0">
                <button type="button" id="cancelCreateModal"
                    class="px-5 py-2.5 text-sm font-medium text-red-600 border border-red-300 rounded-md hover:bg-red-50 transition-colors">
                    Cancel
                </button>
                <div class="flex items-center gap-3">
                    <button type="button" id="createAndAddAnother"
                        class="px-5 py-2.5 text-sm font-medium text-slate-700 border border-slate-300 rounded-md bg-white hover:bg-slate-50 transition-colors">
                        Create and add another
                    </button>
                    <button type="button" id="createCompanyBtn"
                        class="px-6 py-2.5 text-sm font-semibold text-white bg-blue-600 hover:bg-blue-700 rounded-md shadow-sm transition-colors">
                        Create
                    </button>
                </div>
            </div>

        </div>
    </div>
    {{-- ===== END CREATE COMPANY MODAL ===== --}}
@endsection

@section('script')
    <script>

        // Global dropdown prefill helper
        function setDropdownValueBySelector(cleanName, value, optionClass) {
            const hidden = document.getElementById('modal' + cleanName + 'Hidden');
            const label = document.getElementById('modal' + cleanName + 'Label');
            if (hidden) {
                hidden.value = value;
                hidden.dispatchEvent(new Event('change'));
            }
            if (label) {
                const panel = document.getElementById('modal' + cleanName + 'Panel');
                const option = panel ? panel.querySelector('li.' + optionClass + '[data-value="' + value + '"]') : null;
                label.textContent = option ? option.getAttribute('data-label') : (value || (cleanName.includes('Country') ? 'Choose country' : (cleanName.includes('State') ? 'Choose state' : 'All')));
            }
        }

        // ===== Create/Edit Company Modal =====
        (function () {
            const modal = document.getElementById('createCompanyModal');
            const openBtn = document.getElementById('openCreateModal');
            const closeBtn = document.getElementById('closeCreateModal');
            const cancelBtn = document.getElementById('cancelCreateModal');
            const createBtn = document.getElementById('createCompanyBtn');
            const createAddBtn = document.getElementById('createAndAddAnother');
            const form = document.getElementById('createCompanyForm');
            const deliveryCb = document.getElementById('useDeliveryAddress');
            const deliverySec = document.getElementById('deliveryAddressSection');
            const addContactBtn = document.getElementById('addContactBtn');
            const contactsCont = document.getElementById('contactsContainer');

            let contactIndex = 1;
            const roles = @json($roles ?? []);

            function openModal() {
                modal.classList.remove('hidden');
                modal.classList.add('flex');
                document.body.style.overflow = 'hidden';
            }

            function closeModal() {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
                document.body.style.overflow = '';
            }

            function addContactRow(values = null) {
                const idx = contactIndex++;

                let roleOptionsHtml = `<li class="modal-option-contacts${idx}role flex items-center px-4 py-2.5 text-sm cursor-pointer text-slate-600 hover:bg-slate-50 bg-blue-600 text-white font-semibold" data-value="" data-label="Select role">Select role</li>`;
                roles.forEach(function (role) {
                    roleOptionsHtml += `<li class="modal-option-contacts${idx}role flex items-center px-4 py-2.5 text-sm cursor-pointer text-slate-600 hover:bg-slate-50" data-value="${role.value}" data-label="${role.role_name}">${role.role_name}</li>`;
                });

                const row = document.createElement('div');
                row.className = 'contact-row grid grid-cols-2 gap-x-5 gap-y-4 mb-4 pt-4 border-t border-slate-100';
                row.innerHTML = `
                        <div>
                            <label class="block text-xs font-medium text-slate-600 mb-1.5">First name:</label>
                            <input type="text" name="contacts[${idx}][first_name]" placeholder="Add first name"
                                   value="${values ? (values.first_name || '') : ''}"
                                   class="w-full px-3 py-2.5 text-sm border border-slate-200 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-slate-600 mb-1.5">Last name:</label>
                            <input type="text" name="contacts[${idx}][last_name]" placeholder="Add last name"
                                   value="${values ? (values.last_name || '') : ''}"
                                   class="w-full px-3 py-2.5 text-sm border border-slate-200 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-slate-600 mb-1.5">Email:</label>
                            <input type="email" name="contacts[${idx}][email]" placeholder="Add email"
                                   value="${values ? (values.email || '') : ''}"
                                   class="w-full px-3 py-2.5 text-sm border border-slate-200 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                        <div>
                            <div class="relative" id="modalContacts${idx}RoleWrapper">
                                <input type="hidden" name="contacts[${idx}][role]" id="modalContacts${idx}RoleHidden" value="${values ? (values.role || '') : ''}">
                                <button type="button" id="modalContacts${idx}RoleBtn"
                                        class="w-full flex items-center gap-2 pl-3 pr-8 py-2.5 text-sm text-slate-600 border border-slate-200 rounded-md bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 cursor-pointer text-left hover:border-blue-400 transition-colors">
                                    <span id="modalContacts${idx}RoleLabel" class="truncate">Select role</span>
                                </button>
                                <div class="absolute inset-y-0 right-3 flex items-center pointer-events-none">
                                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                    </svg>
                                </div>
                                <div id="modalContacts${idx}RolePanel"
                                     class="hidden absolute z-50 left-0 right-0 mt-2 bg-white border border-slate-200 rounded-md shadow-lg overflow-hidden">
                                    <ul class="py-1 max-h-48 overflow-y-auto">
                                        ${roleOptionsHtml}
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-span-2 flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <input type="checkbox" id="primaryContact${idx}" name="contacts[${idx}][primary]"
                                       ${values && values.primary ? 'checked' : ''}
                                       class="w-4 h-4 rounded-md border-slate-300 text-blue-600 cursor-pointer">
                                <label for="primaryContact${idx}" class="text-sm font-bold text-slate-700 cursor-pointer">
                                    Primary contact
                                </label>
                            </div>
                            <button type="button" onclick="this.closest('.contact-row').remove()"
                                    class="text-xs text-red-500 hover:text-red-700 font-medium">Remove</button>
                        </div>`;
                if (contactsCont) contactsCont.appendChild(row);

                // Initialize role dropdown label text
                if (values && values.role) {
                    const rFound = roles.find(r => r.value === values.role);
                    const labelSpan = document.getElementById(`modalContacts${idx}RoleLabel`);
                    if (labelSpan) labelSpan.textContent = rFound ? rFound.role_name : values.role;
                }

                // Initialize the new dropdown
                if (window.setupModalSimpleDropdown) {
                    window.setupModalSimpleDropdown('contacts[' + idx + '][role]', 'Contacts' + idx + 'Role', 'modal-option-contacts' + idx + 'role');
                }
            }

            function resetFormForCreate() {
                form.reset();
                if (deliverySec) deliverySec.classList.add('hidden');

                document.querySelector('#createCompanyModal h2').textContent = 'Create new company';
                form.setAttribute('action', '{{ route("crm.companies.store") }}');
                document.getElementById('formMethodSpoof').value = 'POST';
                createBtn.textContent = 'Create';
                if (createAddBtn) createAddBtn.classList.remove('hidden');

                // Reset dropdown values to default
                setDropdownValueBySelector('CompanyType', '', 'modal-option-company_type');
                setDropdownValueBySelector('PhoneCode', '+94', 'modal-option-phone_code');
                setDropdownValueBySelector('Country', '', 'modal-option-country');
                setDropdownValueBySelector('State', '', 'modal-option-state');
                setDropdownValueBySelector('DelCountry', '', 'modal-option-country');
                setDropdownValueBySelector('DelState', '', 'modal-option-del_state');

                // Restore nextReference
                form.querySelector('input[name="reference"]').value = '{{ $nextReference ?? "Comp-101" }}';

                // Clear extra contact rows and add one blank row
                if (contactsCont) {
                    const rows = contactsCont.querySelectorAll('.contact-row');
                    rows.forEach(r => r.remove());
                }
                contactIndex = 0;
                addContactRow();
            }

            if (openBtn) {
                openBtn.addEventListener('click', function () {
                    resetFormForCreate();
                    openModal();
                });
            }
            if (closeBtn) closeBtn.addEventListener('click', closeModal);
            if (cancelBtn) cancelBtn.addEventListener('click', closeModal);

            // Close on backdrop click
            modal.addEventListener('click', function (e) {
                if (e.target === modal) closeModal();
            });

            // Close on Escape
            document.addEventListener('keydown', function (e) {
                if (e.key === 'Escape' && !modal.classList.contains('hidden')) closeModal();
            });

            // Toggle delivery address
            if (deliveryCb) {
                deliveryCb.addEventListener('change', function () {
                    if (deliverySec) deliverySec.classList.toggle('hidden', !this.checked);
                });
            }

            // Add contact row button
            if (addContactBtn) {
                addContactBtn.addEventListener('click', function () {
                    addContactRow();
                });
            }

            // Create (submit form normally)
            if (createBtn) {
                createBtn.addEventListener('click', function () {
                    form.submit();
                });
            }

            // Create and add another (submit then reopen)
            if (createAddBtn) {
                createAddBtn.addEventListener('click', function () {
                    let flag = document.createElement('input');
                    flag.type = 'hidden';
                    flag.name = 'add_another';
                    flag.value = '1';
                    form.appendChild(flag);
                    form.submit();
                });
            }

            // Edit trigger
            document.addEventListener('click', function (e) {
                const editBtn = e.target.closest('.btn-edit-company');
                if (!editBtn) return;
                e.preventDefault();

                const id = editBtn.getAttribute('data-id');
                fetch('/crm/companies/' + id)
                    .then(res => res.json())
                    .then(company => {
                        // Re-label modal and action
                        document.querySelector('#createCompanyModal h2').textContent = 'Edit company';
                        form.setAttribute('action', '/crm/companies/' + company.idtbl_create_company);
                        document.getElementById('formMethodSpoof').value = 'PUT';
                        createBtn.textContent = 'Save Changes';
                        if (createAddBtn) createAddBtn.classList.add('hidden');

                        // Prefill text inputs
                        form.querySelector('input[name="name"]').value = company.name || '';
                        form.querySelector('input[name="reference"]').value = company.reference || '';
                        form.querySelector('input[name="email"]').value = company.email || '';
                        form.querySelector('input[name="phone"]').value = company.phone || '';
                        form.querySelector('input[name="website"]').value = company.website || '';
                        form.querySelector('input[name="attention"]').value = company.attention || '';
                        form.querySelector('input[name="address_line1"]').value = company.address_line1 || '';
                        form.querySelector('input[name="address_line2"]').value = company.address_line2 || '';
                        form.querySelector('input[name="address_line3"]').value = company.address_line3 || '';
                        form.querySelector('input[name="postal_code"]').value = company.postal_code || '';

                        // Prefill delivery inputs
                        form.querySelector('input[name="del_attention"]').value = company.del_attention || '';
                        form.querySelector('input[name="del_address_line1"]').value = company.del_address_line1 || '';
                        form.querySelector('input[name="del_address_line2"]').value = company.del_address_line2 || '';
                        form.querySelector('input[name="del_address_line3"]').value = company.del_address_line3 || '';
                        form.querySelector('input[name="del_postal_code"]').value = company.del_postal_code || '';

                        // Checkboxes
                        deliveryCb.checked = !!company.use_delivery_address;
                        deliverySec.classList.toggle('hidden', !deliveryCb.checked);

                        // Dropdowns
                        setDropdownValueBySelector('CompanyType', company.company_type || '', 'modal-option-company_type');
                        setDropdownValueBySelector('PhoneCode', company.phone_code || '+94', 'modal-option-phone_code');
                        setDropdownValueBySelector('Country', company.country || '', 'modal-option-country');
                        setDropdownValueBySelector('State', company.state || '', 'modal-option-state');
                        setDropdownValueBySelector('DelCountry', company.del_country || '', 'modal-option-country');
                        setDropdownValueBySelector('DelState', company.del_state || '', 'modal-option-del_state');

                        // Contacts
                        if (contactsCont) {
                            const rows = contactsCont.querySelectorAll('.contact-row');
                            rows.forEach(r => r.remove());
                        }
                        contactIndex = 0;

                        if (company.contacts && company.contacts.length > 0) {
                            company.contacts.forEach(contact => {
                                addContactRow(contact);
                            });
                        } else {
                            addContactRow();
                        }

                        openModal();
                    });
            });

            // Auto-open modal on page load check
            @if(session('open_modal') || $errors->any() || request('open_modal'))
                openModal();
            @endif

            })();



        // ===== Filter Dropdown Helper =====
        function makeFilterDropdown(wrapperId, btnId, panelId, hiddenId, labelId, optionClass, filterForm) {
            const wrapper = document.getElementById(wrapperId);
            const btn = document.getElementById(btnId);
            const panel = document.getElementById(panelId);
            const hidden = document.getElementById(hiddenId);
            const label = document.getElementById(labelId);
            if (!btn) return;

            btn.addEventListener('click', function (e) {
                e.stopPropagation();
                // close all other filter panels
                document.querySelectorAll('.filter-panel').forEach(function (p) {
                    if (p !== panel) p.classList.add('hidden');
                });
                panel.classList.toggle('hidden');
            });

            panel.classList.add('filter-panel');

            panel.addEventListener('click', function (e) {
                const opt = e.target.closest('.' + optionClass);
                if (!opt) return;
                hidden.value = opt.dataset.value;
                label.textContent = opt.dataset.label;
                // highlight
                panel.querySelectorAll('.' + optionClass).forEach(function (o) {
                    o.classList.remove('bg-blue-600', 'text-white', 'font-semibold');
                    o.classList.add('text-slate-600', 'hover:bg-slate-50');
                });
                opt.classList.add('bg-blue-600', 'text-white', 'font-semibold');
                opt.classList.remove('text-slate-600', 'hover:bg-slate-50');
                panel.classList.add('hidden');
                // submit filter form
                document.getElementById(filterForm).submit();
            });

            document.addEventListener('click', function (e) {
                if (wrapper && !wrapper.contains(e.target)) panel.classList.add('hidden');
            });
        }

        makeFilterDropdown('companyTypeWrapper', 'companyTypeBtn', 'companyTypePanel', 'companyTypeHidden', 'companyTypeLabel', 'ct-option', 'filterForm');
        makeFilterDropdown('statusWrapper', 'statusBtn', 'statusPanel', 'statusHidden', 'statusLabel', 'st-option', 'filterForm');

        // ===== Owner Searchable Dropdown =====
        (function () {
            const btn = document.getElementById('ownerDropdownBtn');
            const panel = document.getElementById('ownerDropdownPanel');
            const search = document.getElementById('ownerSearchInput');
            const label = document.getElementById('ownerDropdownLabel');
            const hidden = document.getElementById('ownerHiddenInput');
            const options = document.querySelectorAll('.owner-option');
            const noResults = document.getElementById('ownerNoResults');

            if (!btn) return;

            // Toggle dropdown
            btn.addEventListener('click', function (e) {
                e.stopPropagation();
                const isOpen = !panel.classList.contains('hidden');
                panel.classList.toggle('hidden', isOpen);
                if (!isOpen) {
                    search.value = '';
                    filterOptions('');
                    search.focus();
                }
            });

            // Filter as user types
            search.addEventListener('input', function () {
                filterOptions(this.value.trim().toLowerCase());
            });

            function filterOptions(query) {
                let visibleCount = 0;
                options.forEach(function (opt) {
                    const text = (opt.dataset.label || '').toLowerCase();
                    const match = text.includes(query);
                    opt.classList.toggle('hidden', !match);
                    if (match) visibleCount++;
                });
                noResults.classList.toggle('hidden', visibleCount > 0);
            }

            // Select an option
            document.getElementById('ownerOptionsList').addEventListener('click', function (e) {
                const opt = e.target.closest('.owner-option');
                if (!opt) return;

                hidden.value = opt.dataset.value;
                label.textContent = opt.dataset.label;

                // Highlight selected
                options.forEach(function (o) {
                    o.classList.remove('bg-blue-50', 'text-blue-700', 'font-medium');
                });
                if (opt.dataset.value) {
                    opt.classList.add('bg-blue-50', 'text-blue-700', 'font-medium');
                }

                panel.classList.add('hidden');
            });

            // Close when clicking outside
            document.addEventListener('click', function (e) {
                if (!document.getElementById('ownerDropdownWrapper').contains(e.target)) {
                    panel.classList.add('hidden');
                }
            });

            // Close on Escape
            document.addEventListener('keydown', function (e) {
                if (e.key === 'Escape') panel.classList.add('hidden');
            });
        })();



        document.addEventListener('DOMContentLoaded', function () {
            window.setupModalSimpleDropdown = function setupModalSimpleDropdown(fieldName, idPrefix = null, optionClassOverride = null) {
                let cleanName = idPrefix;
                if (!cleanName) {
                    cleanName = fieldName.replace(/\[0\]/g, '').replace(/\[/g, '').replace(/\]/g, '').replace(/_/g, ' ');
                    cleanName = cleanName.replace(/\w\S*/g, (txt) => txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase()).replace(/\s/g, '');
                }

                const wrapperId = 'modal' + cleanName + 'Wrapper';
                const wrapper = document.getElementById(wrapperId);
                if (!wrapper) return;
                const btn = document.getElementById('modal' + cleanName + 'Btn');
                const panel = document.getElementById('modal' + cleanName + 'Panel');
                const hidden = document.getElementById('modal' + cleanName + 'Hidden');
                const label = document.getElementById('modal' + cleanName + 'Label');
                const optClass = optionClassOverride || ('modal-option-' + fieldName.replace(/\[/g, '_').replace(/\]/g, '_'));
                const options = panel.querySelectorAll('li.' + optClass);

                btn.addEventListener('click', function (e) {
                    e.stopPropagation();
                    document.querySelectorAll('.filter-panel, [id$="Panel"]').forEach(p => {
                        if (p !== panel && p.id !== 'ownerDropdownPanel' && p.id !== 'companyTypePanel' && p.id !== 'statusPanel') p.classList.add('hidden');
                    });
                    panel.classList.toggle('hidden');
                });

                panel.addEventListener('click', function (e) {
                    const opt = e.target.closest('li.' + optClass);
                    if (!opt) return;
                    hidden.value = opt.getAttribute('data-value');
                    label.textContent = opt.getAttribute('data-label');

                    options.forEach(o => {
                        o.classList.remove('bg-blue-600', 'text-white', 'font-semibold');
                        o.classList.add('text-slate-600', 'hover:bg-slate-50');
                    });
                    opt.classList.add('bg-blue-600', 'text-white', 'font-semibold');
                    opt.classList.remove('text-slate-600', 'hover:bg-slate-50');
                    panel.classList.add('hidden');
                });

                document.addEventListener('click', function (e) {
                    if (!wrapper.contains(e.target)) panel.classList.add('hidden');
                });
            }

            window.setupModalSearchableDropdown = function setupModalSearchableDropdown(fieldName, idPrefix = null, optionClassOverride = null) {
                let cleanName = idPrefix;
                if (!cleanName) {
                    cleanName = fieldName.replace(/\[0\]/g, '').replace(/\[/g, '').replace(/\]/g, '').replace(/_/g, ' ');
                    cleanName = cleanName.replace(/\w\S*/g, (txt) => txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase()).replace(/\s/g, '');
                }

                const wrapperId = 'modal' + cleanName + 'Wrapper';
                const wrapper = document.getElementById(wrapperId);
                if (!wrapper) return;
                const btn = document.getElementById('modal' + cleanName + 'Btn');
                const panel = document.getElementById('modal' + cleanName + 'Panel');
                const hidden = document.getElementById('modal' + cleanName + 'Hidden');
                const label = document.getElementById('modal' + cleanName + 'Label');
                const search = document.getElementById('modal' + cleanName + 'Search');
                const list = document.getElementById('modal' + cleanName + 'List');
                const options = list.querySelectorAll('li:not(.no-results)');
                const noResults = list.querySelector('.no-results');

                btn.addEventListener('click', function (e) {
                    e.stopPropagation();
                    const isOpen = !panel.classList.contains('hidden');
                    document.querySelectorAll('.filter-panel, [id$="Panel"]').forEach(p => {
                        if (p !== panel && p.id !== 'ownerDropdownPanel' && p.id !== 'companyTypePanel' && p.id !== 'statusPanel') p.classList.add('hidden');
                    });
                    panel.classList.toggle('hidden', isOpen);
                    if (!isOpen) {
                        if (search) {
                            search.value = '';
                            filterOptions('');
                            setTimeout(() => search.focus(), 50);
                        }
                    }
                });

                if (search) {
                    search.addEventListener('input', function () {
                        filterOptions(this.value.trim().toLowerCase());
                    });
                }

                function filterOptions(query) {
                    let visibleCount = 0;

                    // Handle country dependency for states
                    let countryHidden = null;
                    if (cleanName.endsWith('State')) {
                        const countryId = 'modal' + cleanName.replace('State', 'Country') + 'Hidden';
                        countryHidden = document.getElementById(countryId);
                    }
                    const currentCountry = countryHidden ? countryHidden.value : null;

                    options.forEach(opt => {
                        const text = (opt.getAttribute('data-label') || '').toLowerCase();
                        const match = text.includes(query);

                        // If there is a country dependency, check if state belongs to the selected country
                        const stateCountry = opt.getAttribute('data-country');
                        let countryMatch = true;
                        if (stateCountry && currentCountry && stateCountry !== currentCountry) {
                            countryMatch = false;
                        }

                        const shouldShow = match && countryMatch;
                        opt.style.display = shouldShow ? '' : 'none';

                        if (shouldShow && opt.getAttribute('data-value') !== "") {
                            visibleCount++;
                        }
                    });
                    if (noResults) noResults.classList.toggle('hidden', visibleCount > 0 || options.length <= 1);
                }

                list.addEventListener('click', function (e) {
                    const opt = e.target.closest('li:not(.no-results)');
                    if (!opt) return;
                    hidden.value = opt.getAttribute('data-value');
                    label.textContent = opt.getAttribute('data-label');

                    // Dispatch change event to notify dependent filtering (e.g. states by country)
                    hidden.dispatchEvent(new Event('change'));

                    options.forEach(o => {
                        o.classList.remove('bg-blue-600', 'text-white', 'font-semibold');
                        o.classList.add('text-slate-600', 'hover:bg-slate-50');
                    });
                    if (opt.getAttribute('data-value')) {
                        opt.classList.add('bg-blue-600', 'text-white', 'font-semibold');
                        opt.classList.remove('text-slate-600', 'hover:bg-slate-50');
                    }
                    panel.classList.add('hidden');

                    if (search) {
                        search.value = '';
                        filterOptions('');
                        setTimeout(() => search.focus(), 50);
                    }
                });

                document.addEventListener('click', function (e) {
                    if (!wrapper.contains(e.target)) panel.classList.add('hidden');
                });
            }

            setupModalSimpleDropdown('company_type');
            setupModalSearchableDropdown('phone_code');
            setupModalSearchableDropdown('country');
            setupModalSearchableDropdown('state');
            setupModalSearchableDropdown('del_country');
            setupModalSearchableDropdown('del_state');
            setupModalSimpleDropdown('contacts[0][role]', 'Contacts0Role', 'modal-option-contacts0role');

            // Dynamic country-to-state dropdown filtering logic
            function bindCountryStateFilter(countryHiddenId, stateWrapperId, stateHiddenId, stateLabelId, stateListId, stateOptionClass) {
                const countryHidden = document.getElementById(countryHiddenId);
                const stateWrapper = document.getElementById(stateWrapperId);
                if (!countryHidden || !stateWrapper) return;

                const stateHidden = document.getElementById(stateHiddenId);
                const stateLabel = document.getElementById(stateLabelId);
                const stateList = document.getElementById(stateListId);
                const stateOptions = stateList.querySelectorAll('li.' + stateOptionClass);

                countryHidden.addEventListener('change', function () {
                    const countryVal = this.value;

                    // Reset selected state
                    stateHidden.value = '';
                    stateLabel.textContent = 'Choose state';

                    // Highlight default "Choose state" option in state dropdown list
                    stateOptions.forEach(opt => {
                        const val = opt.getAttribute('data-value');
                        if (val === '') {
                            opt.classList.add('bg-blue-600', 'text-white', 'font-semibold');
                            opt.classList.remove('text-slate-600', 'hover:bg-slate-50');
                        } else {
                            opt.classList.remove('bg-blue-600', 'text-white', 'font-semibold');
                            opt.classList.add('text-slate-600', 'hover:bg-slate-50');
                        }
                    });

                    // Filter states list based on country relationship
                    stateOptions.forEach(opt => {
                        const stateCountry = opt.getAttribute('data-country');
                        if (opt.getAttribute('data-value') === '') {
                            opt.style.display = ''; // Always keep "Choose state" visible
                        } else if (!countryVal || stateCountry === countryVal) {
                            opt.style.display = '';
                        } else {
                            opt.style.display = 'none';
                        }
                    });
                });
            }

            bindCountryStateFilter('modalCountryHidden', 'modalStateWrapper', 'modalStateHidden', 'modalStateLabel', 'modalStateList', 'modal-option-state');
            bindCountryStateFilter('modalDelCountryHidden', 'modalDelStateWrapper', 'modalDelStateHidden', 'modalDelStateLabel', 'modalDelStateList', 'modal-option-del_state');
        });
    </script>
@endsection
