@extends('layouts.app')

@section('title', 'Companies')

@section('content')
    <div class="p-6 min-h-full">

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
                                        $ctMap = ['customer' => 'Customer', 'supplier' => 'Supplier', 'laboratory' => 'Laboratory', 'partner' => 'Partner', 'broker_sales_agent' => 'Broker & Sales Agent', 'contractor' => 'Contractor'];
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
                                    <li class="ct-option flex items-center px-4 py-2.5 text-sm cursor-pointer {{ request('company_type') === 'customer' ? 'bg-blue-600 text-white font-semibold' : 'text-slate-600 hover:bg-slate-50' }}"
                                        data-value="customer" data-label="Customer">Customer</li>
                                    <li class="ct-option flex items-center px-4 py-2.5 text-sm cursor-pointer {{ request('company_type') === 'supplier' ? 'bg-blue-600 text-white font-semibold' : 'text-slate-600 hover:bg-slate-50' }}"
                                        data-value="supplier" data-label="Supplier">Supplier</li>
                                    <li class="ct-option flex items-center px-4 py-2.5 text-sm cursor-pointer {{ request('company_type') === 'laboratory' ? 'bg-blue-600 text-white font-semibold' : 'text-slate-600 hover:bg-slate-50' }}"
                                        data-value="laboratory" data-label="Laboratory">Laboratory</li>
                                    <li class="ct-option flex items-center px-4 py-2.5 text-sm cursor-pointer {{ request('company_type') === 'partner' ? 'bg-blue-600 text-white font-semibold' : 'text-slate-600 hover:bg-slate-50' }}"
                                        data-value="partner" data-label="Partner">Partner</li>
                                    <li class="ct-option flex items-center px-4 py-2.5 text-sm cursor-pointer {{ request('company_type') === 'broker_sales_agent' ? 'bg-blue-600 text-white font-semibold' : 'text-slate-600 hover:bg-slate-50' }}"
                                        data-value="broker_sales_agent" data-label="Broker &amp; Sales Agent">Broker &amp;
                                        Sales Agent</li>
                                    <li class="ct-option flex items-center px-4 py-2.5 text-sm cursor-pointer {{ request('company_type') === 'contractor' ? 'bg-blue-600 text-white font-semibold' : 'text-slate-600 hover:bg-slate-50' }}"
                                        data-value="contractor" data-label="Contractor">Contractor</li>
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
                                    <a href="{{ route('crm.companies.show', $company->id) }}"
                                        class="font-medium text-primary-600 hover:text-primary-800 hover:underline transition-colors">
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
                            </tr>
                        @empty
                            <tr>
                                <td colspan="12" class="px-4 py-12 text-center">
                                    <div class="flex flex-col items-center gap-3 text-slate-400">
                                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                        </svg>
                                        <p class="text-sm font-medium">No companies found</p>
                                        <a href="{{ route('crm.companies.create') }}"
                                            class="text-primary-600 hover:text-primary-700 text-sm font-medium">
                                            + Create your first company
                                        </a>
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
    <div id="createCompanyModal" class="fixed inset-0 z-50 hidden items-center justify-center"
        style="background:rgba(0,0,0,0.45);">

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
                            <input type="text" name="reference" readonly
                                value="Comp-101"
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
                                        <li class="modal-option-company_type flex items-center px-4 py-2.5 text-sm cursor-pointer text-slate-600 hover:bg-slate-50 "
                                            data-value="customer" data-label="Customer">Customer</li>
                                        <li class="modal-option-company_type flex items-center px-4 py-2.5 text-sm cursor-pointer text-slate-600 hover:bg-slate-50 "
                                            data-value="supplier" data-label="Supplier">Supplier</li>
                                        <li class="modal-option-company_type flex items-center px-4 py-2.5 text-sm cursor-pointer text-slate-600 hover:bg-slate-50 "
                                            data-value="partner" data-label="Partner">Partner</li>
                                        <li class="modal-option-company_type flex items-center px-4 py-2.5 text-sm cursor-pointer text-slate-600 hover:bg-slate-50 "
                                            data-value="reseller" data-label="Reseller">Reseller</li>
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
                                    <input type="hidden" name="phone_code" id="modalPhoneCodeHidden" value="">
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
                                        class="hidden absolute z-50 left-0 right-0 mt-2 bg-white border border-slate-200 rounded-md shadow-lg overflow-hidden w-36">
                                        <div class="p-2 border-b border-slate-100">
                                            <input type="text" id="modalPhoneCodeSearch" placeholder="Search..."
                                                class="w-full px-3 py-2 text-sm border border-slate-200 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                                autocomplete="off">
                                        </div>
                                        <ul id="modalPhoneCodeList" class="py-1 max-h-48 overflow-y-auto w-full">
                                            <li class="modal-option-phone_code flex items-center px-4 py-2.5 text-sm cursor-pointer text-slate-600 hover:bg-slate-50 bg-blue-600 text-white font-semibold"
                                                data-value="+94" data-label="🇱🇰 +94">🇱🇰 +94</li>
                                            <li class="modal-option-phone_code flex items-center px-4 py-2.5 text-sm cursor-pointer text-slate-600 hover:bg-slate-50 "
                                                data-value="+1" data-label="🇺🇸 +1">🇺🇸 +1</li>
                                            <li class="modal-option-phone_code flex items-center px-4 py-2.5 text-sm cursor-pointer text-slate-600 hover:bg-slate-50 "
                                                data-value="+44" data-label="🇬🇧 +44">🇬🇧 +44</li>
                                            <li class="modal-option-phone_code flex items-center px-4 py-2.5 text-sm cursor-pointer text-slate-600 hover:bg-slate-50 "
                                                data-value="+91" data-label="🇮🇳 +91">🇮🇳 +91</li>
                                            <li class="modal-option-phone_code flex items-center px-4 py-2.5 text-sm cursor-pointer text-slate-600 hover:bg-slate-50 "
                                                data-value="+61" data-label="🇦🇺 +61">🇦🇺 +61</li>
                                            <li class="modal-option-phone_code flex items-center px-4 py-2.5 text-sm cursor-pointer text-slate-600 hover:bg-slate-50 "
                                                data-value="+971" data-label="🇦🇪 +971">🇦🇪 +971</li>
                                            <li class="modal-option-phone_code flex items-center px-4 py-2.5 text-sm cursor-pointer text-slate-600 hover:bg-slate-50 "
                                                data-value="+65" data-label="🇸🇬 +65">🇸🇬 +65</li>
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
                        <div style="margin-left: 15px">
                            <label class="block text-xs font-medium text-slate-600 mb-1.5">
                                Profile image: <span class="text-slate-400 font-normal">(Max file size is 1MB)</span>
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
                                        <li class="modal-option-country flex items-center px-4 py-2.5 text-sm cursor-pointer text-slate-600 hover:bg-slate-50 "
                                            data-value="Sri Lanka" data-label="Sri Lanka">Sri Lanka</li>
                                        <li class="modal-option-country flex items-center px-4 py-2.5 text-sm cursor-pointer text-slate-600 hover:bg-slate-50 "
                                            data-value="India" data-label="India">India</li>
                                        <li class="modal-option-country flex items-center px-4 py-2.5 text-sm cursor-pointer text-slate-600 hover:bg-slate-50 "
                                            data-value="United States" data-label="United States">United States</li>
                                        <li class="modal-option-country flex items-center px-4 py-2.5 text-sm cursor-pointer text-slate-600 hover:bg-slate-50 "
                                            data-value="United Kingdom" data-label="United Kingdom">United Kingdom</li>
                                        <li class="modal-option-country flex items-center px-4 py-2.5 text-sm cursor-pointer text-slate-600 hover:bg-slate-50 "
                                            data-value="Australia" data-label="Australia">Australia</li>
                                        <li class="modal-option-country flex items-center px-4 py-2.5 text-sm cursor-pointer text-slate-600 hover:bg-slate-50 "
                                            data-value="Singapore" data-label="Singapore">Singapore</li>
                                        <li class="modal-option-country flex items-center px-4 py-2.5 text-sm cursor-pointer text-slate-600 hover:bg-slate-50 "
                                            data-value="UAE" data-label="UAE">UAE</li>
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
                                        <li class="modal-option-state flex items-center px-4 py-2.5 text-sm cursor-pointer text-slate-600 hover:bg-slate-50 "
                                            data-value="Western" data-label="Western">Western</li>
                                        <li class="modal-option-state flex items-center px-4 py-2.5 text-sm cursor-pointer text-slate-600 hover:bg-slate-50 "
                                            data-value="Central" data-label="Central">Central</li>
                                        <li class="modal-option-state flex items-center px-4 py-2.5 text-sm cursor-pointer text-slate-600 hover:bg-slate-50 "
                                            data-value="Southern" data-label="Southern">Southern</li>
                                        <li class="modal-option-state flex items-center px-4 py-2.5 text-sm cursor-pointer text-slate-600 hover:bg-slate-50 "
                                            data-value="Northern" data-label="Northern">Northern</li>
                                        <li class="modal-option-state flex items-center px-4 py-2.5 text-sm cursor-pointer text-slate-600 hover:bg-slate-50 "
                                            data-value="Eastern" data-label="Eastern">Eastern</li>
                                        {{-- States load dynamically via AJAX based on selected country --}}
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
                                                <li class="modal-option-country px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="206" data-label="Sri Lanka">Sri Lanka</li>
                                                <li class="modal-option-country px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="101" data-label="India">India</li>
                                                <li class="modal-option-country px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="231" data-label="United States">United States</li>
                                                <li class="modal-option-country px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="230" data-label="United Kingdom">United Kingdom</li>
                                                <li class="modal-option-country px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="13" data-label="Australia">Australia</li>
                                                <li class="modal-option-country px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="196" data-label="Singapore">Singapore</li>
                                                <li class="modal-option-country px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="229" data-label="United Arab Emirates">United Arab Emirates
                                                </li>
                                                <li class="modal-option-country px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="1" data-label="Afghanistan">Afghanistan</li>
                                                <li class="modal-option-country px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="3" data-label="Algeria">Algeria</li>
                                                <li class="modal-option-country px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="4" data-label="American Samoa">American Samoa</li>
                                                <li class="modal-option-country px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="5" data-label="Andorra">Andorra</li>
                                                <li class="modal-option-country px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="6" data-label="Angola">Angola</li>
                                                <li class="modal-option-country px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="7" data-label="Anguilla">Anguilla</li>
                                                <li class="modal-option-country px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="9" data-label="Antigua And Barbuda">Antigua And Barbuda</li>
                                                <li class="modal-option-country px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="11" data-label="Armenia">Armenia</li>
                                                <li class="modal-option-country px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="12" data-label="Aruba">Aruba</li>
                                                <li class="modal-option-country px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="14" data-label="Austria">Austria</li>
                                                <li class="modal-option-country px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="15" data-label="Azerbaijan">Azerbaijan</li>
                                                <li class="modal-option-country px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="16" data-label="Bahamas The">Bahamas The</li>
                                                <li class="modal-option-country px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="17" data-label="Bahrain">Bahrain</li>
                                                <li class="modal-option-country px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="18" data-label="Bangladesh">Bangladesh</li>
                                                <li class="modal-option-country px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="19" data-label="Barbados">Barbados</li>
                                                <li class="modal-option-country px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="20" data-label="Belarus">Belarus</li>
                                                <li class="modal-option-country px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="21" data-label="Belgium">Belgium</li>
                                                <li class="modal-option-country px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="22" data-label="Belize">Belize</li>
                                                <li class="modal-option-country px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="23" data-label="Benin">Benin</li>
                                                <li class="modal-option-country px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="25" data-label="Bhutan">Bhutan</li>
                                                <li class="modal-option-country px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="26" data-label="Bolivia">Bolivia</li>
                                                <li class="modal-option-country px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="27" data-label="Bosnia and Herzegovina">Bosnia and
                                                    Herzegovina
                                                </li>
                                                <li class="modal-option-country px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="28" data-label="Botswana">Botswana</li>
                                                <li class="modal-option-country px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="30" data-label="Brazil">Brazil</li>
                                                <li class="modal-option-country px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="32" data-label="Brunei">Brunei</li>
                                                <li class="modal-option-country px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="33" data-label="Bulgaria">Bulgaria</li>
                                                <li class="modal-option-country px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="34" data-label="Burkina Faso">Burkina Faso</li>
                                                <li class="modal-option-country px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="35" data-label="Burundi">Burundi</li>
                                                <li class="modal-option-country px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="36" data-label="Cambodia">Cambodia</li>
                                                <li class="modal-option-country px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="37" data-label="Cameroon">Cameroon</li>
                                                <li class="modal-option-country px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="38" data-label="Canada">Canada</li>
                                                <li class="modal-option-country px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="39" data-label="Cape Verde">Cape Verde</li>
                                                <li class="modal-option-country px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="40" data-label="Cayman Islands">Cayman Islands</li>
                                                <li class="modal-option-country px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="41" data-label="Central African Republic">Central African
                                                    Republic</li>
                                                <li class="modal-option-country px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="42" data-label="Chad">Chad</li>
                                                <li class="modal-option-country px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="43" data-label="Chile">Chile</li>
                                                <li class="modal-option-country px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="44" data-label="China">China</li>
                                                <li class="modal-option-country px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="47" data-label="Colombia">Colombia</li>
                                                <li class="modal-option-country px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="48" data-label="Comoros">Comoros</li>
                                                <li class="modal-option-country px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="49" data-label="Congo">Congo</li>
                                                <li class="modal-option-country px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="50" data-label="Congo The Democratic Republic Of The">Congo
                                                    The
                                                    Democratic Republic Of The</li>
                                                <li class="modal-option-country px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="51" data-label="Cook Islands">Cook Islands</li>
                                                <li class="modal-option-country px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="52" data-label="Costa Rica">Costa Rica</li>
                                                <li class="modal-option-country px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="53" data-label="Cote D'Ivoire (Ivory Coast)">Cote D'Ivoire
                                                    (Ivory Coast)</li>
                                                <li class="modal-option-country px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="54" data-label="Croatia (Hrvatska)">Croatia (Hrvatska)</li>
                                                <li class="modal-option-country px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="55" data-label="Cuba">Cuba</li>
                                                <li class="modal-option-country px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="56" data-label="Cyprus">Cyprus</li>
                                                <li class="modal-option-country px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="57" data-label="Czech Republic">Czech Republic</li>
                                                <li class="modal-option-country px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="58" data-label="Denmark">Denmark</li>
                                                <li class="modal-option-country px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="59" data-label="Djibouti">Djibouti</li>
                                                <li class="modal-option-country px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="60" data-label="Dominica">Dominica</li>
                                                <li class="modal-option-country px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="61" data-label="Dominican Republic">Dominican Republic</li>
                                                <li class="modal-option-country px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="63" data-label="Ecuador">Ecuador</li>
                                                <li class="modal-option-country px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="64" data-label="Egypt">Egypt</li>
                                                <li class="modal-option-country px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="65" data-label="El Salvador">El Salvador</li>
                                                <li class="modal-option-country px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="66" data-label="Equatorial Guinea">Equatorial Guinea</li>
                                                <li class="modal-option-country px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="67" data-label="Eritrea">Eritrea</li>
                                                <li class="modal-option-country px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="68" data-label="Estonia">Estonia</li>
                                                <li class="modal-option-country px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="69" data-label="Ethiopia">Ethiopia</li>
                                                <li class="modal-option-country px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="73" data-label="Fiji Islands">Fiji Islands</li>
                                                <li class="modal-option-country px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="74" data-label="Finland">Finland</li>
                                                <li class="modal-option-country px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="75" data-label="France">France</li>
                                                <li class="modal-option-country px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="79" data-label="Gabon">Gabon</li>
                                                <li class="modal-option-country px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="80" data-label="Gambia The">Gambia The</li>
                                                <li class="modal-option-country px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="81" data-label="Georgia">Georgia</li>
                                                <li class="modal-option-country px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="82" data-label="Germany">Germany</li>
                                                <li class="modal-option-country px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="83" data-label="Ghana">Ghana</li>
                                                <li class="modal-option-country px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="85" data-label="Greece">Greece</li>
                                                <li class="modal-option-country px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="87" data-label="Grenada">Grenada</li>
                                                <li class="modal-option-country px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="89" data-label="Guam">Guam</li>
                                                <li class="modal-option-country px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="90" data-label="Guatemala">Guatemala</li>
                                                <li class="modal-option-country px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="94" data-label="Guyana">Guyana</li>
                                                <li class="modal-option-country px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="95" data-label="Haiti">Haiti</li>
                                                <li class="modal-option-country px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="97" data-label="Honduras">Honduras</li>
                                                <li class="modal-option-country px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="98" data-label="Hong Kong S.A.R.">Hong Kong S.A.R.</li>
                                                <li class="modal-option-country px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="99" data-label="Hungary">Hungary</li>
                                                <li class="modal-option-country px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="100" data-label="Iceland">Iceland</li>
                                                <li class="modal-option-country px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="102" data-label="Indonesia">Indonesia</li>
                                                <li class="modal-option-country px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="103" data-label="Iran">Iran</li>
                                                <li class="modal-option-country px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="104" data-label="Iraq">Iraq</li>
                                                <li class="modal-option-country px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="105" data-label="Ireland">Ireland</li>
                                                <li class="modal-option-country px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="106" data-label="Israel">Israel</li>
                                                <li class="modal-option-country px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="107" data-label="Italy">Italy</li>
                                                <li class="modal-option-country px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="108" data-label="Jamaica">Jamaica</li>
                                                <li class="modal-option-country px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="109" data-label="Japan">Japan</li>
                                                <li class="modal-option-country px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="111" data-label="Jordan">Jordan</li>
                                                <li class="modal-option-country px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="112" data-label="Kazakhstan">Kazakhstan</li>
                                                <li class="modal-option-country px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="113" data-label="Kenya">Kenya</li>
                                                <li class="modal-option-country px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="116" data-label="Korea South">Korea South</li>
                                                <li class="modal-option-country px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="117" data-label="Kuwait">Kuwait</li>
                                                <li class="modal-option-country px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="118" data-label="Kyrgyzstan">Kyrgyzstan</li>
                                                <li class="modal-option-country px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="119" data-label="Laos">Laos</li>
                                                <li class="modal-option-country px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="120" data-label="Latvia">Latvia</li>
                                                <li class="modal-option-country px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="121" data-label="Lebanon">Lebanon</li>
                                                <li class="modal-option-country px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="122" data-label="Lesotho">Lesotho</li>
                                                <li class="modal-option-country px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="123" data-label="Liberia">Liberia</li>
                                                <li class="modal-option-country px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="124" data-label="Libya">Libya</li>
                                                <li class="modal-option-country px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="125" data-label="Liechtenstein">Liechtenstein</li>
                                                <li class="modal-option-country px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="126" data-label="Lithuania">Lithuania</li>
                                                <li class="modal-option-country px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="127" data-label="Luxembourg">Luxembourg</li>
                                                <li class="modal-option-country px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="130" data-label="Madagascar">Madagascar</li>
                                                <li class="modal-option-country px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="131" data-label="Malawi">Malawi</li>
                                                <li class="modal-option-country px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="132" data-label="Malaysia">Malaysia</li>
                                                <li class="modal-option-country px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="134" data-label="Mali">Mali</li>
                                                <li class="modal-option-country px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="135" data-label="Malta">Malta</li>
                                                <li class="modal-option-country px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="139" data-label="Mauritania">Mauritania</li>
                                                <li class="modal-option-country px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="140" data-label="Mauritius">Mauritius</li>
                                                <li class="modal-option-country px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="142" data-label="Mexico">Mexico</li>
                                                <li class="modal-option-country px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="144" data-label="Moldova">Moldova</li>
                                                <li class="modal-option-country px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="145" data-label="Monaco">Monaco</li>
                                                <li class="modal-option-country px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="146" data-label="Mongolia">Mongolia</li>
                                                <li class="modal-option-country px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="148" data-label="Morocco">Morocco</li>
                                                <li class="modal-option-country px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="149" data-label="Mozambique">Mozambique</li>
                                                <li class="modal-option-country px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="150" data-label="Myanmar">Myanmar</li>
                                                <li class="modal-option-country px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="151" data-label="Namibia">Namibia</li>
                                                <li class="modal-option-country px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="153" data-label="Nepal">Nepal</li>
                                                <li class="modal-option-country px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="155" data-label="Netherlands The">Netherlands The</li>
                                                <li class="modal-option-country px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="157" data-label="New Zealand">New Zealand</li>
                                                <li class="modal-option-country px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="158" data-label="Nicaragua">Nicaragua</li>
                                                <li class="modal-option-country px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="159" data-label="Niger">Niger</li>
                                                <li class="modal-option-country px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="160" data-label="Nigeria">Nigeria</li>
                                                <li class="modal-option-country px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="164" data-label="Norway">Norway</li>
                                                <li class="modal-option-country px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="165" data-label="Oman">Oman</li>
                                                <li class="modal-option-country px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="166" data-label="Pakistan">Pakistan</li>
                                                <li class="modal-option-country px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="168" data-label="Palestinian Territory Occupied">Palestinian
                                                    Territory Occupied</li>
                                                <li class="modal-option-country px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="169" data-label="Panama">Panama</li>
                                                <li class="modal-option-country px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="170" data-label="Papua new Guinea">Papua new Guinea</li>
                                                <li class="modal-option-country px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="171" data-label="Paraguay">Paraguay</li>
                                                <li class="modal-option-country px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="172" data-label="Peru">Peru</li>
                                                <li class="modal-option-country px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="173" data-label="Philippines">Philippines</li>
                                                <li class="modal-option-country px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="175" data-label="Poland">Poland</li>
                                                <li class="modal-option-country px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="176" data-label="Portugal">Portugal</li>
                                                <li class="modal-option-country px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="178" data-label="Qatar">Qatar</li>
                                                <li class="modal-option-country px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="180" data-label="Romania">Romania</li>
                                                <li class="modal-option-country px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="181" data-label="Russia">Russia</li>
                                                <li class="modal-option-country px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="182" data-label="Rwanda">Rwanda</li>
                                                <li class="modal-option-country px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="184" data-label="Saint Kitts And Nevis">Saint Kitts And
                                                    Nevis
                                                </li>
                                                <li class="modal-option-country px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="185" data-label="Saint Lucia">Saint Lucia</li>
                                                <li class="modal-option-country px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="187" data-label="Saint Vincent And The Grenadines">Saint
                                                    Vincent
                                                    And The Grenadines</li>
                                                <li class="modal-option-country px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="188" data-label="Samoa">Samoa</li>
                                                <li class="modal-option-country px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="189" data-label="San Marino">San Marino</li>
                                                <li class="modal-option-country px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="192" data-label="Senegal">Senegal</li>
                                                <li class="modal-option-country px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="193" data-label="Serbia">Serbia</li>
                                                <li class="modal-option-country px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="194" data-label="Seychelles">Seychelles</li>
                                                <li class="modal-option-country px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="195" data-label="Sierra Leone">Sierra Leone</li>
                                                <li class="modal-option-country px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="197" data-label="Slovakia">Slovakia</li>
                                                <li class="modal-option-country px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="198" data-label="Slovenia">Slovenia</li>
                                                <li class="modal-option-country px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="200" data-label="Solomon Islands">Solomon Islands</li>
                                                <li class="modal-option-country px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="201" data-label="Somalia">Somalia</li>
                                                <li class="modal-option-country px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="202" data-label="South Africa">South Africa</li>
                                                <li class="modal-option-country px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="204" data-label="South Sudan">South Sudan</li>
                                                <li class="modal-option-country px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="207" data-label="Sudan">Sudan</li>
                                                <li class="modal-option-country px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="208" data-label="Suriname">Suriname</li>
                                                <li class="modal-option-country px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="210" data-label="Swaziland">Swaziland</li>
                                                <li class="modal-option-country px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="211" data-label="Sweden">Sweden</li>
                                                <li class="modal-option-country px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="212" data-label="Switzerland">Switzerland</li>
                                                <li class="modal-option-country px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="213" data-label="Syria">Syria</li>
                                                <li class="modal-option-country px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="214" data-label="Taiwan">Taiwan</li>
                                                <li class="modal-option-country px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="215" data-label="Tajikistan">Tajikistan</li>
                                                <li class="modal-option-country px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="216" data-label="Tanzania">Tanzania</li>
                                                <li class="modal-option-country px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="217" data-label="Thailand">Thailand</li>
                                                <li class="modal-option-country px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="218" data-label="Togo">Togo</li>
                                                <li class="modal-option-country px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="220" data-label="Tonga">Tonga</li>
                                                <li class="modal-option-country px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="221" data-label="Trinidad And Tobago">Trinidad And Tobago
                                                </li>
                                                <li class="modal-option-country px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="222" data-label="Tunisia">Tunisia</li>
                                                <li class="modal-option-country px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="223" data-label="Turkey">Turkey</li>
                                                <li class="modal-option-country px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="224" data-label="Turkmenistan">Turkmenistan</li>
                                                <li class="modal-option-country px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="226" data-label="Tuvalu">Tuvalu</li>
                                                <li class="modal-option-country px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="227" data-label="Uganda">Uganda</li>
                                                <li class="modal-option-country px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="228" data-label="Ukraine">Ukraine</li>
                                                <li class="modal-option-country px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="233" data-label="Uruguay">Uruguay</li>
                                                <li class="modal-option-country px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="234" data-label="Uzbekistan">Uzbekistan</li>
                                                <li class="modal-option-country px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="235" data-label="Vanuatu">Vanuatu</li>
                                                <li class="modal-option-country px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="238" data-label="Vietnam">Vietnam</li>
                                                <li class="modal-option-country px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="243" data-label="Yemen">Yemen</li>
                                                <li class="modal-option-country px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="245" data-label="Zambia">Zambia</li>
                                                <li class="modal-option-country px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="246" data-label="Zimbabwe">Zimbabwe</li>
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
                                            <li class="modal-option-del_state flex items-center px-4 py-2.5 text-sm cursor-pointer text-slate-600 hover:bg-slate-50 "
                                                data-value="Western" data-label="Western">Western</li>
                                            <li class="modal-option-del_state flex items-center px-4 py-2.5 text-sm cursor-pointer text-slate-600 hover:bg-slate-50 "
                                                data-value="Central" data-label="Central">Central</li>
                                            <li class="modal-option-del_state flex items-center px-4 py-2.5 text-sm cursor-pointer text-slate-600 hover:bg-slate-50 "
                                                data-value="Southern" data-label="Southern">Southern</li>
                                            {{-- States load dynamically via AJAX based on selected country --}}
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
                                            <li class="modal-option-contacts0role flex items-center px-4 py-2.5 text-sm cursor-pointer text-slate-600 hover:bg-slate-50 "
                                                data-value="manager" data-label="Manager">Manager</li>
                                            <li class="modal-option-contacts0role flex items-center px-4 py-2.5 text-sm cursor-pointer text-slate-600 hover:bg-slate-50 "
                                                data-value="accountant" data-label="Accountant">Accountant</li>
                                            <li class="modal-option-contacts0role flex items-center px-4 py-2.5 text-sm cursor-pointer text-slate-600 hover:bg-slate-50 "
                                                data-value="director" data-label="Director">Director</li>
                                            <li class="modal-option-contacts0role flex items-center px-4 py-2.5 text-sm cursor-pointer text-slate-600 hover:bg-slate-50 "
                                                data-value="sales" data-label="Sales">Sales</li>
                                            <li class="modal-option-contacts0role flex items-center px-4 py-2.5 text-sm cursor-pointer text-slate-600 hover:bg-slate-50 "
                                                data-value="support" data-label="Support">Support</li>
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

        // ===== Create Company Modal =====
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

            function resetForm() {
                form.reset();
                if (deliverySec) deliverySec.classList.add('hidden');
                contactIndex = 1;
                // Remove extra contacts
                if (contactsCont) {
                    const rows = contactsCont.querySelectorAll('.contact-row');
                    rows.forEach(function (r, i) { if (i > 0) r.remove(); });
                }
            }

            if (openBtn) openBtn.addEventListener('click', openModal);
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

            // Add contact row
            if (addContactBtn) {
                addContactBtn.addEventListener('click', function () {
                    const idx = contactIndex++;
                    const row = document.createElement('div');
                    row.className = 'contact-row grid grid-cols-2 gap-x-5 gap-y-4 mb-4 pt-4 border-t border-slate-100';
                    row.innerHTML = `
                                        <div>
                                            <label class="block text-xs font-medium text-slate-600 mb-1.5">First name:</label>
                                            <input type="text" name="contacts[${idx}][first_name]" placeholder="Add first name"
                                                   class="w-full px-3 py-2.5 text-sm border border-slate-200 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                        </div>
                                        <div>
                                            <label class="block text-xs font-medium text-slate-600 mb-1.5">Last name:</label>
                                            <input type="text" name="contacts[${idx}][last_name]" placeholder="Add last name"
                                                   class="w-full px-3 py-2.5 text-sm border border-slate-200 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                        </div>
                                        <div>
                                            <label class="block text-xs font-medium text-slate-600 mb-1.5">Email:</label>
                                            <input type="email" name="contacts[${idx}][email]" placeholder="Add email"
                                                   class="w-full px-3 py-2.5 text-sm border border-slate-200 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                        </div>
                                        <div>
                                                <div class="relative" id="modalContacts${idx}RoleWrapper">
                                                <input type="hidden" name="contacts[${idx}][role]" id="modalContacts${idx}RoleHidden" value="">
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
                                                        <li class="modal-option-contacts${idx}role flex items-center px-4 py-2.5 text-sm cursor-pointer text-slate-600 hover:bg-slate-50 bg-blue-600 text-white font-semibold" data-value="" data-label="Select role">Select role</li>
                                                        <li class="modal-option-contacts${idx}role flex items-center px-4 py-2.5 text-sm cursor-pointer text-slate-600 hover:bg-slate-50 " data-value="manager" data-label="Manager">Manager</li>
                                                        <li class="modal-option-contacts${idx}role flex items-center px-4 py-2.5 text-sm cursor-pointer text-slate-600 hover:bg-slate-50 " data-value="accountant" data-label="Accountant">Accountant</li>
                                                        <li class="modal-option-contacts${idx}role flex items-center px-4 py-2.5 text-sm cursor-pointer text-slate-600 hover:bg-slate-50 " data-value="director" data-label="Director">Director</li>
                                                        <li class="modal-option-contacts${idx}role flex items-center px-4 py-2.5 text-sm cursor-pointer text-slate-600 hover:bg-slate-50 " data-value="sales" data-label="Sales">Sales</li>
                                                        <li class="modal-option-contacts${idx}role flex items-center px-4 py-2.5 text-sm cursor-pointer text-slate-600 hover:bg-slate-50 " data-value="support" data-label="Support">Support</li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-span-2 flex items-center justify-between">
                                            <div class="flex items-center gap-2">
                                                <input type="checkbox" id="primaryContact${idx}" name="contacts[${idx}][primary]"
                                                       class="w-4 h-4 rounded-md border-slate-300 text-blue-600 cursor-pointer">
                                                <label for="primaryContact${idx}" class="text-sm font-bold text-slate-700 cursor-pointer">
                                                    Primary contact
                                                </label>
                                            </div>
                                            <button type="button" onclick="this.closest('.contact-row').remove()"
                                                    class="text-xs text-red-500 hover:text-red-700 font-medium">Remove</button>
                                        </div>`;
                    if (contactsCont) contactsCont.appendChild(row);

                    // Initialize the new dropdown
                    if (typeof setupModalSimpleDropdown === 'function') {
                        setupModalSimpleDropdown('contacts[' + idx + '][role]', 'Contacts' + idx + 'Role', 'modal-option-contacts' + idx + 'role');
                    }
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
                    // Add hidden input to indicate "add another"
                    let flag = document.createElement('input');
                    flag.type = 'hidden';
                    flag.name = 'add_another';
                    flag.value = '1';
                    form.appendChild(flag);
                    form.submit();
                });
            }

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
            function setupModalSimpleDropdown(fieldName, idPrefix = null, optionClassOverride = null) {
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

            function setupModalSearchableDropdown(fieldName, idPrefix = null, optionClassOverride = null) {
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
                    options.forEach(opt => {
                        const text = (opt.getAttribute('data-label') || '').toLowerCase();
                        const match = text.includes(query);
                        opt.style.display = match ? '' : 'none';
                        if (match && opt.getAttribute('data-value') !== "") visibleCount++;
                    });
                    if (noResults) noResults.classList.toggle('hidden', visibleCount > 0 || options.length <= 1);
                }

                list.addEventListener('click', function (e) {
                    const opt = e.target.closest('li:not(.no-results)');
                    if (!opt) return;
                    hidden.value = opt.getAttribute('data-value');
                    label.textContent = opt.getAttribute('data-label');

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
        });
    </script>
@endsection