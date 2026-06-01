@extends('layouts.app')

@section('title', 'List overview')

@section('content')
    <!-- Tailwind CSS for styling -->
    <script src="https://cdn.tailwindcss.com"></script>

    <div class="p-6 min-h-screen bg-slate-50">
        <!-- Header / Back Button -->
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center gap-3">
                <a href="{{ url('Inventory/MyInventory') }}"
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
            <div>
                <h1 class="text-2xl font-bold text-slate-800 tracking-tight">List overview</h1>
                <p class="text-[13px] text-slate-800 mt-1 font-bold">Last updated: <span
                        class="font-normal text-slate-600">2026-04-22 15:55:38 (3 weeks ago)</span></p>
            </div>
        </div>

        <!-- Filter Card -->
        <div class="bg-white rounded-md border border-slate-200 p-6 mb-6 shadow-sm">
            <div class="flex items-center gap-2 mb-6">
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                </svg>
                <h2 class="text-sm font-bold text-blue-600 uppercase tracking-wider">Filter by</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-12 gap-5 items-end">
                <!-- Company -->
                <div class="col-span-1 md:col-span-2">
                    <label class="block text-xs font-bold text-slate-700 mb-2">Company:</label>
                    <div class="relative">
                        <select
                            class="w-full pl-5 pr-10 py-2.5 text-[13px] text-slate-700 bg-white border border-slate-200 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-500 hover:border-blue-400 appearance-none transition-colors">
                            <option>Select</option>
                        </select>
                        <div class="absolute inset-y-0 right-4 flex items-center pointer-events-none">
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- List type -->
                <div class="col-span-1 md:col-span-3">
                    <label class="block text-xs font-bold text-slate-700 mb-2">List type:</label>
                    <div class="relative" id="listTypeDropdownWrapper">
                        <button type="button" id="listTypeBtn"
                            class="w-full flex items-center justify-between px-3 py-2 bg-[#e2e8f0] border border-slate-300 rounded-md hover:bg-slate-300 transition-colors focus:outline-none h-[40px]">
                            <div class="flex items-center gap-2 text-[#0f3460]">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M4 6a2 2 0 110-4 2 2 0 010 4zm0 8a2 2 0 110-4 2 2 0 010 4zm0 8a2 2 0 110-4 2 2 0 010 4zm6-14h12a1 1 0 100-2H10a1 1 0 100 2zm0 8h12a1 1 0 100-2H10a1 1 0 100 2zm0 8h12a1 1 0 100-2H10a1 1 0 100 2z" />
                                </svg>
                                <span id="listTypeLabel" class="text-[13px] text-slate-400 font-medium">Select</span>
                            </div>
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                                </path>
                            </svg>
                        </button>
                        <div id="listTypePanel"
                            class="hidden absolute left-0 right-0 top-[100%] mt-1 bg-white border border-slate-200 rounded-md shadow-lg z-50">
                            <ul class="py-2">
                                <li class="px-4 py-2.5 text-[14px] text-slate-800 hover:bg-slate-50 cursor-pointer list-type-opt"
                                    data-value="regular">Regular list</li>
                                <li class="px-4 py-2.5 text-[14px] text-slate-800 hover:bg-slate-50 cursor-pointer list-type-opt"
                                    data-value="bulk">Bulk upload</li>
                                <li class="px-4 py-2.5 text-[14px] text-slate-800 hover:bg-slate-50 cursor-pointer list-type-opt"
                                    data-value="website">From website</li>
                                <li class="px-4 py-2.5 text-[14px] text-slate-800 hover:bg-slate-50 cursor-pointer list-type-opt"
                                    data-value="woocommerce">From woocommerce</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Date range -->
                <div class="col-span-1 md:col-span-3">
                    <label class="block text-xs font-bold text-slate-700 mb-2">Creation date range:</label>
                    <div class="flex items-center gap-2">
                        <!-- From Date -->
                        <div
                            class="relative w-full h-[40px] bg-white border border-slate-200 rounded-md flex items-center px-4 hover:border-blue-400 focus-within:border-blue-500 focus-within:ring-1 focus-within:ring-blue-500 transition-all overflow-hidden">
                            <input type="date" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-20"
                                onclick="try { this.showPicker(); } catch(e) {}"
                                onchange="document.getElementById('start_date_text').textContent = this.value || 'mm/dd/yyyy'; if(this.value) { document.getElementById('start_date_text').classList.remove('text-blue-600'); document.getElementById('start_date_text').classList.add('text-blue-600'); } else { document.getElementById('start_date_text').classList.add('text-blue-600'); document.getElementById('start_date_text').classList.remove('text-blue-600'); }">
                            <span id="start_date_text"
                                class="text-[13px] text-blue-600 w-full truncate z-10 relative pointer-events-none select-none text-left">mm/dd/yyyy</span>
                            <svg class="w-4 h-4 text-slate-800 shrink-0 z-10 relative pointer-events-none" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>

                        <span class="text-blue-400">-</span>

                        <!-- To Date -->
                        <div
                            class="relative w-full h-[40px] bg-white border border-slate-200 rounded-md flex items-center px-4 hover:border-blue-400 focus-within:border-blue-500 focus-within:ring-1 focus-within:ring-blue-500 transition-all overflow-hidden">
                            <input type="date" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-20"
                                onclick="try { this.showPicker(); } catch(e) {}"
                                onchange="document.getElementById('end_date_text').textContent = this.value || 'mm/dd/yyyy'; if(this.value) { document.getElementById('end_date_text').classList.remove('text-blue-600'); document.getElementById('end_date_text').classList.add('text-blue-600'); } else { document.getElementById('end_date_text').classList.add('text-blue-600'); document.getElementById('end_date_text').classList.remove('text-blue-600'); }">
                            <span id="end_date_text"
                                class="text-[13px] text-blue-600 w-full truncate z-10 relative pointer-events-none select-none text-left">mm/dd/yyyy</span>
                            <svg class="w-4 h-4 text-slate-800 shrink-0 z-10 relative pointer-events-none" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Creator -->
                <div class="col-span-1 md:col-span-3">
                    <label class="block text-xs font-bold text-slate-700 mb-2">Creator:</label>
                    <div class="relative" id="creatorTypeDropdownWrapper">
                        <button type="button" id="creatorTypeBtn"
                            class="w-full flex items-center justify-between px-3 py-2 bg-[#e2e8f0] border border-slate-300 rounded-md hover:bg-slate-300 transition-colors focus:outline-none h-[40px]">
                            <div class="flex items-center gap-2 text-[#0f3460]">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                    </path>
                                </svg>
                                <span id="creatorTypeLabel" class="text-[13px] text-slate-400 font-medium">Select</span>
                            </div>
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                                </path>
                            </svg>
                        </button>
                        <div id="creatorTypePanel"
                            class="hidden absolute left-0 right-0 top-[100%] mt-1 bg-white border border-slate-200 rounded-md shadow-lg z-50">
                            <ul class="py-2">
                                <li class="px-4 py-2.5 text-[14px] text-slate-800 hover:bg-slate-50 cursor-pointer creator-type-opt"
                                    data-value="all">All</li>
                                <li class="px-4 py-2.5 text-[14px] text-slate-800 hover:bg-slate-50 cursor-pointer creator-type-opt"
                                    data-value="me">Created by me</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Buttons -->
                <div class="col-span-1 md:col-span-12 flex justify-end gap-3 mt-2">
                    <button type="button"
                        class="inline-flex items-center gap-2 px-6 py-2.5 text-sm font-semibold text-blue-600 bg-white border border-blue-200 rounded-md hover:bg-blue-50 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                        Reset
                    </button>
                    <button type="button"
                        class="inline-flex items-center gap-2 px-8 py-2.5 text-sm font-semibold text-white bg-[#2563eb] rounded-md hover:bg-blue-700 shadow-sm transition-colors">
                        Apply
                    </button>
                </div>
            </div>
        </div>

        <!-- Main Content Area -->
        <div class="bg-white rounded-md shadow-sm border border-slate-100 p-5 mt-6 mb-6">

            <!-- Toolbar Top Row -->
            <div class="flex flex-wrap items-center justify-between mb-4 gap-4">
                <button
                    class="px-4 py-2 bg-[#f1f5f9] hover:bg-slate-200 rounded-md text-[13px] font-medium text-slate-700 transition-colors">
                    Manage Columns
                </button>

                <div class="flex items-center gap-4">
                    <div class="text-[13px] text-slate-800"><span class="font-bold">1</span> Items</div>
                    <div class="h-4 w-px bg-slate-300"></div>
                    <div class="text-[13px] text-slate-800 font-bold">0.00 USD</div>
                </div>

                <button
                    class="px-4 py-2 bg-[#f1f5f9] hover:bg-slate-200 rounded-md text-[13px] font-medium text-slate-700 transition-colors flex items-center gap-1">
                    Create new list <span class="text-[15px] leading-none">+</span>
                </button>
            </div>

            <!-- Toolbar Search Row -->
            <div class="flex justify-end mb-4">
                <div
                    class="relative flex items-center w-[250px] border border-slate-200 rounded-md overflow-hidden bg-white">
                    <input type="text" placeholder="search"
                        class="w-full pl-3 pr-2 py-1.5 text-[13px] focus:outline-none placeholder-slate-400">
                    <button class="bg-[#2563eb] text-white p-1.5 hover:bg-blue-700 transition-colors h-full px-3">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Table Container -->
            <div class="overflow-x-auto w-full">
                <table class="w-full text-left border-collapse whitespace-nowrap">
                    <thead class="bg-[#f8fafc] text-slate-800 font-bold text-[13px]">
                        <tr>
                            <th class="px-4 py-3 w-10">
                                <input type="checkbox"
                                    class="w-3.5 h-3.5 rounded-md border-slate-300 text-blue-600 focus:ring-blue-500 bg-white align-middle">
                            </th>
                            <th class="px-4 py-3 font-bold">
                                Ref id
                                <span
                                    class="text-slate-300 ml-1 inline-flex flex-col text-[8px] leading-[6px] align-middle">
                                    <svg class="w-2 h-2" fill="currentColor" viewBox="0 0 320 512">
                                        <path
                                            d="M182.6 137.4c-12.5-12.5-32.8-12.5-45.3 0l-128 128c-9.2 9.2-11.9 22.9-6.9 34.9s16.6 19.8 29.6 19.8h256c12.9 0 24.6-7.8 29.6-19.8s2.2-25.7-6.9-34.9l-128-128z" />
                                    </svg>
                                    <svg class="w-2 h-2 mt-[1px]" fill="currentColor" viewBox="0 0 320 512">
                                        <path
                                            d="M137.4 374.6c12.5 12.5 32.8 12.5 45.3 0l128-128c9.2-9.2 11.9-22.9 6.9-34.9s-16.6-19.8-29.6-19.8L32 192c-12.9 0-24.6 7.8-29.6 19.8s-2.2 25.7 6.9 34.9l128 128z" />
                                    </svg>
                                </span>
                            </th>
                            <th class="px-4 py-3 font-bold">
                                Issue date
                                <span class="text-blue-500 ml-1 inline-flex flex-col text-[8px] leading-[6px] align-middle">
                                    <svg class="w-2 h-2 mt-[1px]" fill="currentColor" viewBox="0 0 320 512">
                                        <path
                                            d="M137.4 374.6c12.5 12.5 32.8 12.5 45.3 0l128-128c9.2-9.2 11.9-22.9 6.9-34.9s-16.6-19.8-29.6-19.8L32 192c-12.9 0-24.6 7.8-29.6 19.8s-2.2 25.7 6.9 34.9l128 128z" />
                                    </svg>
                                </span>
                            </th>
                            <th class="px-4 py-3 font-bold">List type</th>
                            <th class="px-4 py-3 font-bold">List reason</th>
                            <th class="px-4 py-3 font-bold">Receiver type</th>
                            <th class="px-4 py-3 font-bold">Receiver</th>
                            <th class="px-4 py-3 font-bold">
                                Quantity
                                <span
                                    class="text-slate-300 ml-1 inline-flex flex-col text-[8px] leading-[6px] align-middle">
                                    <svg class="w-2 h-2" fill="currentColor" viewBox="0 0 320 512">
                                        <path
                                            d="M182.6 137.4c-12.5-12.5-32.8-12.5-45.3 0l-128 128c-9.2 9.2-11.9 22.9-6.9 34.9s16.6 19.8 29.6 19.8h256c12.9 0 24.6-7.8 29.6-19.8s2.2-25.7-6.9-34.9l-128-128z" />
                                    </svg>
                                    <svg class="w-2 h-2 mt-[1px]" fill="currentColor" viewBox="0 0 320 512">
                                        <path
                                            d="M137.4 374.6c12.5 12.5 32.8 12.5 45.3 0l128-128c9.2-9.2 11.9-22.9 6.9-34.9s-16.6-19.8-29.6-19.8L32 192c-12.9 0-24.6 7.8-29.6 19.8s-2.2 25.7 6.9 34.9l128 128z" />
                                    </svg>
                                </span>
                            </th>
                            <th class="px-4 py-3 font-bold">
                                Weight
                                <span
                                    class="text-slate-300 ml-1 inline-flex flex-col text-[8px] leading-[6px] align-middle">
                                    <svg class="w-2 h-2" fill="currentColor" viewBox="0 0 320 512">
                                        <path
                                            d="M182.6 137.4c-12.5-12.5-32.8-12.5-45.3 0l-128 128c-9.2 9.2-11.9 22.9-6.9 34.9s16.6 19.8 29.6 19.8h256c12.9 0 24.6-7.8 29.6-19.8s2.2-25.7-6.9-34.9l-128-128z" />
                                    </svg>
                                    <svg class="w-2 h-2 mt-[1px]" fill="currentColor" viewBox="0 0 320 512">
                                        <path
                                            d="M137.4 374.6c12.5 12.5 32.8 12.5 45.3 0l128-128c9.2-9.2 11.9-22.9 6.9-34.9s-16.6-19.8-29.6-19.8L32 192c-12.9 0-24.6 7.8-29.6 19.8s-2.2 25.7 6.9 34.9l128 128z" />
                                    </svg>
                                </span>
                            </th>
                            <th class="px-4 py-3 font-bold">Amount</th>
                            <th class="px-4 py-3 font-bold">
                                Link expiry date
                                <span
                                    class="text-slate-300 ml-1 inline-flex flex-col text-[8px] leading-[6px] align-middle">
                                    <svg class="w-2 h-2" fill="currentColor" viewBox="0 0 320 512">
                                        <path
                                            d="M182.6 137.4c-12.5-12.5-32.8-12.5-45.3 0l-128 128c-9.2 9.2-11.9 22.9-6.9 34.9s16.6 19.8 29.6 19.8h256c12.9 0 24.6-7.8 29.6-19.8s2.2-25.7-6.9-34.9l-128-128z" />
                                    </svg>
                                    <svg class="w-2 h-2 mt-[1px]" fill="currentColor" viewBox="0 0 320 512">
                                        <path
                                            d="M137.4 374.6c12.5 12.5 32.8 12.5 45.3 0l128-128c9.2-9.2 11.9-22.9 6.9-34.9s-16.6-19.8-29.6-19.8L32 192c-12.9 0-24.6 7.8-29.6 19.8s-2.2 25.7 6.9 34.9l128 128z" />
                                    </svg>
                                </span>
                            </th>
                        </tr>
                    </thead>
                </table>
            </div>

            <!-- Pagination Footer -->
            <div class="pt-6 pb-2 flex items-center justify-between text-[13px]">
                <div class="flex items-center gap-2 text-slate-500 font-medium">
                    <span>Results per page Show</span>
                    <div class="relative">
                        <select
                            class="border border-slate-300 rounded-md py-1 pl-2 pr-6 text-[13px] focus:outline-none appearance-none bg-white cursor-pointer text-slate-700">
                            <option value="25">25</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select>
                        <div class="absolute inset-y-0 right-1.5 flex items-center pointer-events-none">
                            <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                                </path>
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="text-slate-500 font-medium text-center">Showing 1 to 1 of 1 entries</div>
                <div class="flex items-center gap-3">
                    <button class="text-blue-500 hover:text-blue-600 font-medium transition-colors">Previous</button>
                    <button
                        class="w-6 h-6 flex items-center justify-center bg-slate-200 text-slate-700 font-medium rounded-md">1</button>
                    <button class="text-blue-500 hover:text-blue-600 font-medium transition-colors">Next</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Dropdown Logic Reusable Function
            function setupDropdown(btnId, panelId, labelId, optionClass) {
                const btn = document.getElementById(btnId);
                const panel = document.getElementById(panelId);
                const label = document.getElementById(labelId);
                const options = document.querySelectorAll('.' + optionClass);

                if (btn && panel) {
                    btn.addEventListener('click', (e) => {
                        e.stopPropagation();
                        // Close other panels
                        document.querySelectorAll('.dropdown-panel').forEach(p => {
                            if (p.id !== panelId) p.classList.add('hidden');
                        });
                        panel.classList.toggle('hidden');
                    });

                    document.addEventListener('click', (e) => {
                        if (!btn.contains(e.target) && !panel.contains(e.target)) {
                            panel.classList.add('hidden');
                        }
                    });

                    options.forEach(option => {
                        option.addEventListener('click', () => {
                            label.textContent = option.textContent;
                            label.classList.remove('text-slate-400');
                            label.classList.add('text-slate-800');
                            panel.classList.add('hidden');
                        });
                    });
                }
            }

            setupDropdown('listTypeBtn', 'listTypePanel', 'listTypeLabel', 'list-type-opt');
            setupDropdown('creatorTypeBtn', 'creatorTypePanel', 'creatorTypeLabel', 'creator-type-opt');

            // Add a class to panels to easily close them
            document.getElementById('listTypePanel')?.classList.add('dropdown-panel');
            document.getElementById('creatorTypePanel')?.classList.add('dropdown-panel');
        });
    </script>
@endsection