@extends('layouts.app')

@section('title', 'Inventory Adjustment')

@section('content')
    <script src="https://cdn.tailwindcss.com"></script>

    <div class="p-6 min-h-screen bg-slate-50">

        <!-- Header Row -->
        <div class="flex items-center justify-between mb-5">
            <div>
                <h1 class="text-2xl font-bold text-slate-800 tracking-tight">Inventory adjustment</h1>
                <p class="text-[13px] text-slate-500 mt-1">Last updated: <span class="font-normal">28 Apr 2026, 12:20 PM (2
                        weeks ago)</span></p>
            </div>
            <button
                class="inline-flex items-center gap-2 px-5 py-2.5 text-sm font-semibold text-white bg-[#2563eb] rounded-md hover:bg-blue-700 shadow-sm transition-colors">
                Adjust inventory
            </button>
        </div>

        <!-- Filter Card -->
        <div class="bg-white rounded-md border border-slate-200 p-5 mb-5 shadow-sm">
            <div class="flex items-center gap-2 mb-4">
                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                </svg>
                <h2 class="text-sm font-bold text-blue-600">Filter by</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">

                <!-- Storage Location -->
                <div>
                    <label class="block text-xs text-slate-500 mb-1">Storage location:</label>
                    <!-- Storage Location Custom Dropdown -->
                    <div class="relative" id="storageLoc_wrapper">
                        <button type="button" id="storageLoc_btn" onclick="toggleAdjDropdown(event, 'storageLoc_panel')"
                            class="w-full flex items-center justify-between pl-3 pr-3 py-2 bg-[#e2e8f0] border border-slate-300 rounded-md hover:bg-slate-300 transition-colors focus:outline-none h-[38px]">
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-slate-400 shrink-0" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <span id="storageLoc_label" class="text-[13px] text-slate-400 font-medium">Select storage
                                    location</span>
                            </div>
                            <svg class="w-4 h-4 text-slate-400 shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <!-- Dropdown panel -->
                        <div id="storageLoc_panel" onclick="event.stopPropagation()"
                            style="display:none;position:absolute;left:0;right:0;top:100%;margin-top:4px;background:#fff;border:1px solid #e2e8f0;border-radius:6px;box-shadow:0 4px 16px rgba(0,0,0,0.10);z-index:9999;">
                            <div class="p-2 border-b border-slate-100">
                                <input type="text" placeholder=""
                                    class="w-full px-3 py-1.5 text-[13px] border border-slate-200 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-500"
                                    oninput="filterDropdown(this, 'storageLoc_list')">
                            </div>
                            <ul id="storageLoc_list" class="py-1 max-h-48 overflow-y-auto">
                                <li class="px-4 py-2.5 text-[13px] text-blue-600 hover:bg-slate-50 cursor-pointer"
                                    onclick="selectAdjOption(event, 'storageLoc_label', 'Select storage location', true)">
                                    Select storage location</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Date Range - two separate pills -->
                <div>
                    <label class="block text-xs text-slate-500 mb-1">Date range:</label>
                    <div class="flex items-center gap-2">
                        <!-- From pill -->
                        <div
                            class="relative flex-1 h-[38px] bg-white border border-slate-200 rounded-md flex items-center px-4 hover:border-blue-400 focus-within:border-blue-500 focus-within:ring-1 focus-within:ring-blue-500 transition-all overflow-hidden">
                            <svg class="w-4 h-4 text-slate-400 shrink-0 mr-2 pointer-events-none" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <input type="date" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-20"
                                onclick="try { this.showPicker(); } catch(e) {}"
                                onchange="document.getElementById('adj_from_label').textContent = this.value || 'From';">
                            <span id="adj_from_label"
                                class="text-[13px] text-slate-400 pointer-events-none select-none">From</span>
                        </div>
                        <span class="text-slate-400 text-sm">→</span>
                        <!-- To pill -->
                        <div
                            class="relative flex-1 h-[38px] bg-white border border-slate-200 rounded-md flex items-center px-4 hover:border-blue-400 focus-within:border-blue-500 focus-within:ring-1 focus-within:ring-blue-500 transition-all overflow-hidden">
                            <svg class="w-4 h-4 text-slate-400 shrink-0 mr-2 pointer-events-none" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <input type="date" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-20"
                                onclick="try { this.showPicker(); } catch(e) {}"
                                onchange="document.getElementById('adj_to_label').textContent = this.value || 'To';">
                            <span id="adj_to_label"
                                class="text-[13px] text-slate-400 pointer-events-none select-none">To</span>
                        </div>
                    </div>
                </div>


                <!-- User -->
                <div>
                    <label class="block text-xs text-slate-500 mb-1">User:</label>
                    <div class="flex items-center gap-2">
                        <!-- User custom searchable dropdown -->
                        <div class="relative flex-1" id="adjUser_wrapper">
                            <button type="button" id="adjUser_btn" onclick="toggleAdjDropdown(event, 'adjUser_panel')"
                                class="w-full flex items-center justify-between pl-3 pr-3 py-2 bg-[#e2e8f0] border border-slate-300 rounded-md hover:bg-slate-300 transition-colors focus:outline-none h-[38px]">
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-slate-400 shrink-0" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    <span id="adjUser_label" class="text-[13px] text-slate-400 font-medium">Select
                                        user</span>
                                </div>
                                <svg class="w-4 h-4 text-slate-400 shrink-0" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                            <div id="adjUser_panel" onclick="event.stopPropagation()"
                                style="display:none;position:absolute;left:0;right:0;top:100%;margin-top:4px;background:#fff;border:1px solid #e2e8f0;border-radius:6px;box-shadow:0 4px 16px rgba(0,0,0,0.10);z-index:9999;">
                                <div class="p-2 border-b border-slate-100">
                                    <input type="text" placeholder=""
                                        class="w-full px-3 py-1.5 text-[13px] border border-slate-200 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-500"
                                        oninput="filterDropdown(this, 'adjUser_list')">
                                </div>
                                <ul id="adjUser_list" class="py-1 max-h-48 overflow-y-auto">
                                    <li class="px-4 py-2.5 text-[13px] text-blue-600 hover:bg-slate-50 cursor-pointer"
                                        onclick="selectAdjOption(event, 'adjUser_label', 'Select user', true)">Select user
                                    </li>
                                    <li class="px-4 py-2.5 text-[13px] text-slate-800 hover:bg-slate-50 cursor-pointer"
                                        onclick="selectAdjOption(event, 'adjUser_label', 'Adjustment by me', false)">
                                        Adjustment by me</li>
                                </ul>
                            </div>
                        </div>
                        <!-- Reset icon button -->
                        <button
                            class="flex items-center justify-center w-9 h-9 border border-slate-200 rounded-md bg-white hover:bg-slate-50 transition-colors shrink-0"
                            title="Reset">
                            <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                            </svg>
                        </button>
                        <!-- Apply button -->
                        <button
                            class="px-5 py-2 text-sm font-semibold text-white bg-[#2563eb] rounded-md hover:bg-blue-700 transition-colors shrink-0">
                            Apply
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="bg-white rounded-md border border-slate-200 shadow-sm">

            <!-- Toolbar -->
            <div class="flex items-center justify-between px-5 py-4 border-b border-slate-100">
                <button
                    class="inline-flex items-center gap-2 px-4 py-2 text-[13px] font-medium text-slate-600 bg-white border border-slate-200 rounded-md hover:bg-slate-50 transition-colors">
                    <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Excel Export
                </button>

                <div class="relative flex items-center">
                    <input type="text" placeholder="Search e.g. name, ref, etc"
                        class="w-[260px] pl-4 pr-10 py-2 text-[13px] border border-slate-200 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-500 placeholder-slate-400 bg-white">
                    <button
                        class="absolute right-0 top-0 bottom-0 px-3 bg-[#2563eb] text-white rounded-r-md hover:bg-blue-700 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse whitespace-nowrap text-[13px]">
                    <thead>
                        <tr class="border-b border-slate-100">
                            <th class="px-5 py-3 font-semibold text-slate-700">SKU</th>
                            <th class="px-5 py-3 font-semibold text-slate-700">Updated from</th>
                            <th class="px-5 py-3 font-semibold text-slate-700">User</th>
                            <th class="px-5 py-3 font-semibold text-slate-700">Update date</th>
                            <th class="px-5 py-3 font-semibold text-slate-700">Status</th>
                            <th class="px-5 py-3 font-semibold text-slate-700">Old weight</th>
                            <th class="px-5 py-3 font-semibold text-slate-700">New weight</th>
                            <th class="px-5 py-3 font-semibold text-slate-700">Total cost</th>
                            <th class="px-5 py-3 font-semibold text-slate-700">Reason</th>
                        </tr>
                    </thead>
                </table>
            </div>

            <!-- Pagination Footer -->
            <div class="flex items-center justify-between px-5 py-4 text-[13px] text-slate-500">
                <div class="flex items-center gap-2">
                    <span>Show</span>
                    <div class="relative">
                        <select
                            class="border border-slate-200 rounded-md py-1 pl-2 pr-6 text-[13px] focus:outline-none appearance-none bg-white cursor-pointer text-slate-700">
                            <option value="10">10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                        </select>
                        <div class="absolute inset-y-0 right-1.5 flex items-center pointer-events-none">
                            <svg class="w-3 h-3 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                    </div>
                    <span>items per page</span>
                </div>

                <div class="text-slate-500">Showing results 1 to 1 of 1 entries</div>

                <div class="flex items-center gap-2">
                    <button class="text-slate-500 hover:text-slate-800 font-medium transition-colors">Previous</button>
                    <button
                        class="w-7 h-7 flex items-center justify-center bg-slate-100 text-slate-700 font-semibold rounded-md border border-slate-200 text-[13px]">1</button>
                    <button class="text-slate-500 hover:text-slate-800 font-medium transition-colors">Next</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Toggle dropdown - called inline from button onclick
        function toggleAdjDropdown(event, panelId) {
            event.stopPropagation();
            var panel = document.getElementById(panelId);
            var allPanels = ['storageLoc_panel', 'adjUser_panel'];
            // Close other panels
            allPanels.forEach(function (id) {
                if (id !== panelId) {
                    document.getElementById(id).style.display = 'none';
                }
            });
            // Toggle this panel
            if (panel.style.display === 'none' || panel.style.display === '') {
                panel.style.display = 'block';
                // Focus search
                var s = panel.querySelector('input[type=text]');
                if (s) setTimeout(function () { s.focus(); }, 10);
            } else {
                panel.style.display = 'none';
            }
        }

        // Select option from dropdown
        function selectAdjOption(event, labelId, text, isPlaceholder) {
            event.stopPropagation();
            var label = document.getElementById(labelId);
            if (label) {
                label.textContent = text;
                label.style.color = isPlaceholder ? '#94a3b8' : '#1e293b';
            }
            // Close parent panel
            var panel = event.target.closest('[id$="_panel"]');
            if (panel) panel.style.display = 'none';
        }

        // Filter list items by search
        function filterDropdown(input, listId) {
            var q = input.value.toLowerCase();
            document.querySelectorAll('#' + listId + ' li').forEach(function (li) {
                li.style.display = li.textContent.toLowerCase().includes(q) ? '' : 'none';
            });
        }

        // Close all on outside click
        document.addEventListener('click', function () {
            ['storageLoc_panel', 'adjUser_panel'].forEach(function (id) {
                var el = document.getElementById(id);
                if (el) el.style.display = 'none';
            });
        });
    </script>
@endsection