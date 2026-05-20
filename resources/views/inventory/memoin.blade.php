@extends('layouts.app')

@section('title', 'Memo in')

@section('content')
    <!-- Tailwind CSS for styling -->
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        /* Custom Scrollbar for Table */
        .overflow-x-auto::-webkit-scrollbar {
            height: 10px;
        }

        .overflow-x-auto::-webkit-scrollbar-track {
            background: #f1f5f9;
            border-radius: 6px;
            margin: 0 16px;
        }

        .overflow-x-auto::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 6px;
        }

        .overflow-x-auto::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        /* Tab buttons */
        .pc-tab-btn {
            transition: all 0.2s ease-in-out;
        }
    </style>

    <div class="p-6 min-h-screen bg-slate-50">
        <!-- Title Row -->
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-slate-800 tracking-tight">Memo in</h1>
        </div>

        <!-- Filter Card -->
        <div class="bg-white rounded-md border border-slate-200 p-5 mb-6 shadow-sm">
            <div class="flex items-center gap-2 mb-4">
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                </svg>
                <h2 class="text-[15px] font-medium text-blue-700 tracking-wider">Filter by</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                <!-- Product Category -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Product category:</label>
                    <div class="relative" id="productCategoryDropdownWrapper">
                        <button type="button" id="productCategoryDropdownBtn"
                            class="w-full flex items-center justify-between pl-3 pr-8 py-2.5 text-sm text-slate-700 bg-slate-100 border border-slate-200 rounded-md focus:outline-none cursor-pointer text-left hover:border-blue-400 transition-colors">
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-2 text-slate-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                <span id="productCategoryDropdownLabel" class="truncate text-slate-500">Choose
                                    Category</span>
                            </div>
                        </button>
                        <div class="absolute inset-y-0 right-3 flex items-center pointer-events-none">
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>

                        <div id="productCategoryDropdownPanel"
                            class="hidden absolute z-50 mt-2 w-full bg-white border border-slate-200 rounded-md shadow-lg overflow-hidden">
                            <ul class="py-2 px-2 space-y-1">
                                <li
                                    class="flex items-center space-x-3 px-3 py-2 text-sm text-slate-700 hover:bg-slate-50 cursor-pointer rounded-md">
                                    <input type="checkbox"
                                        class="w-4 h-4 rounded-md border-slate-300 text-blue-600 focus:ring-blue-500 cursor-pointer">
                                    <span>C&P Gemstone</span>
                                </li>
                                <li
                                    class="flex items-center space-x-3 px-3 py-2 text-sm text-slate-700 hover:bg-slate-50 cursor-pointer rounded-md">
                                    <input type="checkbox"
                                        class="w-4 h-4 rounded-md border-slate-300 text-blue-600 focus:ring-blue-500 cursor-pointer">
                                    <span>Rough Gemstone</span>
                                </li>
                                <li
                                    class="flex items-center space-x-3 px-3 py-2 text-sm text-slate-700 hover:bg-slate-50 cursor-pointer rounded-md">
                                    <input type="checkbox"
                                        class="w-4 h-4 rounded-md border-slate-300 text-blue-600 focus:ring-blue-500 cursor-pointer">
                                    <span>C&P Diamond</span>
                                </li>
                                <li
                                    class="flex items-center space-x-3 px-3 py-2 text-sm text-slate-700 hover:bg-slate-50 cursor-pointer rounded-md">
                                    <input type="checkbox"
                                        class="w-4 h-4 rounded-md border-slate-300 text-blue-600 focus:ring-blue-500 cursor-pointer">
                                    <span>Jewelry</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Supplier Name -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Supplier name:</label>
                    <div class="relative" id="supplierDropdownWrapper">
                        <button type="button" id="supplierDropdownBtn"
                            class="w-full flex items-center justify-between pl-3 pr-8 py-2.5 text-sm text-slate-700 bg-slate-100 border border-slate-200 rounded-md focus:outline-none cursor-pointer text-left hover:border-blue-400 transition-colors">
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-2 text-slate-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                <span id="supplierDropdownLabel" class="truncate text-slate-400">Select supplier name</span>
                            </div>
                        </button>
                        <div class="absolute inset-y-0 right-3 flex items-center pointer-events-none">
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>

                        <div id="supplierDropdownPanel"
                            class="hidden absolute z-50 mt-2 w-full bg-white border border-slate-200 rounded-md shadow-lg overflow-hidden">
                            <!-- Search box -->
                            <div class="p-2 border-b border-slate-100">
                                <input type="text" id="supplierSearchInput" placeholder=""
                                    class="w-full px-3 py-2 text-sm border border-slate-200 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                    autocomplete="off">
                            </div>
                            <ul id="supplierList" class="py-1 max-h-48 overflow-y-auto">
                                <li class="supplier-option px-4 py-2.5 text-sm text-blue-500 hover:bg-blue-50 hover:text-blue-700 cursor-pointer font-medium"
                                    data-value="Select supplier name">Select supplier name</li>
                                <li id="supplierNoResults" class="hidden px-4 py-2.5 text-sm text-slate-400 italic">No suppliers found</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Creation Date Range -->
                <div class="col-span-1 md:col-span-1 min-w-[300px]">
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Creation date range:</label>
                    <div class="flex items-center gap-2">
                        <input type="date"
                            class="w-full bg-white border border-slate-300 text-slate-700 py-2.5 px-3 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm hover:border-blue-400 transition-colors">
                        <span class="text-slate-400 font-medium">-</span>
                        <input type="date"
                            class="w-full bg-white border border-slate-300 text-slate-700 py-2.5 px-3 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm hover:border-blue-400 transition-colors">
                    </div>
                </div>

                <!-- Buttons -->
                <div class="col-span-1 flex justify-end gap-3">
                    <button type="button" id="btn-filter-reset" title="Clear filter"
                        class="flex items-center justify-center w-[42px] h-[42px] text-slate-500 bg-white border border-slate-200 rounded-md hover:bg-slate-50 hover:text-slate-700 transition-colors shadow-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                    </button>
                    <button type="button" id="btn-filter-apply"
                        class="inline-flex items-center justify-center px-10 h-[42px] text-[15px] font-bold text-white bg-[#2563eb] rounded-full hover:bg-blue-700 shadow-sm transition-colors whitespace-nowrap">
                        Apply
                    </button>
                </div>
            </div>
        </div>

        <!-- Main Content Area -->
        <div class="bg-white rounded-md shadow-sm border border-slate-200 overflow-hidden">

            <!-- Tabs -->
            <div class="relative flex border-b border-slate-200 bg-white">
                <button
                    class="pc-tab-btn active flex-1 py-3.5 text-[14px] font-semibold text-blue-700 bg-blue-50 text-center transition-colors relative z-10"
                    data-target="tab-memoin">
                    Memo in (0)
                </button>
                <button
                    class="pc-tab-btn flex-1 py-3.5 text-[14px] font-semibold text-slate-500 hover:text-slate-700 hover:bg-slate-50 text-center transition-colors relative z-10"
                    data-target="tab-returned">
                    Returned history (0)
                </button>
                <!-- Animated Indicator -->
                <div id="tab-indicator"
                    class="absolute bottom-0 left-0 h-0.5 bg-blue-700 w-1/2 transition-transform duration-300 ease-out z-20">
                </div>
            </div>

            <!-- Tab Content -->
            <div class="block">
                <!-- Toolbar -->
                <div class="p-4 flex flex-wrap items-center justify-end border-b border-slate-100 bg-white gap-4">
                    <div class="flex items-center gap-2">
                        <div
                            class="relative w-[280px] shadow-sm rounded-md overflow-hidden border border-slate-300 focus-within:ring-2 focus-within:ring-blue-100 focus-within:border-blue-500 transition-all flex">
                            <input type="text" id="main-search-input" placeholder="search e.g memo #, sku, weig"
                                class="w-full pl-4 pr-10 py-2 border-none text-[13px] focus:outline-none focus:ring-0 placeholder-slate-400">
                            <button id="main-search-btn"
                                class="absolute right-0 top-0 bottom-0 px-3 text-white bg-blue-700 hover:bg-blue-800 flex items-center justify-center transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </button>
                        </div>

                        <button id="btn-scan-sku"
                            class="p-2 border border-slate-200 rounded-md text-slate-700 bg-slate-50 hover:bg-slate-100 transition-colors shadow-sm">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M4 8V6a2 2 0 012-2h2M4 16v2a2 2 0 002 2h2M16 4h2a2 2 0 012 2v2M16 20h2a2 2 0 002-2v-2M9 10h.01M15 10h.01M12 10h.01M9 14h.01M15 14h.01M12 14h.01" />
                            </svg>
                        </button>

                        <div class="relative" id="filteredByWrapper">
                            <button id="filteredByBtn"
                                class="flex items-center gap-2 px-3.5 py-2 border border-blue-600 rounded-md text-[13px] font-medium text-blue-600 bg-slate-100 hover:bg-blue-50 transition-colors shadow-sm">
                                Filtered by
                                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            <div id="filteredByPanel"
                                class="hidden absolute right-0 z-50 mt-2 w-36 bg-white border border-slate-200 rounded-md shadow-lg overflow-hidden">
                                <ul class="py-2 px-2 space-y-1">
                                    <li class="px-3 py-2 text-sm text-blue-600 bg-slate-50 rounded-md cursor-pointer font-medium">All</li>
                                    <li class="px-3 py-2 text-sm text-slate-700 hover:bg-slate-50 hover:text-blue-600 rounded-md cursor-pointer">Overdue</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Table Container: Memo In Tab -->
                <div id="contentMemoIn" class="block overflow-x-auto custom-scrollbar">
                    <table class="w-full text-left border-collapse whitespace-nowrap">
                        <thead class="bg-[#f8fafc] text-slate-800 font-semibold text-[13px] border-b border-slate-200">
                            <tr>
                                <th class="px-5 py-3.5 font-semibold w-10">
                                    <input type="checkbox" id="cb-select-all"
                                        class="w-4 h-4 rounded-md border-slate-300 text-blue-600 focus:ring-blue-500 align-middle">
                                </th>
                                <th class="px-5 py-3.5 font-semibold text-center">All</th>
                                <th class="px-5 py-3.5 font-semibold">
                                    SKU <svg class="w-3.5 h-3.5 text-slate-400 inline-block ml-1" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 9l4-4 4 4m0 6l-4 4-4-4" />
                                    </svg>
                                </th>
                                <th class="px-5 py-3.5 font-semibold">
                                    Supplier name <svg class="w-3.5 h-3.5 text-slate-400 inline-block ml-1" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 9l4-4 4 4m0 6l-4 4-4-4" />
                                    </svg>
                                </th>
                                <th class="px-5 py-3.5 font-semibold">
                                    Memo in # <svg class="w-3.5 h-3.5 text-slate-400 inline-block ml-1" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 9l4-4 4 4m0 6l-4 4-4-4" />
                                    </svg>
                                </th>
                                <th class="px-5 py-3.5 font-semibold">
                                    Reference <svg class="w-3.5 h-3.5 text-slate-400 inline-block ml-1" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 9l4-4 4 4m0 6l-4 4-4-4" />
                                    </svg>
                                </th>
                                <th class="px-5 py-3.5 font-semibold">
                                    Variety <svg class="w-3.5 h-3.5 text-slate-400 inline-block ml-1" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 9l4-4 4 4m0 6l-4 4-4-4" />
                                    </svg>
                                </th>
                                <th class="px-5 py-3.5 font-semibold">
                                    status <svg class="w-3.5 h-3.5 text-slate-400 inline-block ml-1" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 9l4-4 4 4m0 6l-4 4-4-4" />
                                    </svg>
                                </th>
                                <th class="px-5 py-3.5 font-semibold text-right">
                                    Quantity <svg class="w-3.5 h-3.5 text-slate-400 inline-block ml-1" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 9l4-4 4 4m0 6l-4 4-4-4" />
                                    </svg>
                                </th>
                                <th class="px-5 py-3.5 font-semibold text-right">
                                    Weight <svg class="w-3.5 h-3.5 text-slate-400 inline-block ml-1" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 9l4-4 4 4m0 6l-4 4-4-4" />
                                    </svg>
                                </th>
                                <th class="px-5 py-3.5 font-semibold text-right">
                                    Total price <svg class="w-3.5 h-3.5 text-blue-500 inline-block mx-0.5" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                        </path>
                                    </svg> <svg class="w-3.5 h-3.5 text-slate-400 inline-block ml-1" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 9l4-4 4 4m0 6l-4 4-4-4" />
                                    </svg>
                                </th>
                                <th class="px-5 py-3.5 font-semibold">
                                    Memo Creation date <svg class="w-3.5 h-3.5 text-slate-400 inline-block ml-1" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 9l4-4 4 4m0 6l-4 4-4-4" />
                                    </svg>
                                </th>
                                <th class="px-5 py-3.5 font-semibold">
                                    Memo Due date <svg class="w-3.5 h-3.5 text-slate-400 inline-block ml-1" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 9l4-4 4 4m0 6l-4 4-4-4" />
                                    </svg>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-slate-700 text-[13px] bg-white">
                            <tr>
                                <td colspan="13" class="px-6 py-16 text-center text-slate-500 bg-white">
                                    <p class="text-[14px] font-medium text-slate-600">No records found</p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Table Container: Returned History Tab (Hidden by default) -->
                <div id="contentReturned" class="hidden overflow-x-auto custom-scrollbar">
                    <table class="w-full text-left border-collapse whitespace-nowrap">
                        <thead class="bg-[#f8fafc] text-slate-800 font-semibold text-[13px] border-b border-slate-200">
                            <tr>
                                <th class="px-5 py-3.5 font-semibold w-10">
                                    <input type="checkbox" id="cb-select-all-returned"
                                        class="w-4 h-4 rounded-md border-slate-300 text-blue-600 focus:ring-blue-500 align-middle">
                                </th>
                                <th class="px-5 py-3.5 font-semibold">SKU</th>
                                <th class="px-5 py-3.5 font-semibold">Supplier name</th>
                                <th class="px-5 py-3.5 font-semibold">Return Date</th>
                                <th class="px-5 py-3.5 font-semibold">Reason</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-slate-700 text-[13px] bg-white">
                            <tr>
                                <td colspan="5" class="px-6 py-16 text-center text-slate-500 bg-white">
                                    <p class="text-[14px] font-medium text-slate-600">No returned history found</p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination Footer -->
                <div
                    class="px-5 py-3 border-t border-slate-200 flex items-center justify-between bg-white text-[13px] text-slate-600 rounded-b-md">
                    <div class="flex items-center gap-2"><span>Show</span>
                        <div class="relative">
                            <select
                                class="border border-slate-300 rounded-md py-1.5 pl-2 pr-7 text-[13px] focus:ring-2 focus:ring-blue-100 focus:border-blue-500 appearance-none bg-white cursor-pointer">
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select>
                            <div class="absolute inset-y-0 right-2 flex items-center pointer-events-none">
                                <svg class="w-3 h-3 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </div>
                        </div><span>Items per page</span>
                    </div>
                    <div>Showing results 0 to 0</div>
                    <div class="flex items-center gap-1">
                        <button
                            class="px-3 py-1.5 border border-slate-200 rounded-md text-slate-400 cursor-not-allowed bg-slate-50">Previous</button>
                        <button
                            class="px-3 py-1.5 border border-slate-200 rounded-md text-slate-400 cursor-not-allowed bg-slate-50">1</button>
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
            <div class="bg-white rounded-md shadow-2xl w-full max-w-xl relative z-10 transform scale-95 opacity-0 transition-all duration-200"
                id="scan-sku-modal-content">
                <!-- Header -->
                <div class="flex items-center justify-between p-6 pb-4">
                    <h3 class="text-[17px] font-bold text-slate-800">Scan / type to return</h3>
                    <button type="button" class="pc-modal-close text-slate-400 hover:text-slate-600 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Body -->
                <div class="p-6 pt-0">
                    <div class="bg-[#FFF8EE] border-l-4 border-[#D97706] p-4 rounded-r-md mb-5 flex items-start justify-between">
                        <p class="text-sm text-slate-800 leading-relaxed pr-4">
                            <span class="font-bold">Note:</span> Please scan or type your SKU number within the field. Also
                            please make sure your barcode scanner is configured to return after scanning.
                        </p>
                        <button type="button" class="text-slate-400 hover:text-slate-600 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <input type="text" id="scan-sku-input"
                        class="w-full bg-white border border-slate-300 text-slate-800 py-2.5 px-3 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-shadow"
                        placeholder="e.g cps1234">
                </div>

                <!-- Footer -->
                <div class="p-6 pt-0 flex items-center gap-3">
                    <button type="button"
                        class="pc-modal-close px-5 py-2 text-sm font-semibold text-red-500 bg-white border border-red-500 rounded-md hover:bg-red-50 transition-colors">
                        Cancel
                    </button>
                    <button type="button" id="btn-scan-submit"
                        class="px-6 py-2 text-sm font-semibold text-white bg-[#2563eb] rounded-md hover:bg-blue-700 shadow-sm transition-colors">
                        Add
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Dropdown util
            function setupDropdown(btnId, panelId) {
                const btn = document.getElementById(btnId);
                const panel = document.getElementById(panelId);
                if (!btn || !panel) return;

                btn.addEventListener('click', (e) => {
                    e.stopPropagation();
                    panel.classList.toggle('hidden');
                });

                document.addEventListener('click', (e) => {
                    if (!btn.contains(e.target) && !panel.contains(e.target)) {
                        panel.classList.add('hidden');
                    }
                });
            }

            setupDropdown('productCategoryDropdownBtn', 'productCategoryDropdownPanel');
            setupDropdown('supplierDropdownBtn', 'supplierDropdownPanel');
            setupDropdown('filteredByBtn', 'filteredByPanel');

            // Supplier Dropdown selection Logic
            const supplierOptions = document.querySelectorAll('.supplier-option');
            const supplierLabel = document.getElementById('supplierDropdownLabel');
            const supplierPanel = document.getElementById('supplierDropdownPanel');
            const supplierSearch = document.getElementById('supplierSearchInput');
            const supplierNoResults = document.getElementById('supplierNoResults');

            supplierOptions.forEach(opt => {
                opt.addEventListener('click', function () {
                    const val = this.getAttribute('data-value');
                    supplierLabel.textContent = val;
                    if (val === 'Select supplier name') {
                        supplierLabel.classList.remove('text-slate-800');
                        supplierLabel.classList.add('text-slate-400');
                    } else {
                        supplierLabel.classList.remove('text-slate-400');
                        supplierLabel.classList.add('text-slate-800');
                    }
                    supplierPanel.classList.add('hidden');
                });
            });

            // Supplier Search Logic
            if (supplierSearch) {
                supplierSearch.addEventListener('input', (e) => {
                    const searchTerm = e.target.value.toLowerCase();
                    let visibleCount = 0;

                    supplierOptions.forEach(option => {
                        const label = option.getAttribute('data-value').toLowerCase();
                        if (label.includes(searchTerm)) {
                            option.classList.remove('hidden');
                            if (label !== 'select supplier name') {
                                visibleCount++;
                            }
                        } else {
                            option.classList.add('hidden');
                        }
                    });

                    if (visibleCount === 0 && searchTerm !== '') {
                        supplierNoResults.classList.remove('hidden');
                    } else {
                        supplierNoResults.classList.add('hidden');
                    }
                });
            }

            // Tabs Logic
            const tabs = document.querySelectorAll('.pc-tab-btn');
            const indicator = document.getElementById('tab-indicator');
            const contentMemoIn = document.getElementById('contentMemoIn');
            const contentReturned = document.getElementById('contentReturned');

            tabs.forEach((tab, index) => {
                tab.addEventListener('click', function () {
                    // Reset active states
                    tabs.forEach(t => {
                        t.classList.remove('text-blue-700', 'bg-blue-50', 'active');
                        t.classList.add('text-slate-500', 'hover:text-slate-700', 'hover:bg-slate-50');
                    });

                    // Set current active
                    this.classList.remove('text-slate-500', 'hover:text-slate-700', 'hover:bg-slate-50');
                    this.classList.add('text-blue-700', 'bg-blue-50', 'active');

                    // Move indicator
                    if (indicator) {
                        indicator.style.transform = `translateX(${index * 100}%)`;
                    }

                    // Switch content
                    const target = this.getAttribute('data-target');
                    if (target === 'tab-memoin') {
                        contentMemoIn.classList.remove('hidden');
                        contentReturned.classList.add('hidden');
                    } else {
                        contentMemoIn.classList.add('hidden');
                        contentReturned.classList.remove('hidden');
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
        });
    </script>
@endsection