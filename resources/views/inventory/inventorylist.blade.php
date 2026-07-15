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
            <div class="flex gap-3">
                <a href="{{ route('inventory.lotsplit.index') }}" class="px-5 py-2.5 bg-indigo-600 text-white rounded-lg font-medium hover:bg-indigo-700 transition-colors shadow-sm flex items-center gap-2">
                    <i class="fa-solid fa-scissors"></i> Lot Split
                </a>
                <a href="{{ route('inventory.myinventory.create') }}" class="px-5 py-2.5 bg-blue-600 text-white rounded-lg font-medium hover:bg-blue-700 transition-colors shadow-sm flex items-center gap-2">
                    <i class="fa-solid fa-plus"></i> Add New
                </a>
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
                            <th class="px-4 py-3 font-bold">SKU</th>
                            <th class="px-4 py-3 font-bold">Type</th>
                            <th class="px-4 py-3 font-bold">Variety</th>
                            <th class="px-4 py-3 font-bold">Shape</th>
                            <th class="px-4 py-3 font-bold">Color</th>
                            <th class="px-4 py-3 font-bold">Weight</th>
                            <th class="px-4 py-3 font-bold">Quantity</th>
                            <th class="px-4 py-3 font-bold">Cost</th>
                            <th class="px-4 py-3 font-bold">Wholesale Price</th>
                            <th class="px-4 py-3 font-bold">Retail Price</th>
                            <th class="px-4 py-3 font-bold">Supplier</th>
                            <th class="px-4 py-3 font-bold">Purchase Date</th>
                            <th class="px-4 py-3 font-bold">Save Status</th>
                            <th class="px-4 py-3 font-bold text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm">
                        @forelse($products ?? [] as $product)
                            <tr class="border-b border-slate-100 hover:bg-slate-50 transition-colors">
                                <td class="px-4 py-3">
                                    <input type="checkbox"
                                        class="w-3.5 h-3.5 rounded-md border-slate-300 text-blue-600 focus:ring-blue-500 bg-white align-middle">
                                </td>
                                <td class="px-4 py-3 font-medium text-blue-600">{{ $product->sku_number }}</td>
                                <td class="px-4 py-3">{{ $product->type_name ?? '-' }}</td>
                                <td class="px-4 py-3">{{ $product->variety_name ?? '-' }}</td>
                                <td class="px-4 py-3">{{ $product->shape_name ?? '-' }}</td>
                                <td class="px-4 py-3">{{ $product->color_name ?? '-' }}</td>
                                <td class="px-4 py-3">{{ $product->weight }} {{ $product->weight_unit }}</td>
                                <td class="px-4 py-3">{{ $product->pricing_quantity ?? '-' }}</td>
                                <td class="px-4 py-3">{{ $product->cost_per_unit ?? '-' }}</td>
                                <td class="px-4 py-3">{{ $product->wholesale_price_per_unit ?? '-' }}</td>
                                <td class="px-4 py-3">{{ $product->retail_price_per_unit ?? '-' }}</td>
                                <td class="px-4 py-3">{{ $product->supplier_name ?? '-' }}</td>
                                <td class="px-4 py-3">{{ $product->date_of_purchase ?? '-' }}</td>
                                <td class="px-4 py-3">
                                    @if(($product->inventerysavestatus ?? null) == '01' || ($product->inventerysavestatus ?? null) == '1')
                                        <span class="px-2 py-1 bg-blue-50 text-blue-600 rounded text-xs font-medium border border-blue-200">Quick View</span>
                                    @elseif(($product->inventerysavestatus ?? null) == '2')
                                        <span class="px-2 py-1 bg-purple-50 text-purple-600 rounded text-xs font-medium border border-purple-200">Overview</span>
                                    @else
                                        {{ $product->inventerysavestatus ?? '-' }}
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <button type="button" class="text-blue-500 hover:text-blue-700 view-product-btn" title="View" data-product="{{ json_encode($product) }}">
                                            <i class="fa-solid fa-eye"></i>
                                        </button>
                                        @if(($product->inventerysavestatus ?? null) == '01' || ($product->inventerysavestatus ?? null) == '1')
                                            <a href="{{ url('Inventory/MyInventory') }}?edit_id={{ $product->idtbl_products }}" class="text-amber-500 hover:text-amber-700" title="Edit">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </a>
                                        @else
                                            <a href="{{ url('Inventory/MyInventory/' . $product->idtbl_products) }}" class="text-amber-500 hover:text-amber-700" title="Edit">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </a>
                                        @endif
                                        <button type="button" class="text-red-500 hover:text-red-700" title="Delete" onclick="if(confirm('Are you sure you want to delete this item?')) { document.getElementById('delete-form-{{ $product->idtbl_products }}').submit(); }">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                        <form id="delete-form-{{ $product->idtbl_products }}" action="{{ url('Inventory/MyInventory/' . $product->idtbl_products) }}" method="POST" style="display: none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="14" class="px-4 py-8 text-center text-slate-500">No inventory data found.</td>
                            </tr>
                        @endforelse
                    </tbody>
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

    <!-- View Product Modal -->
    <div id="viewProductModal" class="fixed inset-0 z-[100] hidden bg-slate-900/50 backdrop-blur-sm overflow-y-auto p-4 flex items-center justify-center">
        <div class="relative w-full max-w-4xl mx-auto transition-all transform scale-95 opacity-0 duration-200" id="modalDialog">
            <div class="bg-white rounded-xl shadow-2xl border border-slate-200 overflow-hidden flex flex-col max-h-[90vh]">
                <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100 bg-slate-50/50 shrink-0">
                    <h3 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                        <i class="fa-solid fa-box-open text-blue-600"></i> Product Details
                    </h3>
                    <button type="button" class="text-slate-400 hover:text-red-500 hover:bg-red-50 rounded-lg p-2 transition-colors close-modal-btn">
                        <i class="fa-solid fa-xmark text-lg"></i>
                    </button>
                </div>
                <div id="modalContent" class="flex flex-col min-h-0 overflow-hidden">
                    <!-- Content will be injected here -->
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

            // View Product Modal Logic
            const modal = document.getElementById('viewProductModal');
            const modalDialog = document.getElementById('modalDialog');
            const modalContent = document.getElementById('modalContent');
            const closeBtns = document.querySelectorAll('.close-modal-btn');
            
            function openModal() {
                modal.classList.remove('hidden');
                modal.classList.add('flex');
                setTimeout(() => {
                    modalDialog.classList.remove('scale-95', 'opacity-0');
                    modalDialog.classList.add('scale-100', 'opacity-100');
                }, 10);
            }

            function closeModal() {
                modalDialog.classList.remove('scale-100', 'opacity-100');
                modalDialog.classList.add('scale-95', 'opacity-0');
                setTimeout(() => {
                    modal.classList.add('hidden');
                    modal.classList.remove('flex');
                }, 200);
            }

            document.querySelectorAll('.view-product-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const product = JSON.parse(this.getAttribute('data-product') || '{}');
                    
                    const formatLabel = (label) => `<span class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">${label}</span>`;
                    const formatValue = (val) => `<span class="block text-sm text-slate-800 font-medium">${val !== null && val !== undefined && val !== '' ? val : '-'}</span>`;
                    
                    let allDetails = [];
                    for (const [key, value] of Object.entries(product)) {
                        const formattedLabel = key.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase());
                        let displayValue = value;
                        
                        if (typeof value === 'object' && value !== null) {
                            displayValue = JSON.stringify(value);
                        } else if (typeof value === 'string' && value.trim() !== '') {
                            const isImage = value.match(/\.(jpeg|jpg|gif|png|svg|webp)$/i) || 
                                            key.toLowerCase().includes('photo') || 
                                            key.toLowerCase().includes('image');
                                            
                            if (isImage && value.length > 3) {
                                let src = value;
                                if (!src.startsWith('http') && !src.startsWith('/')) {
                                    src = '/' + src; 
                                }
                                displayValue = `<div class="mt-1"><img src="${src}" class="max-w-[120px] max-h-[120px] object-contain rounded-md border border-slate-200 shadow-sm bg-slate-50" alt="${formattedLabel}" onerror="this.outerHTML='<span class=\\'text-xs text-slate-400\\'>[Image cannot be loaded: ${value}]</span>'"></div>`;
                            }
                        }
                        
                        allDetails.push({ label: formattedLabel, value: displayValue });
                    }
                    
                    let itemsPerPage = 12; // 6 rows x 2 columns
                    let totalPages = Math.ceil(allDetails.length / itemsPerPage);
                    if (totalPages === 0) totalPages = 1;
                    
                    let pagesHTML = '<div class="overflow-y-auto p-6 bg-white flex-1 min-h-[300px]">';
                    for(let i=0; i<totalPages; i++) {
                        let pageItems = allDetails.slice(i * itemsPerPage, (i + 1) * itemsPerPage);
                        pagesHTML += `<div class="data-page ${i === 0 ? '' : 'hidden'} grid grid-cols-1 sm:grid-cols-2 gap-y-6 gap-x-8">`;
                        pageItems.forEach(item => {
                            pagesHTML += `<div>${formatLabel(item.label)}${formatValue(item.value)}</div>`;
                        });
                        pagesHTML += `</div>`;
                    }
                    pagesHTML += '</div>';
                    
                    let paginationHTML = `
                        <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/50 flex justify-between items-center shrink-0">
                            <span class="text-sm font-bold text-slate-500" id="pageIndicator">Page 1 of ${totalPages}</span>
                            <div class="flex items-center gap-3">
                                <button type="button" id="prevPageBtn" class="px-4 py-2 bg-white border border-slate-300 hover:bg-slate-50 text-slate-700 text-sm font-semibold rounded-lg shadow-sm transition-colors disabled:opacity-50 disabled:cursor-not-allowed">Previous</button>
                                <button type="button" id="nextPageBtn" class="px-4 py-2 bg-blue-600 border border-transparent hover:bg-blue-700 text-white text-sm font-semibold rounded-lg shadow-sm transition-colors disabled:opacity-50 disabled:cursor-not-allowed">Next</button>
                                <button type="button" class="ml-2 px-4 py-2 bg-slate-200 border border-transparent hover:bg-slate-300 text-slate-800 text-sm font-semibold rounded-lg shadow-sm transition-colors close-modal-btn-dynamic">Close</button>
                            </div>
                        </div>
                    `;
                    
                    modalContent.innerHTML = pagesHTML + paginationHTML;
                    
                    // Re-bind close button logic to the newly injected close button
                    modalContent.querySelector('.close-modal-btn-dynamic').addEventListener('click', closeModal);
                    
                    let currentPage = 0;
                    const prevBtn = document.getElementById('prevPageBtn');
                    const nextBtn = document.getElementById('nextPageBtn');
                    const pageInd = document.getElementById('pageIndicator');
                    const pages = modalContent.querySelectorAll('.data-page');
                    
                    function updatePagination() {
                        pages.forEach((p, index) => {
                            if(index === currentPage) p.classList.remove('hidden');
                            else p.classList.add('hidden');
                        });
                        prevBtn.disabled = currentPage === 0;
                        nextBtn.disabled = currentPage >= totalPages - 1;
                        pageInd.textContent = 'Page ' + (currentPage + 1) + ' of ' + totalPages;
                    }
                    
                    if (prevBtn) {
                        prevBtn.addEventListener('click', () => {
                            if (currentPage > 0) {
                                currentPage--;
                                updatePagination();
                            }
                        });
                    }
                    if (nextBtn) {
                        nextBtn.addEventListener('click', () => {
                            if (currentPage < totalPages - 1) {
                                currentPage++;
                                updatePagination();
                            }
                        });
                    }
                    updatePagination();
                    openModal();
                });
            });

            closeBtns.forEach(btn => {
                btn.addEventListener('click', closeModal);
            });

            modal.addEventListener('click', function(e) {
                if (e.target === modal) {
                    closeModal();
                }
            });
        });
    </script>
@endsection