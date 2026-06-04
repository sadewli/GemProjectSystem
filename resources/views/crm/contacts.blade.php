@extends('layouts.app')

@section('title', 'Contacts')

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
            <h1 class="text-2xl font-bold text-primary-700 tracking-tight">Contacts</h1>
            <div class="flex items-center gap-3">
                <button type="button" id="openCreateModal"
                    class="inline-flex items-center gap-2 bg-primary-600 hover:bg-primary-700 text-white text-sm font-semibold px-4 py-2.5 rounded-md shadow-sm transition-all duration-150 active:scale-95">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Create new
                </button>
                <a href="{{ route('crm.contacts.import') }}"
                    class="inline-flex items-center gap-2 border border-slate-300 bg-white hover:bg-slate-50 text-slate-700 text-sm font-medium px-4 py-2.5 rounded-md transition-all duration-150">
                    Import Contacts
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

            <form method="GET" action="{{ route('crm.contacts.index') }}" id="filterForm">
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
                                        foreach($companyTypes ?? [] as $ct) {
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
                            <div id="companyTypePanel"
                                class="hidden absolute z-50 left-0 right-0 mt-2 bg-white border border-slate-200 rounded-md shadow-lg overflow-hidden">
                                <ul id="companyTypeList" class="py-1">
                                    <li class="ct-option flex items-center px-4 py-2.5 text-sm cursor-pointer {{ !request('company_type') ? 'bg-blue-600 text-white font-semibold' : 'text-slate-600 hover:bg-slate-50' }}"
                                        data-value="" data-label="Select company type">Select company type</li>
                                    @foreach($companyTypes ?? [] as $ct)
                                        <li class="ct-option flex items-center px-4 py-2.5 text-sm cursor-pointer {{ request('company_type') === $ct->value ? 'bg-blue-600 text-white font-semibold' : 'text-slate-600 hover:bg-slate-50' }}"
                                            data-value="{{ $ct->value }}" data-label="{{ $ct->company_type }}">{{ $ct->company_type }}</li>
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
                                <input type="hidden" name="owner" id="ownerHiddenInput" value="{{ request('owner') }}">
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
                                <div class="absolute inset-y-0 right-3 flex items-center pointer-events-none">
                                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7" />
                                    </svg>
                                </div>
                                <div id="ownerDropdownPanel"
                                    class="hidden absolute z-50 mt-2 w-full bg-white border border-slate-200 rounded-md shadow-lg overflow-hidden">
                                    <div class="p-2 border-b border-slate-100">
                                        <input type="text" id="ownerSearchInput" placeholder="Search owner..."
                                            class="w-full px-3 py-2 text-sm border border-slate-200 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                            autocomplete="off">
                                    </div>
                                    <ul id="ownerOptionsList" class="py-1 max-h-48 overflow-y-auto">
                                        <li class="owner-option px-3 py-2 text-sm text-slate-400 italic cursor-pointer hover:bg-slate-50"
                                            data-value="" data-label="Select owner">Select owner</li>
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
                        </div>

                        {{-- Reset + Apply --}}
                        <div class="flex items-end gap-2">
                            <a href="{{ route('crm.contacts.index') }}" title="Reset filters"
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

            {{-- Contacts Table --}}
            <div class="p-5">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm">
                        <thead>
                            <tr class="text-slate-500 text-xs uppercase tracking-wider">
                                <th class="px-3 py-2">Ref</th>
                                <th class="px-3 py-2">Name</th>
                                <th class="px-3 py-2">Email</th>
                                <th class="px-3 py-2">Phone</th>
                                <th class="px-3 py-2">Company</th>
                                <th class="px-3 py-2">Owner</th>
                                <th class="px-3 py-2">Status</th>
                                <th class="px-3 py-2">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($contacts ?? [] as $contact)
                                <tr class="border-t border-slate-100">
                                    <td class="px-3 py-3 align-top">{{ $contact->reference }}</td>
                                    <td class="px-3 py-3 align-top">{{ $contact->first_name }} {{ $contact->last_name }}</td>
                                    <td class="px-3 py-3 align-top">{{ $contact->email }}</td>
                                    <td class="px-3 py-3 align-top">{{ $contact->phone_code ? $contact->phone_code . ' ' : '' }}{{ $contact->phone }}</td>
                                    <td class="px-3 py-3 align-top">{{ optional($contact->company)->name ?? '' }}</td>
                                    <td class="px-3 py-3 align-top">{{ optional($contact->owner)->name ?? '' }}</td>
                                    <td class="px-3 py-3 align-top">{{ ucfirst($contact->status ?? '') }}</td>
                                    <td class="px-3 py-3 align-top">
                                        <div class="flex items-center gap-2">
                                            <button type="button" class="edit-contact inline-flex items-center gap-2 px-3 py-1.5 border rounded-md text-sm text-slate-600 hover:bg-slate-50" data-id="{{ $contact->idtbl_create_contact }}">Edit</button>

                                            <form action="{{ url('crm/contacts/' . $contact->idtbl_create_contact) }}" method="POST" onsubmit="return confirm('Delete this contact?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="inline-flex items-center gap-2 px-3 py-1.5 border rounded-md text-sm text-red-600 hover:bg-red-50">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="px-3 py-4 text-slate-500" colspan="8">No contacts found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
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
                    @if(isset($contacts) && method_exists($contacts, 'total'))
                        Showing results {{ $contacts->firstItem() ?? 0 }} to {{ $contacts->lastItem() ?? 0 }} of
                        {{ $contacts->total() }} entries
                    @endif
                </div>

                <div class="flex items-center gap-1">
                    @if(isset($contacts) && method_exists($contacts, 'previousPageUrl'))
                        <a href="{{ $contacts->previousPageUrl() }}"
                            class="px-3 py-1.5 text-sm rounded-md {{ $contacts->onFirstPage() ? 'text-slate-300 cursor-not-allowed pointer-events-none' : 'text-slate-600 hover:bg-slate-200 transition-colors' }}">
                            Previous
                        </a>
                        @foreach($contacts->getUrlRange(1, $contacts->lastPage()) as $page => $url)
                                <a href="{{ $url }}" class="w-8 h-8 flex items-center justify-center text-sm rounded-md transition-colors
                                                                                                  {{ $page == $contacts->currentPage()
                            ? 'bg-primary-600 text-white font-semibold'
                            : 'text-slate-600 hover:bg-slate-200' }}">
                                    {{ $page }}
                                </a>
                        @endforeach
                        <a href="{{ $contacts->nextPageUrl() }}"
                            class="px-3 py-1.5 text-sm rounded-md {{ !$contacts->hasMorePages() ? 'text-slate-300 cursor-not-allowed pointer-events-none' : 'text-slate-600 hover:bg-slate-200 transition-colors' }}">
                            Next
                        </a>
                    @endif
                </div>
            </div>
        </div>

    </div>

    {{-- ===== ADD CONTACT MODAL ===== --}}
    <div id="createCompanyModal" class="fixed inset-0 hidden items-center justify-center"
        style="background:rgba(0,0,0,0.45); z-index:1100;">

        <div class="bg-white rounded-md shadow-2xl w-full max-w-2xl mx-4 flex flex-col" style="max-height:90vh;">

            {{-- Modal Header --}}
            <div class="flex items-center justify-between px-7 pt-6 pb-4 flex-shrink-0">
                <h2 class="text-2xl font-bold text-slate-800">Add contact</h2>
                <button type="button" id="closeCreateModal"
                    class="w-8 h-8 flex items-center justify-center rounded-full hover:bg-slate-100 text-slate-500 hover:text-slate-700 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            {{-- Modal Body (scrollable) --}}
            <div class="overflow-y-auto flex-1 px-7 pb-4">
                <form id="createCompanyForm" action="{{ route('crm.contacts.store') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf

                    {{-- ---- Personal Information ---- --}}
                    <div class="mb-5">
                        <h3 class="text-lg font-bold text-slate-800 mb-4">Personal information</h3>

                        <div class="grid grid-cols-2 gap-x-5 gap-y-4">

                            {{-- First Name --}}
                            <div>
                                <label class="block text-xs font-medium text-slate-600 mb-1.5">First name:</label>
                                <input type="text" name="first_name" placeholder="Enter first name"
                                    class="w-full px-3 py-2.5 text-sm border border-slate-200 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent placeholder-slate-400">
                            </div>

                            {{-- Last Name --}}
                            <div>
                                <label class="block text-xs font-medium text-slate-600 mb-1.5">Last name:</label>
                                <input type="text" name="last_name" placeholder="Enter last name"
                                    class="w-full px-3 py-2.5 text-sm border border-slate-200 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent placeholder-slate-400">
                            </div>

                            {{-- Reference # --}}
                            <div>
                                <label class="block text-xs font-medium text-slate-600 mb-1.5">Reference #:</label>
                                <input type="text" name="reference" readonly
                                    value="{{ $nextReference ?? 'P-101' }}"
                                    class="w-full px-3 py-2.5 text-sm border border-slate-200 rounded-md bg-slate-50 text-slate-700 focus:outline-none cursor-default">
                            </div>

                            {{-- Contact Type --}}
                            <div>
                                <label class="block text-xs font-medium text-slate-600 mb-1.5">Contact type:</label>
                                <div class="relative" id="modalContactTypeWrapper">
                                    <input type="hidden" name="contact_type" id="modalContactTypeHidden" value="">
                                    <button type="button" id="modalContactTypeBtn"
                                        class="w-full flex items-center gap-2 pl-3 pr-8 py-2.5 text-sm text-slate-600 border border-slate-200 rounded-md bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 cursor-pointer text-left hover:border-blue-400 transition-colors">
                                        <span id="modalContactTypeLabel" class="truncate">Select contact types</span>
                                    </button>
                                    <div class="absolute inset-y-0 right-3 flex items-center pointer-events-none">
                                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </div>
                                    <div id="modalContactTypePanel"
                                        class="hidden absolute z-50 left-0 right-0 mt-2 bg-white border border-slate-200 rounded-md shadow-lg overflow-hidden">
                                        <ul class="py-1 max-h-48 overflow-y-auto">
                                            <li class="modal-option-contact_type flex items-center px-4 py-2.5 text-sm cursor-pointer text-slate-600 hover:bg-slate-50 bg-blue-600 text-white font-semibold"
                                                data-value="" data-label="Select contact types">Select contact types</li>
                                            <li class="modal-option-contact_type flex items-center px-4 py-2.5 text-sm cursor-pointer text-slate-600 hover:bg-slate-50 "
                                                data-value="customer" data-label="Customer">Customer</li>
                                            <li class="modal-option-contact_type flex items-center px-4 py-2.5 text-sm cursor-pointer text-slate-600 hover:bg-slate-50 "
                                                data-value="supplier" data-label="Supplier">Supplier</li>
                                            <li class="modal-option-contact_type flex items-center px-4 py-2.5 text-sm cursor-pointer text-slate-600 hover:bg-slate-50 "
                                                data-value="partner" data-label="Partner">Partner</li>
                                            <li class="modal-option-contact_type flex items-center px-4 py-2.5 text-sm cursor-pointer text-slate-600 hover:bg-slate-50 "
                                                data-value="broker_sales_agent" data-label="Broker &amp; Sales Agent">Broker
                                                &amp; Sales Agent</li>
                                            <li class="modal-option-contact_type flex items-center px-4 py-2.5 text-sm cursor-pointer text-slate-600 hover:bg-slate-50 "
                                                data-value="contractor" data-label="Contractor">Contractor</li>
                                            <li class="modal-option-contact_type flex items-center px-4 py-2.5 text-sm cursor-pointer text-slate-600 hover:bg-slate-50 "
                                                data-value="employee" data-label="Employee">Employee</li>
                                            <li class="modal-option-contact_type flex items-center px-4 py-2.5 text-sm cursor-pointer text-slate-600 hover:bg-slate-50 "
                                                data-value="all" data-label="All">All</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            {{-- Email --}}
                            <div>
                                <label class="block text-xs font-medium text-slate-600 mb-1.5">Email:</label>
                                <input type="email" name="email" placeholder="Enter email"
                                    class="w-full px-3 py-2.5 text-sm border border-slate-200 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent placeholder-slate-400">
                            </div>

                            {{-- Phone Number --}}
                            <div>
                                <label class="block text-xs font-medium text-slate-600 mb-1.5">Phone number</label>
                                <div class="flex gap-2">
                                    <div id="modalPhoneCodeWrapper" class="relative w-36 flex-shrink-0">
                                        <input type="hidden" name="phone_code" id="modalPhoneCodeHidden" value="">
                                        <button type="button" id="modalPhoneCodeBtn"
                                            class="w-full flex items-center gap-2 pl-3 pr-6 py-2.5 text-sm text-slate-600 border border-slate-200 rounded-md bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 cursor-pointer text-left hover:border-blue-400 transition-colors">
                                            <span id="modalPhoneCodeLabel" class="truncate">Country code</span>
                                        </button>
                                        <div class="absolute inset-y-0 right-2 flex items-center pointer-events-none">
                                            <svg class="w-3 h-3 text-slate-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 9l-7 7-7-7" />
                                            </svg>
                                        </div>
                                        <div id="modalPhoneCodePanel"
                                            class="hidden absolute z-50 left-0 mt-2 bg-white border border-slate-200 rounded-md shadow-lg overflow-hidden w-64">
                                            <div class="p-2 border-b border-slate-100">
                                                <input type="text" id="modalPhoneCodeSearch" placeholder="Search..."
                                                    class="w-full px-3 py-2 text-sm border border-slate-200 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                                    autocomplete="off">
                                            </div>
                                                                                        <ul id="modalPhoneCodeList" class="py-1 max-h-48 overflow-y-auto w-full">
                                                <li class="modal-option-phone_code px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer text-slate-400 italic"
                                                    data-value="" data-label="Country code">Country code</li>
                                                @foreach($phoneCodes ?? [] as $pc)
                                                    <li class="modal-option-phone_code px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer"
                                                        data-value="{{ $pc->phone_code }}" data-label="{{ $pc->flag_emoji }} {{ $pc->phone_code }}">
                                                        {{ $pc->flag_emoji }} {{ $pc->phone_code }} ({{ $pc->country_name }})
                                                    </li>
                                                @endforeach
                                                <li class="hidden px-3 py-2 text-sm text-slate-400 italic no-results">No results
                                                    found</li>
                                            </ul>
                                        </div>
                                    </div>
                                    <input type="text" name="phone" placeholder="Phone"
                                        class="flex-1 px-3 py-2.5 text-sm border border-slate-200 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent placeholder-slate-400">
                                </div>
                            </div>

                            {{-- Owned By --}}
                            <div>
                                <label class="block text-xs font-medium text-slate-600 mb-1.5">Owned by:</label>
                                <div class="relative" id="modalOwnedByWrapper">
                                    <input type="hidden" name="owned_by" id="modalOwnedByHidden" value="">
                                    <button type="button" id="modalOwnedByBtn"
                                        class="w-full flex items-center gap-2 px-3 py-2.5 text-sm text-slate-600 border border-slate-200 rounded-md bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 cursor-pointer text-left hover:border-blue-400 transition-colors">
                                        <span id="modalOwnedByLabel" class="truncate">select owned by</span>
                                    </button>
                                    <div class="absolute inset-y-0 right-3 flex items-center pointer-events-none">
                                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </div>
                                    <div id="modalOwnedByPanel"
                                        class="hidden absolute z-50 left-0 mt-2 bg-white border border-slate-200 rounded-md shadow-lg overflow-hidden"
                                        style="min-width: 100%;">
                                        <div class="p-2 border-b border-slate-100">
                                            <input type="text" id="modalOwnedBySearch" placeholder="Search..."
                                                class="w-full px-3 py-2 text-sm border border-slate-200 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                                autocomplete="off">
                                        </div>
                                        <ul id="modalOwnedByList" class="py-1 max-h-48 overflow-y-auto">
                                            <li class="modal-option-owned_by px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer text-slate-400 italic"
                                                data-value="" data-label="select owned by">select owned by</li>
                                            @foreach($owners ?? [] as $owner)
                                                <li class="modal-option-owned_by px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer"
                                                    data-value="{{ $owner->id }}" data-label="{{ $owner->name }}">
                                                    {{ $owner->name }}
                                                </li>
                                            @endforeach
                                            <li class="hidden px-3 py-2 text-sm text-slate-400 italic no-results">No results
                                                found</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            {{-- Role --}}
                            <div>
                                <label class="block text-xs font-medium text-slate-600 mb-1.5">Role:</label>
                                <div class="relative" id="modalRoleWrapper">
                                    <input type="hidden" name="role" id="modalRoleHidden" value="">
                                    <button type="button" id="modalRoleBtn"
                                        class="w-full flex items-center gap-2 pl-3 pr-8 py-2.5 text-sm text-slate-600 border border-slate-200 rounded-md bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 cursor-pointer text-left hover:border-blue-400 transition-colors">
                                        <span id="modalRoleLabel" class="truncate">Select role</span>
                                    </button>
                                    <div class="absolute inset-y-0 right-3 flex items-center pointer-events-none">
                                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </div>
                                    <div id="modalRolePanel"
                                        class="hidden absolute z-50 left-0 right-0 mt-2 bg-white border border-slate-200 rounded-md shadow-lg overflow-hidden">
                                        <ul class="py-1 max-h-48 overflow-y-auto">
                                            <li class="modal-option-role flex items-center px-4 py-2.5 text-sm cursor-pointer text-slate-600 hover:bg-slate-50 bg-blue-600 text-white font-semibold"
                                                data-value="" data-label="Select role">Select role</li>
                                            @foreach($roles ?? [] as $role)
                                                <li class="modal-option-role flex items-center px-4 py-2.5 text-sm cursor-pointer text-slate-600 hover:bg-slate-50"
                                                    data-value="{{ $role->value ?? $role->idtbl_role }}" data-label="{{ $role->role_name }}">{{ $role->role_name }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            {{-- Profile Image (full width) --}}
                            <div class="col-span-2">
                                <label class="block text-xs font-medium text-slate-600 mb-1.5">
                                    Profile image: <span class="text-slate-400 font-normal">(Max file size is 1MB)</span>
                                </label>
                                <input type="file" name="profile_image" accept="image/*"
                                    class="w-full text-sm text-slate-500 border border-slate-200 rounded-md file:mr-3 file:py-2 file:px-4 file:rounded-l-md file:border-0 file:text-sm file:font-medium file:bg-slate-100 file:text-slate-700 hover:file:bg-slate-200 cursor-pointer">
                            </div>

                        </div>
                    </div>

                    {{-- Divider --}}
                    <div class="border-t border-slate-100 my-2"></div>

                    {{-- ---- Address ---- --}}
                    <div class="mb-5 mt-5">
                        <div class="bg-slate-50 rounded-md px-5 py-3 mb-5">
                            <h3 class="text-lg font-bold text-slate-800">Address</h3>
                        </div>

                        <div class="grid grid-cols-2 gap-x-5 gap-y-4">

                            <div>
                                <label class="block text-xs font-medium text-slate-600 mb-1.5">Address (line 1):</label>
                                <input type="text" name="address_line1" placeholder="Add address line 1"
                                    class="w-full px-3 py-2.5 text-sm border border-slate-200 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent placeholder-slate-400">
                            </div>

                            <div>
                                <label class="block text-xs font-medium text-slate-600 mb-1.5">Address (line 2):</label>
                                <input type="text" name="address_line2" placeholder="Add address line 2"
                                    class="w-full px-3 py-2.5 text-sm border border-slate-200 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent placeholder-slate-400">
                            </div>

                            <div>
                                <label class="block text-xs font-medium text-slate-600 mb-1.5">Address (line 3):</label>
                                <input type="text" name="address_line3" placeholder="Add address line 3"
                                    class="w-full px-3 py-2.5 text-sm border border-slate-200 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent placeholder-slate-400">
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
                                        class="hidden absolute z-50 left-0 mt-2 bg-white border border-slate-200 rounded-md shadow-lg overflow-hidden w-64">
                                        <div class="p-2 border-b border-slate-100">
                                            <input type="text" id="modalCountrySearch" placeholder="Search..."
                                                class="w-full px-3 py-2 text-sm border border-slate-200 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                                autocomplete="off">
                                        </div>
                                                                                <ul id="modalCountryList" class="py-1 max-h-48 overflow-y-auto w-full">
                                            <li class="modal-option-country px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer text-slate-400 italic"
                                                data-value="" data-label="Choose country">Choose country</li>
                                            @foreach($countries ?? [] as $co)
                                                <li class="modal-option-country px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer"
                                                    data-value="{{ $co->value ?? $co->idtbl_country }}" data-label="{{ $co->country_name }}">{{ $co->country_name }}</li>
                                            @endforeach
                                            <li class="hidden px-3 py-2 text-sm text-slate-400 italic no-results">No results
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
                                        class="hidden absolute z-50 left-0 mt-2 bg-white border border-slate-200 rounded-md shadow-lg overflow-hidden w-64">
                                        <div class="p-2 border-b border-slate-100">
                                            <input type="text" id="modalStateSearch" placeholder="Search..."
                                                class="w-full px-3 py-2 text-sm border border-slate-200 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                                autocomplete="off">
                                        </div>
                                                                                <ul id="modalStateList" class="py-1 max-h-48 overflow-y-auto w-full">
                                            <li class="modal-option-state px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer text-slate-400 italic"
                                                data-value="" data-label="Choose state">Choose state</li>
                                            @foreach($states ?? [] as $st)
                                                <li class="modal-option-state px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer"
                                                    data-value="{{ $st->value ?? $st->idtbl_state }}" data-label="{{ $st->state_name }}" data-country="{{ $st->country->value ?? $st->idtbl_country }}">{{ $st->state_name }}</li>
                                            @endforeach
                                            <li class="hidden px-3 py-2 text-sm text-slate-400 italic no-results">No results
                                                found</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <label class="block text-xs font-medium text-slate-600 mb-1.5">Postal code:</label>
                                <input type="text" name="postal_code" placeholder="Add postal code"
                                    class="w-full px-3 py-2.5 text-sm border border-slate-200 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent placeholder-slate-400">
                            </div>

                        </div>
                    </div>

                    {{-- Divider --}}
                    <div class="border-t border-slate-100 my-2"></div>

                    {{-- ---- Companies ---- --}}
                    <div class="mb-5 mt-5">
                        <div class="bg-slate-50 rounded-md px-5 py-3 mb-5">
                            <h3 class="text-lg font-bold text-slate-800">Companies</h3>
                        </div>

                        <div>
                            <label class="block text-xs font-medium text-slate-600 mb-1.5">Company name:</label>
                            <div id="modalCompanyIdWrapper" class="relative w-1/2">
                                <input type="hidden" name="company_id" id="modalCompanyIdHidden" value="">
                                <button type="button" id="modalCompanyIdBtn"
                                    class="w-full flex items-center gap-2 pl-3 pr-8 py-2.5 text-sm text-slate-600 border border-slate-200 rounded-md bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 cursor-pointer text-left hover:border-blue-400 transition-colors">
                                    <span id="modalCompanyIdLabel" class="truncate">Choose company</span>
                                </button>
                                <div class="absolute inset-y-0 right-3 flex items-center pointer-events-none">
                                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7" />
                                    </svg>
                                </div>
                                <div id="modalCompanyIdPanel"
                                    class="hidden absolute z-50 left-0 mt-2 bg-white border border-slate-200 rounded-md shadow-lg overflow-hidden"
                                    style="min-width: 100%;">
                                    <div class="p-2 border-b border-slate-100">
                                        <input type="text" id="modalCompanyIdSearch" placeholder="Search..."
                                            class="w-full px-3 py-2 text-sm border border-slate-200 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                            autocomplete="off">
                                    </div>
                                    <ul id="modalCompanyIdList" class="py-1 max-h-48 overflow-y-auto">
                                        <li class="modal-option-company_id px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer text-slate-400 italic"
                                            data-value="" data-label="Choose company">Choose company</li>
                                        @foreach($companies_list ?? [] as $company)
                                            <li class="modal-option-company_id px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer"
                                                data-value="{{ $company->id }}" data-label="{{ $company->name }}">
                                                {{ $company->name }}
                                            </li>
                                        @endforeach
                                        <li class="hidden px-3 py-2 text-sm text-slate-400 italic no-results">No results
                                            found</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Hidden status default --}}
                    <input type="hidden" name="status" value="active">

                </form>
            </div>

            {{-- Modal Footer --}}
            <div class="flex items-center justify-between px-7 py-4 border-t border-slate-100 flex-shrink-0">
                <button type="button" id="cancelCreateModal"
                    class="px-6 py-2.5 text-sm font-semibold text-red-500 border border-red-400 rounded-md hover:bg-red-50 transition-colors">
                    Cancel
                </button>
                <button type="button" id="createCompanyBtn"
                    class="px-8 py-2.5 text-sm font-semibold text-white bg-blue-600 hover:bg-blue-700 rounded-md shadow-sm transition-colors">
                    Update
                </button>
            </div>

        </div>
    </div>
    {{-- ===== END ADD CONTACT MODAL ===== --}}

@endsection

@section('script')
    <script>

        (function () {
            const modal = document.getElementById('createCompanyModal');
            const openBtn = document.getElementById('openCreateModal');
            const closeBtn = document.getElementById('closeCreateModal');
            const cancelBtn = document.getElementById('cancelCreateModal');
            const actionBtn = document.getElementById('createCompanyBtn');
            const form = document.getElementById('createCompanyForm');

            const storeUrl = "{{ route('crm.contacts.store') }}";
            const contactBaseUrl = "{{ url('crm/contacts') }}";

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

            function setFormToCreate() {
                form.reset();
                form.action = storeUrl;
                // remove method spoof if present
                const m = form.querySelector('input[name="_method"]');
                if (m) m.remove();
                // reset modal labels that are not regular inputs
                const labelIds = ['modalContactTypeLabel','modalPhoneCodeLabel','modalOwnedByLabel','modalRoleLabel','modalCountryLabel','modalStateLabel','modalCompanyIdLabel'];
                labelIds.forEach(id => {
                    const el = document.getElementById(id);
                    if (el) {
                        // default placeholder text when cleared
                        if (id === 'modalPhoneCodeLabel') el.textContent = 'Country code';
                        else if (id === 'modalCompanyIdLabel') el.textContent = 'Choose company';
                        else if (id === 'modalCountryLabel') el.textContent = 'Choose country';
                        else if (id === 'modalStateLabel') el.textContent = 'Choose state';
                        else el.textContent = 'Select';
                    }
                });
                // header + action button text
                const header = modal.querySelector('h2');
                if (header) header.textContent = 'Add contact';
                if (actionBtn) actionBtn.textContent = 'Create';
            }

            async function setFormToEdit(id) {
                try {
                    const res = await fetch(contactBaseUrl + '/' + id);
                    if (!res.ok) throw new Error('Failed to fetch');
                    const data = await res.json();

                    // set simple fields
                    Object.keys(data).forEach(key => {
                        const el = form.querySelector('[name="' + key + '"]');
                        if (el) {
                            el.value = data[key] ?? '';
                        }
                    });

                    // update labels for select-like components
                    const mapping = {
                        contact_type: 'modalContactTypeLabel',
                        phone_code: 'modalPhoneCodeLabel',
                        owned_by: 'modalOwnedByLabel',
                        role: 'modalRoleLabel',
                        country: 'modalCountryLabel',
                        state: 'modalStateLabel',
                        company_id: 'modalCompanyIdLabel'
                    };
                    Object.keys(mapping).forEach(k => {
                        const lbl = document.getElementById(mapping[k]);
                        if (lbl) {
                            lbl.textContent = data[k] ?? lbl.textContent;
                        }
                    });

                    // change action + method
                    form.action = contactBaseUrl + '/' + id;
                    let methodInput = form.querySelector('input[name="_method"]');
                    if (!methodInput) {
                        methodInput = document.createElement('input');
                        methodInput.type = 'hidden';
                        methodInput.name = '_method';
                        form.appendChild(methodInput);
                    }
                    methodInput.value = 'PUT';

                    const header = modal.querySelector('h2');
                    if (header) header.textContent = 'Edit contact';
                    if (actionBtn) actionBtn.textContent = 'Update';
                } catch (err) {
                    console.error(err);
                    alert('Unable to load contact data.');
                }
            }

            if (openBtn) openBtn.addEventListener('click', function () {
                setFormToCreate();
                openModal();
            });
            if (closeBtn) closeBtn.addEventListener('click', closeModal);
            if (cancelBtn) cancelBtn.addEventListener('click', closeModal);

            if (modal) {
                modal.addEventListener('click', function (e) {
                    if (e.target === modal) closeModal();
                });
            }

            document.addEventListener('keydown', function (e) {
                if (modal && e.key === 'Escape' && !modal.classList.contains('hidden')) closeModal();
            });

            if (actionBtn) {
                actionBtn.addEventListener('click', function () {
                    form.submit();
                });
            }

            // delegate edit button clicks
            document.addEventListener('click', function (e) {
                const editBtn = e.target.closest('.edit-contact');
                if (editBtn) {
                    const id = editBtn.dataset.id;
                    if (id) {
                        setFormToEdit(id);
                        openModal();
                    }
                }
            });
        })();



        function makeFilterDropdown(wrapperId, btnId, panelId, hiddenId, labelId, optionClass, filterForm) {
            const wrapper = document.getElementById(wrapperId);
            const btn = document.getElementById(btnId);
            const panel = document.getElementById(panelId);
            const hidden = document.getElementById(hiddenId);
            const label = document.getElementById(labelId);
            if (!btn) return;

            btn.addEventListener('click', function (e) {
                e.stopPropagation();
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
                panel.querySelectorAll('.' + optionClass).forEach(function (o) {
                    o.classList.remove('bg-blue-600', 'text-white', 'font-semibold');
                    o.classList.add('text-slate-600', 'hover:bg-slate-50');
                });
                opt.classList.add('bg-blue-600', 'text-white', 'font-semibold');
                opt.classList.remove('text-slate-600', 'hover:bg-slate-50');
                panel.classList.add('hidden');
                document.getElementById(filterForm).submit();
            });

            document.addEventListener('click', function (e) {
                if (wrapper && !wrapper.contains(e.target)) panel.classList.add('hidden');
            });
        }

        makeFilterDropdown('companyTypeWrapper', 'companyTypeBtn', 'companyTypePanel', 'companyTypeHidden', 'companyTypeLabel', 'ct-option', 'filterForm');
        makeFilterDropdown('statusWrapper', 'statusBtn', 'statusPanel', 'statusHidden', 'statusLabel', 'st-option', 'filterForm');

        (function () {
            const btn = document.getElementById('ownerDropdownBtn');
            const panel = document.getElementById('ownerDropdownPanel');
            const search = document.getElementById('ownerSearchInput');
            const label = document.getElementById('ownerDropdownLabel');
            const hidden = document.getElementById('ownerHiddenInput');
            const options = document.querySelectorAll('.owner-option');
            const noResults = document.getElementById('ownerNoResults');

            if (!btn) return;

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

            document.getElementById('ownerOptionsList').addEventListener('click', function (e) {
                const opt = e.target.closest('.owner-option');
                if (!opt) return;
                hidden.value = opt.dataset.value;
                label.textContent = opt.dataset.label;
                options.forEach(function (o) {
                    o.classList.remove('bg-blue-50', 'text-blue-700', 'font-medium');
                });
                if (opt.dataset.value) {
                    opt.classList.add('bg-blue-50', 'text-blue-700', 'font-medium');
                }
                panel.classList.add('hidden');
            });

            document.addEventListener('click', function (e) {
                if (!document.getElementById('ownerDropdownWrapper').contains(e.target)) {
                    panel.classList.add('hidden');
                }
            });

            document.addEventListener('keydown', function (e) {
                if (e.key === 'Escape') panel.classList.add('hidden');
            });
        })();



        document.addEventListener('DOMContentLoaded', function () {
            function setupModalSimpleDropdown(fieldName) {
                const wrapperId = 'modal' + fieldName + 'Wrapper';
                const wrapper = document.getElementById(wrapperId);
                if (!wrapper) return;
                const btn = document.getElementById('modal' + fieldName + 'Btn');
                const panel = document.getElementById('modal' + fieldName + 'Panel');
                const hidden = document.getElementById('modal' + fieldName + 'Hidden');
                const label = document.getElementById('modal' + fieldName + 'Label');
                const options = panel.querySelectorAll('li.modal-option-' + fieldName.replace(/([A-Z])/g, "_$1").toLowerCase().replace(/^_/, ''));

                btn.addEventListener('click', function (e) {
                    e.stopPropagation();
                    document.querySelectorAll('.filter-panel, [id$="Panel"]').forEach(p => {
                        if (p !== panel && p.id !== 'ownerDropdownPanel' && p.id !== 'companyTypePanel' && p.id !== 'statusPanel') p.classList.add('hidden');
                    });
                    panel.classList.toggle('hidden');
                });

                panel.addEventListener('click', function (e) {
                    const opt = e.target.closest('li');
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

            function setupModalSearchableDropdown(fieldName) {
                const wrapperId = 'modal' + fieldName + 'Wrapper';
                const wrapper = document.getElementById(wrapperId);
                if (!wrapper) return;
                const btn = document.getElementById('modal' + fieldName + 'Btn');
                const panel = document.getElementById('modal' + fieldName + 'Panel');
                const hidden = document.getElementById('modal' + fieldName + 'Hidden');
                const label = document.getElementById('modal' + fieldName + 'Label');
                const search = document.getElementById('modal' + fieldName + 'Search');
                const list = document.getElementById('modal' + fieldName + 'List');
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
                    if (fieldName.endsWith('State')) {
                        const countryId = 'modal' + fieldName.replace('State', 'Country') + 'Hidden';
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
                        o.classList.remove('bg-blue-50', 'text-blue-700', 'font-medium');
                    });
                    if (opt.getAttribute('data-value')) {
                        opt.classList.add('bg-blue-50', 'text-blue-700', 'font-medium');
                    }
                    panel.classList.add('hidden');
                });

                document.addEventListener('click', function (e) {
                    if (!wrapper.contains(e.target)) panel.classList.add('hidden');
                });
            }

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

            setupModalSimpleDropdown('ContactType');
            setupModalSearchableDropdown('PhoneCode');
            setupModalSearchableDropdown('OwnedBy');
            setupModalSimpleDropdown('Role');
            setupModalSearchableDropdown('Country');
            setupModalSearchableDropdown('State');
            setupModalSearchableDropdown('CompanyId');

            bindCountryStateFilter('modalCountryHidden', 'modalStateWrapper', 'modalStateHidden', 'modalStateLabel', 'modalStateList', 'modal-option-state');
        });
    </script>
@endsection
