@extends('layouts.app')

@section('title', 'My Inventory - ShapeUP')

@section('content')
<!-- Tailwind CSS for this page -->
<script src="https://cdn.tailwindcss.com"></script>

<style>
    .tab-btn { transition: all 0.2s; border-bottom: 2px solid transparent; }
    .tab-btn.active { color: #2563eb !important; border-bottom-color: #2563eb !important; }
    .tab-content { display: none; }
    .tab-content.active, .tab-content.block { display: block !important; }

    /* Custom scrollbar for modal body */
    .custom-scrollbar::-webkit-scrollbar { width: 6px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: #f1f5f9; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 3px; }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #94a3b8; }

    .section-header {
        font-size: 14px;
        font-weight: 700;
        color: #1e293b;
        margin-top: 24px;
        margin-bottom: 16px;
        text-transform: uppercase;
        letter-spacing: 0.025em;
    }

    .form-control {
        height: 42px;
        border-radius: 6px !important;
        border: 1px solid #e2e8f0 !important;
        font-size: 14px !important;
        transition: all 0.2s !important;
    }

    .form-control:focus {
        border-color: #3b82f6 !important;
        box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1) !important;
    }
</style>

<div class="container-fluid mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">My Inventory</h1>
        <div class="relative inline-block" id="createBtnWrapper">
            <button type="button" id="openGemstoneModalBtn" class="btn btn-primary flex items-center gap-2">
                <i class="fas fa-plus"></i> Create New Product
                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
            </button>
            {{-- Product Type Picker Dropdown --}}
            <div id="productTypePickerMenu" class="hidden absolute right-0 z-50 mt-2 w-56 bg-white rounded-lg shadow-xl border border-slate-200 overflow-hidden">
                <div class="px-4 py-2.5 bg-slate-50 border-b border-slate-200">
                    <p class="text-[12px] font-semibold text-slate-500 uppercase tracking-wide">Select Product Type</p>
                </div>
                <ul class="py-1">
                    @foreach($productTypes as $type)
                        <li>
                            <button type="button"
                                class="product-type-pick-btn w-full text-left flex items-center gap-3 px-4 py-3 text-[14px] text-slate-700 hover:bg-blue-50 hover:text-blue-700 transition-colors"
                                data-type-id="{{ $type->idtbl_product_types }}"
                                data-type-name="{{ $type->name }}">
                                <span class="inline-flex items-center justify-center w-8 h-8 rounded-md bg-blue-100 text-blue-700 text-[11px] font-bold">{{ strtoupper(substr($type->skuname ?? $type->name, 0, 2)) }}</span>
                                <span>{{ $type->name }}</span>
                            </button>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>

    {{-- You can add a table here later --}}
    <div class="card shadow-sm">
        <div class="card-body text-center py-5">
            <i class="fa-light fa-boxes fa-3x text-muted mb-3"></i>
            <p class="text-muted">No inventory items found. Click "Create New Product" to add your first item.</p>
        </div>
    </div>
</div>

{{-- ===== CREATE NEW PRODUCT MODAL ===== --}}
<div id="createGemstoneModal" class="fixed inset-0 z-50 hidden items-center justify-center p-4 sm:p-6" style="background:rgba(0,0,0,0.5); z-index: 9999;">
    <div class="bg-white rounded-md shadow-2xl w-full max-w-5xl flex flex-col h-[95vh] relative overflow-hidden">

        {{-- Modal Header --}}
        <div class="px-6 py-4 flex-shrink-0 bg-[#f8fafc] rounded-t-md">
            <div class="flex justify-between items-start">
                <button type="button" id="closeGemstoneModalBtn" class="text-slate-500 hover:text-slate-700 transition-colors p-1 -ml-1">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
                <a href="{{ route('inventory.myinventory.new') }}" class="text-slate-500 hover:text-slate-800 transition-colors bg-white p-2.5 rounded-md border border-slate-200 shadow-sm inline-flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.75 3.75v4.5m0-4.5h4.5m-4.5 0L9 9M3.75 20.25v-4.5m0 4.5h4.5m-4.5 0L9 15M20.25 3.75h-4.5m4.5 0v4.5m0-4.5L15 9m5.25 11.25h-4.5m4.5 0v-4.5m0 4.5L15 15" /></svg>
                </a>
            </div>
            <div class="mt-2">
                <h2 class="text-[20px] font-bold text-slate-800 leading-tight">Create new product</h2>
                <div class="flex items-center gap-2 mt-1 text-[14px]">
                    <span class="text-amber-500 font-medium">Draft</span>
                    <span class="text-slate-500 font-medium">Created by Sachintha Kaveen {{ date('d M Y') }}</span>
                    <span class="text-slate-300">•</span>
                    <span id="selectedProductTypeLabel" class="text-blue-600 font-medium"></span>
                </div>
            </div>
        </div>

        {{-- Tabs Navigation --}}
        <div class="px-6 border-b border-slate-200 flex-shrink-0 bg-white flex w-full">
            <button type="button" class="tab-btn active py-3.5 font-semibold text-[14px] flex-1 text-center" data-target="#tab-quick-view">Quick View</button>
            <button type="button" class="tab-btn py-3.5 font-semibold text-[14px] flex-1 text-center text-slate-500" data-target="#tab-pricing">Pricing</button>
            <button type="button" class="tab-btn py-3.5 font-semibold text-[14px] flex-1 text-center text-slate-500" data-target="#tab-history">History</button>
        </div>

        <div class="flex-1 overflow-y-auto custom-scrollbar bg-white relative">
            <form id="createGemstoneForm" action="{{ route('inventory.myinventory.store') }}" method="POST">
                @csrf
                <input type="hidden" name="product_id" id="edit_product_id" value="">
                <input type="hidden" name="my_company_id" value="1">
                <input type="hidden" name="idtbl_product_types" id="ddProductTypeHidden" value="">

                {{-- ================= TAB 1: QUICK VIEW ================= --}}
                <div id="tab-quick-view" class="tab-content active block px-6 py-6 pb-20">

                    {{-- Upload Box --}}
                    <div class="w-[120px] h-[120px] bg-[#f1f5f9] rounded-md flex flex-col items-center justify-center cursor-pointer hover:bg-slate-200 transition-colors mb-6 border border-transparent">
                        <svg class="w-8 h-8 text-blue-600 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        <span class="text-blue-600 text-[13px] font-medium">Upload</span>
                    </div>

                    {{-- Section: Product attributes --}}
                    <div class="section-header !mt-0">Product attributes</div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-x-6 gap-y-5">
                        {{-- SKU --}}
                        <div>
                            <label class="block text-[13px] text-slate-700 mb-1.5">SKU</label>
                            <div class="flex gap-2">
                                <div class="w-1/2">
                                    <label class="block text-[13px] text-slate-500 mb-1">Prefix</label>
                                    <div class="relative searchable-dropdown" id="ddSkuPrefixWrapper">
                                        <input type="hidden" name="idtbl_skus" id="ddSkuPrefixHidden" value="">
                                        <button type="button" id="ddSkuPrefixBtn" class="form-control flex items-center pl-3 pr-8 text-left">
                                            <span id="ddSkuPrefixLabel" class="truncate text-slate-800">Prefix</span>
                                        </button>
                                        <div class="absolute inset-y-0 right-3 flex items-center pointer-events-none">
                                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                        </div>
                                        <div id="ddSkuPrefixPanel" class="hidden absolute z-50 left-0 right-0 mt-2 bg-white border border-slate-200 rounded-md shadow-lg overflow-hidden">
                                            <ul id="ddSkuPrefixList" class="py-1 max-h-48 overflow-y-auto custom-scrollbar">
                                                <li class="dd-option flex items-center px-4 py-2.5 text-[14px] cursor-pointer bg-slate-100 text-slate-800 font-semibold" data-value="Prefix" data-label="Prefix">Prefix</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                <div class="w-1/2">
                                    <label class="block text-[13px] text-slate-500 mb-1">SKU</label>
                                    <input type="text" name="sku_number" id="skuNumberInput" value="{{ old('sku_number','') }}" class="form-control w-full px-3">
                                </div>
                            </div>
                        </div>

                        {{-- Variety --}}
                        <div>
                            <label class="block text-[13px] text-slate-700 mb-1.5">Variety <span class="text-rose-500">*</span></label>
                            <div class="relative w-full searchable-dropdown" id="ddVarietyWrapper">
                                <input type="hidden" name="idtbl_varieties" id="ddVarietyHidden">
                                <button type="button" id="ddVarietyBtn" class="form-control flex items-center pl-3 pr-8 text-left">
                                    <span id="ddVarietyLabel" class="truncate text-slate-400">Select variety</span>
                                </button>
                                <div class="absolute inset-y-0 right-3 flex items-center pointer-events-none">
                                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </div>
                                <div id="ddVarietyPanel" class="hidden absolute z-50 left-0 right-0 mt-2 bg-white border border-slate-200 rounded-md shadow-lg overflow-hidden">
                                    <div class="p-2 border-b border-slate-100">
                                        <input type="text" id="ddVarietySearch" placeholder="Search..." class="form-control !h-9 px-3">
                                    </div>
                                    <ul id="ddVarietyList" class="py-1 max-h-48 overflow-y-auto custom-scrollbar">
                                        <li class="dd-option flex items-center px-4 py-2.5 text-[14px] cursor-pointer hover:bg-slate-50 text-slate-600" data-value="" data-label="Select variety">Select variety</li>
                                        <li class="dd-option flex items-center px-4 py-2.5 text-[14px] cursor-pointer hover:bg-slate-50 text-slate-600" data-value="sapphire" data-label="Sapphire">Sapphire</li>
                                        <li class="dd-option flex items-center px-4 py-2.5 text-[14px] cursor-pointer hover:bg-slate-50 text-slate-600" data-value="ruby" data-label="Ruby">Ruby</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        {{-- Sub - Category --}}
                        <div>
                            <label class="block text-[13px] text-slate-700 mb-1.5">Sub - Category</label>
                            <div class="relative w-full searchable-dropdown" id="ddSubCategoryWrapper">
                                <input type="hidden" name="idtbl_sub_categories" id="ddSubCategoryHidden" value="Unspecified">
                                <button type="button" id="ddSubCategoryBtn" class="form-control flex items-center pl-3 pr-8 text-left">
                                    <span id="ddSubCategoryLabel" class="truncate text-slate-800">Unspecified</span>
                                </button>
                                <div class="absolute inset-y-0 right-3 flex items-center pointer-events-none">
                                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </div>
                                <div id="ddSubCategoryPanel" class="hidden absolute z-50 left-0 right-0 mt-2 bg-white border border-slate-200 rounded-md shadow-lg overflow-hidden">
                                    <ul id="ddSubCategoryList" class="py-1 max-h-48 overflow-y-auto custom-scrollbar">
                                        <li class="dd-option flex items-center px-4 py-2.5 text-[14px] cursor-pointer bg-slate-100 text-slate-800 font-semibold" data-value="Unspecified" data-label="Unspecified">Unspecified</li>
                                        <li class="dd-option flex items-center px-4 py-2.5 text-[14px] cursor-pointer hover:bg-slate-50 text-slate-600" data-value="Natural" data-label="Natural">Natural</li>
                                        <li class="dd-option flex items-center px-4 py-2.5 text-[14px] cursor-pointer hover:bg-slate-50 text-slate-600" data-value="Synthetic" data-label="Synthetic">Synthetic</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        {{-- Quantity --}}
                        <div>
                            <label class="block text-[13px] text-slate-700 mb-1.5">Quantity</label>
                            <input type="text" name="quantity" placeholder="Quantity" class="form-control px-3">
                        </div>

                        {{-- Dimensions --}}
                        <div>
                            <label class="block text-[13px] text-slate-700 mb-1.5">Dimensions (mm.)</label>
                            <div class="flex items-center gap-2">
                                <input type="text" name="length_mm" placeholder="L" class="form-control px-3 text-center !rounded-md">
                                <span class="text-slate-600 font-medium text-[13px]">x</span>
                                <input type="text" name="width_mm" placeholder="W" class="form-control px-3 text-center !rounded-md">
                                <span class="text-slate-600 font-medium text-[13px]">x</span>
                                <input type="text" name="height_mm" placeholder="H" class="form-control px-3 text-center !rounded-md">
                            </div>
                        </div>

                        {{-- Weight --}}
                        <div>
                            <label class="block text-[13px] text-slate-700 mb-1.5">Weight <span class="text-rose-500">*</span></label>
                            <div class="flex gap-2">
                                <input type="text" name="weight" placeholder='Weight e.g. "1.2"' class="form-control flex-1 px-3">
                                <div class="relative w-[85px] searchable-dropdown" id="ddWeightUnitWrapper">
                                    <input type="hidden" name="idtbl_weight_units" id="ddWeightUnitHidden" value="ct">
                                    <button type="button" id="ddWeightUnitBtn" class="form-control flex items-center pl-3 pr-7 text-left">
                                        <span id="ddWeightUnitLabel" class="truncate text-slate-800">ct</span>
                                    </button>
                                    <div class="absolute inset-y-0 right-2.5 flex items-center pointer-events-none">
                                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                    </div>
                                    <div id="ddWeightUnitPanel" class="hidden absolute z-50 left-0 right-0 mt-2 bg-white border border-slate-200 rounded-md shadow-lg overflow-hidden">
                                        <ul id="ddWeightUnitList" class="py-1 max-h-48 overflow-y-auto custom-scrollbar">
                                            <li class="dd-option flex items-center px-4 py-2.5 text-[14px] cursor-pointer bg-slate-100 text-slate-800 font-semibold" data-value="ct" data-label="ct">ct</li>
                                            <li class="dd-option flex items-center px-4 py-2.5 text-[14px] cursor-pointer hover:bg-slate-50 text-slate-600" data-value="g" data-label="g">g</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Color --}}
                        <div>
                            <label class="block text-[13px] text-slate-700 mb-1.5">Color</label>
                            <div class="relative w-full searchable-dropdown" id="ddColorWrapper">
                                <input type="hidden" name="idtbl_colors" id="ddColorHidden">
                                <button type="button" id="ddColorBtn" class="form-control flex items-center pl-3 pr-8 text-left">
                                    <span id="ddColorLabel" class="truncate text-slate-400">Select color</span>
                                </button>
                                <div class="absolute inset-y-0 right-3 flex items-center pointer-events-none">
                                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </div>
                                <div id="ddColorPanel" class="hidden absolute z-50 left-0 right-0 mt-2 bg-white border border-slate-200 rounded-md shadow-lg overflow-hidden">
                                    <div class="p-2 border-b border-slate-100">
                                        <input type="text" id="ddColorSearch" placeholder="Search..." class="form-control !h-9 px-3">
                                    </div>
                                    <ul id="ddColorList" class="py-1 max-h-48 overflow-y-auto custom-scrollbar">
                                        <li class="dd-option flex items-center px-4 py-2.5 text-[14px] cursor-pointer hover:bg-slate-50 text-slate-600" data-value="" data-label="Select color">Select color</li>
                                        <li class="dd-option flex items-center px-4 py-2.5 text-[14px] cursor-pointer hover:bg-slate-50 text-slate-600" data-value="blue" data-label="Blue">Blue</li>
                                        <li class="dd-option flex items-center px-4 py-2.5 text-[14px] cursor-pointer hover:bg-slate-50 text-slate-600" data-value="red" data-label="Red">Red</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        {{-- Shape --}}
                        <div>
                            <label class="block text-[13px] text-slate-700 mb-1.5">Shape</label>
                            <div class="relative w-full searchable-dropdown" id="ddShapeWrapper">
                                <input type="hidden" name="idtbl_shapes" id="ddShapeHidden">
                                <button type="button" id="ddShapeBtn" class="form-control flex items-center pl-3 pr-8 text-left">
                                    <span id="ddShapeLabel" class="truncate text-slate-400">Select shape</span>
                                </button>
                                <div class="absolute inset-y-0 right-3 flex items-center pointer-events-none">
                                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </div>
                                <div id="ddShapePanel" class="hidden absolute z-50 left-0 right-0 mt-2 bg-white border border-slate-200 rounded-md shadow-lg overflow-hidden">
                                    <div class="p-2 border-b border-slate-100">
                                        <input type="text" id="ddShapeSearch" placeholder="Search..." class="form-control !h-9 px-3">
                                    </div>
                                    <ul id="ddShapeList" class="py-1 max-h-48 overflow-y-auto custom-scrollbar">
                                        <li class="dd-option flex items-center px-4 py-2.5 text-[14px] cursor-pointer hover:bg-slate-50 text-slate-600" data-value="" data-label="Select shape">Select shape</li>
                                        <li class="dd-option flex items-center px-4 py-2.5 text-[14px] cursor-pointer hover:bg-slate-50 text-slate-600" data-value="oval" data-label="Oval">Oval</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        {{-- Cutting type --}}
                        <div>
                            <label class="block text-[13px] text-slate-700 mb-1.5">Cutting type</label>
                            <div class="relative w-full searchable-dropdown" id="ddCuttingWrapper">
                                <input type="hidden" name="idtbl_cuts" id="ddCuttingHidden">
                                <button type="button" id="ddCuttingBtn" class="form-control flex items-center pl-3 pr-8 text-left">
                                    <span id="ddCuttingLabel" class="truncate text-slate-400">Select cutting type</span>
                                </button>
                                <div class="absolute inset-y-0 right-3 flex items-center pointer-events-none">
                                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </div>
                                <div id="ddCuttingPanel" class="hidden absolute z-50 left-0 right-0 mt-2 bg-white border border-slate-200 rounded-md shadow-lg overflow-hidden">
                                    <ul id="ddCuttingList" class="py-1 max-h-48 overflow-y-auto custom-scrollbar">
                                        <li class="dd-option flex items-center px-4 py-2.5 text-[14px] cursor-pointer hover:bg-slate-50 text-slate-600" data-value="" data-label="Select cutting type">Select cutting type</li>
                                        <li class="dd-option flex items-center px-4 py-2.5 text-[14px] cursor-pointer hover:bg-slate-50 text-slate-600" data-value="step" data-label="Step">Step</li>
                                        <li class="dd-option flex items-center px-4 py-2.5 text-[14px] cursor-pointer hover:bg-slate-50 text-slate-600" data-value="brilliant" data-label="Brilliant">Brilliant</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        {{-- Color grade --}}
                        <div>
                            <label class="block text-[13px] text-slate-700 mb-1.5">Color grade</label>
                            <div class="relative w-full searchable-dropdown" id="ddColorGradeWrapper">
                                <input type="hidden" name="idtbl_color_grade" id="ddColorGradeHidden">
                                <button type="button" id="ddColorGradeBtn" class="form-control flex items-center pl-3 pr-8 text-left">
                                    <span id="ddColorGradeLabel" class="truncate text-slate-400">Select color grade</span>
                                </button>
                                <div class="absolute inset-y-0 right-3 flex items-center pointer-events-none">
                                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </div>
                                <div id="ddColorGradePanel" class="hidden absolute z-50 left-0 right-0 mt-2 bg-white border border-slate-200 rounded-md shadow-lg overflow-hidden">
                                    <ul id="ddColorGradeList" class="py-1 max-h-48 overflow-y-auto custom-scrollbar">
                                        <li class="dd-option flex items-center px-4 py-2.5 text-[14px] cursor-pointer hover:bg-slate-50 text-slate-600" data-value="" data-label="Select color grade">Select color grade</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        {{-- Clarity grade --}}
                        <div>
                            <label class="block text-[13px] text-slate-700 mb-1.5">Clarity grade</label>
                            <div class="relative w-full searchable-dropdown" id="ddClarityWrapper">
                                <input type="hidden" name="idtbl_clarity_grade" id="ddClarityHidden">
                                <button type="button" id="ddClarityBtn" class="form-control flex items-center pl-3 pr-8 text-left">
                                    <span id="ddClarityLabel" class="truncate text-slate-400">Select clarity grade</span>
                                </button>
                                <div class="absolute inset-y-0 right-3 flex items-center pointer-events-none">
                                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </div>
                                <div id="ddClarityPanel" class="hidden absolute z-50 left-0 right-0 mt-2 bg-white border border-slate-200 rounded-md shadow-lg overflow-hidden">
                                    <ul id="ddClarityList" class="py-1 max-h-48 overflow-y-auto custom-scrollbar">
                                        <li class="dd-option flex items-center px-4 py-2.5 text-[14px] cursor-pointer hover:bg-slate-50 text-slate-600" data-value="" data-label="Select clarity grade">Select clarity grade</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        {{-- Cut grade --}}
                        <div>
                            <label class="block text-[13px] text-slate-700 mb-1.5">Cut grade</label>
                            <div class="relative w-full searchable-dropdown" id="ddCutGradeWrapper">
                                <input type="hidden" name="idtbl_cuttinggrade" id="ddCutGradeHidden">
                                <button type="button" id="ddCutGradeBtn" class="form-control flex items-center pl-3 pr-8 text-left">
                                    <span id="ddCutGradeLabel" class="truncate text-slate-400">Select cut grade</span>
                                </button>
                                <div class="absolute inset-y-0 right-3 flex items-center pointer-events-none">
                                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </div>
                                <div id="ddCutGradePanel" class="hidden absolute z-50 left-0 right-0 mt-2 bg-white border border-slate-200 rounded-md shadow-lg overflow-hidden">
                                    <ul id="ddCutGradeList" class="py-1 max-h-48 overflow-y-auto custom-scrollbar">
                                        <li class="dd-option flex items-center px-4 py-2.5 text-[14px] cursor-pointer hover:bg-slate-50 text-slate-600" data-value="" data-label="Select cut grade">Select cut grade</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        {{-- Origin --}}
                        <div>
                            <label class="block text-[13px] text-slate-700 mb-1.5">Origin</label>
                            <div class="relative w-full searchable-dropdown" id="ddOriginWrapper">
                                <input type="hidden" name="idtbl_origins" id="ddOriginHidden">
                                <button type="button" id="ddOriginBtn" class="form-control flex items-center pl-3 pr-8 text-left">
                                    <span id="ddOriginLabel" class="truncate text-slate-400">Select origin</span>
                                </button>
                                <div class="absolute inset-y-0 right-3 flex items-center pointer-events-none">
                                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </div>
                                <div id="ddOriginPanel" class="hidden absolute z-50 left-0 right-0 mt-2 bg-white border border-slate-200 rounded-md shadow-lg overflow-hidden">
                                    <div class="p-2 border-b border-slate-100">
                                        <input type="text" id="ddOriginSearch" placeholder="Search..." class="form-control !h-9 px-3">
                                    </div>
                                    <ul id="ddOriginList" class="py-1 max-h-48 overflow-y-auto custom-scrollbar">
                                        <li class="dd-option flex items-center px-4 py-2.5 text-[14px] cursor-pointer hover:bg-slate-50 text-slate-600" data-value="" data-label="Select origin">Select origin</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        {{-- Treatment --}}
                        <div>
                            <label class="block text-[13px] text-slate-700 mb-1.5">Treatment</label>
                            <div class="relative w-full searchable-dropdown" id="ddTreatmentWrapper">
                                <input type="hidden" name="idtbl_treatments" id="ddTreatmentHidden">
                                <button type="button" id="ddTreatmentBtn" class="form-control flex items-center pl-3 pr-8 text-left">
                                    <span id="ddTreatmentLabel" class="truncate text-slate-400">Select treatment</span>
                                </button>
                                <div class="absolute inset-y-0 right-3 flex items-center pointer-events-none">
                                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </div>
                                <div id="ddTreatmentPanel" class="hidden absolute z-50 left-0 right-0 mt-2 bg-white border border-slate-200 rounded-md shadow-lg overflow-hidden">
                                    <div class="p-2 border-b border-slate-100">
                                        <input type="text" id="ddTreatmentSearch" placeholder="Search..." class="form-control !h-9 px-3">
                                    </div>
                                    <ul id="ddTreatmentList" class="py-1 max-h-48 overflow-y-auto custom-scrollbar">
                                        <li class="dd-option flex items-center px-4 py-2.5 text-[14px] cursor-pointer hover:bg-slate-50 text-slate-600" data-value="" data-label="Select treatment">Select treatment</li>
                                        @foreach($treatments as $treatment)
                                            <li class="dd-option flex items-center px-4 py-2.5 text-[14px] cursor-pointer hover:bg-slate-50 text-slate-600" data-value="{{ $treatment->idtbl_treatments }}" data-label="{{ $treatment->treatment_name }}">{{ $treatment->treatment_name }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>

                        {{-- Storage locations --}}
                        <div>
                            <label class="block text-[13px] text-slate-700 mb-1.5">Storage locations</label>
                            <div class="relative w-full searchable-dropdown" id="ddStorageWrapper">
                                <input type="hidden" name="idtbl_storage_locations" id="ddStorageHidden">
                                <button type="button" id="ddStorageBtn" class="form-control flex items-center pl-3 pr-8 text-left">
                                    <span id="ddStorageLabel" class="truncate text-slate-400">Select storage location</span>
                                </button>
                                <div class="absolute inset-y-0 right-3 flex items-center pointer-events-none">
                                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </div>
                                <div id="ddStoragePanel" class="hidden absolute z-50 left-0 right-0 mt-2 bg-white border border-slate-200 rounded-md shadow-lg overflow-hidden">
                                    <ul id="ddStorageList" class="py-1 max-h-48 overflow-y-auto custom-scrollbar">
                                        <li class="dd-option flex items-center px-4 py-2.5 text-[14px] cursor-pointer hover:bg-slate-50 text-slate-600" data-value="" data-label="Select storage location">Select storage location</li>
                                        @foreach($storageLocations as $location)
                                            <li class="dd-option flex items-center px-4 py-2.5 text-[14px] cursor-pointer hover:bg-slate-50 text-slate-600" data-value="{{ $location->idtbl_storage_locations }}" data-label="{{ $location->location_name }}">{{ $location->location_name }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>

                        {{-- Trays/Boxes# --}}
                        <div>
                            <label class="block text-[13px] text-slate-700 mb-1.5">Trays/Boxes#</label>
                            <div class="relative w-full searchable-dropdown" id="ddTraysWrapper">
                                <input type="hidden" name="idtbl_tray_box" id="ddTraysHidden">
                                <button type="button" id="ddTraysBtn" class="form-control flex items-center pl-3 pr-8 text-left">
                                    <span id="ddTraysLabel" class="truncate text-slate-400">Select trays/boxes#</span>
                                </button>
                                <div class="absolute inset-y-0 right-3 flex items-center pointer-events-none">
                                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </div>
                                <div id="ddTraysPanel" class="hidden absolute z-50 left-0 right-0 mt-2 bg-white border border-slate-200 rounded-md shadow-lg overflow-hidden">
                                    <ul id="ddTraysList" class="py-1 max-h-48 overflow-y-auto custom-scrollbar">
                                        <li class="dd-option flex items-center px-4 py-2.5 text-[14px] cursor-pointer hover:bg-slate-50 text-slate-600" data-value="" data-label="Select trays/boxes#">Select trays/boxes#</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Section: Lab certificate --}}
                    <div class="mt-6 mb-1.5">
                        <label class="block text-[13px] text-slate-700">Lab certificate</label>
                    </div>
                    <div class="w-[180px] h-[90px] bg-white border border-slate-200 rounded-md flex flex-col items-center justify-center cursor-pointer hover:bg-slate-50 transition-colors shadow-sm mb-6">
                        <svg class="w-6 h-6 text-blue-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v2m0 0v2m0-2h2m-2 0H10"></path>
                        </svg>
                        <span class="text-slate-800 text-[13px] font-medium">Add certificate</span>
                    </div>

                    {{-- Section: Purchasing details --}}
                    <div class="section-header">Purchasing details</div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-x-6 gap-y-5 mb-6">
                        {{-- Supplier name --}}
                        <div>
                            <label class="block text-[13px] text-slate-700 mb-1.5">Supplier name</label>
                            <div class="relative w-full searchable-dropdown" id="ddSupplierWrapper">
                                <input type="hidden" name="idtbl_suppliers" id="ddSupplierHidden">
                                <button type="button" id="ddSupplierBtn" class="form-control flex items-center pl-3 pr-8 text-left">
                                    <span id="ddSupplierLabel" class="truncate text-slate-400">Select Supplier ref/name</span>
                                </button>
                                <div class="absolute inset-y-0 right-3 flex items-center pointer-events-none">
                                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </div>
                                <div id="ddSupplierPanel" class="hidden absolute z-50 left-0 right-0 mt-2 bg-white border border-slate-200 rounded-md shadow-lg overflow-hidden">
                                    <ul id="ddSupplierList" class="py-1 max-h-48 overflow-y-auto custom-scrollbar">
                                        <li class="dd-option flex items-center px-4 py-2.5 text-[14px] cursor-pointer hover:bg-slate-50 text-slate-600" data-value="" data-label="Select Supplier ref/name">Select Supplier ref/name</li>
                                        @foreach($suppliers as $supplier)
                                            <li class="dd-option flex items-center px-4 py-2.5 text-[14px] cursor-pointer hover:bg-slate-50 text-slate-600" data-value="{{ $supplier->idtbl_suppliers }}" data-label="{{ $supplier->supplier_name }}">{{ $supplier->supplier_name }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>

                        {{-- Date of purchase --}}
                        <div>
                            <label class="block text-[13px] text-slate-700 mb-1.5">Date of purchase</label>
                            <input type="text" name="date_of_purchase" placeholder="Date of purchase" class="form-control px-3">
                        </div>

                        {{-- Ownership type --}}
                        <div>
                            <label class="block text-[13px] text-slate-700 mb-1.5">Ownership type</label>
                            <div class="relative w-full searchable-dropdown" id="ddOwnershipWrapper">
                                <input type="hidden" name="idtbl_ownership_type" id="ddOwnershipHidden">
                                <button type="button" id="ddOwnershipBtn" class="form-control flex items-center pl-3 pr-8 text-left">
                                    <span id="ddOwnershipLabel" class="truncate text-slate-400">Select Ownership Type</span>
                                </button>
                                <div class="absolute inset-y-0 right-3 flex items-center pointer-events-none">
                                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </div>
                                <div id="ddOwnershipPanel" class="hidden absolute z-50 left-0 right-0 mt-2 bg-white border border-slate-200 rounded-md shadow-lg overflow-hidden">
                                    <ul id="ddOwnershipList" class="py-1 max-h-48 overflow-y-auto custom-scrollbar">
                                        <li class="dd-option flex items-center px-4 py-2.5 text-[14px] cursor-pointer hover:bg-slate-50 text-slate-600" data-value="" data-label="Select Ownership Type">Select Ownership Type</li>
                                        @foreach($ownershipTypes as $ownership)
                                            <li class="dd-option flex items-center px-4 py-2.5 text-[14px] cursor-pointer hover:bg-slate-50 text-slate-600" data-value="{{ $ownership->idtbl_ownership_type }}" data-label="{{ $ownership->ownership_type_name }}">{{ $ownership->ownership_type_name }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>

                        {{-- Partners Section --}}
                        <div class="col-span-1 md:col-span-3">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-x-6 mb-1.5">
                                <label class="block text-[13px] text-slate-700">Partners</label>
                                <label class="block text-[13px] text-slate-700">% of ownership</label>
                                <label class="block text-[13px] text-slate-700">% of profit share</label>
                            </div>
                            <div id="partnerRowsContainer" class="flex flex-col gap-y-3">
                                {{-- My company row --}}
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-x-6 items-center">
                                    <div class="relative">
                                        <input type="hidden" name="my_company_id" value="1">
                                        <input type="text" value="My company" readonly class="form-control pl-3 pr-8 bg-slate-50 text-slate-600">
                                        <div class="absolute inset-y-0 right-3 flex items-center pointer-events-none">
                                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                                        </div>
                                    </div>
                                    <div class="relative">
                                        <input type="text" name="my_ownership_percentage" value="100" class="form-control pl-3 pr-8 bg-slate-50 text-slate-600" readonly>
                                        <div class="absolute inset-y-0 right-3 flex items-center pointer-events-none">
                                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <div class="relative flex-1">
                                            <input type="text" name="my_profit_share_percentage" value="100" class="form-control pl-3 pr-8 bg-slate-50 text-slate-600" readonly>
                                            <div class="absolute inset-y-0 right-3 flex items-center pointer-events-none">
                                                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                                            </div>
                                        </div>
                                        <button type="button" class="p-1.5 text-blue-800 hover:bg-slate-100 rounded-md">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                        </button>
                                        <div class="w-8"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="flex justify-end mt-3">
                                <button type="button" onclick="toggleAddPartnerModal(true)" class="px-3 py-1.5 bg-[#f1f5f9] text-[13px] text-slate-700 font-medium rounded-md hover:bg-slate-200">Add partner</button>
                            </div>
                        </div>
                    </div>

                    {{-- Section: All document --}}
                    <div class="section-header">All document</div>
                    <div class="mb-6">
                        <label class="block text-[14px] font-semibold text-slate-800 mb-3">Purchasing document</label>
                        <p class="text-[14px] text-slate-600">Purchasing document not found</p>
                    </div>

                    {{-- Section: Documents --}}
                    <div class="mb-6">
                        <label class="block text-[14px] font-semibold text-slate-800 mb-3">Documents</label>
                        <div class="w-[180px] h-[90px] bg-white border border-slate-200 rounded-md flex flex-col items-center justify-center cursor-pointer hover:bg-slate-50 transition-colors shadow-sm">
                            <svg class="w-6 h-6 text-blue-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v2m0 0v2m0-2h2m-2 0H10"></path>
                            </svg>
                            <span class="text-slate-800 text-[13px] font-medium">Add document(s)</span>
                        </div>
                    </div>

                    {{-- Section: Traceability info --}}
                    <div class="mb-2">
                        <label class="block text-[14px] font-semibold text-slate-800 mb-3">Traceability info</label>
                        <div class="w-[180px] h-[90px] bg-white border border-slate-200 rounded-md flex flex-col items-center justify-center cursor-pointer hover:bg-slate-50 transition-colors shadow-sm">
                            <svg class="w-6 h-6 text-blue-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v2m0 0v2m0-2h2m-2 0H10"></path>
                            </svg>
                            <span class="text-slate-800 text-[13px] font-medium">Add document(s)</span>
                        </div>
                    </div>
                </div>

                {{-- ================= TAB 2: PRICING ================= --}}
                <div id="tab-pricing" class="tab-content hidden px-6 py-6 pb-20">
                    <div class="flex items-center gap-6 mb-6">

                        <div class="w-64">
                            <label class="block text-[13px] text-slate-700 mb-1.5">Pricing unit</label>
                            <div class="relative searchable-dropdown" id="ddPricingUnitWrapper">
                                <input type="hidden" name="pricing_unit" id="ddPricingUnitHidden" value="Weight">
                                <button type="button" id="ddPricingUnitBtn" class="form-control flex items-center pl-3 pr-8 text-left">
                                    <span id="ddPricingUnitLabel" class="truncate text-slate-800">Weight</span>
                                </button>
                                <div class="absolute inset-y-0 right-3 flex items-center pointer-events-none">
                                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </div>
                                <div id="ddPricingUnitPanel" class="hidden absolute z-50 left-0 right-0 mt-2 bg-white border border-slate-200 rounded-md shadow-lg overflow-hidden">
                                    <ul id="ddPricingUnitList" class="py-1 max-h-48 overflow-y-auto custom-scrollbar">
                                        <li class="dd-option flex items-center px-4 py-2.5 text-[14px] cursor-pointer bg-slate-100 text-slate-800 font-semibold" data-value="Weight" data-label="Weight">Weight</li>
                                        <li class="dd-option flex items-center px-4 py-2.5 text-[14px] cursor-pointer hover:bg-slate-50 text-slate-600" data-value="Quantity" data-label="Quantity">Quantity</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="text-[14px] text-slate-800 mt-6">By weight or quantity.</div>
                    </div>

                    {{-- Costing module --}}
                    <div class="section-header flex items-center gap-2">
                        Costing module
                        <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-5 mb-3">
                        <div>
                            <label class="block text-[13px] text-slate-700 mb-1.5">Cost/unit</label>
                            <input type="text" name="cost_per_unit" placeholder="Cost Per/unit" class="form-control px-3">
                        </div>
                        <div>
                            <label class="block text-[13px] text-slate-700 mb-1.5 flex items-center gap-1">Total cost <svg class="w-3.5 h-3.5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg></label>
                            <input type="text" name="total_cost" placeholder="Total Cost" class="form-control px-3">
                        </div>
                        <div>
                            <label class="block text-[13px] text-slate-700 mb-1.5">My cost/unit</label>
                            <input type="text" name="my_cost_per_unit" placeholder="My cost Per/unit" class="form-control px-3">
                        </div>
                        <div>
                            <label class="block text-[13px] text-slate-700 mb-1.5 flex items-center gap-1">My total cost <svg class="w-3.5 h-3.5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg></label>
                            <input type="text" name="my_total_cost" placeholder="My total cost" class="form-control px-3">
                        </div>
                    </div>
                    <div class="flex justify-end mb-6">
                        <button type="button" class="px-4 py-2 bg-[#f1f5f9] text-[13px] text-slate-800 font-medium rounded-md hover:bg-slate-200">Add cost</button>
                    </div>

                    {{-- Selling prices --}}
                    <div class="section-header !mt-0">Selling prices</div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-5 mb-6">
                        <div>
                            <label class="block text-[13px] text-slate-700 mb-1.5">Wholesale / unit</label>
                            <input type="text" name="wholesale_per_unit" placeholder="Wholesale Cost Per/unit" class="form-control px-3">
                        </div>
                        <div>
                            <label class="block text-[13px] text-slate-700 mb-1.5">Wholesale total</label>
                            <input type="text" name="wholesale_total" placeholder="Total Wholesale Cost" class="form-control px-3">
                        </div>
                        <div>
                            <label class="block text-[13px] text-slate-700 mb-1.5">Retail / unit</label>
                            <input type="text" name="retail_per_unit" placeholder="Retail Cost Per/unit" class="form-control px-3">
                        </div>
                        <div>
                            <label class="block text-[13px] text-slate-700 mb-1.5">Retail total</label>
                            <input type="text" name="retail_total" placeholder="Total Retail Cost" class="form-control px-3">
                        </div>
                        <div>
                            <label class="block text-[13px] text-slate-700 mb-1.5">Matrix / unit</label>
                            <input type="text" name="matrix_per_unit" placeholder="Matrix Price Per/unit" class="form-control px-3">
                        </div>
                        <div>
                            <label class="block text-[13px] text-slate-700 mb-1.5">Matrix total</label>
                            <input type="text" name="matrix_total" placeholder="Total Matrix Price" class="form-control px-3">
                        </div>
                    </div>

                    {{-- Custom pricing --}}
                    <div class="section-header">Custom pricing</div>

                    {{-- Offer price history --}}
                    <div class="section-header mb-0">Offer price history</div>
                    <div class="bg-[#f8fafc] px-4 py-3 border-b border-slate-100 flex font-semibold text-[13px] text-slate-800 rounded-b-md">
                        <div class="w-1/6">Date</div>
                        <div class="w-1/6">Document</div>
                        <div class="w-1/6">Document type</div>
                        <div class="w-1/6">Customer</div>
                        <div class="w-1/6">Unit Price</div>
                        <div class="w-1/6">Total price</div>
                    </div>
                    {{-- empty state for offer price history goes here --}}

                </div>

                {{-- ================= TAB 3: HISTORY ================= --}}
                <div id="tab-history" class="tab-content hidden px-6 py-6 pb-20">
                    <div class="flex justify-between items-center mb-6">
                        <div class="relative w-64 searchable-dropdown" id="ddFilterWrapper">
                            <input type="hidden" name="history_filter" id="ddFilterHidden" value="Filter">
                            <button type="button" id="ddFilterBtn" class="form-control flex items-center pl-3 pr-8 text-left bg-[#f8fafc] !border-slate-300">
                                <span id="ddFilterLabel" class="truncate text-slate-800">Filter</span>
                            </button>
                            <div class="absolute inset-y-0 right-3 flex items-center pointer-events-none">
                                <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </div>
                            <div id="ddFilterPanel" class="hidden absolute z-50 left-0 right-0 mt-2 bg-white border border-slate-200 rounded-md shadow-lg overflow-hidden">
                                <ul id="ddFilterList" class="py-1 max-h-48 overflow-y-auto custom-scrollbar">
                                    <li class="dd-option flex items-center px-4 py-2.5 text-[14px] cursor-pointer bg-slate-100 text-slate-800 font-semibold" data-value="Filter" data-label="Filter">Filter</li>
                                </ul>
                            </div>
                        </div>

                        <div class="flex">
                            <input type="text" placeholder="Search" class="form-control !rounded-r-none !border-r-0 w-64 px-3">
                            <button type="button" class="bg-blue-700 hover:bg-blue-800 text-white px-4 py-2 rounded-r-md h-[42px] flex items-center justify-center">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            </button>
                        </div>
                    </div>

                    <div class="border border-slate-100 rounded-md overflow-hidden shadow-sm">
                        <table class="w-full text-left text-[13px]">
                            <thead class="bg-[#f8fafc] text-slate-800 font-semibold border-b border-slate-200">
                                <tr>
                                    <th class="px-4 py-3.5">Date</th>
                                    <th class="px-4 py-3.5">Time</th>
                                    <th class="px-4 py-3.5">User</th>
                                    <th class="px-4 py-3.5">Action</th>
                                    <th class="px-4 py-3.5">Old Value</th>
                                    <th class="px-4 py-3.5">New Value</th>
                                    <th class="px-4 py-3.5">Note</th>
                                    <th class="px-4 py-3.5 text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="text-slate-700 bg-white">
                                @forelse($auditLogs ?? [] as $log)
                                    <tr class="border-b border-slate-50 hover:bg-slate-50">
                                        <td class="px-4 py-3">{{ \Carbon\Carbon::parse($log->insertdatetime)->format('Y-m-d') }}</td>
                                        <td class="px-4 py-3">{{ \Carbon\Carbon::parse($log->insertdatetime)->format('H:i:s') }}</td>
                                        <td class="px-4 py-3">{{ $log->user_name ?? 'System' }}</td>
                                        <td class="px-4 py-3">
                                            <span class="px-2.5 py-1 rounded-md text-[12px] font-semibold {{ $log->action === 'Created' ? 'bg-blue-50 text-blue-700' : 'bg-amber-50 text-amber-700' }}">
                                                {{ $log->action }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3 text-slate-400">-</td>
                                        <td class="px-4 py-3 text-slate-400">-</td>
                                        <td class="px-4 py-3 truncate max-w-[200px]">Product ID: {{ $log->entity_id }}</td>
                                        <td class="px-4 py-3 text-right">
                                            <div class="flex items-center justify-end gap-2">
                                                <button type="button" onclick='viewAuditLog({{ $log->entity_id }}, @json($log->action ?? ""), @json($log->user_name ?? "System"), @json($log->insertdatetime ?? ""))' class="text-slate-400 hover:text-blue-600 transition-colors" title="View">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                                </button>
                                                <button type="button" onclick='editProduct({{ $log->entity_id }})' class="text-slate-400 hover:text-emerald-600 transition-colors" title="Edit">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                                </button>
                                                <button type="button" onclick='deleteAuditLog({{ $log->idtbl_audit_logs }})' class="text-slate-400 hover:text-rose-600 transition-colors" title="Delete">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="px-4 py-8 text-center text-slate-400">No activity history found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4 flex justify-between items-center text-[13px] text-slate-600">
                        <div class="flex items-center gap-2">
                            Show
                            <div class="relative searchable-dropdown inline-block" id="ddShowEntriesWrapper">
                                <input type="hidden" name="show_entries" id="ddShowEntriesHidden" value="10">
                                <button type="button" id="ddShowEntriesBtn" class="border border-slate-300 rounded-md px-2 py-1 focus:outline-none bg-white flex items-center gap-2">
                                    <span id="ddShowEntriesLabel" class="truncate text-slate-800">10</span>
                                    <svg class="w-3 h-3 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </button>
                                <div id="ddShowEntriesPanel" class="hidden absolute z-50 bottom-full mb-1 left-0 mt-2 bg-white border border-slate-200 rounded-md shadow-lg overflow-hidden min-w-[80px]">
                                    <ul id="ddShowEntriesList" class="py-1 max-h-48 overflow-y-auto custom-scrollbar">
                                        <li class="dd-option flex items-center px-4 py-2 text-[13px] cursor-pointer bg-slate-100 text-slate-800 font-semibold" data-value="10" data-label="10">10</li>
                                        <li class="dd-option flex items-center px-4 py-2 text-[13px] cursor-pointer hover:bg-slate-50 text-slate-600" data-value="25" data-label="25">25</li>
                                        <li class="dd-option flex items-center px-4 py-2 text-[13px] cursor-pointer hover:bg-slate-50 text-slate-600" data-value="50" data-label="50">50</li>
                                    </ul>
                                </div>
                            </div>
                            entries
                        </div>
                        <div>Showing 1 to 1 of 1 entries</div>
                        <div class="flex items-center gap-1">
                            <button type="button" class="px-3 py-1 text-slate-400 hover:text-blue-600">Previous</button>
                            <button type="button" class="px-3 py-1 bg-[#f1f5f9] border border-slate-200 rounded-md text-slate-700 font-medium">1</button>
                            <button type="button" class="px-3 py-1 text-blue-600 hover:text-blue-800">Next</button>
                        </div>
                    </div>
                </div>

            </form>
        </div>

        {{-- Modal Footer --}}
        <div class="px-6 py-4 border-t border-slate-200 bg-white flex justify-end gap-3 flex-shrink-0 z-10">
            <button type="button" id="cancelGemstoneModalBtn" class="px-6 py-2.5 text-[14px] font-medium text-rose-500 bg-white border border-rose-300 rounded-md hover:bg-rose-50 transition-colors">
                Cancel
            </button>
            <button type="button" class="px-6 py-2.5 text-[14px] font-medium text-slate-800 bg-[#f1f5f9] border border-slate-200 rounded-md hover:bg-slate-200 transition-colors">
                Create and add another
            </button>
            <button type="submit" form="createGemstoneForm" class="px-8 py-2.5 text-[14px] font-medium text-white bg-blue-700 rounded-md hover:bg-blue-800 transition-colors shadow-sm active:scale-95">
                Create
            </button>
        </div>

    </div>
</div>

{{-- Add Partner Modal --}}
<div id="addPartnerModal" class="fixed inset-0 z-[10000] hidden items-center justify-center bg-slate-900/40 backdrop-blur-sm transition-opacity">
    <div class="bg-white rounded-xl shadow-2xl w-full max-w-[500px] transform transition-all p-7">
        <div class="flex justify-between items-center mb-5">
            <h3 class="text-[18px] font-bold text-slate-800">Add Partner</h3>
            <button type="button" onclick="toggleAddPartnerModal(false)" class="text-slate-400 hover:text-slate-600 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        
        <div class="bg-[#FFF6ec] border-l-4 border-[#ca8a04] text-[#854d0e] text-[13.5px] px-4 py-3.5 rounded-r-md mb-6">
            <strong class="font-bold text-[#854d0e]">Note:</strong> If the percentage of profit sharing is not specified, it will be auto-calculated based on the percentage of ownership.
        </div>

        <div class="mb-5">
            <label class="block text-[13px] font-medium text-slate-600 mb-1.5">Select Partner <span class="text-rose-500">*</span></label>
            <div class="relative w-full" id="ddAddPartnerWrapper">
                <input type="hidden" id="ddAddPartnerHidden">
                <button type="button" id="ddAddPartnerBtn" class="w-full h-[42px] border border-slate-300 rounded-md flex items-center justify-between px-3 bg-white text-left focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-all">
                    <span id="ddAddPartnerLabel" class="truncate text-slate-400 text-[14px]">Select Partner</span>
                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </button>
                <div id="ddAddPartnerPanel" class="hidden absolute z-[10001] left-0 right-0 mt-1 bg-white border border-slate-200 rounded-md shadow-lg overflow-hidden">
                    <div class="p-2 border-b border-slate-100">
                        <input type="text" id="ddAddPartnerSearch" placeholder="Search partner..." class="w-full h-[36px] border border-slate-200 rounded-md px-3 text-[14px] focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-all">
                    </div>
                    <ul id="ddAddPartnerList" class="py-1 max-h-48 overflow-y-auto custom-scrollbar">
                        <li class="dd-option flex items-center px-4 py-2 text-[14px] cursor-pointer hover:bg-slate-50 text-slate-500" data-value="" data-label="Select Partner">Select Partner</li>
                        @foreach($partners as $partner)
                            <li class="dd-option flex items-center px-4 py-2 text-[14px] cursor-pointer hover:bg-slate-50 text-slate-700" data-value="{{ $partner->idtbl_partners }}" data-label="{{ $partner->partner_name }}">{{ $partner->partner_name }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-5 mb-8">
            <div>
                <label class="block text-[13px] font-medium text-slate-600 mb-1.5">% of ownership <span class="text-rose-500">*</span></label>
                <input type="number" id="addPartnerOwnership" placeholder="E.g 20" class="w-full h-[42px] border border-slate-300 rounded-md px-3 text-[14px] text-slate-700 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-all" min="0" max="100">
            </div>
            <div>
                <label class="block text-[13px] font-medium text-slate-600 mb-1.5">% of profit sharing</label>
                <input type="number" id="addPartnerProfit" placeholder="E.g 20" class="w-full h-[42px] border border-slate-300 rounded-md px-3 text-[14px] text-slate-700 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-all" min="0" max="100">
            </div>
        </div>

        <div class="flex justify-between items-center mt-2">
            <button type="button" onclick="toggleAddPartnerModal(false)" class="px-6 py-2.5 text-[14px] font-medium text-[#ef4444] bg-white border border-[#ef4444] rounded-lg hover:bg-red-50 transition-colors">
                Cancel
            </button>
            <button type="button" id="confirmAddPartnerBtn" class="px-7 py-2.5 text-[14px] font-medium text-white bg-[#2563eb] rounded-lg hover:bg-blue-700 transition-colors shadow-sm">
                Update
            </button>
        </div>
    </div>
</div>

{{-- Product Detailed View Modal (Audit Log) --}}
<div id="auditLogViewModal" class="fixed inset-0 z-[10000] hidden items-center justify-center bg-slate-900/60 backdrop-blur-sm transition-opacity p-4">
    <div class="bg-white rounded-xl shadow-2xl w-full max-w-4xl max-h-[90vh] flex flex-col transform transition-all overflow-hidden border border-slate-200">
        {{-- Header --}}
        <div class="bg-slate-800 px-6 py-4 flex justify-between items-center text-white shrink-0">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-blue-500/20 flex items-center justify-center">
                    <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                </div>
                <div>
                    <h2 class="text-[18px] font-bold tracking-wide uppercase flex items-center gap-2">GemExhibit Enterprise <span class="text-blue-400 text-[14px] font-normal tracking-normal">- Product Detailed View</span></h2>
                    <div class="text-[12px] text-slate-300 mt-0.5 flex items-center gap-3">
                        <span class="flex items-center"><svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg> SKU: <strong id="vLogSku" class="text-white ml-1">N/A</strong></span>
                        <span class="flex items-center"><svg class="w-3.5 h-3.5 text-emerald-400 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg> Status: ACTIVE</span>
                        <span class="flex items-center"><svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg> Type: Diamond/Gemstone</span>
                    </div>
                </div>
            </div>
            <button type="button" onclick="closeAuditLogViewModal()" class="text-slate-400 hover:text-white transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
            </button>
        </div>

        {{-- Body --}}
        <div class="p-6 overflow-y-auto custom-scrollbar bg-slate-50 flex-1 text-[13px] text-slate-700">
            
            {{-- 1. Basic Details --}}
            <div class="bg-white rounded-lg border border-slate-200 p-5 mb-5 shadow-sm">
                <h3 class="text-[14px] font-bold text-slate-800 uppercase tracking-wide border-b border-slate-100 pb-2 mb-4 flex items-center gap-2">📦 1. Basic & Physical Details</h3>
                <div class="grid grid-cols-2 gap-x-6 gap-y-3">
                    <div class="col-span-2 text-[14px]"><span class="font-semibold text-slate-500 inline-block w-28">Product Title</span> : <span id="vLogTitle" class="font-bold text-slate-900"></span></div>
                    <div class="col-span-2 text-[14px] mb-2"><span class="font-semibold text-slate-500 inline-block w-28">Description</span> : <span id="vLogDesc" class="text-slate-600"></span></div>
                    
                    <div><span class="font-semibold text-slate-500 inline-block w-28">Category</span> : <span id="vLogCategory"></span></div>
                    <div><span class="font-semibold text-slate-500 inline-block w-28">Variety</span> : <span id="vLogVariety"></span></div>
                    <div><span class="font-semibold text-slate-500 inline-block w-28">Color / Grade</span> : <span id="vLogColor"></span></div>
                    <div><span class="font-semibold text-slate-500 inline-block w-28">Shape / Cut</span> : <span id="vLogShape"></span></div>
                    <div><span class="font-semibold text-slate-500 inline-block w-28">Treatment</span> : <span id="vLogTreatment"></span></div>
                    <div><span class="font-semibold text-slate-500 inline-block w-28">Origin</span> : <span id="vLogOrigin"></span></div>
                    <div class="col-span-2"><span class="font-semibold text-slate-500 inline-block w-28">Dimensions</span> : <span id="vLogDims" class="font-medium text-slate-800"></span></div>
                    <div><span class="font-semibold text-slate-500 inline-block w-28">Storage Loc.</span> : <span id="vLogStorage"></span></div>
                    <div><span class="font-semibold text-slate-500 inline-block w-28">Tray / Box</span> : <span id="vLogTray"></span></div>
                </div>
            </div>

            {{-- 2. Pricing & Inventory --}}
            <div class="bg-white rounded-lg border border-slate-200 p-5 mb-5 shadow-sm">
                <h3 class="text-[14px] font-bold text-slate-800 uppercase tracking-wide border-b border-slate-100 pb-2 mb-4 flex items-center gap-2">💰 2. Pricing & Inventory Summary</h3>
                <div class="grid grid-cols-2 gap-x-6 gap-y-3 mb-5">
                    <div><span class="font-semibold text-slate-500 inline-block w-28">Selling Unit</span> : <span id="vLogSellingUnit"></span></div>
                    <div><span class="font-semibold text-slate-500 inline-block w-28">Quantity</span> : <span id="vLogQuantity"></span> pcs</div>
                    <div><span class="font-semibold text-slate-500 inline-block w-28">Total Weight</span> : <span id="vLogWeight" class="font-medium text-slate-800"></span> ct</div>
                    <div><span class="font-semibold text-slate-500 inline-block w-28">Avg Wt/Pc</span> : <span id="vLogAvgWt"></span> ct</div>
                </div>
                
                <table class="w-full text-left border-collapse rounded-md overflow-hidden ring-1 ring-slate-200">
                    <thead class="bg-slate-100 text-slate-600 font-semibold">
                        <tr>
                            <th class="py-2.5 px-4 border-b border-slate-200">Price Type</th>
                            <th class="py-2.5 px-4 border-b border-slate-200 text-right">Per Unit Price</th>
                            <th class="py-2.5 px-4 border-b border-slate-200 text-right">Total Value</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        <tr><td class="py-2.5 px-4 font-medium">Cost Price</td><td class="py-2.5 px-4 text-right" id="vLogCostPerUnit"></td><td class="py-2.5 px-4 text-right font-medium text-slate-800" id="vLogTotalCost"></td></tr>
                        <tr><td class="py-2.5 px-4 font-medium">My Cost (Partner)</td><td class="py-2.5 px-4 text-right" id="vLogMyCostPerUnit"></td><td class="py-2.5 px-4 text-right font-medium text-slate-800" id="vLogMyTotalCost"></td></tr>
                        <tr><td class="py-2.5 px-4 font-medium">Wholesale Price</td><td class="py-2.5 px-4 text-right" id="vLogWholesalePerUnit"></td><td class="py-2.5 px-4 text-right font-medium text-slate-800" id="vLogWholesaleTotal"></td></tr>
                        <tr><td class="py-2.5 px-4 font-semibold text-blue-600">Retail Price</td><td class="py-2.5 px-4 text-right text-blue-600 font-medium" id="vLogRetailPerUnit"></td><td class="py-2.5 px-4 text-right font-bold text-blue-700" id="vLogRetailTotal"></td></tr>
                        <tr><td class="py-2.5 px-4 font-medium">Matrix Price</td><td class="py-2.5 px-4 text-right" id="vLogMatrixPerUnit"></td><td class="py-2.5 px-4 text-right font-medium text-slate-800" id="vLogMatrixTotal"></td></tr>
                    </tbody>
                </table>
            </div>

            {{-- 3 & 4 Grid --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">
                {{-- 3. Custom Pricing --}}
                <div class="bg-white rounded-lg border border-slate-200 p-5 shadow-sm opacity-50">
                    <h3 class="text-[14px] font-bold text-slate-800 uppercase tracking-wide border-b border-slate-100 pb-2 mb-4 flex items-center gap-2">🏷️ 3. Custom Pricing Tiers</h3>
                    <ul class="space-y-4">
                        <li class="flex flex-col text-slate-400">Custom pricing not implemented</li>
                    </ul>
                </div>

                {{-- 4. Purchasing --}}
                <div class="bg-white rounded-lg border border-slate-200 p-5 shadow-sm">
                    <h3 class="text-[14px] font-bold text-slate-800 uppercase tracking-wide border-b border-slate-100 pb-2 mb-4 flex items-center gap-2">🤝 4. Purchasing Info</h3>
                    <div class="space-y-3">
                        <div><span class="font-semibold text-slate-500 inline-block w-28">Supplier</span> : <span id="vLogSupplier"></span></div>
                        <div><span class="font-semibold text-slate-500 inline-block w-28">Contact</span> : <span id="vLogContact"></span></div>
                        <div><span class="font-semibold text-slate-500 inline-block w-28">Reference</span> : <span id="vLogSupplierRef"></span></div>
                        <div><span class="font-semibold text-slate-500 inline-block w-28">Date</span> : <span id="vLogPurchaseDate"></span></div>
                        <div><span class="font-semibold text-slate-500 inline-block w-28">Ownership</span> : <span id="vLogOwnership"></span></div>
                    </div>
                </div>
            </div>

            {{-- 5. Partnership --}}
            <div class="bg-white rounded-lg border border-slate-200 p-5 shadow-sm mb-2">
                <h3 class="text-[14px] font-bold text-slate-800 uppercase tracking-wide border-b border-slate-100 pb-2 mb-4 flex items-center gap-2">👥 5. Partnership & Profit Share</h3>
                <table class="w-full text-left border-collapse rounded-md overflow-hidden ring-1 ring-slate-200">
                    <thead class="bg-slate-100 text-slate-600 font-semibold">
                        <tr>
                            <th class="py-2.5 px-4 border-b border-slate-200">Company / Partner</th>
                            <th class="py-2.5 px-4 border-b border-slate-200 text-right">Ownership %</th>
                            <th class="py-2.5 px-4 border-b border-slate-200 text-right">Profit Share %</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100" id="vLogPartnersBody">
                    </tbody>
                </table>
            </div>

            {{-- Audit Context --}}
            <div class="mt-6 text-center text-[12px] text-slate-400 border-t border-slate-200 pt-4 flex items-center justify-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg> 
                <span>Log Type: <span id="vLogActionBadge" class="font-bold text-slate-500 uppercase tracking-wide"></span> | Performed by <span id="vLogUser" class="font-bold text-slate-500"></span> on <span id="vLogDate" class="font-bold text-slate-500"></span></span>
            </div>

        </div>
    </div>
</div>

{{-- Audit Log Edit Modal --}}
<div id="auditLogEditModal" class="fixed inset-0 z-[10000] hidden items-center justify-center bg-slate-900/40 backdrop-blur-sm transition-opacity">
    <div class="bg-white rounded-xl shadow-2xl w-full max-w-[400px] transform transition-all p-6 text-left">
        <h3 class="text-[18px] font-bold text-slate-800 mb-4 border-b pb-2">Edit Audit Log</h3>
        <input type="hidden" id="editLogId">
        <div class="mb-4">
            <label class="block text-[13px] font-medium text-slate-600 mb-1.5">Note</label>
            <textarea id="editLogNote" class="w-full h-[100px] border border-slate-300 rounded-md px-3 py-2 text-[14px] focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-all"></textarea>
        </div>
        <div class="flex justify-end gap-3">
            <button type="button" onclick="closeAuditLogEditModal()" class="px-5 py-2 text-[14px] font-medium text-slate-700 bg-slate-100 rounded-lg hover:bg-slate-200 transition-colors">Cancel</button>
            <button type="button" onclick="saveAuditLogEdit()" class="px-5 py-2 text-[14px] font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition-colors">Save Changes</button>
        </div>
    </div>
</div>

{{-- Validation Error Modal --}}
<div id="validationErrorModal" class="fixed inset-0 z-[10000] hidden items-center justify-center bg-slate-900/40 backdrop-blur-sm transition-opacity">
    <div class="bg-white rounded-xl shadow-2xl w-full max-w-[400px] transform transition-all p-6 text-center">
        <div class="w-16 h-16 bg-rose-100 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg class="w-8 h-8 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
        </div>
        <h3 class="text-[18px] font-bold text-slate-800 mb-2">Missing Required Fields</h3>
        <p class="text-[14px] text-slate-600 mb-4">Please fill in the following required fields before creating the product:</p>
        <div class="bg-rose-50 rounded-lg p-4 mb-6 text-left border border-rose-100">
            <ul id="validationErrorList" class="list-disc list-inside text-[13px] text-rose-700 space-y-1 font-medium">
                <!-- Errors will be injected here -->
            </ul>
        </div>
        <button type="button" onclick="closeValidationModal()" class="w-full px-6 py-2.5 text-[14px] font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition-colors shadow-sm">
            Got it, let me fix them
        </button>
    </div>
</div>

{{-- ===== JAVASCRIPT FOR MODAL & DROPDOWNS ===== --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {

        // --- Modal Toggle Logic ---
        const modal = document.getElementById('createGemstoneModal');
        const openBtn = document.getElementById('openGemstoneModalBtn');
        const closeBtn = document.getElementById('closeGemstoneModalBtn');
        const cancelBtn = document.getElementById('cancelGemstoneModalBtn');

        function toggleModal(show) {
            if (show) {
                modal.classList.remove('hidden');
                modal.classList.add('flex');
                document.body.style.overflow = 'hidden';
                const existingType = document.getElementById('ddProductTypeHidden');
                if (existingType && existingType.value) {
                    const typeId = existingType.value;
                    fetch(`{{ url('Inventory/MyInventory/next-sku') }}/${typeId}`)
                        .then(r => r.json())
                        .then(data => {
                            const prefixLabel = document.getElementById('ddSkuPrefixLabel');
                            const prefixHidden = document.getElementById('ddSkuPrefixHidden');
                            if (prefixLabel) prefixLabel.textContent = data.prefix_name || 'Prefix';
                            if (prefixHidden) prefixHidden.value = data.idtbl_skus || '';

                            const skuNumInput = document.querySelector('input[name="sku_number"]');
                            if (skuNumInput) skuNumInput.value = data.sku_code || '';
                        })
                        .catch(() => {});
                }
            } else {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
                document.body.style.overflow = '';
            }
        }

        // --- Product Type Picker → then open Modal ---
        const productTypePickerMenu = document.getElementById('productTypePickerMenu');

        openBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            productTypePickerMenu.classList.toggle('hidden');
        });

        // Close picker when clicking outside
        document.addEventListener('click', (e) => {
            if (!document.getElementById('createBtnWrapper').contains(e.target)) {
                productTypePickerMenu.classList.add('hidden');
            }
        });

        // When a product type is selected: set hidden field + fetch SKU + open modal
        document.querySelectorAll('.product-type-pick-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                const typeId   = btn.dataset.typeId;
                const typeName = btn.dataset.typeName;

                // Set the hidden product_type_id field in the modal form
                const hiddenField = document.getElementById('ddProductTypeHidden');
                if (hiddenField) hiddenField.value = typeId;

                // Show selected type in the modal header
                const typeLabel = document.getElementById('selectedProductTypeLabel');
                if (typeLabel) typeLabel.textContent = typeName;

                // Close the picker and open the modal
                productTypePickerMenu.classList.add('hidden');
                toggleModal(true);

                // AJAX: Fetch the next SKU info and available prefixes for this product type
                fetch(`{{ url('Inventory/MyInventory/next-sku') }}/${typeId}`)
                    .then(r => r.json())
                    .then(data => {
                        const prefixLabel = document.getElementById('ddSkuPrefixLabel');
                        const prefixHidden = document.getElementById('ddSkuPrefixHidden');
                        if (prefixLabel) prefixLabel.textContent = data.prefix_name || 'Prefix';
                        if (prefixHidden) prefixHidden.value = data.idtbl_skus || '';

                        const skuNumInput = document.querySelector('input[name="sku_number"]');
                        if (skuNumInput) skuNumInput.value = data.sku_code || '';
                    })
                    .catch(() => {/* silently fail */});

                // AJAX: Fetch dependent data
                fetch(`{{ url('Inventory/MyInventory/dependent-data') }}/${typeId}`)
                    .then(r => r.json())
                    .then(data => {
                        populateDropdown('ddVarietyList', data.varieties, 'idtbl_varieties', 'name', 'Select variety');
                        populateDropdown('ddSubCategoryList', data.subCategories, 'idtbl_sub_categories', 'sub_category_name', 'Unspecified');
                        populateDropdown('ddColorList', data.colors, 'idtbl_colors', 'color_name', 'Select color');
                        populateDropdown('ddShapeList', data.shapes, 'idtbl_shapes', 'name', 'Select shape');
                        populateDropdown('ddCuttingList', data.cuts, 'idtbl_cuts', 'name', 'Select cutting type');
                        populateDropdown('ddOriginList', data.origins, 'idtbl_origins', 'origin_name', 'Select origin');
                        populateDropdown('ddColorGradeList', data.colorGrades, 'idtbl_color_grade', 'grade_name', 'Select color grade');
                        populateDropdown('ddCutGradeList', data.cuttingGrades, 'idtbl_cuttinggrade', 'cuttinggradename', 'Select cut grade');
                        populateDropdown('ddClarityList', data.clarityGrades, 'idtbl_clarity_grade', 'clarity_grade_name', 'Select clarity grade');
                    })
                    .catch(err => console.error(err));
            });
        });

        function populateDropdown(listId, items, valKey, labelKey, defaultText) {
            const list = document.getElementById(listId);
            if (!list) return;
            let html = `<li class="dd-option flex items-center px-4 py-2.5 text-[14px] cursor-pointer hover:bg-slate-50 text-slate-600" data-value="" data-label="${defaultText}">${defaultText}</li>`;
            items.forEach(item => {
                html += `<li class="dd-option flex items-center px-4 py-2.5 text-[14px] cursor-pointer hover:bg-slate-50 text-slate-600" data-value="${item[valKey]}" data-label="${item[labelKey]}">${item[labelKey]}</li>`;
            });
            list.innerHTML = html;
        }

    // (openBtn click is handled by the product type picker)
        closeBtn.addEventListener('click', () => toggleModal(false));
        cancelBtn.addEventListener('click', () => toggleModal(false));



        // --- Tabs Logic ---
        const tabBtns = document.querySelectorAll('.tab-btn');
        const tabContents = document.querySelectorAll('.tab-content');

        tabBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                // Remove active state from all buttons
                tabBtns.forEach(b => {
                    b.classList.remove('active');
                    b.classList.add('text-slate-500');
                });

                // Hide all tab contents
                tabContents.forEach(c => {
                    c.classList.remove('active');
                    c.classList.add('hidden');
                    c.classList.remove('block');
                });

                // Set active state on clicked button
                btn.classList.add('active');
                btn.classList.remove('text-slate-500');

                // Show targeted tab content
                const target = document.querySelector(btn.dataset.target);
                if (target) {
                    target.classList.add('active');
                    target.classList.remove('hidden');
                    target.classList.add('block');
                }
            });
        });

        // --- Searchable Dropdowns Logic ---
        function setupSearchableDropdown(wrapperId) {
            const wrapper = document.getElementById(wrapperId);
            if (!wrapper) return;

            // Special: SKU prefix dropdown click handling (delegated from list)
            if (wrapperId === 'ddSkuPrefixWrapper') {
                const list = wrapper.querySelector('#ddSkuPrefixList');
                if (list) {
                    list.addEventListener('click', (e) => {
                        const li = e.target.closest('li');
                        if (!li) return;
                        const value = li.dataset.value ?? '';
                        const label = li.dataset.label ?? li.textContent ?? '';
                        const btnLabel = wrapper.querySelector('#ddSkuPrefixLabel');
                        const hidden = wrapper.querySelector('#ddSkuPrefixHidden');
                        if (btnLabel) btnLabel.textContent = label;
                        if (hidden) hidden.value = value;
                        // close panel
                        wrapper.querySelector('#ddSkuPrefixPanel').classList.add('hidden');
                    });
                }
            }

            const btn = wrapper.querySelector('button');
            const panel = wrapper.querySelector('.hidden.absolute');
            const hidden = wrapper.querySelector('input[type="hidden"]');
            const label = wrapper.querySelector('.truncate');
            const search = wrapper.querySelector('input[type="text"]');
            const options = wrapper.querySelectorAll('.dd-option');

            btn.addEventListener('click', function (e) {
                e.stopPropagation();
                const isOpen = !panel.classList.contains('hidden');

                // Close all other panels
                document.querySelectorAll('.searchable-dropdown .hidden.absolute').forEach(p => {
                    if (p !== panel && p.parentElement.classList.contains('searchable-dropdown')) {
                        p.classList.add('hidden');
                    }
                });

                panel.classList.toggle('hidden', isOpen);

                if (!isOpen && search) {
                    search.value = '';
                    filterOptions('');
                    setTimeout(() => search.focus(), 50);
                }
            });

            if (search) {
                search.addEventListener('input', function () {
                    filterOptions(this.value.trim().toLowerCase());
                });
            }

            function filterOptions(query) {
                options.forEach(opt => {
                    const text = (opt.getAttribute('data-label') || '').toLowerCase();
                    const match = text.includes(query);
                    opt.style.display = match ? '' : 'none';
                });
            }

            wrapper.addEventListener('click', function (e) {
                const opt = e.target.closest('.dd-option');
                if (!opt) return;

                hidden.value = opt.getAttribute('data-value');
                label.textContent = opt.getAttribute('data-label');
                label.classList.remove('text-slate-400');
                label.classList.add('text-slate-800');

                // Active style like companies/index
                options.forEach(o => o.classList.remove('bg-slate-100', 'text-slate-800', 'font-semibold'));
                opt.classList.add('bg-slate-100', 'text-slate-800', 'font-semibold');
                opt.classList.remove('text-slate-600');

                if (search) {
                    search.value = '';
                    filterOptions('');
                }
                panel.classList.add('hidden');
            });

            document.addEventListener('click', function (e) {
                if (!wrapper.contains(e.target)) panel.classList.add('hidden');
            });
        }

        // Initialize all searchable dropdowns
        document.querySelectorAll('.searchable-dropdown').forEach(dd => {
            setupSearchableDropdown(dd.id);
        });

        // --- File Upload Simulation ---
        document.querySelectorAll('.flex-col.items-center.cursor-pointer').forEach(box => {
            const fileInput = document.createElement('input');
            fileInput.type = 'file';
            fileInput.className = 'hidden';
            box.appendChild(fileInput);

            box.addEventListener('click', (e) => {
                if(e.target !== fileInput) fileInput.click();
            });

            fileInput.addEventListener('change', (e) => {
                if(e.target.files.length > 0) {
                    const span = box.querySelector('span');
                    if(span) {
                        span.textContent = e.target.files[0].name;
                        span.classList.add('truncate', 'w-full', 'px-2', 'text-center');
                    }
                    const svg = box.querySelector('svg');
                    if(svg) {
                        svg.classList.remove('text-blue-600');
                        svg.classList.add('text-emerald-500');
                    }
                    box.classList.add('border-emerald-500', 'bg-emerald-50');
                }
            });
        });


        // --- Add Cost Simulation ---
        const addCostBtn = Array.from(document.querySelectorAll('button')).find(b => b.textContent && b.textContent.includes('Add cost'));
        if (addCostBtn) {
            addCostBtn.addEventListener('click', () => {
                const grid = addCostBtn.parentElement.previousElementSibling;
                if (grid && grid.classList.contains('grid')) {
                    const clone = grid.cloneNode(true);
                    clone.querySelectorAll('input').forEach(i => i.value = '');
                    grid.parentElement.insertBefore(clone, addCostBtn.parentElement);

                    // re-bind calc
                    const inputs = clone.querySelectorAll('input');
                    if(inputs.length >= 2) {
                        inputs[0].addEventListener('input', () => {
                            const w = parseFloat(document.querySelector('input[placeholder*="Weight e.g."]')?.value) || 0;
                            const c = parseFloat(inputs[0].value) || 0;
                            if (w && c) inputs[1].value = (w * c).toFixed(2);
                            else inputs[1].value = '';
                        });
                    }
                }
            });
        }

        // --- Pricing Calculations ---
        const weightInput = document.querySelector('input[placeholder*="Weight e.g."]');

        function bindCalc(unitPlaceholder, totalPlaceholder) {
            const unitInput = document.querySelector(`input[placeholder="${unitPlaceholder}"]`);
            const totalInput = document.querySelector(`input[placeholder="${totalPlaceholder}"]`);

            if (unitInput && totalInput && weightInput) {
                const calc = () => {
                    const w = parseFloat(weightInput.value) || 0;
                    const c = parseFloat(unitInput.value) || 0;
                    if (w && c) totalInput.value = (w * c).toFixed(2);
                    else totalInput.value = '';
                };
                weightInput.addEventListener('input', calc);
                unitInput.addEventListener('input', calc);
            }
        }

        bindCalc("Cost Per/unit", "Total Cost");
        bindCalc("My cost Per/unit", "My total cost");
        bindCalc("Wholesale Cost Per/unit", "Total Wholesale Cost");
        bindCalc("Retail Cost Per/unit", "Total Retail Cost");
        bindCalc("Matrix Price Per/unit", "Total Matrix Price");

        // --- Add Partner Modal Logic ---
        const confirmAddPartnerBtn = document.getElementById('confirmAddPartnerBtn');
        const partnerRowsContainer = document.getElementById('partnerRowsContainer');
        const myOwnershipInput = document.querySelector('input[name="my_ownership_percentage"]');
        const myProfitInput = document.querySelector('input[name="my_profit_share_percentage"]');

        window.toggleAddPartnerModal = function(show) {
            const addPartnerModal = document.getElementById('addPartnerModal');
            if (!addPartnerModal) return;
            if (show) {
                addPartnerModal.classList.remove('hidden');
                addPartnerModal.classList.add('flex');
            } else {
                addPartnerModal.classList.add('hidden');
                addPartnerModal.classList.remove('flex');
                // Reset inputs
                const hiddenInput = document.getElementById('ddAddPartnerHidden');
                if(hiddenInput) hiddenInput.value = '';
                const label = document.getElementById('ddAddPartnerLabel');
                if(label) label.textContent = 'Select Partner';
                const ownership = document.getElementById('addPartnerOwnership');
                if(ownership) ownership.value = '';
                const profit = document.getElementById('addPartnerProfit');
                if(profit) profit.value = '';
            }
        };

        // Auto-calculate profit sharing based on ownership if left blank
        document.getElementById('addPartnerOwnership').addEventListener('input', function() {
            const ownershipVal = this.value;
            const profitInput = document.getElementById('addPartnerProfit');
            if(profitInput.value === '' && ownershipVal !== '') {
                profitInput.placeholder = 'E.g ' + ownershipVal;
            }
        });

        if(confirmAddPartnerBtn) {
            confirmAddPartnerBtn.addEventListener('click', function() {
                const partnerId = document.getElementById('ddAddPartnerHidden').value;
                const partnerName = document.getElementById('ddAddPartnerLabel').textContent;
                const ownership = parseFloat(document.getElementById('addPartnerOwnership').value) || 0;
                let profit = parseFloat(document.getElementById('addPartnerProfit').value);
                
                if (isNaN(profit)) {
                    profit = ownership;
                }

                if (!partnerId) {
                    alert('Please select a partner.');
                    return;
                }
                if (ownership <= 0) {
                    alert('Percentage of ownership must be greater than 0.');
                    return;
                }

                // Append new row
                const row = document.createElement('div');
                row.className = 'grid grid-cols-1 md:grid-cols-3 gap-x-6 items-center partner-row';
                row.innerHTML = `
                    <div class="relative">
                        <input type="hidden" name="partner_ids[]" value="${partnerId}">
                        <input type="text" value="${partnerName}" readonly class="form-control pl-3 pr-8 bg-slate-50 text-slate-600">
                        <div class="absolute inset-y-0 right-3 flex items-center pointer-events-none">
                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        </div>
                    </div>
                    <div class="relative">
                        <input type="text" name="ownership_percentages[]" value="${ownership}" class="form-control pl-3 pr-8 bg-slate-50 text-slate-600" readonly>
                        <div class="absolute inset-y-0 right-3 flex items-center pointer-events-none">
                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="relative flex-1">
                            <input type="text" name="profit_percentages[]" value="${profit}" class="form-control pl-3 pr-8 bg-slate-50 text-slate-600" readonly>
                            <div class="absolute inset-y-0 right-3 flex items-center pointer-events-none">
                                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                            </div>
                        </div>
                        <button type="button" class="p-1.5 text-blue-800 hover:bg-slate-100 rounded-md">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                        </button>
                        <button type="button" class="p-1.5 text-rose-500 hover:bg-rose-50 rounded-md remove-partner-btn">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        </button>
                    </div>
                `;
                partnerRowsContainer.appendChild(row);

                // Add remove listener
                row.querySelector('.remove-partner-btn').addEventListener('click', function() {
                    row.remove();
                    updateMyCompanyPercentages();
                });

                updateMyCompanyPercentages();
                toggleAddPartnerModal(false);
            });
        }

        function updateMyCompanyPercentages() {
            let totalOwnership = 0;
            let totalProfit = 0;
            document.querySelectorAll('.partner-row').forEach(row => {
                totalOwnership += parseFloat(row.querySelector('input[name="ownership_percentages[]"]').value) || 0;
                totalProfit += parseFloat(row.querySelector('input[name="profit_percentages[]"]').value) || 0;
            });

            myOwnershipInput.value = Math.max(0, 100 - totalOwnership);
            myProfitInput.value = Math.max(0, 100 - totalProfit);
        }

        // --- Dedicated Add Partner Dropdown Logic ---
        (function() {
            const wrapper = document.getElementById('ddAddPartnerWrapper');
            if (!wrapper) return;

            const btn = document.getElementById('ddAddPartnerBtn');
            const panel = document.getElementById('ddAddPartnerPanel');
            const hidden = document.getElementById('ddAddPartnerHidden');
            const label = document.getElementById('ddAddPartnerLabel');
            const search = document.getElementById('ddAddPartnerSearch');
            const list = document.getElementById('ddAddPartnerList');

            btn.addEventListener('click', function(e) {
                e.stopPropagation();
                const isOpen = !panel.classList.contains('hidden');
                panel.classList.toggle('hidden', isOpen);
                if (!isOpen && search) {
                    search.value = '';
                    filterPartnerOptions('');
                    setTimeout(() => search.focus(), 50);
                }
            });

            if (search) {
                search.addEventListener('input', function() {
                    filterPartnerOptions(this.value.trim().toLowerCase());
                });
                search.addEventListener('click', function(e) {
                    e.stopPropagation();
                });
            }

            function filterPartnerOptions(query) {
                list.querySelectorAll('.dd-option').forEach(opt => {
                    const text = (opt.getAttribute('data-label') || '').toLowerCase();
                    opt.style.display = text.includes(query) ? '' : 'none';
                });
            }

            list.addEventListener('click', function(e) {
                const opt = e.target.closest('.dd-option');
                if (!opt) return;

                hidden.value = opt.getAttribute('data-value');
                label.textContent = opt.getAttribute('data-label');
                label.classList.remove('text-slate-400');
                label.classList.add('text-slate-800');

                // Active highlight
                list.querySelectorAll('.dd-option').forEach(o => o.classList.remove('bg-slate-100', 'text-slate-800', 'font-semibold'));
                opt.classList.add('bg-slate-100', 'text-slate-800', 'font-semibold');
                opt.classList.remove('text-slate-600', 'text-slate-500');

                if (search) search.value = '';
                filterPartnerOptions('');
                panel.classList.add('hidden');
            });

            document.addEventListener('click', function(e) {
                if (!wrapper.contains(e.target)) {
                    panel.classList.add('hidden');
                }
            });
        })();

        // --- Form Validation Logic ---
        const form = document.getElementById('createGemstoneForm');
        if (form) {
            form.addEventListener('submit', function(e) {
                // Quick View validation
                const variety = document.getElementById('ddVarietyHidden') ? document.getElementById('ddVarietyHidden').value : '';
                const weight = document.querySelector('input[name="weight"]') ? document.querySelector('input[name="weight"]').value : '';
                
                // Pricing validation
                const costPerUnit = document.querySelector('input[name="cost_per_unit"]') ? document.querySelector('input[name="cost_per_unit"]').value : '';
                
                let errors = [];
                
                if (!variety) {
                    errors.push('- Variety (Quick View)');
                }
                if (!weight) {
                    errors.push('- Weight (Quick View)');
                }
                if (!costPerUnit) {
                    errors.push('- Cost/unit (Pricing)');
                }

                if (errors.length > 0) {
                    e.preventDefault(); // Prevent form submission
                    
                    // Show custom modal instead of alert
                    const errorList = document.getElementById('validationErrorList');
                    errorList.innerHTML = '';
                    errors.forEach(err => {
                        const li = document.createElement('li');
                        li.textContent = err;
                        errorList.appendChild(li);
                    });
                    
                    const errorModal = document.getElementById('validationErrorModal');
                    if(errorModal) {
                        errorModal.classList.remove('hidden');
                        errorModal.classList.add('flex');
                    }
                    
                    // Optionally, switch to the tab with the first error
                    if (!variety || !weight) {
                        document.querySelector('button[data-target="#tab-quick-view"]').click();
                    } else if (!costPerUnit) {
                        document.querySelector('button[data-target="#tab-pricing"]').click();
                    }
                }
            });
        }

        window.closeValidationModal = function() {
            const modal = document.getElementById('validationErrorModal');
            if(modal) {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }
        };

        // --- Audit Log Actions ---
        window.editProduct = function(id) {
            fetch(`/Inventory/MyInventory/product-details/${id}`)
                .then(res => res.json())
                .then(json => {
                    if (json.success && json.data.product) {
                        const p = json.data.product;
                        const pr = json.data.pricing || {};
                        const pu = json.data.purchasing || {};

                        toggleModal(true);

                        document.getElementById('edit_product_id').value = id;
                        const form = document.getElementById('createGemstoneForm');
                        form.action = "{{ route('inventory.myinventory.update') }}";

                        const submitBtn = document.getElementById('saveMediaDocsBtn') || document.querySelector('#createGemstoneForm button[type="submit"]');
                        if (submitBtn) submitBtn.innerHTML = '<i class="fa-regular fa-save mr-2"></i> Update Product';

                        function setVal(idName, val) {
                            const el = document.getElementById(idName) || document.querySelector(`[name="${idName}"]`);
                            if (el) {
                                el.value = val !== null && val !== undefined ? val : '';
                                if (el.tagName === 'SELECT' && window.jQuery) {
                                    $(el).trigger('change');
                                }
                            }
                        }

                        setVal('idtbl_product_types', p.idtbl_product_types);
                        setVal('idtbl_sub_categories', p.idtbl_sub_categories);
                        setVal('idtbl_varieties', p.idtbl_varieties);
                        setVal('idtbl_colors', p.idtbl_colors);
                        setVal('idtbl_shapes', p.idtbl_shapes);
                        setVal('idtbl_cuts', p.idtbl_cuts);
                        setVal('idtbl_treatments', p.idtbl_treatments);
                        setVal('idtbl_origins', p.idtbl_origins);
                        setVal('idtbl_color_grade', p.idtbl_color_grade);
                        setVal('idtbl_cuttinggrade', p.idtbl_cuttinggrade);
                        setVal('idtbl_clarity_grade', p.idtbl_clarity_grade);
                        setVal('idtbl_storage_locations', p.idtbl_storage_locations);
                        setVal('idtbl_tray_box', p.idtbl_tray_box);
                        setVal('idtbl_ownership_type', pu.idtbl_ownership_type || p.idtbl_ownership_type);
                        
                        setVal('length_mm', p.length_mm);
                        setVal('width_mm', p.width_mm);
                        setVal('height_mm', p.height_mm);
                        setVal('product_title', p.product_title);
                        setVal('product_description', p.product_description);

                        setVal('pricing_unit', pr.selling_unit == 2 ? 'Quantity' : 'Weight');
                        setVal('idtbl_weight_units', pr.idtbl_weight_units);
                        setVal('weight', pr.weight);
                        setVal('quantity', pr.quantity);
                        setVal('cost_per_unit', pr.cost_per_unit);
                        setVal('total_cost', pr.total_cost);
                        setVal('my_cost_per_unit', pr.my_cost_per_unit);
                        setVal('my_total_cost', pr.my_total_cost);
                        setVal('wholesale_per_unit', pr.wholesale_price_per_unit);
                        setVal('wholesale_total', pr.wholesale_total_price);
                        setVal('retail_per_unit', pr.retail_price_per_unit);
                        setVal('retail_total', pr.retail_total_price);
                        setVal('matrix_per_unit', pr.matrix_price_per_unit);
                        setVal('matrix_total', pr.matrix_total_price);

                        const quickViewTab = document.querySelector('button[data-target="#tab-quick-view"]');
                        if (quickViewTab) {
                            quickViewTab.click();
                        }
                    } else {
                        alert('Could not fetch product details.');
                    }
                })
                .catch(err => {
                    console.error('Error fetching product details:', err);
                    alert('Failed to fetch product details.');
                });
        };
        window.viewAuditLog = function(id, action, user, date) {
            document.getElementById('vLogActionBadge').textContent = action;
            document.getElementById('vLogUser').textContent = user;
            document.getElementById('vLogDate').textContent = date;
            
            // Show modal immediately with loading state
            const modal = document.getElementById('auditLogViewModal');
            document.getElementById('vLogTitle').textContent = 'Loading...';
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            
            if (!id) return;

            fetch(`/Inventory/MyInventory/product-details/${id}`)
                .then(res => res.json())
                .then(json => {
                    if (json.success && json.data.product) {
                        const p = json.data.product;
                        const pr = json.data.pricing || {};
                        const pu = json.data.purchasing || {};
                        const pt = json.data.partners || [];
                        
                        document.getElementById('vLogSku').textContent = p.sku_number || 'N/A';
                        document.getElementById('vLogTitle').textContent = p.product_title || p.category_name || 'Unspecified Product';
                        document.getElementById('vLogDesc').textContent = p.product_description || '-';
                        document.getElementById('vLogCategory').textContent = p.category_name || '-';
                        document.getElementById('vLogVariety').textContent = p.variety_name || '-';
                        
                        let colorGradeStr = p.color_grade_name ? ` / ${p.color_grade_name}` : '';
                        document.getElementById('vLogColor').textContent = (p.color_name || '-') + colorGradeStr;
                        
                        let shapeCutStr = p.cut_name ? ` / ${p.cut_name}` : '';
                        document.getElementById('vLogShape').textContent = (p.shape_name || '-') + shapeCutStr;
                        
                        document.getElementById('vLogTreatment').textContent = p.treatment_name || '-';
                        document.getElementById('vLogOrigin').textContent = p.origin_name || '-';
                        
                        const l = p.length_mm ? parseFloat(p.length_mm).toFixed(2) : '0.00';
                        const w = p.width_mm ? parseFloat(p.width_mm).toFixed(2) : '0.00';
                        const h = p.height_mm ? parseFloat(p.height_mm).toFixed(2) : '0.00';
                        document.getElementById('vLogDims').textContent = `${l} mm (L) x ${w} mm (W) x ${h} mm (H)`;
                        
                        document.getElementById('vLogStorage').textContent = p.location_name || '-';
                        document.getElementById('vLogTray').textContent = p.tray_box_name || '-';
                        
                        // Pricing
                        document.getElementById('vLogSellingUnit').textContent = pr.selling_unit == 2 ? 'Quantity' : 'Weight (ct)';
                        document.getElementById('vLogQuantity').textContent = pr.quantity || '0';
                        document.getElementById('vLogWeight').textContent = pr.weight ? parseFloat(pr.weight).toFixed(4) : '0.0000';
                        
                        let avgWt = (pr.weight && pr.quantity) ? (parseFloat(pr.weight) / parseFloat(pr.quantity)) : 0;
                        document.getElementById('vLogAvgWt').textContent = avgWt.toFixed(4);

                        const formatCurrency = (val) => val ? `Rs. ${parseFloat(val).toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2})}` : '-';

                        document.getElementById('vLogCostPerUnit').textContent = formatCurrency(pr.cost_per_unit);
                        document.getElementById('vLogTotalCost').textContent = formatCurrency(pr.total_cost);
                        document.getElementById('vLogMyCostPerUnit').textContent = formatCurrency(pr.my_cost_per_unit);
                        document.getElementById('vLogMyTotalCost').textContent = formatCurrency(pr.my_total_cost);
                        document.getElementById('vLogWholesalePerUnit').textContent = formatCurrency(pr.wholesale_price_per_unit);
                        document.getElementById('vLogWholesaleTotal').textContent = formatCurrency(pr.wholesale_total_price);
                        document.getElementById('vLogRetailPerUnit').textContent = formatCurrency(pr.retail_price_per_unit);
                        document.getElementById('vLogRetailTotal').textContent = formatCurrency(pr.retail_total_price);
                        document.getElementById('vLogMatrixPerUnit').textContent = formatCurrency(pr.matrix_price_per_unit);
                        document.getElementById('vLogMatrixTotal').textContent = formatCurrency(pr.matrix_total_price);
                        
                        // Purchasing
                        document.getElementById('vLogSupplier').textContent = pu.supplier_name || '-';
                        document.getElementById('vLogContact').textContent = pu.contact_name || '-';
                        document.getElementById('vLogSupplierRef').textContent = pu.supplier_stone_ref || '-';
                        document.getElementById('vLogPurchaseDate').textContent = pu.date_of_purchase || '-';
                        document.getElementById('vLogOwnership').textContent = pu.ownership_type_name || '-';

                        // Partners
                        const pBody = document.getElementById('vLogPartnersBody');
                        pBody.innerHTML = '';
                        if (pt.length > 0) {
                            pt.forEach(partner => {
                                const tr = document.createElement('tr');
                                tr.innerHTML = `<td class="py-2.5 px-4 font-medium text-slate-800">${partner.name}</td>
                                                <td class="py-2.5 px-4 text-right font-medium text-slate-800">${parseFloat(partner.ownership || 0).toFixed(2)} %</td>
                                                <td class="py-2.5 px-4 text-right font-medium text-slate-800">${parseFloat(partner.profit || 0).toFixed(2)} %</td>`;
                                pBody.appendChild(tr);
                            });
                        } else {
                            pBody.innerHTML = `<tr><td colspan="3" class="py-3 px-4 text-center text-slate-400">No partnership details found</td></tr>`;
                        }
                    } else {
                        document.getElementById('vLogTitle').textContent = 'Error loading product data';
                    }
                })
                .catch(err => {
                    console.error("Fetch error", err);
                    document.getElementById('vLogTitle').textContent = 'Error loading product data';
                });
        };

        window.closeAuditLogViewModal = function() {
            document.getElementById('auditLogViewModal').classList.add('hidden');
            document.getElementById('auditLogViewModal').classList.remove('flex');
        };

        window.editAuditLog = function(id, note) {
            document.getElementById('editLogId').value = id;
            document.getElementById('editLogNote').value = note;
            
            const modal = document.getElementById('auditLogEditModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        };

        window.closeAuditLogEditModal = function() {
            document.getElementById('auditLogEditModal').classList.add('hidden');
            document.getElementById('auditLogEditModal').classList.remove('flex');
        };

        window.saveAuditLogEdit = function() {
            const id = document.getElementById('editLogId').value;
            const note = document.getElementById('editLogNote').value;
            
            fetch("{{ route('inventory.myinventory.auditlog.update') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ log_id: id, note: note })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    alert('Audit log updated successfully.');
                    window.location.reload(); // Reload to see changes
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(err => {
                console.error(err);
                alert('An error occurred while updating.');
            });
        };

        window.deleteAuditLog = function(id) {
            if (confirm('Are you sure you want to delete this log?')) {
                fetch("{{ route('inventory.myinventory.auditlog.delete') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ log_id: id })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        alert('Log deleted successfully.');
                        window.location.reload();
                    } else {
                        alert('Error: ' + data.message);
                    }
                })
                .catch(err => {
                    console.error(err);
                    alert('An error occurred while deleting.');
                });
            }
        };

    });
</script>
@endsection
