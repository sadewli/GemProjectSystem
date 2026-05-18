@extends('layouts.app')

@section('title', 'Negative Inventory Adjustment')

<style>
    /* Negative Inventory Custom Styles */
/* These styles supplement Tailwind CSS for specific custom UI components if needed */

.negative-inventory-filter-card {
    transition: all 0.2s ease-in-out;
}

/* Custom scrollbar for tables if needed */
.custom-scrollbar::-webkit-scrollbar {
    height: 8px;
    width: 8px;
}

.custom-scrollbar::-webkit-scrollbar-track {
    background: #f1f5f9;
    border-radius: 6px;
}

.custom-scrollbar::-webkit-scrollbar-thumb {
    background: #cbd5e1;
    border-radius: 6px;
}

.custom-scrollbar::-webkit-scrollbar-thumb:hover {
    background: #94a3b8;
}
</style>

@section('content')
<div class="p-6 min-h-screen bg-slate-50">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-slate-800 tracking-tight">Negative inventory adjustment</h1>
    </div>

    {{-- Filter Section --}}
    <div class="bg-white rounded-md border border-slate-200 p-5 mb-6 shadow-sm negative-inventory-filter-card">
        <div class="flex items-center gap-2 mb-4">
            <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
            </svg>
            <h2 class="text-sm font-bold text-blue-700 uppercase tracking-wider">Filter by</h2>
        </div>
        <div class="flex flex-wrap lg:flex-nowrap items-end gap-3 w-full">
            <div class="w-full lg:w-64 flex-shrink-0">
                <label class="block text-[13px] text-slate-600 mb-1.5 font-medium">Status:</label>
                <div class="relative" id="statusDropdownWrapper">
                    <!-- Hidden input for the actual value -->
                    <input type="hidden" name="status" id="statusHiddenInput" class="filter-select-custom" value="">

                    <!-- Trigger button -->
                    <button type="button" id="statusDropdownBtn"
                        class="w-full flex items-center justify-between pl-3 pr-8 py-2.5 text-[13px] text-slate-500 bg-white border border-slate-300 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500 cursor-pointer text-left hover:border-slate-400 transition-colors">
                        <span id="statusDropdownLabel" class="truncate">Select status</span>
                    </button>
                    <!-- Chevron icon -->
                    <div class="absolute inset-y-0 right-3 flex items-center pointer-events-none">
                        <svg class="w-4 h-4 text-slate-400 transition-transform duration-200" id="statusDropdownIcon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </div>

                    <!-- Dropdown panel -->
                    <div id="statusDropdownPanel"
                        class="hidden absolute z-50 mt-1 w-full bg-white border border-slate-200 rounded-md shadow-lg overflow-hidden">
                        <!-- Options list -->
                        <ul id="statusList" class="max-h-48 overflow-y-auto py-1">
                            <li class="status-option px-3 py-2 text-[13px] text-slate-700 hover:bg-slate-50 cursor-pointer"
                                data-value="pending" data-label="Pending">Pending</li>
                            <li class="status-option px-3 py-2 text-[13px] text-slate-700 hover:bg-slate-50 cursor-pointer"
                                data-value="partially_resolved" data-label="Partially resolved">Partially resolved</li>
                            <li class="status-option px-3 py-2 text-[13px] text-slate-700 hover:bg-slate-50 cursor-pointer"
                                data-value="resolved" data-label="Resolved">Resolved</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="w-full lg:flex-1">
                <label class="block text-[13px] font-semibold text-[#1e293b] mb-1.5">Creation date range:</label>
                <div class="flex items-center gap-2.5">
                    <div class="relative flex-1">
                        <input type="date"
                            class="filter-date w-full bg-white border border-slate-300 text-slate-700 py-2 px-3 rounded-md text-[13px] focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-500 transition-shadow">
                    </div>
                    <span class="text-slate-400 font-medium">-</span>
                    <div class="relative flex-1">
                        <input type="date"
                            class="filter-date w-full bg-white border border-slate-300 text-slate-700 py-2 px-3 rounded-md text-[13px] focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-500 transition-shadow">
                    </div>
                </div>
            </div>

            <div class="flex items-center gap-3 ml-auto flex-shrink-0">
                <button type="button" id="resetFiltersBtn" class="flex items-center justify-center w-[42px] h-[42px] bg-slate-100 text-[#1e3a8a] rounded-md hover:bg-slate-200 transition-colors tooltip" title="Reset Filters">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                </button>
                <button type="button" class="px-6 h-[42px] text-[14px] font-semibold text-white bg-[#2563eb] rounded-md hover:bg-blue-700 shadow-sm transition-colors">
                    Apply
                </button>
            </div>
        </div>
    </div>

    {{-- Main Content Area --}}
    <div class="bg-white rounded-md border border-slate-200 shadow-sm overflow-hidden">
        {{-- Tabs --}}
        <div class="flex w-full">
            <button class="tab-btn active w-1/2 py-3 text-sm font-semibold text-blue-700 bg-blue-50/50" data-target="pending-tab">
                Pending (0)
            </button>
            <button class="tab-btn w-1/2 py-3 text-sm font-semibold text-slate-600 bg-slate-50/50 hover:bg-slate-100 transition-colors" data-target="resolved-tab">
                Resolved (0)
            </button>
        </div>

        {{-- Pending Tab Content --}}
        <div id="pending-tab" class="tab-content p-4 block">
            {{-- Toolbar --}}
            <div class="flex flex-wrap items-center justify-between gap-4 mb-4">
                <div class="flex items-center gap-3">
                    <div class="flex items-stretch shadow-sm rounded-md overflow-hidden border border-slate-300 focus-within:ring-1 focus-within:ring-blue-500 focus-within:border-blue-500 transition-all">
                        <input type="text" placeholder="Search..." class="w-80 px-4 py-2 text-sm border-none focus:outline-none focus:ring-0">
                        <button class="px-5 bg-[#2563eb] text-white flex items-center justify-center hover:bg-blue-700 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                        </button>
                    </div>
                </div>
            </div>

            {{-- Table --}}
            <div class="overflow-x-auto">
                <table class="w-full text-left whitespace-nowrap border-collapse">
                    <thead>
                        <tr class="bg-white text-slate-800 text-[13px] font-bold border-y border-slate-200">
                            <th class="py-3 px-4 font-bold whitespace-nowrap">SKU</th>
                            <th class="py-3 px-4 font-bold whitespace-nowrap">Document</th>
                            <th class="py-3 px-4 font-bold whitespace-nowrap">Weight</th>
                            <th class="py-3 px-4 font-bold whitespace-nowrap">Weight in doc (ct)</th>
                            <th class="py-3 px-4 font-bold whitespace-nowrap">Negative inventory (ct)</th>
                            <th class="py-3 px-4 font-bold whitespace-nowrap">Cost/ct</th>
                            <th class="py-3 px-4 font-bold whitespace-nowrap">Total cost</th>
                            <th class="py-3 px-4 font-bold whitespace-nowrap">Status</th>
                            <th class="py-3 px-4 font-bold whitespace-nowrap">Reason</th>
                            <th class="py-3 px-4 font-bold whitespace-nowrap text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="text-slate-700 text-sm bg-white">
                        {{-- Empty State --}}
                        <tr>
                            <td colspan="10" class="py-12 text-center text-slate-500 text-sm bg-white">
                                <div class="flex flex-col items-center justify-center">
                                    <svg class="w-12 h-12 text-slate-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                                    </svg>
                                    <p>No data available in table</p>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="flex items-center justify-between mt-4 text-sm text-slate-500">
                <div class="flex items-center gap-2">
                    <span>Show</span>
                    <select class="bg-white border border-slate-300 rounded-md px-2 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option>10</option>
                        <option>25</option>
                        <option>50</option>
                    </select>
                    <span>entries</span>
                </div>
                <div>Showing 0 to 0 of 0 entries</div>
                <div class="flex items-center gap-1">
                    <button class="px-3 py-1.5 border border-slate-200 text-slate-400 bg-slate-50 rounded-md cursor-not-allowed">Previous</button>
                    <button class="px-3 py-1.5 border border-slate-200 text-slate-400 bg-slate-50 rounded-md cursor-not-allowed">Next</button>
                </div>
            </div>
        </div>

        {{-- Resolved Tab Content --}}
        <div id="resolved-tab" class="tab-content hidden p-4">
            {{-- Toolbar --}}
            <div class="flex flex-wrap items-center justify-between gap-4 mb-4">
                <div class="flex items-center gap-3">
                    <div class="flex items-stretch shadow-sm rounded-md overflow-hidden border border-slate-300 focus-within:ring-1 focus-within:ring-blue-500 focus-within:border-blue-500 transition-all">
                        <input type="text" placeholder="Search..." class="w-80 px-4 py-2 text-sm border-none focus:outline-none focus:ring-0">
                        <button class="px-5 bg-[#2563eb] text-white flex items-center justify-center hover:bg-blue-700 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                        </button>
                    </div>
                </div>
            </div>

            {{-- Table --}}
            <div class="overflow-x-auto">
                <table class="w-full text-left whitespace-nowrap border-collapse">
                    <thead>
                        <tr class="bg-white text-slate-800 text-[13px] font-bold border-y border-slate-200">
                            <th class="py-3 px-4 font-bold whitespace-nowrap">SKU</th>
                            <th class="py-3 px-4 font-bold whitespace-nowrap">Document</th>
                            <th class="py-3 px-4 font-bold whitespace-nowrap">Weight</th>
                            <th class="py-3 px-4 font-bold whitespace-nowrap">Weight in doc (ct)</th>
                            <th class="py-3 px-4 font-bold whitespace-nowrap">Negative inventory (ct)</th>
                            <th class="py-3 px-4 font-bold whitespace-nowrap">Cost/ct</th>
                            <th class="py-3 px-4 font-bold whitespace-nowrap">Total cost</th>
                            <th class="py-3 px-4 font-bold whitespace-nowrap">Status</th>
                            <th class="py-3 px-4 font-bold whitespace-nowrap">Reason</th>
                            <th class="py-3 px-4 font-bold whitespace-nowrap text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="text-slate-700 text-sm bg-white">
                        {{-- Empty State --}}
                        <tr>
                            <td colspan="10" class="py-12 text-center text-slate-500 text-sm bg-white">
                                <div class="flex flex-col items-center justify-center">
                                    <svg class="w-12 h-12 text-slate-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2-2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                                    </svg>
                                    <p>No resolved items found</p>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="flex items-center justify-between mt-4 text-sm text-slate-500">
                <div class="flex items-center gap-2">
                    <span>Show</span>
                    <select class="bg-white border border-slate-300 rounded-md px-2 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option>10</option>
                        <option>25</option>
                        <option>50</option>
                    </select>
                    <span>entries</span>
                </div>
                <div>Showing 0 to 0 of 0 entries</div>
                <div class="flex items-center gap-1">
                    <button class="px-3 py-1.5 border border-slate-200 text-slate-400 bg-slate-50 rounded-md cursor-not-allowed">Previous</button>
                    <button class="px-3 py-1.5 border border-slate-200 text-slate-400 bg-slate-50 rounded-md cursor-not-allowed">Next</button>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
    // Tab switching logic for Pending/Resolved
    const tabBtns = document.querySelectorAll('.tab-btn');
    const tabContents = document.querySelectorAll('.tab-content');

    tabBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            // Remove active classes
            tabBtns.forEach(b => {
                b.classList.remove('text-blue-700', 'bg-blue-50', 'border-blue-700', 'border-b-2');
                b.classList.add('text-slate-500', 'hover:text-slate-700', 'hover:bg-slate-50');
            });

            // Add active classes to clicked tab
            btn.classList.add('text-blue-700', 'bg-blue-50', 'border-blue-700', 'border-b-2');
            btn.classList.remove('text-slate-500', 'hover:text-slate-700', 'hover:bg-slate-50');

            const target = btn.getAttribute('data-target');

            tabContents.forEach(content => {
                if (content.id === target) {
                    content.classList.remove('hidden');
                } else {
                    content.classList.add('hidden');
                }
            });
        });
    });

    // Status Custom Dropdown Logic
    const statusBtn = document.getElementById('statusDropdownBtn');
    const statusPanel = document.getElementById('statusDropdownPanel');
    const statusLabel = document.getElementById('statusDropdownLabel');
    const statusHidden = document.getElementById('statusHiddenInput');
    const statusOptions = document.querySelectorAll('.status-option');
    const statusIcon = document.getElementById('statusDropdownIcon');

    if (statusBtn && statusPanel) {
        // Toggle dropdown
        statusBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            statusPanel.classList.toggle('hidden');
            if (!statusPanel.classList.contains('hidden')) {
                statusIcon.classList.add('rotate-180');
            } else {
                statusIcon.classList.remove('rotate-180');
            }
        });

        // Close when clicking outside
        document.addEventListener('click', (e) => {
            if (!statusBtn.contains(e.target) && !statusPanel.contains(e.target)) {
                statusPanel.classList.add('hidden');
                statusIcon.classList.remove('rotate-180');
            }
        });

        // Select an option
        statusOptions.forEach(option => {
            option.addEventListener('click', () => {
                const val = option.getAttribute('data-value');
                const label = option.getAttribute('data-label');

                statusHidden.value = val;
                statusLabel.textContent = label;
                statusLabel.classList.remove('text-slate-500');
                statusLabel.classList.add('text-slate-800', 'font-medium');

                // Highlight selected
                statusOptions.forEach(opt => opt.classList.remove('bg-blue-50', 'text-blue-700', 'font-medium'));
                option.classList.add('bg-blue-50', 'text-blue-700', 'font-medium');

                statusPanel.classList.add('hidden');
                statusIcon.classList.remove('rotate-180');
            });
        });
    }

    // Reset button logic
    const resetBtn = document.getElementById('resetFiltersBtn');
    if(resetBtn) {
        resetBtn.addEventListener('click', () => {
            const dates = document.querySelectorAll('.filter-date');
            dates.forEach(d => d.value = '');

            // Reset custom status dropdown
            if (statusHidden && statusLabel) {
                statusHidden.value = '';
                statusLabel.textContent = 'Select status';
                statusLabel.classList.remove('text-slate-800', 'font-medium');
                statusLabel.classList.add('text-slate-500');

                statusOptions.forEach(opt => opt.classList.remove('bg-blue-50', 'text-blue-700', 'font-medium'));
            }
        });
    }
});
</script>
@endsection
