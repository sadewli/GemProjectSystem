@extends('layouts.app')

@section('title', 'Stone Detail - CPG9')

@section('style')
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* My Inventory - Show Page Styles */

        /* Card custom styling */
        .card {
            background-color: #ffffff !important;
            border-radius: 12px !important;
            border: 1px solid #e2e8f0 !important;
            padding: 24px !important;
            margin-bottom: 24px !important;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.05), 0 1px 2px 0 rgba(0, 0, 0, 0.03) !important;
        }

        .card-title {
            font-size: 16px !important;
            font-weight: 700 !important;
            color: #1e293b !important;
            margin-top: 0 !important;
            margin-bottom: 20px !important;
            letter-spacing: -0.01em !important;
        }

        /* Form controls and group */
        .form-group {
            display: flex !important;
            flex-direction: column !important;
            gap: 4px !important;
        }

        .form-group label {
            font-size: 13px !important;
            font-weight: 600 !important;
            color: #334155 !important;
            margin-bottom: 0px !important;
        }

        .form-group .sub-label {
            font-size: 11px !important;
            color: #64748b !important;
            margin-bottom: 6px !important;
            line-height: 1.3 !important;
        }

        .form-control {
            height: 42px !important;
            border-radius: 8px !important;
            border: 1px solid #cbd5e1 !important;
            font-size: 13px !important;
            font-weight: 400 !important;
            color: #334155 !important;
            background-color: #ffffff !important;
            transition: all 0.2s ease-in-out !important;
            width: 100% !important;
        }

        .form-control:focus {
            border-color: #3b82f6 !important;
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.08) !important;
            outline: none !important;
        }

        /* Custom Select Dropdowns */
        .custom-select-wrapper {
            position: relative !important;
        }

        .custom-dropdown-panel {
            display: none !important;
            position: absolute !important;
            top: calc(100% + 4px) !important;
            left: 0 !important;
            right: 0 !important;
            background-color: #ffffff !important;
            border: 1px solid #e2e8f0 !important;
            border-radius: 8px !important;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -4px rgba(0, 0, 0, 0.1) !important;
            z-index: 9999 !important;
            max-height: 200px !important;
            overflow-y: auto !important;
        }

        /* Custom Scrollbar for dropdowns */
        .custom-dropdown-panel::-webkit-scrollbar {
            width: 5px !important;
        }

        .custom-dropdown-panel::-webkit-scrollbar-track {
            background: #f1f5f9 !important;
        }

        .custom-dropdown-panel::-webkit-scrollbar-thumb {
            background: #cbd5e1 !important;
            border-radius: 3px !important;
        }

        .custom-select-wrapper.open .custom-dropdown-panel {
            display: block !important;
        }

        .dd-item {
            padding: 8px 12px !important;
            font-size: 13px !important;
            color: #334155 !important;
            cursor: pointer !important;
            transition: background-color 0.15s ease !important;
        }

        .dd-item:hover {
            background-color: #f1f5f9 !important;
        }

        .dd-item.selected {
            background-color: #eff6ff !important;
            color: #2563eb !important;
            font-weight: 500 !important;
        }

        /* Tab contents hidden by default */
        .tab-content {
            display: none !important;
        }

        .tab-content.active {
            display: flex !important;
        }
    </style>
@endsection

