@extends('layouts.app')

@section('title', 'Product Code Management')

<style>
    /* Custom CSS for Product Code Management */

.pc-tab-btn {
    transition: all 0.2s ease-in-out;
}

/* Custom Scrollbar for Table */
.overflow-x-auto::-webkit-scrollbar {
    height: 10px;
}
.overflow-x-auto::-webkit-scrollbar-track {
    background: #f1f5f9;
    border-radius: 8px;
    margin: 0 16px;
}
.overflow-x-auto::-webkit-scrollbar-thumb {
    background: #cbd5e1;
    border-radius: 8px;
}
.overflow-x-auto::-webkit-scrollbar-thumb:hover {
    background: #94a3b8;
}
</style>

@section('content')
    <div class="p-6 min-h-screen bg-slate-50">
        <!-- Header -->
        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center gap-3">
                <a href="#"
                    class="inline-flex items-center gap-1.5 text-sm font-medium text-slate-500 hover:text-slate-800 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    Back
                </a>
            </div>
        </div>

        <!-- Title Row -->
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-slate-800 tracking-tight">Product code management</h1>
        </div>

        <!-- Filter Card -->
        <div class="bg-white rounded-2xl border border-slate-200 p-5 mb-6 shadow-sm">
            <div class="flex items-center gap-2 mb-4">
                <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                </svg>
                <h2 class="text-sm font-bold text-blue-700 uppercase tracking-wider">Filter by</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                <!-- Product Category -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Product category:</label>
                    <div class="relative" id="productCategoryDropdownWrapper">
                        <!-- Hidden input for the actual value -->
                        <input type="hidden" name="product_category" id="productCategoryHiddenInput" class="pc-filter-input"
                            value="">

                        <!-- Trigger button -->
                        <button type="button" id="productCategoryDropdownBtn"
                            class="w-full flex items-center justify-between pl-3 pr-8 py-2.5 text-sm text-slate-700 bg-white border border-slate-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 cursor-pointer text-left hover:border-blue-400 transition-colors">
                            <span id="productCategoryDropdownLabel" class="truncate">Select</span>
                        </button>
                        <!-- Chevron icon -->
                        <div class="absolute inset-y-0 right-3 flex items-center pointer-events-none">
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>

                        <!-- Dropdown panel -->
                        <div id="productCategoryDropdownPanel"
                            class="hidden absolute z-50 mt-2 w-full bg-white border border-slate-200 rounded-xl shadow-lg overflow-hidden">
                            <!-- Search box -->
                            <div class="p-2 border-b border-slate-100">
                                <input type="text" id="productCategorySearchInput" placeholder="Search category..."
                                    class="w-full px-3 py-2 text-sm border border-slate-200 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                    autocomplete="off">
                            </div>

                            <!-- Options list -->
                            <ul id="productCategoryList" class="max-h-48 overflow-y-auto py-1">
                                <li class="product-category-option px-3 py-2 text-sm text-slate-700 hover:bg-blue-600 hover:text-white cursor-pointer"
                                    data-value="" data-label="Select">Select</li>
                                <li class="product-category-option px-3 py-2 text-sm text-slate-700 hover:bg-blue-600 hover:text-white cursor-pointer"
                                    data-value="1" data-label="C &amp; P Gemstone">C &amp; P Gemstone</li>
                                <li class="product-category-option px-3 py-2 text-sm text-slate-700 hover:bg-blue-600 hover:text-white cursor-pointer"
                                    data-value="2" data-label="Rough and Specimen">Rough and Specimen</li>
                                <li class="product-category-option px-3 py-2 text-sm text-slate-700 hover:bg-blue-600 hover:text-white cursor-pointer"
                                    data-value="7" data-label="C &amp; P Diamond">C &amp; P Diamond</li>
                                <li id="productCategoryNoResults" class="hidden px-3 py-2 text-sm text-slate-400 italic">No
                                    categories found</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Variety -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Variety:</label>
                    <div class="relative" id="varietyDropdownWrapper">
                        <!-- Hidden input for the actual value -->
                        <input type="hidden" name="variety" id="varietyHiddenInput" class="pc-filter-input" value="">

                        <!-- Trigger button -->
                        <button type="button" id="varietyDropdownBtn"
                            class="w-full flex items-center justify-between pl-3 pr-8 py-2.5 text-sm text-slate-700 bg-white border border-slate-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 cursor-pointer text-left hover:border-blue-400 transition-colors">
                            <span id="varietyDropdownLabel" class="truncate">Select</span>
                        </button>
                        <!-- Chevron icon -->
                        <div class="absolute inset-y-0 right-3 flex items-center pointer-events-none">
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>

                        <!-- Dropdown panel -->
                        <div id="varietyDropdownPanel"
                            class="hidden absolute z-50 mt-2 w-full bg-white border border-slate-200 rounded-xl shadow-lg overflow-hidden">
                            <!-- Search box -->
                            <div class="p-2 border-b border-slate-100">
                                <input type="text" id="varietySearchInput" placeholder="Search variety..."
                                    class="w-full px-3 py-2 text-sm border border-slate-200 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                    autocomplete="off">
                            </div>

                            <!-- Options list -->
                            <ul id="varietyList" class="max-h-48 overflow-y-auto py-1">
                                <li class="variety-option px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer"
                                    data-value="" data-label="Select">Select</li>
                                <li id="varietyNoResults" class="hidden px-3 py-2 text-sm text-slate-400 italic">No
                                    varieties found</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Creation Date Range -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Creation date range:</label>
                    <div class="flex items-center gap-2">
                        <input type="date"
                            class="pc-filter-input w-full bg-white border border-slate-300 text-slate-700 py-2.5 px-3 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm hover:border-blue-400 transition-colors"
                            placeholder="From">
                        <span class="text-slate-400 font-medium">-</span>
                        <input type="date"
                            class="pc-filter-input w-full bg-white border border-slate-300 text-slate-700 py-2.5 px-3 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm hover:border-blue-400 transition-colors"
                            placeholder="To">
                    </div>
                </div>

                <!-- Creator -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Creator:</label>
                    <div class="relative" id="creatorDropdownWrapper">
                        <!-- Hidden input for the actual value -->
                        <input type="hidden" name="creator" id="creatorHiddenInput" class="pc-filter-input" value="">

                        <!-- Trigger button -->
                        <button type="button" id="creatorDropdownBtn"
                            class="w-full flex items-center justify-between pl-3 pr-8 py-2.5 text-sm text-slate-700 bg-white border border-slate-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 cursor-pointer text-left hover:border-blue-400 transition-colors">
                            <span id="creatorDropdownLabel" class="truncate">Select</span>
                        </button>
                        <!-- Chevron icon -->
                        <div class="absolute inset-y-0 right-3 flex items-center pointer-events-none">
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>

                        <!-- Dropdown panel -->
                        <div id="creatorDropdownPanel"
                            class="hidden absolute z-50 mt-2 w-full bg-white border border-slate-200 rounded-xl shadow-lg overflow-hidden">
                            <!-- Search box -->
                            <div class="p-2 border-b border-slate-100">
                                <input type="text" id="creatorSearchInput" placeholder="Search creator..."
                                    class="w-full px-3 py-2 text-sm border border-slate-200 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                    autocomplete="off">
                            </div>

                            <!-- Options list -->
                            <ul id="creatorList" class="max-h-48 overflow-y-auto py-1">
                                <li class="creator-option px-3 py-2 text-sm text-slate-700 hover:bg-blue-600 hover:text-white cursor-pointer"
                                    data-value="" data-label="Select">Select</li>
                                <li class="creator-option px-3 py-2 text-sm text-slate-700 hover:bg-blue-600 hover:text-white cursor-pointer"
                                    data-value="all" data-label="All">All</li>
                                <li class="creator-option px-3 py-2 text-sm text-slate-700 hover:bg-blue-600 hover:text-white cursor-pointer"
                                    data-value="1273" data-label="Created by me">Created by me</li>
                                <li id="creatorNoResults" class="hidden px-3 py-2 text-sm text-slate-400 italic">No
                                    creators found</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Buttons -->
                <div class="col-span-1 md:col-span-4 flex justify-end gap-3 mt-2">
                    <button type="button" id="btn-filter-reset"
                        class="inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold text-blue-700 bg-white border border-blue-600 rounded-xl hover:bg-blue-50 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                        Reset
                    </button>
                    <button type="button" id="btn-filter-apply"
                        class="inline-flex items-center gap-2 px-5 py-2 text-sm font-semibold text-white bg-blue-600 rounded-xl hover:bg-blue-700 shadow-sm transition-colors">
                        Apply
                    </button>
                </div>
            </div>
        </div>

        <!-- Scanned Results (Hidden) -->
        <div id="scanned-results" class="hidden bg-white rounded-xl shadow-sm p-5 border border-slate-200 mb-6">
            <div class="flex items-center justify-between mb-4">
                <h6 class="text-[14px] font-semibold text-slate-800">Scanned/typed results</h6>
                <button type="button" id="btn-clear-scans"
                    class="text-[13px] font-semibold text-red-600 bg-red-50 hover:bg-red-100 px-3 py-1.5 rounded-lg transition-colors">Clear
                    All</button>
            </div>
            <div class="h-px bg-slate-200 w-full mb-4"></div>
            <div id="tags-container" class="flex flex-wrap gap-2"></div>
        </div>

        <!-- Main Content Area -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">

            <!-- Tabs -->
            <div class="relative flex border-b border-slate-200 bg-white">
                <button
                    class="pc-tab-btn active flex-1 py-3.5 text-[14px] font-semibold text-blue-700 bg-blue-50 text-center transition-colors relative z-10"
                    data-target="tab-all">
                    All (0)
                </button>
                <button
                    class="pc-tab-btn flex-1 py-3.5 text-[14px] font-semibold text-slate-500 hover:text-slate-700 hover:bg-slate-50 text-center transition-colors relative z-10"
                    data-target="tab-duplicate">
                    Duplicate (0)
                </button>
                <!-- Animated Indicator -->
                <div id="tab-indicator" class="absolute bottom-0 left-0 h-0.5 bg-blue-700 w-1/2 transition-transform duration-300 ease-out z-20"></div>
            </div>

            <!-- Tab Content -->
            <div class="block">
                <!-- Toolbar -->
                <div class="p-4 flex flex-wrap items-center justify-between border-b border-slate-100 bg-white gap-4">
                    <div class="flex items-center gap-3">
                        <button
                            class="px-4 py-2 text-[13px] font-medium text-slate-700 bg-slate-50 border border-slate-200 rounded-lg hover:bg-slate-100 transition-colors">
                            Manage Columns
                        </button>
                    </div>

                    <div class="flex items-center gap-3">
                        <div
                            class="relative w-80 shadow-sm rounded-lg overflow-hidden border border-slate-300 focus-within:ring-2 focus-within:ring-blue-100 focus-within:border-blue-500 transition-all flex">
                            <input type="text" id="main-search-input" placeholder="e.g. Product code, SKU, Variety, Weight"
                                class="w-full pl-4 pr-10 py-2 border-none text-[13px] focus:outline-none focus:ring-0">
                            <button id="main-search-btn"
                                class="absolute right-0 top-0 bottom-0 px-3 text-slate-400 hover:text-blue-700 bg-transparent flex items-center justify-center transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </button>
                        </div>
                        <button id="btn-scan-sku"
                            class="p-2 text-slate-500 border border-slate-200 bg-white rounded-lg hover:bg-slate-50 hover:text-slate-800 transition-colors shadow-sm tooltip"
                            title="Scan SKU's to search">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M4 8V6a2 2 0 012-2h2M4 16v2a2 2 0 002 2h2M16 4h2a2 2 0 012 2v2M16 20h2a2 2 0 002-2v-2M9 10h.01M15 10h.01M12 10h.01M9 14h.01M15 14h.01M12 14h.01" />
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Action Bar -->
                <div class="flex items-center gap-6 px-5 py-3 border-b border-slate-100 bg-slate-50/50">
                    <div class="text-[13px] font-medium text-slate-500">0 selected</div>
                    <button
                        class="flex items-center gap-1.5 text-[13px] font-medium text-slate-500 hover:text-slate-800 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        Add to list
                    </button>
                    <button
                        class="flex items-center gap-1.5 text-[13px] font-medium text-slate-500 hover:text-slate-800 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                        </svg>
                        Split
                    </button>
                    <button
                        class="flex items-center gap-1.5 text-[13px] font-medium text-slate-500 hover:text-slate-800 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                        </svg>
                        Merge
                    </button>
                </div>

                <!-- Table -->
                <div class="overflow-x-auto custom-scrollbar">
                    <table class="w-full text-left border-collapse whitespace-nowrap">
                        <thead class="bg-[#f8fafc] text-slate-800 font-semibold text-[13px] border-b border-slate-200">
                            <tr>
                                <th class="px-5 py-3.5 font-semibold w-24">
                                    <input type="checkbox" id="cb-select-all"
                                        class="w-4 h-4 rounded border-slate-300 text-blue-600 focus:ring-blue-500 align-middle mr-2">
                                    All
                                </th>
                                <th class="px-5 py-3.5 font-semibold">
                                    Product code <svg class="w-3.5 h-3.5 text-slate-400 inline-block ml-1" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 9l4-4 4 4m0 6l-4 4-4-4" />
                                    </svg>
                                </th>
                                <th class="px-5 py-3.5 font-semibold">
                                    SKU <svg class="w-3.5 h-3.5 text-slate-400 inline-block ml-1" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 9l4-4 4 4m0 6l-4 4-4-4" />
                                    </svg>
                                </th>
                                <th class="px-5 py-3.5 font-semibold">Category</th>
                                <th class="px-5 py-3.5 font-semibold">
                                    Variety <svg class="w-3.5 h-3.5 text-slate-400 inline-block ml-1" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 9l4-4 4 4m0 6l-4 4-4-4" />
                                    </svg>
                                </th>
                                <th class="px-5 py-3.5 font-semibold">
                                    Status <svg class="w-3.5 h-3.5 text-slate-400 inline-block ml-1" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 9l4-4 4 4m0 6l-4 4-4-4" />
                                    </svg>
                                </th>
                                <th class="px-5 py-3.5 font-semibold">
                                    Color <svg class="w-3.5 h-3.5 text-slate-400 inline-block ml-1" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 9l4-4 4 4m0 6l-4 4-4-4" />
                                    </svg>
                                </th>
                                <th class="px-5 py-3.5 font-semibold">
                                    Shape <svg class="w-3.5 h-3.5 text-slate-400 inline-block ml-1" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 9l4-4 4 4m0 6l-4 4-4-4" />
                                    </svg>
                                </th>
                                <th class="px-5 py-3.5 font-semibold text-center">
                                    Quantity <svg class="w-3.5 h-3.5 text-slate-400 inline-block ml-1" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 9l4-4 4 4m0 6l-4 4-4-4" />
                                    </svg>
                                </th>
                                <th class="px-5 py-3.5 font-semibold">Dimensions</th>
                                <th class="px-5 py-3.5 font-semibold text-center">Weight</th>
                                <th class="px-5 py-3.5 font-semibold">
                                    Treatment <svg class="w-3.5 h-3.5 text-slate-400 inline-block ml-1" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 9l4-4 4 4m0 6l-4 4-4-4" />
                                    </svg>
                                </th>
                                <th class="px-5 py-3.5 font-semibold">
                                    Origin <svg class="w-3.5 h-3.5 text-slate-400 inline-block ml-1" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 9l4-4 4 4m0 6l-4 4-4-4" />
                                    </svg>
                                </th>
                                <th class="px-5 py-3.5 font-semibold text-right">
                                    Cost per unit <svg class="w-3.5 h-3.5 text-slate-400 inline-block ml-1" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 9l4-4 4 4m0 6l-4 4-4-4" />
                                    </svg>
                                </th>
                                <th class="px-5 py-3.5 font-semibold text-right">Total cost</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-slate-700 text-[13px] bg-white">
                            <tr>
                                <td colspan="15" class="px-6 py-16 text-center text-slate-500 bg-white">
                                    <div class="flex flex-col items-center justify-center">
                                        <svg class="w-12 h-12 text-slate-200 mb-3" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                        </svg>
                                        <p class="text-[14px] font-medium text-slate-600">No data available in table</p>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination Footer -->
                <div
                    class="px-5 py-3 border-t border-slate-200 flex items-center justify-between bg-white text-[13px] text-slate-600 rounded-b-xl">
                    <div class="flex items-center gap-2"><span>Show</span>
                        <div class="relative">
                            <select
                                class="border border-slate-300 rounded-md py-1.5 pl-2 pr-7 text-[13px] focus:ring-2 focus:ring-blue-100 focus:border-blue-500 appearance-none bg-white">
                                <option value="50">50</option>
                                <option value="100">100</option>
                                <option value="150">150</option>
                                <option value="200">200</option>
                                <option value="300">300</option>
                                <option value="500">500</option>
                            </select>
                            <div class="absolute inset-y-0 right-2 flex items-center pointer-events-none">
                                <svg class="w-3 h-3 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </div>
                        </div><span>entries</span>
                    </div>
                    <div>Showing 0 to 0 of 0 entries</div>
                    <div class="flex items-center gap-1">
                        <button
                            class="px-3 py-1.5 border border-slate-200 rounded-md text-slate-400 cursor-not-allowed bg-slate-50">Previous</button>
                        <button
                            class="px-3 py-1.5 border border-slate-200 rounded-md text-slate-400 cursor-not-allowed bg-slate-50">Next</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Scan SKU Modal -->
        <div id="scan-sku-modal" class="fixed inset-0 z-50 hidden flex items-center justify-center">
            <!-- Backdrop -->
            <div class="absolute inset-0 bg-slate-900/40 backdrop-blur-sm pc-modal-backdrop"></div>

            <!-- Modal Content -->
            <div class="bg-white rounded-xl shadow-2xl w-full max-w-xl relative z-10 transform scale-95 opacity-0 transition-all duration-200"
                id="scan-sku-modal-content">
                <!-- Header -->
                <div class="flex items-center justify-between p-6 pb-4">
                    <h3 class="text-[17px] font-bold text-slate-800">Scan / type to search</h3>
                    <button type="button" class="pc-modal-close text-slate-400 hover:text-slate-600 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Body -->
                <div class="p-6 pt-0">
                    <div class="bg-[#FFF8EE] border-l-4 border-[#D97706] p-4 rounded-r-lg mb-5">
                        <p class="text-sm text-slate-800 leading-relaxed">
                            <span class="font-bold">Note:</span> Please scan or type your SKU number within the field. Also,
                            please make sure your barcode scanner is configured to return after scanning.
                        </p>
                    </div>

                    <input type="text" id="scan-sku-input"
                        class="w-full bg-white border border-slate-300 text-slate-800 py-2.5 px-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-shadow"
                        placeholder="">
                </div>

                <!-- Footer -->
                <div class="p-6 pt-0 flex items-center gap-3">
                    <button type="button"
                        class="pc-modal-close px-5 py-2 text-sm font-semibold text-red-500 bg-white border border-red-500 rounded-lg hover:bg-red-50 transition-colors">
                        Cancel
                    </button>
                    <button type="button" id="btn-scan-submit"
                        class="px-6 py-2 text-sm font-semibold text-white bg-[#2563eb] rounded-lg hover:bg-blue-700 shadow-sm transition-colors">
                        Search
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
    const tabs = document.querySelectorAll('.pc-tab-btn');
    const indicator = document.getElementById('tab-indicator');

    tabs.forEach((tab, index) => {
        tab.addEventListener('click', function () {
            tabs.forEach(t => {
                t.classList.remove('text-blue-700', 'bg-blue-50', 'active');
                t.classList.add('text-slate-500', 'hover:text-slate-700', 'hover:bg-slate-50');
            });

            this.classList.remove('text-slate-500', 'hover:text-slate-700', 'hover:bg-slate-50');
            this.classList.add('text-blue-700', 'bg-blue-50', 'active');

            if (indicator) {
                indicator.style.transform = `translateX(${index * 100}%)`;
            }
        });
    });

    // Scan SKU Modal Logic
    const scanBtn = document.getElementById('btn-scan-sku');
    const scanModal = document.getElementById('scan-sku-modal');
    const scanModalContent = document.getElementById('scan-sku-modal-content');
    const closeBtns = document.querySelectorAll('.pc-modal-close, .pc-modal-backdrop');
    const scanInput = document.getElementById('scan-sku-input');

    if (scanBtn && scanModal) {
        scanBtn.addEventListener('click', () => {
            scanModal.classList.remove('hidden');
            // Small delay to allow transition
            setTimeout(() => {
                scanModalContent.classList.remove('scale-95', 'opacity-0');
                scanModalContent.classList.add('scale-100', 'opacity-100');
                scanInput.focus();
            }, 10);
        });

        closeBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                scanModalContent.classList.remove('scale-100', 'opacity-100');
                scanModalContent.classList.add('scale-95', 'opacity-0');
                setTimeout(() => {
                    scanModal.classList.add('hidden');
                }, 200);
            });
        });
    }

    // Filter Reset Logic
    const btnFilterReset = document.getElementById('btn-filter-reset');
    if (btnFilterReset) {
        btnFilterReset.addEventListener('click', () => {
            const filterContainer = btnFilterReset.closest('.bg-white.rounded-2xl');
            if (filterContainer) {
                const inputs = filterContainer.querySelectorAll('input, select');
                inputs.forEach(input => {
                    input.value = '';
                });
            }
        });
    }

    // Filter Apply Logic
    const btnFilterApply = document.getElementById('btn-filter-apply');
    if (btnFilterApply) {
        btnFilterApply.addEventListener('click', () => {
            // For now, just a visual feedback or console log
            const originalText = btnFilterApply.innerHTML;
            btnFilterApply.innerHTML = 'Applying...';
            setTimeout(() => {
                btnFilterApply.innerHTML = originalText;
            }, 800);
        });
    }

    // Select All Checkbox Logic
    const cbSelectAll = document.getElementById('cb-select-all');
    if (cbSelectAll) {
        cbSelectAll.addEventListener('change', (e) => {
            const rowCheckboxes = document.querySelectorAll('tbody input[type="checkbox"]');
            rowCheckboxes.forEach(cb => {
                cb.checked = e.target.checked;
            });
        });
    }

    // Scanned Results Logic
    const btnScanSubmit = document.getElementById('btn-scan-submit');
    const tagsContainer = document.getElementById('tags-container');
    const scannedResultsDiv = document.getElementById('scanned-results');
    const btnClearScans = document.getElementById('btn-clear-scans');

    if (btnScanSubmit && scanInput && tagsContainer && scannedResultsDiv) {
        btnScanSubmit.addEventListener('click', () => {
            const val = scanInput.value.trim();
            if (val) {
                // Show container
                scannedResultsDiv.classList.remove('hidden');

                // Create Tag
                const tag = document.createElement('div');
                tag.className = 'inline-flex items-center gap-1.5 px-3 py-1 bg-slate-100 text-slate-700 text-sm font-medium rounded-lg border border-slate-200';
                tag.innerHTML = `
                    <span>${val}</span>
                    <button type="button" class="text-slate-400 hover:text-red-500 transition-colors remove-tag-btn">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                `;
                tagsContainer.appendChild(tag);

                // Add remove event to the new tag's button
                tag.querySelector('.remove-tag-btn').addEventListener('click', () => {
                    tag.remove();
                    if (tagsContainer.children.length === 0) {
                        scannedResultsDiv.classList.add('hidden');
                    }
                });

                // Clear input and close modal
                scanInput.value = '';
                document.querySelector('.pc-modal-close').click();
            }
        });

        // Enter key to submit
        scanInput.addEventListener('keypress', (e) => {
            if (e.key === 'Enter') {
                e.preventDefault();
                btnScanSubmit.click();
            }
        });
    }

    if (btnClearScans) {
        btnClearScans.addEventListener('click', () => {
            tagsContainer.innerHTML = '';
            scannedResultsDiv.classList.add('hidden');
        });
    }

    // Main Search Logic
    const mainSearchInput = document.getElementById('main-search-input');
    const mainSearchBtn = document.getElementById('main-search-btn');

    if (mainSearchBtn && mainSearchInput) {
        mainSearchBtn.addEventListener('click', () => {
            const val = mainSearchInput.value.trim();
            if (val) {
                // Show container and add tag similarly to scan modal
                scannedResultsDiv.classList.remove('hidden');

                // Create Tag
                const tag = document.createElement('div');
                tag.className = 'inline-flex items-center gap-1.5 px-3 py-1 bg-slate-100 text-slate-700 text-sm font-medium rounded-lg border border-slate-200';
                tag.innerHTML = `
                    <span>Search: ${val}</span>
                    <button type="button" class="text-slate-400 hover:text-red-500 transition-colors remove-tag-btn">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                `;
                tagsContainer.appendChild(tag);

                tag.querySelector('.remove-tag-btn').addEventListener('click', () => {
                    tag.remove();
                    if (tagsContainer.children.length === 0) {
                        scannedResultsDiv.classList.add('hidden');
                    }
                });

                mainSearchInput.value = ''; // clear input
            }
        });

        mainSearchInput.addEventListener('keypress', (e) => {
            if (e.key === 'Enter') {
                e.preventDefault();
                mainSearchBtn.click();
            }
        });
    }

    // Variety Custom Dropdown Logic
    const varietyBtn = document.getElementById('varietyDropdownBtn');
    const varietyPanel = document.getElementById('varietyDropdownPanel');
    const varietyLabel = document.getElementById('varietyDropdownLabel');
    const varietyHidden = document.getElementById('varietyHiddenInput');
    const varietySearch = document.getElementById('varietySearchInput');
    const varietyOptions = document.querySelectorAll('.variety-option');
    const varietyNoResults = document.getElementById('varietyNoResults');

    if (varietyBtn && varietyPanel) {
        // Toggle dropdown
        varietyBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            varietyPanel.classList.toggle('hidden');
            if (!varietyPanel.classList.contains('hidden')) {
                varietySearch.focus();
            }
        });

        // Close when clicking outside
        document.addEventListener('click', (e) => {
            if (!varietyBtn.contains(e.target) && !varietyPanel.contains(e.target)) {
                varietyPanel.classList.add('hidden');
            }
        });

        // Select an option
        varietyOptions.forEach(option => {
            option.addEventListener('click', () => {
                const val = option.getAttribute('data-value');
                const label = option.getAttribute('data-label');

                varietyHidden.value = val;
                varietyLabel.textContent = label;
                varietyLabel.classList.remove('text-slate-500');
                varietyLabel.classList.add('text-slate-800', 'font-medium');

                // Highlight selected
                varietyOptions.forEach(opt => opt.classList.remove('bg-blue-50', 'text-blue-700', 'font-medium'));
                option.classList.add('bg-blue-50', 'text-blue-700', 'font-medium');

                varietyPanel.classList.add('hidden');
            });
        });

        // Search options
        varietySearch.addEventListener('input', (e) => {
            const searchTerm = e.target.value.toLowerCase();
            let visibleCount = 0;

            varietyOptions.forEach(option => {
                const label = option.getAttribute('data-label').toLowerCase();
                if (label.includes(searchTerm)) {
                    option.classList.remove('hidden');
                    visibleCount++;
                } else {
                    option.classList.add('hidden');
                }
            });

            if (visibleCount === 0) {
                varietyNoResults.classList.remove('hidden');
            } else {
                varietyNoResults.classList.add('hidden');
            }
        });
    }

    // Product Category Custom Dropdown Logic
    const prodCatBtn = document.getElementById('productCategoryDropdownBtn');
    const prodCatPanel = document.getElementById('productCategoryDropdownPanel');
    const prodCatLabel = document.getElementById('productCategoryDropdownLabel');
    const prodCatHidden = document.getElementById('productCategoryHiddenInput');
    const prodCatSearch = document.getElementById('productCategorySearchInput');
    const prodCatOptions = document.querySelectorAll('.product-category-option');
    const prodCatNoResults = document.getElementById('productCategoryNoResults');

    if (prodCatBtn && prodCatPanel) {
        // Toggle dropdown
        prodCatBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            prodCatPanel.classList.toggle('hidden');
            if (!prodCatPanel.classList.contains('hidden')) {
                prodCatSearch.focus();
            }
        });

        // Close when clicking outside
        document.addEventListener('click', (e) => {
            if (!prodCatBtn.contains(e.target) && !prodCatPanel.contains(e.target)) {
                prodCatPanel.classList.add('hidden');
            }
        });

        // Select an option
        prodCatOptions.forEach(option => {
            option.addEventListener('click', () => {
                const val = option.getAttribute('data-value');
                const label = option.getAttribute('data-label');

                prodCatHidden.value = val;
                prodCatLabel.textContent = label;
                prodCatLabel.classList.remove('text-slate-500');
                prodCatLabel.classList.add('text-slate-800', 'font-medium');

                // Highlight selected
                prodCatOptions.forEach(opt => opt.classList.remove('bg-blue-600', 'text-white', 'font-medium'));
                option.classList.add('bg-blue-600', 'text-white', 'font-medium');

                prodCatPanel.classList.add('hidden');
            });
        });

        // Search options
        prodCatSearch.addEventListener('input', (e) => {
            const searchTerm = e.target.value.toLowerCase();
            let visibleCount = 0;

            prodCatOptions.forEach(option => {
                const label = option.getAttribute('data-label').toLowerCase();
                if (label.includes(searchTerm)) {
                    option.classList.remove('hidden');
                    visibleCount++;
                } else {
                    option.classList.add('hidden');
                }
            });

            if (visibleCount === 0) {
                prodCatNoResults.classList.remove('hidden');
            } else {
                prodCatNoResults.classList.add('hidden');
            }
        });
    }

    // Creator Custom Dropdown Logic
    const creatorBtn = document.getElementById('creatorDropdownBtn');
    const creatorPanel = document.getElementById('creatorDropdownPanel');
    const creatorLabel = document.getElementById('creatorDropdownLabel');
    const creatorHidden = document.getElementById('creatorHiddenInput');
    const creatorSearch = document.getElementById('creatorSearchInput');
    const creatorOptions = document.querySelectorAll('.creator-option');
    const creatorNoResults = document.getElementById('creatorNoResults');

    if (creatorBtn && creatorPanel) {
        // Toggle dropdown
        creatorBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            creatorPanel.classList.toggle('hidden');
            if (!creatorPanel.classList.contains('hidden')) {
                creatorSearch.focus();
            }
        });

        // Close when clicking outside
        document.addEventListener('click', (e) => {
            if (!creatorBtn.contains(e.target) && !creatorPanel.contains(e.target)) {
                creatorPanel.classList.add('hidden');
            }
        });

        // Select an option
        creatorOptions.forEach(option => {
            option.addEventListener('click', () => {
                const val = option.getAttribute('data-value');
                const label = option.getAttribute('data-label');

                creatorHidden.value = val;
                creatorLabel.textContent = label;
                creatorLabel.classList.remove('text-slate-500');
                creatorLabel.classList.add('text-slate-800', 'font-medium');

                // Highlight selected
                creatorOptions.forEach(opt => opt.classList.remove('bg-blue-600', 'text-white', 'font-medium'));
                option.classList.add('bg-blue-600', 'text-white', 'font-medium');

                creatorPanel.classList.add('hidden');
            });
        });

        // Search options
        creatorSearch.addEventListener('input', (e) => {
            const searchTerm = e.target.value.toLowerCase();
            let visibleCount = 0;

            creatorOptions.forEach(option => {
                const label = option.getAttribute('data-label').toLowerCase();
                if (label.includes(searchTerm)) {
                    option.classList.remove('hidden');
                    visibleCount++;
                } else {
                    option.classList.add('hidden');
                }
            });

            if (visibleCount === 0) {
                creatorNoResults.classList.remove('hidden');
            } else {
                creatorNoResults.classList.add('hidden');
            }
        });
    }
});
</script>
@endsection
