@extends('layouts.app')

@push('styles')
@endpush

<style>
    /* Archived Products — Custom CSS */

/* Custom scrollbar for table container */
.entriestable-row .overflow-x-auto::-webkit-scrollbar {
    height: 6px;
}
.entriestable-row .overflow-x-auto::-webkit-scrollbar-track {
    background: #f1f5f9;
    border-radius: 6px;
}
.entriestable-row .overflow-x-auto::-webkit-scrollbar-thumb {
    background: #cbd5e1;
    border-radius: 6px;
}
.entriestable-row .overflow-x-auto::-webkit-scrollbar-thumb:hover {
    background: #94a3b8;
}

/* Hover row highlight */
#archived-table tbody tr:hover td {
    background-color: #f8fafc;
}

/* Style Bootstrap-Select to match Tailwind design from screenshot */
.custom-gray-select.bootstrap-select > .btn {
    background-color: #e2e8f0 !important; /* Matches screenshot gray */
    border: 1px solid #cbd5e1 !important;
    color: #334155 !important;
    font-size: 13px !important;
    padding: 6px 12px !important;
    border-radius: 6px !important;
    box-shadow: none !important;
    height: 36px !important;
    display: flex !important;
    align-items: center !important;
}
.custom-gray-select.bootstrap-select > .btn:focus {
    outline: none !important;
    border-color: #2563eb !important;
    box-shadow: 0 0 0 1px #2563eb !important;
}
.custom-gray-select.bootstrap-select .dropdown-toggle .filter-option {
    display: flex;
    align-items: center;
}
.custom-gray-select.bootstrap-select .dropdown-menu {
    border: 1px solid #e2e8f0;
    border-radius: 6px;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    padding: 8px 0;
}

/* Fix for giant icons */
#noData svg, .flex.items-center svg {
    max-width: 100%;
}
</style>

@section('content')
<!-- Tailwind CSS for this page -->
<script src="https://cdn.tailwindcss.com"></script>

