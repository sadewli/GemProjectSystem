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

    {{-- ===== ADD CONTACT MODAL ===== --}}
    <div id="createCompanyModal" class="fixed inset-0 z-50 hidden items-center justify-center"
        style="background:rgba(0,0,0,0.45);">

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
                                    value="P-101"
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
                                                <li class="modal-option-phone_code px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="LK+94" data-label="LK+94">LK+94</li>
                                                <li class="modal-option-phone_code px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="AF+93" data-label="AF+93">AF+93</li>
                                                <li class="modal-option-phone_code px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="DZ+213" data-label="DZ+213">DZ+213</li>
                                                <li class="modal-option-phone_code px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="AS+1684" data-label="AS+1684">AS+1684</li>
                                                <li class="modal-option-phone_code px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="AD+376" data-label="AD+376">AD+376</li>
                                                <li class="modal-option-phone_code px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="AO+244" data-label="AO+244">AO+244</li>
                                                <li class="modal-option-phone_code px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="AI+1264" data-label="AI+1264">AI+1264</li>
                                                <li class="modal-option-phone_code px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="AG+1268" data-label="AG+1268">AG+1268</li>
                                                <li class="modal-option-phone_code px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="AM+374" data-label="AM+374">AM+374</li>
                                                <li class="modal-option-phone_code px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="AW+297" data-label="AW+297">AW+297</li>
                                                <li class="modal-option-phone_code px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="AU+61" data-label="AU+61">AU+61</li>
                                                <li class="modal-option-phone_code px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="AT+43" data-label="AT+43">AT+43</li>
                                                <li class="modal-option-phone_code px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="AZ+994" data-label="AZ+994">AZ+994</li>
                                                <li class="modal-option-phone_code px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="BS+1242" data-label="BS+1242">BS+1242</li>
                                                <li class="modal-option-phone_code px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="BH+973" data-label="BH+973">BH+973</li>
                                                <li class="modal-option-phone_code px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="BD+880" data-label="BD+880">BD+880</li>
                                                <li class="modal-option-phone_code px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="BB+1246" data-label="BB+1246">BB+1246</li>
                                                <li class="modal-option-phone_code px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="BY+375" data-label="BY+375">BY+375</li>
                                                <li class="modal-option-phone_code px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="BE+32" data-label="BE+32">BE+32</li>
                                                <li class="modal-option-phone_code px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="BZ+501" data-label="BZ+501">BZ+501</li>
                                                <li class="modal-option-phone_code px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="BJ+229" data-label="BJ+229">BJ+229</li>
                                                <li class="modal-option-phone_code px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="BT+975" data-label="BT+975">BT+975</li>
                                                <li class="modal-option-phone_code px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="BO+591" data-label="BO+591">BO+591</li>
                                                <li class="modal-option-phone_code px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="BA+387" data-label="BA+387">BA+387</li>
                                                <li class="modal-option-phone_code px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="BW+267" data-label="BW+267">BW+267</li>
                                                <li class="modal-option-phone_code px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="BR+55" data-label="BR+55">BR+55</li>
                                                <li class="modal-option-phone_code px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="BN+673" data-label="BN+673">BN+673</li>
                                                <li class="modal-option-phone_code px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="BG+359" data-label="BG+359">BG+359</li>
                                                <li class="modal-option-phone_code px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="BF+226" data-label="BF+226">BF+226</li>
                                                <li class="modal-option-phone_code px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="BI+257" data-label="BI+257">BI+257</li>
                                                <li class="modal-option-phone_code px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="KH+855" data-label="KH+855">KH+855</li>
                                                <li class="modal-option-phone_code px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="CM+237" data-label="CM+237">CM+237</li>
                                                <li class="modal-option-phone_code px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="CA+1" data-label="CA+1">CA+1</li>
                                                <li class="modal-option-phone_code px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="CV+238" data-label="CV+238">CV+238</li>
                                                <li class="modal-option-phone_code px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="KY+1345" data-label="KY+1345">KY+1345</li>
                                                <li class="modal-option-phone_code px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="CF+236" data-label="CF+236">CF+236</li>
                                                <li class="modal-option-phone_code px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="TD+235" data-label="TD+235">TD+235</li>
                                                <li class="modal-option-phone_code px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="CL+56" data-label="CL+56">CL+56</li>
                                                <li class="modal-option-phone_code px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="CN+86" data-label="CN+86">CN+86</li>
                                                <li class="modal-option-phone_code px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="CO+57" data-label="CO+57">CO+57</li>
                                                <li class="modal-option-phone_code px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="KM+269" data-label="KM+269">KM+269</li>
                                                <li class="modal-option-phone_code px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="CG+242" data-label="CG+242">CG+242</li>
                                                <li class="modal-option-phone_code px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="CD+243" data-label="CD+243">CD+243</li>
                                                <li class="modal-option-phone_code px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="CK+682" data-label="CK+682">CK+682</li>
                                                <li class="modal-option-phone_code px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="CR+506" data-label="CR+506">CR+506</li>
                                                <li class="modal-option-phone_code px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="CI+225" data-label="CI+225">CI+225</li>
                                                <li class="modal-option-phone_code px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="HR+385" data-label="HR+385">HR+385</li>
                                                <li class="modal-option-phone_code px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="CU+53" data-label="CU+53">CU+53</li>
                                                <li class="modal-option-phone_code px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="CY+357" data-label="CY+357">CY+357</li>
                                                <li class="modal-option-phone_code px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="CZ+420" data-label="CZ+420">CZ+420</li>
                                                <li class="modal-option-phone_code px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="DK+45" data-label="DK+45">DK+45</li>
                                                <li class="modal-option-phone_code px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="DJ+253" data-label="DJ+253">DJ+253</li>
                                                <li class="modal-option-phone_code px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="DM+1767" data-label="DM+1767">DM+1767</li>
                                                <li class="modal-option-phone_code px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="DO+1809" data-label="DO+1809">DO+1809</li>
                                                <li class="modal-option-phone_code px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="EC+593" data-label="EC+593">EC+593</li>
                                                <li class="modal-option-phone_code px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="EG+20" data-label="EG+20">EG+20</li>
                                                <li class="modal-option-phone_code px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="SV+503" data-label="SV+503">SV+503</li>
                                                <li class="modal-option-phone_code px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="GQ+240" data-label="GQ+240">GQ+240</li>
                                                <li class="modal-option-phone_code px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="ER+291" data-label="ER+291">ER+291</li>
                                                <li class="modal-option-phone_code px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="EE+372" data-label="EE+372">EE+372</li>
                                                <li class="modal-option-phone_code px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="ET+251" data-label="ET+251">ET+251</li>
                                                <li class="modal-option-phone_code px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="FJ+679" data-label="FJ+679">FJ+679</li>
                                                <li class="modal-option-phone_code px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="FI+358" data-label="FI+358">FI+358</li>
                                                <li class="modal-option-phone_code px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="FR+33" data-label="FR+33">FR+33</li>
                                                <li class="modal-option-phone_code px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="GA+241" data-label="GA+241">GA+241</li>
                                                <li class="modal-option-phone_code px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="GM+220" data-label="GM+220">GM+220</li>
                                                <li class="modal-option-phone_code px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="GE+995" data-label="GE+995">GE+995</li>
                                                <li class="modal-option-phone_code px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="DE+49" data-label="DE+49">DE+49</li>
                                                <li class="modal-option-phone_code px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="GH+233" data-label="GH+233">GH+233</li>
                                                <li class="modal-option-phone_code px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="GI+350" data-label="GI+350">GI+350</li>
                                                <li class="modal-option-phone_code px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="GR+30" data-label="GR+30">GR+30</li>
                                                <li class="modal-option-phone_code px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="GL+299" data-label="GL+299">GL+299</li>
                                                <li class="modal-option-phone_code px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="GD+1473" data-label="GD+1473">GD+1473</li>
                                                <li class="modal-option-phone_code px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="GU+1671" data-label="GU+1671">GU+1671</li>
                                                <li class="modal-option-phone_code px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="GT+502" data-label="GT+502">GT+502</li>
                                                <li class="modal-option-phone_code px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="GY+592" data-label="GY+592">GY+592</li>
                                                <li class="modal-option-phone_code px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="HT+509" data-label="HT+509">HT+509</li>
                                                <li class="modal-option-phone_code px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="HN+504" data-label="HN+504">HN+504</li>
                                                <li class="modal-option-phone_code px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="HK+852" data-label="HK+852">HK+852</li>
                                                <li class="modal-option-phone_code px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="HU+36" data-label="HU+36">HU+36</li>
                                                <li class="modal-option-phone_code px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="IS+354" data-label="IS+354">IS+354</li>
                                                <li class="modal-option-phone_code px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="IN+91" data-label="IN+91">IN+91</li>
                                                <li class="modal-option-phone_code px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="ID+62" data-label="ID+62">ID+62</li>
                                                <li class="modal-option-phone_code px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="IR+98" data-label="IR+98">IR+98</li>
                                                <li class="modal-option-phone_code px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="IQ+964" data-label="IQ+964">IQ+964</li>
                                                <li class="modal-option-phone_code px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="IE+353" data-label="IE+353">IE+353</li>
                                                <li class="modal-option-phone_code px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="IL+972" data-label="IL+972">IL+972</li>
                                                <li class="modal-option-phone_code px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="IT+39" data-label="IT+39">IT+39</li>
                                                <li class="modal-option-phone_code px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="JM+1876" data-label="JM+1876">JM+1876</li>
                                                <li class="modal-option-phone_code px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="JP+81" data-label="JP+81">JP+81</li>
                                                <li class="modal-option-phone_code px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="JO+962" data-label="JO+962">JO+962</li>
                                                <li class="modal-option-phone_code px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="KZ+76" data-label="KZ+76">KZ+76</li>
                                                <li class="modal-option-phone_code px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="KE+254" data-label="KE+254">KE+254</li>
                                                <li class="modal-option-phone_code px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="KI+686" data-label="KI+686">KI+686</li>
                                                <li class="modal-option-phone_code px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="KP+850" data-label="KP+850">KP+850</li>
                                                <li class="modal-option-phone_code px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="KR+82" data-label="KR+82">KR+82</li>
                                                <li class="modal-option-phone_code px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="KW+965" data-label="KW+965">KW+965</li>
                                                <li class="modal-option-phone_code px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="KG+996" data-label="KG+996">KG+996</li>
                                                <li class="modal-option-phone_code px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="LA+856" data-label="LA+856">LA+856</li>
                                                <li class="modal-option-phone_code px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="LV+371" data-label="LV+371">LV+371</li>
                                                <li class="modal-option-phone_code px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="LB+961" data-label="LB+961">LB+961</li>
                                                <li class="modal-option-phone_code px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="LS+266" data-label="LS+266">LS+266</li>
                                                <li class="modal-option-phone_code px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="LR+231" data-label="LR+231">LR+231</li>
                                                <li class="modal-option-phone_code px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="LY+218" data-label="LY+218">LY+218</li>
                                                <li class="modal-option-phone_code px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="LI+423" data-label="LI+423">LI+423</li>
                                                <li class="modal-option-phone_code px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="LT+370" data-label="LT+370">LT+370</li>
                                                <li class="modal-option-phone_code px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="LU+352" data-label="LU+352">LU+352</li>
                                                <li class="modal-option-phone_code px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="MO+853" data-label="MO+853">MO+853</li>
                                                <li class="modal-option-phone_code px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="MK+389" data-label="MK+389">MK+389</li>
                                                <li class="modal-option-phone_code px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="MG+261" data-label="MG+261">MG+261</li>
                                                <li class="modal-option-phone_code px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="MW+265" data-label="MW+265">MW+265</li>
                                                <li class="modal-option-phone_code px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="MY+60" data-label="MY+60">MY+60</li>
                                                <li class="modal-option-phone_code px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="ML+223" data-label="ML+223">ML+223</li>
                                                <li class="modal-option-phone_code px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="MT+356" data-label="MT+356">MT+356</li>
                                                <li class="modal-option-phone_code px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="MH+692" data-label="MH+692">MH+692</li>
                                                <li class="modal-option-phone_code px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="MQ+596" data-label="MQ+596">MQ+596</li>
                                                <li class="modal-option-phone_code px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="MR+222" data-label="MR+222">MR+222</li>
                                                <li class="modal-option-phone_code px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="MU+230" data-label="MU+230">MU+230</li>
                                                <li class="modal-option-phone_code px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="MX+52" data-label="MX+52">MX+52</li>
                                                <li class="modal-option-phone_code px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="FM+691" data-label="FM+691">FM+691</li>
                                                <li class="modal-option-phone_code px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="MD+373" data-label="MD+373">MD+373</li>
                                                <li class="modal-option-phone_code px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="MC+377" data-label="MC+377">MC+377</li>
                                                <li class="modal-option-phone_code px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="MN+976" data-label="MN+976">MN+976</li>
                                                <li class="modal-option-phone_code px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="MA+212" data-label="MA+212">MA+212</li>
                                                <li class="modal-option-phone_code px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="MZ+258" data-label="MZ+258">MZ+258</li>
                                                <li class="modal-option-phone_code px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="MM+95" data-label="MM+95">MM+95</li>
                                                <li class="modal-option-phone_code px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="NA+264" data-label="NA+264">NA+264</li>
                                                <li class="modal-option-phone_code px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="NR+674" data-label="NR+674">NR+674</li>
                                                <li class="modal-option-phone_code px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="NP+977" data-label="NP+977">NP+977</li>
                                                <li class="modal-option-phone_code px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="NL+31" data-label="NL+31">NL+31</li>
                                                <li class="modal-option-phone_code px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="NZ+64" data-label="NZ+64">NZ+64</li>
                                                <li class="modal-option-phone_code px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="NI+505" data-label="NI+505">NI+505</li>
                                                <li class="modal-option-phone_code px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="NE+227" data-label="NE+227">NE+227</li>
                                                <li class="modal-option-phone_code px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="NG+234" data-label="NG+234">NG+234</li>
                                                <li class="modal-option-phone_code px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="NO+47" data-label="NO+47">NO+47</li>
                                                <li class="modal-option-phone_code px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="OM+968" data-label="OM+968">OM+968</li>
                                                <li class="modal-option-phone_code px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="PK+92" data-label="PK+92">PK+92</li>
                                                <li class="modal-option-phone_code px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="PW+680" data-label="PW+680">PW+680</li>
                                                <li class="modal-option-phone_code px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="PS+970" data-label="PS+970">PS+970</li>
                                                <li class="modal-option-phone_code px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="PA+507" data-label="PA+507">PA+507</li>
                                                <li class="modal-option-phone_code px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="PG+675" data-label="PG+675">PG+675</li>
                                                <li class="modal-option-phone_code px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="PY+595" data-label="PY+595">PY+595</li>
                                                <li class="modal-option-phone_code px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="PE+51" data-label="PE+51">PE+51</li>
                                                <li class="modal-option-phone_code px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="PH+63" data-label="PH+63">PH+63</li>
                                                <li class="modal-option-phone_code px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="PL+48" data-label="PL+48">PL+48</li>
                                                <li class="modal-option-phone_code px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="PT+351" data-label="PT+351">PT+351</li>
                                                <li class="modal-option-phone_code px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="PR+1787" data-label="PR+1787">PR+1787</li>
                                                <li class="modal-option-phone_code px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="QA+974" data-label="QA+974">QA+974</li>
                                                <li class="modal-option-phone_code px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="RO+40" data-label="RO+40">RO+40</li>
                                                <li class="modal-option-phone_code px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="RU+73" data-label="RU+73">RU+73</li>
                                                <li class="modal-option-phone_code px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="RW+250" data-label="RW+250">RW+250</li>
                                                <li class="modal-option-phone_code px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="KN+1869" data-label="KN+1869">KN+1869</li>
                                                <li class="modal-option-phone_code px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="LC+1758" data-label="LC+1758">LC+1758</li>
                                                <li class="modal-option-phone_code px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="VC+1784" data-label="VC+1784">VC+1784</li>
                                                <li class="modal-option-phone_code px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="WS+685" data-label="WS+685">WS+685</li>
                                                <li class="modal-option-phone_code px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="SM+378" data-label="SM+378">SM+378</li>
                                                <li class="modal-option-phone_code px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="SN+221" data-label="SN+221">SN+221</li>
                                                <li class="modal-option-phone_code px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="RS+381" data-label="RS+381">RS+381</li>
                                                <li class="modal-option-phone_code px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="SC+248" data-label="SC+248">SC+248</li>
                                                <li class="modal-option-phone_code px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="SL+232" data-label="SL+232">SL+232</li>
                                                <li class="modal-option-phone_code px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="SG+65" data-label="SG+65">SG+65</li>
                                                <li class="modal-option-phone_code px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="SK+421" data-label="SK+421">SK+421</li>
                                                <li class="modal-option-phone_code px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="SI+386" data-label="SI+386">SI+386</li>
                                                <li class="modal-option-phone_code px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="SB+677" data-label="SB+677">SB+677</li>
                                                <li class="modal-option-phone_code px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="SO+252" data-label="SO+252">SO+252</li>
                                                <li class="modal-option-phone_code px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="ZA+27" data-label="ZA+27">ZA+27</li>
                                                <li class="modal-option-phone_code px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="SS+211" data-label="SS+211">SS+211</li>
                                                <li class="modal-option-phone_code px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="SD+249" data-label="SD+249">SD+249</li>
                                                <li class="modal-option-phone_code px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="SR+597" data-label="SR+597">SR+597</li>
                                                <li class="modal-option-phone_code px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="SZ+268" data-label="SZ+268">SZ+268</li>
                                                <li class="modal-option-phone_code px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="SE+46" data-label="SE+46">SE+46</li>
                                                <li class="modal-option-phone_code px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="CH+41" data-label="CH+41">CH+41</li>
                                                <li class="modal-option-phone_code px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="SY+963" data-label="SY+963">SY+963</li>
                                                <li class="modal-option-phone_code px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="TW+886" data-label="TW+886">TW+886</li>
                                                <li class="modal-option-phone_code px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="TJ+992" data-label="TJ+992">TJ+992</li>
                                                <li class="modal-option-phone_code px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="TZ+255" data-label="TZ+255">TZ+255</li>
                                                <li class="modal-option-phone_code px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="TH+66" data-label="TH+66">TH+66</li>
                                                <li class="modal-option-phone_code px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="TG+228" data-label="TG+228">TG+228</li>
                                                <li class="modal-option-phone_code px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="TO+676" data-label="TO+676">TO+676</li>
                                                <li class="modal-option-phone_code px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="TT+1868" data-label="TT+1868">TT+1868</li>
                                                <li class="modal-option-phone_code px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="TN+216" data-label="TN+216">TN+216</li>
                                                <li class="modal-option-phone_code px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="TR+90" data-label="TR+90">TR+90</li>
                                                <li class="modal-option-phone_code px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="TM+993" data-label="TM+993">TM+993</li>
                                                <li class="modal-option-phone_code px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="TC+1649" data-label="TC+1649">TC+1649</li>
                                                <li class="modal-option-phone_code px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="TV+688" data-label="TV+688">TV+688</li>
                                                <li class="modal-option-phone_code px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="UG+256" data-label="UG+256">UG+256</li>
                                                <li class="modal-option-phone_code px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="UA+380" data-label="UA+380">UA+380</li>
                                                <li class="modal-option-phone_code px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="AE+971" data-label="AE+971">AE+971</li>
                                                <li class="modal-option-phone_code px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="US+1" data-label="US+1">US+1</li>
                                                <li class="modal-option-phone_code px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="UY+598" data-label="UY+598">UY+598</li>
                                                <li class="modal-option-phone_code px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="UZ+998" data-label="UZ+998">UZ+998</li>
                                                <li class="modal-option-phone_code px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="VU+678" data-label="VU+678">VU+678</li>
                                                <li class="modal-option-phone_code px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="VN+84" data-label="VN+84">VN+84</li>
                                                <li class="modal-option-phone_code px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="VG+1284" data-label="VG+1284">VG+1284</li>
                                                <li class="modal-option-phone_code px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="VI+1340" data-label="VI+1340">VI+1340</li>
                                                <li class="modal-option-phone_code px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="YE+967" data-label="YE+967">YE+967</li>
                                                <li class="modal-option-phone_code px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="ZM+260" data-label="ZM+260">ZM+260</li>
                                                <li class="modal-option-phone_code px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                    data-value="ZW+263" data-label="ZW+263">ZW+263</li>
                                                <li class="hidden px-3 py-2 text-sm text-slate-400 italic no-results">No
                                                    results found</li>
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
                                            <li class="modal-option-role flex items-center px-4 py-2.5 text-sm cursor-pointer text-slate-600 hover:bg-slate-50 "
                                                data-value="ceo" data-label="CEO">CEO</li>
                                            <li class="modal-option-role flex items-center px-4 py-2.5 text-sm cursor-pointer text-slate-600 hover:bg-slate-50 "
                                                data-value="accountant_operation_manager"
                                                data-label="Accountant operations manager">Accountant operations manager
                                            </li>
                                            <li class="modal-option-role flex items-center px-4 py-2.5 text-sm cursor-pointer text-slate-600 hover:bg-slate-50 "
                                                data-value="supply_chain_manager" data-label="Supply chain manager">Supply
                                                chain manager</li>
                                            <li class="modal-option-role flex items-center px-4 py-2.5 text-sm cursor-pointer text-slate-600 hover:bg-slate-50 "
                                                data-value="warehouse_manager" data-label="Warehouse manager">Warehouse
                                                manager</li>
                                            <li class="modal-option-role flex items-center px-4 py-2.5 text-sm cursor-pointer text-slate-600 hover:bg-slate-50 "
                                                data-value="sales_manager" data-label="Sales manager">Sales manager</li>
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
                                                data-value="229" data-label="United Arab Emirates">United Arab Emirates</li>
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
                                                data-value="27" data-label="Bosnia and Herzegovina">Bosnia and Herzegovina
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
                                                data-value="50" data-label="Congo The Democratic Republic Of The">Congo The
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
                                                data-value="184" data-label="Saint Kitts And Nevis">Saint Kitts And Nevis
                                            </li>
                                            <li class="modal-option-country px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                data-value="185" data-label="Saint Lucia">Saint Lucia</li>
                                            <li class="modal-option-country px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer "
                                                data-value="187" data-label="Saint Vincent And The Grenadines">Saint Vincent
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
                                                data-value="221" data-label="Trinidad And Tobago">Trinidad And Tobago</li>
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
                                            {{-- States load dynamically via AJAX based on selected country --}}
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

    <script>

        (function () {
            const modal = document.getElementById('createCompanyModal');
            const openBtn = document.getElementById('openCreateModal');
            const closeBtn = document.getElementById('closeCreateModal');
            const cancelBtn = document.getElementById('cancelCreateModal');
            const createBtn = document.getElementById('createCompanyBtn');
            const form = document.getElementById('createCompanyForm');

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

            if (openBtn) openBtn.addEventListener('click', openModal);
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

            if (createBtn) {
                createBtn.addEventListener('click', function () {
                    form.submit();
                });
            }
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

            setupModalSimpleDropdown('ContactType');
            setupModalSearchableDropdown('PhoneCode');
            setupModalSearchableDropdown('OwnedBy');
            setupModalSimpleDropdown('Role');
            setupModalSearchableDropdown('Country');
            setupModalSearchableDropdown('State');
            setupModalSearchableDropdown('CompanyId');
        });
    </script>

@endsection