@section('content')
    <div class="p-6 bg-[#f8fafc] min-h-screen font-sans">
        <form id="productForm" method="POST" action="{{ route('inventory.myinventory.store') }}">
            @csrf
            @if(request()->has('production_sheet_id'))
                <input type="hidden" name="production_sheet_id" value="{{ (int) request('production_sheet_id') }}">
            @endif

        {{-- Top Header --}}
        <div class="bg-white rounded-xl border border-slate-200 p-4 mb-6 flex justify-between items-center shadow-sm">
            <div class="flex items-center gap-4">
                <a href="{{ route('inventory.myinventory.index') }}"
                    class="w-9 h-9 flex items-center justify-center rounded-full bg-slate-50 border border-slate-200 hover:bg-slate-100 text-slate-400 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                </a>
                <div>
                    <h1 class="text-[17px] font-bold text-blue-700 leading-none mb-1">CPG9</h1>
                    <div class="text-[11px] font-semibold text-amber-500">Draft</div>
                </div>
            </div>
            <button type="submit"
                class="bg-[#2563eb] hover:bg-blue-700 text-white px-5 py-2 rounded-lg text-[13px] font-medium flex items-center gap-2 transition-colors shadow-sm">
                Save
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M5 13l4 4L19 7" />
                </svg>
            </button>
        </div>

        {{-- Tabs Navigation --}}
        <div class="bg-white rounded-xl border border-slate-200 px-2 flex gap-8 mb-6 shadow-sm overflow-x-auto">
            <a href="#overview" data-target="tab-overview"
                class="tab-link active border-b-[3px] border-[#2563eb] text-[#2563eb] font-bold py-3.5 px-4 text-[13px] flex items-center gap-2 whitespace-nowrap">
                Overview
            </a>
            <a href="#advance" data-target="tab-advance"
                class="tab-link border-b-[3px] border-transparent text-slate-500 hover:text-slate-700 font-semibold py-3.5 px-4 text-[13px] flex items-center gap-2 whitespace-nowrap">
                Advance Details
            </a>
            <a href="#media" data-target="tab-media"
                class="tab-link border-b-[3px] border-transparent text-slate-500 hover:text-slate-700 font-semibold py-3.5 px-4 text-[13px] flex items-center gap-2 whitespace-nowrap">
                Media & Docs
            </a>
            <a href="#memo" data-target="tab-memo"
                class="tab-link border-b-[3px] border-transparent text-slate-500 hover:text-slate-700 font-semibold py-3.5 px-4 text-[13px] flex items-center gap-2 whitespace-nowrap">
                Memo & Purchases
            </a>
            <a href="#history" data-target="tab-history"
                class="tab-link border-b-[3px] border-transparent text-slate-500 hover:text-slate-700 font-semibold py-3.5 px-4 text-[13px] flex items-center gap-2 whitespace-nowrap">
                History
            </a>
        </div>

        <div class="flex flex-col lg:flex-row gap-6 items-start">

            {{-- ================= LEFT COLUMN ================= --}}
            <div class="flex-1 w-full flex flex-col gap-6">
                @include('inventory.myinventory.fullpage.fullpage.partials._overview')
                @include('inventory.myinventory.fullpage.fullpage.partials._advance')
                @include('inventory.myinventory.fullpage.fullpage.partials._media')
                @include('inventory.myinventory.fullpage.fullpage.partials._memo')
                @include('inventory.myinventory.fullpage.fullpage.partials._history')
            </div>

            {{-- ================= RIGHT COLUMN (Sidebar) ================= --}}
            @include('inventory.myinventory.fullpage.fullpage.partials._sidebar')

        </div>
        </div>
        </form>

        {{-- Create New Value Modal --}}
        <div id="createNewModal" class="fixed inset-0 z-[10000] hidden items-center justify-center bg-black/50 backdrop-blur-sm">
            <div class="bg-white rounded-xl shadow-xl w-full max-w-md mx-4 overflow-hidden">
                <div class="flex justify-between items-center p-4 border-b border-slate-100">
                    <h3 class="text-lg font-bold text-slate-800">Create new value</h3>
                    <button type="button" id="closeCreateModal" class="text-slate-400 hover:text-slate-600 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                <div class="p-4">
                    <input type="hidden" id="createNewTable" value="">
                    <input type="text" id="newValueInput" placeholder="Enter Value" class="form-control w-full px-3 py-2 border border-slate-300 rounded-lg focus:outline-none focus:border-blue-500">
                </div>
                <div class="p-4 flex justify-end">
                    <button type="button" id="submitNewValue" class="bg-[#2563eb] hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-[13px] font-medium flex items-center gap-2 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Create new
                    </button>
                </div>
            </div>
        </div>

    </div>
@endsection

