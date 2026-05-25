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
            <button type="button"
                class="bg-[#2563eb] hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-[13px] font-medium flex items-center gap-2 transition-colors">
                Save and add new
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
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
@endsection

@section('script')
    <script>// My Inventory - Show Page Scripts

        document.addEventListener('DOMContentLoaded', function () {
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
        });
    </script>
@endsection