<div class="p-6 bg-[#f8fafc] min-h-screen font-sans relative">

    <!-- Title -->
    <div class="mb-4">
        <h1 class="text-[20px] font-bold text-gray-900 m-0">Archived products</h1>
    </div>

    <!-- Filter Card -->
    <div class="bg-white border border-gray-200 rounded-md shadow-sm w-full mb-10 relative z-20">

        <!-- Filter Header -->
        <div class="bg-[#f8fafc] border-b border-gray-200 px-4 py-3 rounded-t-md flex items-center">
            <svg class="w-[18px] h-[18px] text-[#2563eb] mr-2" width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
            </svg>
            <span class="text-[#2563eb] text-[14px] font-semibold">Filter by</span>
        </div>

        <!-- Filter Body -->
        <div class="p-4 flex flex-wrap xl:flex-nowrap items-center justify-between gap-4">

            <div class="flex flex-wrap md:flex-nowrap items-center gap-6">
                <!-- Status Filter (Custom Tailwind Dropdown) -->
                <div class="flex items-center gap-2">
                    <label class="text-[13px] text-gray-500 font-medium whitespace-nowrap m-0">Filter by status:</label>
                    <div class="w-[220px] relative" id="statusDropdownContainer">

                        <!-- Hidden original select to maintain compatibility with existing JS/backend -->
                        <select id="stone_status_filter" name="stone_status_filter[]" class="hidden" multiple>
                            <option value="all" selected>All</option>
                            <option value="4">Sold</option>
                            <option value="2">Deleted</option>
                            <option value="6">Transformed</option>
                            <option value="9">Merged</option>
                            <option value="16">In Jewelry</option>
                        </select>

                        <!-- Custom Dropdown Button -->
                        <button type="button" id="statusDropdownBtn" class="w-full flex items-center justify-between px-3 py-1.5 bg-[white] border border-[#cbd5e1] rounded-md focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-colors h-[36px]">
                            <span id="statusDropdownLabel" class="text-[13px] text-gray-800 font-medium truncate">All</span>
                            <svg class="w-4 h-4 text-gray-500 shrink-0 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </button>

                        <!-- Custom Dropdown Panel -->
                        <div id="statusDropdownPanel" class="absolute left-0 top-[100%] mt-1 w-[260px] bg-white border border-gray-200 rounded-md shadow-lg z-50 hidden max-h-[300px] flex-col overflow-hidden">
                            <!-- Search Bar -->
                            <div class="p-2 border-b border-gray-100 bg-gray-50 shrink-0">
                                <div class="relative">
                                    <svg class="w-4 h-4 text-gray-400 absolute left-2.5 top-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                    <input type="text" id="statusSearchInput" placeholder="Search status..." class="w-full pl-8 pr-3 py-1.5 text-[13px] border border-gray-300 rounded-md focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                                </div>
                            </div>

                            <ul class="py-1 overflow-y-auto flex-1 max-h-[200px]" id="statusOptionsList">
                                <li>
                                    <label class="flex items-center px-3 py-2 hover:bg-gray-50 cursor-pointer transition-colors group">
                                        <input type="checkbox" class="status-cb w-4 h-4 text-blue-600 border-gray-300 rounded-md focus:ring-blue-500 cursor-pointer" value="all" checked>
                                        <span class="ml-3 text-[13px] text-gray-700 group-hover:text-blue-700 option-text">All</span>
                                    </label>
                                </li>
                                <li>
                                    <label class="flex items-center px-3 py-2 hover:bg-gray-50 cursor-pointer transition-colors group">
                                        <input type="checkbox" class="status-cb w-4 h-4 text-blue-600 border-gray-300 rounded-md focus:ring-blue-500 cursor-pointer" value="4">
                                        <span class="ml-3 text-[13px] text-gray-700 group-hover:text-blue-700 option-text">Sold</span>
                                    </label>
                                </li>
                                <li>
                                    <label class="flex items-center px-3 py-2 hover:bg-gray-50 cursor-pointer transition-colors group">
                                        <input type="checkbox" class="status-cb w-4 h-4 text-blue-600 border-gray-300 rounded-md focus:ring-blue-500 cursor-pointer" value="2">
                                        <span class="ml-3 text-[13px] text-gray-700 group-hover:text-blue-700 option-text">Deleted</span>
                                    </label>
                                </li>
                                <li>
                                    <label class="flex items-center px-3 py-2 hover:bg-gray-50 cursor-pointer transition-colors group">
                                        <input type="checkbox" class="status-cb w-4 h-4 text-blue-600 border-gray-300 rounded-md focus:ring-blue-500 cursor-pointer" value="6">
                                        <span class="ml-3 text-[13px] text-gray-700 group-hover:text-blue-700 option-text">Transformed</span>
                                    </label>
                                </li>
                                <li>
                                    <label class="flex items-center px-3 py-2 hover:bg-gray-50 cursor-pointer transition-colors group">
                                        <input type="checkbox" class="status-cb w-4 h-4 text-blue-600 border-gray-300 rounded-md focus:ring-blue-500 cursor-pointer" value="9">
                                        <span class="ml-3 text-[13px] text-gray-700 group-hover:text-blue-700 option-text">Merged</span>
                                    </label>
                                </li>
                                <li>
                                    <label class="flex items-center px-3 py-2 hover:bg-gray-50 cursor-pointer transition-colors group">
                                        <input type="checkbox" class="status-cb w-4 h-4 text-blue-600 border-gray-300 rounded-md focus:ring-blue-500 cursor-pointer" value="16">
                                        <span class="ml-3 text-[13px] text-gray-700 group-hover:text-blue-700 option-text">In Jewelry</span>
                                    </label>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- From Date -->
                <div class="flex items-center gap-2">
                    <label class="text-[13px] text-gray-500 font-medium whitespace-nowrap m-0">From date:</label>
                    <div class="relative w-[180px] h-[36px] bg-white border border-gray-300 rounded-md flex items-center px-3 hover:border-gray-400 focus-within:border-blue-500 focus-within:ring-1 focus-within:ring-blue-500 transition-all overflow-hidden">
                        <!-- Native Date Picker overlaid invisibly -->
                        <input type="date" name="start_date_range" id="start_date_range" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-20" onclick="try { this.showPicker(); } catch(e) {}" onchange="document.getElementById('start_date_text').textContent = this.value || 'From Date'; if(this.value) { document.getElementById('start_date_text').classList.remove('text-gray-400'); document.getElementById('start_date_text').classList.add('text-gray-800', 'font-medium'); } else { document.getElementById('start_date_text').classList.add('text-gray-400'); document.getElementById('start_date_text').classList.remove('text-gray-800', 'font-medium'); }">

                        <!-- Visible Custom UI -->
                        <svg class="w-4 h-4 text-gray-400 shrink-0 z-10 relative pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        <span id="start_date_text" class="text-[13px] text-gray-400 px-2 w-full truncate z-10 relative pointer-events-none select-none">From Date</span>
                        <svg class="w-4 h-4 text-gray-400 shrink-0 z-10 relative pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </div>
                </div>

                <!-- To Date -->
                <div class="flex items-center gap-2">
                    <label class="text-[13px] text-gray-500 font-medium whitespace-nowrap m-0">To date:</label>
                    <div class="relative w-[180px] h-[36px] bg-white border border-gray-300 rounded-md flex items-center px-3 hover:border-gray-400 focus-within:border-blue-500 focus-within:ring-1 focus-within:ring-blue-500 transition-all overflow-hidden">
                        <!-- Native Date Picker overlaid invisibly -->
                        <input type="date" name="end_date_range" id="end_date_range" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-20" onclick="try { this.showPicker(); } catch(e) {}" onchange="document.getElementById('end_date_text').textContent = this.value || 'To Date'; if(this.value) { document.getElementById('end_date_text').classList.remove('text-gray-400'); document.getElementById('end_date_text').classList.add('text-gray-800', 'font-medium'); } else { document.getElementById('end_date_text').classList.add('text-gray-400'); document.getElementById('end_date_text').classList.remove('text-gray-800', 'font-medium'); }">

                        <!-- Visible Custom UI -->
                        <svg class="w-4 h-4 text-gray-400 shrink-0 z-10 relative pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        <span id="end_date_text" class="text-[13px] text-gray-400 px-2 w-full truncate z-10 relative pointer-events-none select-none">To Date</span>
                        <svg class="w-4 h-4 text-gray-400 shrink-0 z-10 relative pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center gap-3">
                <button class="px-4 py-[8px] text-[13px] font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-md transition-colors" id="reset_all_filter" type="button">
                    Clear filter
                </button>
                <button class="px-5 py-[8px] text-[13px] font-medium text-white bg-[#1d4ed8] hover:bg-blue-800 rounded-md shadow-sm transition-colors" id="update_filters_results">
                    Update results
                </button>
            </div>

        </div>
    </div>

    @if($archivedItems->isEmpty())
    <!-- Empty State -->
    <div id="noData" class="w-full flex flex-col items-center justify-center pt-16 pb-24 relative z-10 bg-white rounded-md border border-gray-100 mt-4">
        <div class="mb-6 bg-gray-50 p-6 rounded-full">
            <svg class="w-16 h-16 text-gray-300" width="64" height="64" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
            </svg>
        </div>
        <h2 class="text-[20px] font-bold text-gray-900 mb-[8px]">No archived products</h2>
        <p class="text-[14px] text-gray-500 mb-[32px] text-center max-w-[450px] leading-relaxed">
            No archived products found. When items are archived, they will appear here. You can filter by status or date above to refine your results.
        </p>
        <div class="flex items-center gap-4">
            <a href="javascript:void(0)" onclick="history.back()" class="inline-flex items-center px-6 py-[10px] border border-[#cbd5e1] text-[#334155] bg-white rounded-md hover:bg-gray-50 transition-all font-semibold text-[13px] no-underline shadow-sm active:scale-95">
                Return to inventory
            </a>
            <a href="/gemstone/show" class="inline-flex items-center px-6 py-[10px] bg-[#2563eb] text-white rounded-md hover:bg-blue-700 transition-all font-semibold text-[13px] no-underline shadow-sm active:scale-95">
                View all inventory
            </a>
        </div>
    </div>
    @else
    <!-- Table Container -->
    <div id="table-container" class="w-full relative z-10">
        <div class="bg-white rounded-md shadow-sm border border-gray-200 overflow-x-auto w-full">
            <table id="archived-table" class="min-w-full text-left text-sm whitespace-nowrap w-full">
                <thead>
                    <tr class="bg-[#f8fafc] text-gray-600 text-xs font-bold border-b border-gray-200">
                        <th class="px-4 py-3 w-10"><input type="checkbox" id="cb-select-all" class="rounded-md border-gray-300"></th>
                        <th class="px-4 py-3">Item #</th>
                        <th class="px-4 py-3">Image</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3">Category</th>
                        <th class="px-4 py-3">Date</th>
                        <th class="px-4 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
    @endif