@section('script')
    <script>// My Inventory - Show Page Scripts

        document.addEventListener('DOMContentLoaded', function () {
            const productForm = document.getElementById('productForm');
            if (productForm) {
                productForm.addEventListener('submit', function (e) {
                    // Check for essential data (Weight or Quantity)
                    const weight = document.getElementById('input-weight');
                    const quantity = document.getElementById('input-quantity');
                    
                    let hasData = false;
                    if ((weight && weight.value.trim() !== '') || (quantity && quantity.value.trim() !== '')) {
                        hasData = true;
                    }
                    
                    if (!hasData) {
                        e.preventDefault();
                        Swal.fire({
                            icon: 'warning',
                            title: 'Action Required',
                            text: 'Please enter the required data first.',
                            confirmButtonColor: '#2563eb'
                        });
                    }
                });
            }

            // === TABS FUNCTIONALITY ===
            const tabLinks = document.querySelectorAll('.tab-link');
            const tabContents = document.querySelectorAll('.tab-content');

            tabLinks.forEach(link => {
                link.addEventListener('click', function (e) {
                    e.preventDefault();

                    // Get target tab content ID
                    const targetId = this.getAttribute('data-target');
                    if (!targetId) return;

                    // Remove active state from all links
                    tabLinks.forEach(l => {
                        l.classList.remove('active');
                        l.classList.remove('border-[#2563eb]', 'text-[#2563eb]', 'font-bold');
                        l.classList.add('border-transparent', 'text-slate-500', 'hover:text-slate-700', 'font-semibold');
                    });

                    // Add active state to clicked link
                    this.classList.add('active');
                    this.classList.remove('border-transparent', 'text-slate-500', 'hover:text-slate-700', 'font-semibold');
                    this.classList.add('border-[#2563eb]', 'text-[#2563eb]', 'font-bold');

                    // Hide all tab contents
                    tabContents.forEach(content => {
                        content.classList.remove('active');
                    });

                    // Show active tab content
                    const targetContent = document.getElementById(targetId);
                    if (targetContent) {
                        targetContent.classList.add('active');
                    }
                    
                    // Show/hide Pricing module based on tab
                    const pricingModule = document.getElementById('pricing-module');
                    if (pricingModule) {
                        if (targetId === 'tab-history') {
                            pricingModule.style.display = 'none';
                        } else {
                            pricingModule.style.display = 'block';
                        }
                    }
                });
            });

            // === CUSTOM DROPDOWN SELECTS ===
            const dropdownWrappers = document.querySelectorAll('.custom-select-wrapper');

            dropdownWrappers.forEach(wrapper => {
                const button = wrapper.querySelector('button');
                const items = wrapper.querySelectorAll('.dd-item');
                const selectedTextSpan = wrapper.querySelector('.selected-text');

                if (button) {
                    button.addEventListener('click', function (e) {
                        e.stopPropagation();

                        // Close other open dropdowns
                        dropdownWrappers.forEach(w => {
                            if (w !== wrapper) {
                                w.classList.remove('open');
                            }
                        });

                        // Toggle current dropdown
                        wrapper.classList.toggle('open');
                    });
                }

                items.forEach(item => {
                    item.addEventListener('click', function (e) {
                        e.stopPropagation();

                        const val = this.innerText || this.textContent;

                        // Update selected text span
                        if (selectedTextSpan) {
                            selectedTextSpan.innerText = val;
                            selectedTextSpan.classList.remove('text-slate-400');
                            selectedTextSpan.classList.add('text-slate-800');
                        }

                        // Update hidden input if it exists
                        const hiddenInput = wrapper.querySelector('input[type="hidden"]');
                        if (hiddenInput) {
                            hiddenInput.value = this.getAttribute('data-value') || '';
                        }

                        // Mark selected item
                        items.forEach(i => i.classList.remove('selected'));
                        this.classList.add('selected');

                        // Close dropdown
                        wrapper.classList.remove('open');
                    });
                });
            });

            // Close dropdowns when clicking outside
            document.addEventListener('click', function () {
                dropdownWrappers.forEach(wrapper => {
                    wrapper.classList.remove('open');
                });
            });

            // Fetch SKU for fullpage
            const productTypeInput = document.querySelector('input[name="idtbl_product_types"]');
            if (productTypeInput && productTypeInput.value) {
                const productTypeId = productTypeInput.value;
                fetch(`/Inventory/MyInventory/next-sku/${productTypeId}`)
                    .then(res => res.json())
                    .then(data => {
                        if (data.prefix_name && data.sku_code) {
                            const prefixSpan = document.querySelector('#skuPrefixTextFullpage');
                            const skuInput = document.querySelector('#skuNumberInputFullpage');
                            const hiddenPrefix = document.querySelector('#hiddenPrefixIdFullpage');
                            const prefixBtn = document.querySelector('#prefixDropdownBtnFullpage');
                            
                            if (prefixSpan) prefixSpan.innerText = data.prefix_name;
                            if (hiddenPrefix) hiddenPrefix.value = data.idtbl_skus;
                            if (skuInput) {
                                skuInput.value = data.sku_code;
                                skuInput.setAttribute('readonly', 'true');
                                skuInput.classList.add('bg-slate-50/50', 'text-slate-500');
                            }
                            if (prefixBtn) {
                                prefixBtn.disabled = true;
                                prefixBtn.classList.add('bg-slate-50/50');
                            }
                        }
                    })
                    .catch(err => console.error("Error fetching SKU:", err));
            }
            // === CREATE NEW VALUE MODAL ===
            const createNewModal = document.getElementById('createNewModal');
            const closeCreateModalBtn = document.getElementById('closeCreateModal');
            const submitNewValueBtn = document.getElementById('submitNewValue');
            const createNewTableInput = document.getElementById('createNewTable');
            const newValueInput = document.getElementById('newValueInput');
            let currentDropdownPanel = null;
            let currentWrapper = null;
            
            // Open modal when + Create New is clicked
            document.querySelectorAll('.create-new-btn').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    const tableName = this.getAttribute('data-table');
                    if(tableName) {
                        createNewTableInput.value = tableName;
                        newValueInput.value = '';
                        createNewModal.classList.remove('hidden');
                        createNewModal.classList.add('flex');
                        currentDropdownPanel = this.closest('.custom-dropdown-panel');
                        currentWrapper = this.closest('.custom-select-wrapper');
                        
                        // Close the dropdown so it doesn't stay open
                        if (currentWrapper) currentWrapper.classList.remove('open');
                        
                        setTimeout(() => newValueInput.focus(), 100);
                    }
                });
            });

            // Close modal
            function closeCreateModal() {
                createNewModal.classList.add('hidden');
                createNewModal.classList.remove('flex');
                currentDropdownPanel = null;
                currentWrapper = null;
            }

            closeCreateModalBtn.addEventListener('click', closeCreateModal);
            
            // Close on click outside
            createNewModal.addEventListener('click', function(e) {
                if (e.target === createNewModal) {
                    closeCreateModal();
                }
            });

            // Handle Submit
            submitNewValueBtn.addEventListener('click', function() {
                const table = createNewTableInput.value;
                const value = newValueInput.value.trim();
                
                if (!value) {
                    Swal.fire({icon: 'warning', title: 'Action Required', text: 'Please enter a value.'});
                    return;
                }
                
                // Show loading state
                const originalBtnHtml = submitNewValueBtn.innerHTML;
                submitNewValueBtn.innerHTML = '<svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Saving...';
                submitNewValueBtn.disabled = true;

                fetch('{{ route("inventory.createDropdownValue") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ table_name: table, value: value })
                })
                .then(response => response.json())
                .then(data => {
                    submitNewValueBtn.innerHTML = originalBtnHtml;
                    submitNewValueBtn.disabled = false;
                    
                    if (data.success) {
                        // Successfully created
                        closeCreateModal();
                        
                        // Append new item to the dropdown panel
                        if (currentDropdownPanel && currentWrapper) {
                            const newItem = document.createElement('div');
                            newItem.className = 'p-2 hover:bg-slate-50 cursor-pointer text-[13px] px-3 dd-item selected';
                            newItem.setAttribute('data-value', data.id);
                            newItem.innerText = data.value;
                            
                            // Insert before the create button container (which is the last element)
                            const createBtnContainer = currentDropdownPanel.querySelector('.border-t');
                            currentDropdownPanel.insertBefore(newItem, createBtnContainer);
                            
                            // Update selection
                            const selectedTextSpan = currentWrapper.querySelector('.selected-text');
                            if (selectedTextSpan) {
                                selectedTextSpan.innerText = data.value;
                                selectedTextSpan.classList.remove('text-slate-400');
                                selectedTextSpan.classList.add('text-slate-800');
                            }
                            
                            const hiddenInput = currentWrapper.querySelector('input[type="hidden"]');
                            if (hiddenInput) {
                                hiddenInput.value = data.id;
                            }
                            
                            // Update existing items to remove selected class
                            currentDropdownPanel.querySelectorAll('.dd-item').forEach(i => i.classList.remove('selected'));
                            newItem.classList.add('selected');
                            
                            // Re-bind click event for the new item
                            newItem.addEventListener('click', function(e) {
                                e.stopPropagation();
                                if (selectedTextSpan) {
                                    selectedTextSpan.innerText = this.innerText || this.textContent;
                                    selectedTextSpan.classList.remove('text-slate-400');
                                    selectedTextSpan.classList.add('text-slate-800');
                                }
                                if (hiddenInput) {
                                    hiddenInput.value = this.getAttribute('data-value') || '';
                                }
                                currentDropdownPanel.querySelectorAll('.dd-item').forEach(i => i.classList.remove('selected'));
                                this.classList.add('selected');
                                currentWrapper.classList.remove('open');
                            });
                        }
                    } else {
                        Swal.fire({icon: 'error', title: 'Error', text: data.message || 'Failed to create value.'});
                    }
                })
                .catch(err => {
                    console.error(err);
                    submitNewValueBtn.innerHTML = originalBtnHtml;
                    submitNewValueBtn.disabled = false;
                    Swal.fire({icon: 'error', title: 'Error', text: 'Something went wrong.'});
                });
            });
        });
    </script>
@endsection