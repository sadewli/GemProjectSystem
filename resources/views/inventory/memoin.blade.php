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
        <div class="bg-white rounded-2xl border border-slate-200 p-5 mb-6 shadow-sm">
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
                            class="w-full flex items-center justify-between pl-3 pr-8 py-2.5 text-sm text-slate-700 bg-slate-100 border border-slate-200 rounded-xl focus:outline-none cursor-pointer text-left hover:border-blue-400 transition-colors">
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
                            class="hidden absolute z-50 mt-2 w-full bg-white border border-slate-200 rounded-xl shadow-lg overflow-hidden">
                            <ul class="py-2 px-2 space-y-1">
                                <li
                                    class="flex items-center space-x-3 px-3 py-2 text-sm text-slate-700 hover:bg-slate-50 cursor-pointer rounded-lg">
                                    <input type="checkbox"
                                        class="w-4 h-4 rounded border-slate-300 text-blue-600 focus:ring-blue-500 cursor-pointer">
                                    <span>C&P Gemstone</span>
                                </li>
                                <li
                                    class="flex items-center space-x-3 px-3 py-2 text-sm text-slate-700 hover:bg-slate-50 cursor-pointer rounded-lg">
                                    <input type="checkbox"
                                        class="w-4 h-4 rounded border-slate-300 text-blue-600 focus:ring-blue-500 cursor-pointer">
                                    <span>Rough Gemstone</span>
                                </li>
                                <li
                                    class="flex items-center space-x-3 px-3 py-2 text-sm text-slate-700 hover:bg-slate-50 cursor-pointer rounded-lg">
                                    <input type="checkbox"
                                        class="w-4 h-4 rounded border-slate-300 text-blue-600 focus:ring-blue-500 cursor-pointer">
                                    <span>C&P Diamond</span>
                                </li>
                                <li
                                    class="flex items-center space-x-3 px-3 py-2 text-sm text-slate-700 hover:bg-slate-50 cursor-pointer rounded-lg">
                                    <input type="checkbox"
                                        class="w-4 h-4 rounded border-slate-300 text-blue-600 focus:ring-blue-500 cursor-pointer">
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
                            class="w-full flex items-center justify-between pl-3 pr-8 py-2.5 text-sm text-slate-700 bg-white border border-slate-300 rounded-xl focus:outline-none cursor-pointer text-left hover:border-blue-400 transition-colors">
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-2 text-slate-400" fill="none" stroke="currentColor"
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
                            class="hidden absolute z-50 mt-2 w-full bg-white border border-slate-200 rounded-xl shadow-lg overflow-hidden">
                            <ul class="py-1 max-h-48 overflow-y-auto">
                                <li class="supplier-option px-4 py-2.5 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer"
                                    data-value="Comp-1">Comp-1</li>
                                <li class="supplier-option px-4 py-2.5 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer"
                                    data-value="Comp-2">Comp-2</li>
                                <li class="supplier-option px-4 py-2.5 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer"
                                    data-value="Global Diamonds">Global Diamonds</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Creation Date Range -->
                <div class="col-span-1 md:col-span-1 min-w-[300px]">
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Creation date range:</label>
                    <div
                        class="flex items-center bg-white border border-slate-300 rounded-xl px-3 focus-within:border-blue-400 transition-colors">
                        <svg class="w-4 h-4 text-blue-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                            </path>
                        </svg>
                        <input type="text" placeholder="From"
                            class="w-full bg-transparent py-2.5 text-sm outline-none text-slate-700 placeholder-slate-400">
                        <svg class="w-3 h-3 text-slate-800 mx-2 flex-shrink-0" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                        </svg>
                        <input type="text" placeholder="To"
                            class="w-full bg-transparent py-2.5 text-sm outline-none text-slate-700 placeholder-slate-400">
                    </div>
                </div>

                <!-- Buttons -->
                <div class="col-span-1 flex justify-end gap-3">
                    <button type="button" id="btn-filter-reset" title="Clear filter"
                        class="flex items-center justify-center w-[42px] h-[42px] text-slate-500 bg-white border border-slate-200 rounded-2xl hover:bg-slate-50 hover:text-slate-700 transition-colors shadow-sm">
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
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">

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
                            class="relative w-[280px] shadow-sm rounded-lg overflow-hidden border border-slate-300 focus-within:ring-2 focus-within:ring-blue-100 focus-within:border-blue-500 transition-all flex">
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

                        <button
                            class="p-2 border border-slate-300 rounded-lg text-slate-500 hover:bg-slate-50 transition-colors shadow-sm">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M12 4v16m8-8H4M4 4h16M4 20h16"></path>
                            </svg>
                        </button>

                        <div class="relative" id="filteredByWrapper">
                            <button id="filteredByBtn"
                                class="flex items-center gap-2 px-3.5 py-2 border border-slate-300 rounded-lg text-[13px] font-medium text-slate-700 bg-slate-50 hover:bg-slate-100 transition-colors shadow-sm">
                                Filtered by
                                <svg class="w-3 h-3 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            <div id="filteredByPanel"
                                class="hidden absolute right-0 z-50 mt-2 w-48 bg-white border border-slate-200 rounded-xl shadow-lg overflow-hidden">
                                <ul class="py-1">
                                    <li class="px-4 py-2 text-sm text-slate-700 hover:bg-blue-50 cursor-pointer">Date:
                                        Newest</li>
                                    <li class="px-4 py-2 text-sm text-slate-700 hover:bg-blue-50 cursor-pointer">Date:
                                        Oldest</li>
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
                                        class="w-4 h-4 rounded border-slate-300 text-blue-600 focus:ring-blue-500 align-middle">
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
                                        class="w-4 h-4 rounded border-slate-300 text-blue-600 focus:ring-blue-500 align-middle">
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
                    class="px-5 py-3 border-t border-slate-200 flex items-center justify-between bg-white text-[13px] text-slate-600 rounded-b-xl">
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

            supplierOptions.forEach(opt => {
                opt.addEventListener('click', function () {
                    supplierLabel.textContent = this.getAttribute('data-value');
                    supplierLabel.classList.remove('text-slate-400');
                    supplierLabel.classList.add('text-slate-800');
                    supplierPanel.classList.add('hidden');
                });
            });

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
        });
    </script>
@endsection