</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {

    /* Select All Checkbox Logic */
    const cbSelectAll = document.getElementById('cb-select-all');

    if (cbSelectAll) {
        cbSelectAll.addEventListener('change', (e) => {
            const rowCheckboxes = document.querySelectorAll('tbody input[type="checkbox"]');
            rowCheckboxes.forEach(cb => {
                cb.checked = e.target.checked;
            });
        });
    }

    /* Create New Item Dropdown */
    const createBtn = document.getElementById('noDataCreateDropdown');

    if (createBtn) {
        createBtn.addEventListener('click', function (e) {
            e.preventDefault();
            e.stopPropagation();

            const menu = this.nextElementSibling;
            if (menu && menu.classList.contains('dropdown-menu')) {
                menu.classList.toggle('hidden');
            }
        });
    }

    /* Status Filter Dropdown (Multi Select) */
    const statusBtn = document.getElementById('statusDropdownBtn');
    const statusPanel = document.getElementById('statusDropdownPanel');
    const statusLabel = document.getElementById('statusDropdownLabel');
    const hiddenSelect = document.getElementById('stone_status_filter');
    const checkboxes = document.querySelectorAll('.status-cb');
    const searchInput = document.getElementById('statusSearchInput');

    if (statusBtn && statusPanel) {

        // Toggle panel
        statusBtn.addEventListener('click', function (e) {
            e.preventDefault();
            e.stopPropagation();
            statusPanel.classList.toggle('hidden');
        });

        function updateSelection() {
            let selectedValues = [];
            let selectedTexts = [];
            let hasAll = false;

            checkboxes.forEach(cb => {
                if (cb.checked) {
                    let val = cb.value;
                    let txt = cb.nextElementSibling?.textContent.trim() || '';

                    if (val === 'all') hasAll = true;

                    selectedValues.push(val);
                    selectedTexts.push(txt);
                }
            });

            // update hidden select
            if (hiddenSelect) {
                Array.from(hiddenSelect.options).forEach(opt => {
                    opt.selected = selectedValues.includes(opt.value);
                });

                hiddenSelect.dispatchEvent(new Event('change', { bubbles: true }));
            }

            // update label
            if (statusLabel) {
                if (selectedValues.length === 0) {
                    statusLabel.textContent = 'None selected';
                } else if (hasAll && selectedValues.length === 1) {
                    statusLabel.textContent = 'All';
                } else if (hasAll) {
                    statusLabel.textContent = 'All + ' + (selectedValues.length - 1);
                } else if (selectedValues.length <= 2) {
                    statusLabel.textContent = selectedTexts.join(', ');
                } else {
                    statusLabel.textContent = selectedValues.length + ' selected';
                }
            }
        }

        // checkbox logic
        checkboxes.forEach(cb => {
            cb.addEventListener('change', function () {
                let val = this.value;

                if (val === 'all' && this.checked) {
                    checkboxes.forEach(c => { if (c !== this) c.checked = false; });
                } else if (val !== 'all' && this.checked) {
                    checkboxes.forEach(c => { if (c.value === 'all') c.checked = false; });
                }

                updateSelection();
            });
        });

        // search inside dropdown
        if (searchInput) {
            searchInput.addEventListener('keyup', function () {
                let term = this.value.toLowerCase();

                document.querySelectorAll('#statusOptionsList li').forEach(li => {
                    let text = li.querySelector('.option-text')?.textContent.toLowerCase();

                    if (!text || text.indexOf(term) === -1) {
                        li.style.display = 'none';
                    } else {
                        li.style.display = '';
                    }
                });
            });
        }

        updateSelection();
    }

    /* Filter Buttons (Clear + Update) */
    const btnReset = document.getElementById('reset_all_filter');
    const btnApply = document.getElementById('update_filters_results');

    if (btnReset) {
        btnReset.addEventListener('click', () => {
            // reset inputs
            document.querySelectorAll('input, select').forEach(el => {
                if (el.type === 'checkbox') {
                    el.checked = false;
                } else {
                    el.value = '';
                }
            });

            location.reload(); // simple reset
        });
    }

    if (btnApply) {
        btnApply.addEventListener('click', () => {
            const original = btnApply.innerHTML;
            btnApply.innerHTML = 'Updating...';

            setTimeout(() => {
                btnApply.innerHTML = original;
            }, 800);
        });
    }

    /* Close dropdowns when clicking outside */
    document.addEventListener('click', function (e) {

        if (!e.target.closest('.dashboard-add-dropdown')) {
            document.querySelectorAll('.dropdown-menu').forEach(menu => {
                menu.classList.add('hidden');
            });
        }

        if (!e.target.closest('#statusDropdownContainer')) {
            if (statusPanel) statusPanel.classList.add('hidden');
        }
    });

});
</script>
@endsection
