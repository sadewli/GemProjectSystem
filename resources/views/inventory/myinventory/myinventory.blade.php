@extends('layouts.app')

@section('title', 'My Inventory - ShapeUP')

@section('content')
<!-- Tailwind CSS for this page -->
<script src="https://cdn.tailwindcss.com"></script>

<style>
    .tab-btn { transition: all 0.2s; border-bottom: 2px solid transparent; }
    .tab-btn.active { color: #2563eb !important; border-bottom-color: #2563eb !important; }
    .tab-content { display: none; }
    .tab-content.active { display: block !important; }

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
        <div class="relative inline-block text-left">
            <button type="button" id="createProductDropdownBtn" class="btn btn-primary flex items-center">
                <i class="fas fa-plus mr-2"></i> Create New Product
                <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                </svg>
            </button>
            <div id="createProductDropdownMenu" class="hidden absolute right-0 z-50 mt-2 w-56 origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none">
                <div class="py-1" role="none">
                    @foreach($productTypes as $type)
                        <a href="javascript:void(0)" class="text-gray-700 block px-4 py-2 text-sm hover:bg-gray-100 openGemstoneModalBtnItem" data-type-id="{{ $type->idtbl_product_types }}" data-type-name="{{ $type->name }}">{{ $type->name }}</a>
                    @endforeach
                </div>
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
                </div>
            </div>
        </div>

        {{-- Tabs Navigation --}}
        <div class="px-6 border-b border-slate-200 flex-shrink-0 bg-white flex w-full">
            <button type="button" class="tab-btn active py-3.5 font-semibold text-[14px] flex-1 text-center" data-target="#tab-quick-view">Quick View</button>
            <button type="button" class="tab-btn py-3.5 font-semibold text-[14px] flex-1 text-center text-slate-500" data-target="#tab-pricing">Pricing</button>
            <button type="button" class="tab-btn py-3.5 font-semibold text-[14px] flex-1 text-center text-slate-500" data-target="#tab-history">History</button>
        </div>

        {{-- Modal Body (Scrollable) --}}
        <div class="flex-1 overflow-y-auto custom-scrollbar bg-white relative">
            <form id="createGemstoneForm" action="#" method="POST">
                @csrf

                {{-- ================= TAB 1: QUICK VIEW ================= --}}
                <div id="tab-quick-view" class="tab-content block px-6 py-6 pb-20">

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
        {{-- Product Type --}}
        <div>
            <label class="block text-[13px] text-slate-700 mb-1.5">Product Type *</label>
            <div class="relative w-full searchable-dropdown" id="ddProductTypeWrapper">
                <input type="hidden" name="product_type_id" id="ddProductTypeHidden">
                <button type="button" id="ddProductTypeBtn" class="form-control flex items-center pl-3 pr-8 text-left">
                    <span id="ddProductTypeLabel" class="truncate text-slate-400">Select product type</span>
                </button>
                <div class="absolute inset-y-0 right-3 flex items-center pointer-events-none">
                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </div>
                <div id="ddProductTypePanel" class="hidden absolute z-50 left-0 right-0 mt-2 bg-white border border-slate-200 rounded-md shadow-lg overflow-hidden">
                    <div class="p-2 border-b border-slate-100">
                        <input type="text" id="ddProductTypeSearch" placeholder="Search..." class="form-control !h-9 px-3" />
                    </div>
                    <ul id="ddProductTypeList" class="py-1 max-h-48 overflow-y-auto custom-scrollbar">
                        @foreach($productTypes as $type)
                            <li class="dd-option flex items-center px-4 py-2.5 text-[14px] cursor-pointer hover:bg-slate-50 text-slate-600" data-value="{{ $type->idtbl_product_types }}" data-label="{{ $type->name }}">{{ $type->name }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
                        {{-- SKU --}}
                        <div>
                            <label class="block text-[13px] text-slate-700 mb-1.5">SKU</label>
                            <div class="flex gap-2">
                                <div class="relative w-1/2 searchable-dropdown" id="ddSkuPrefixWrapper">
                                    <input type="hidden" name="sku_prefix" id="ddSkuPrefixHidden" value="Prefix">
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
                                <input type="text" value="CPG8" class="form-control w-1/2 px-3">
                            </div>
                        </div>

                        {{-- Variety --}}
                        <div>
                            <label class="block text-[13px] text-slate-700 mb-1.5">Variety <span class="text-rose-500">*</span></label>
                            <div class="relative w-full searchable-dropdown" id="ddVarietyWrapper">
                                <input type="hidden" name="variety" id="ddVarietyHidden">
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
                                <input type="hidden" name="sub_category" id="ddSubCategoryHidden" value="Unspecified">
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
                            <input type="text" placeholder="Quantity" class="form-control px-3">
                        </div>

                        {{-- Dimensions --}}
                        <div>
                            <label class="block text-[13px] text-slate-700 mb-1.5">Dimensions (mm.)</label>
                            <div class="flex items-center gap-2">
                                <input type="text" placeholder="L" class="form-control px-3 text-center !rounded-md">
                                <span class="text-slate-600 font-medium text-[13px]">x</span>
                                <input type="text" placeholder="W" class="form-control px-3 text-center !rounded-md">
                                <span class="text-slate-600 font-medium text-[13px]">x</span>
                                <input type="text" placeholder="H" class="form-control px-3 text-center !rounded-md">
                            </div>
                        </div>

                        {{-- Weight --}}
                        <div>
                            <label class="block text-[13px] text-slate-700 mb-1.5">Weight <span class="text-rose-500">*</span></label>
                            <div class="flex gap-2">
                                <input type="text" placeholder='Weight e.g. "1.2"' class="form-control flex-1 px-3">
                                <div class="relative w-[85px] searchable-dropdown" id="ddWeightUnitWrapper">
                                    <input type="hidden" name="weight_unit" id="ddWeightUnitHidden" value="ct">
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
                                <input type="hidden" name="color" id="ddColorHidden">
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
                                <input type="hidden" name="shape" id="ddShapeHidden">
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
                                <input type="hidden" name="cutting_type" id="ddCuttingHidden">
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
                                <input type="hidden" name="color_grade" id="ddColorGradeHidden">
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
                                <input type="hidden" name="clarity_grade" id="ddClarityHidden">
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
                                <input type="hidden" name="cut_grade" id="ddCutGradeHidden">
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
                                <input type="hidden" name="origin" id="ddOriginHidden">
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
                                <input type="hidden" name="treatment" id="ddTreatmentHidden">
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
                                    </ul>
                                </div>
                            </div>
                        </div>

                        {{-- Storage locations --}}
                        <div>
                            <label class="block text-[13px] text-slate-700 mb-1.5">Storage locations</label>
                            <div class="relative w-full searchable-dropdown" id="ddStorageWrapper">
                                <input type="hidden" name="storage" id="ddStorageHidden">
                                <button type="button" id="ddStorageBtn" class="form-control flex items-center pl-3 pr-8 text-left">
                                    <span id="ddStorageLabel" class="truncate text-slate-400">Select storage location</span>
                                </button>
                                <div class="absolute inset-y-0 right-3 flex items-center pointer-events-none">
                                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </div>
                                <div id="ddStoragePanel" class="hidden absolute z-50 left-0 right-0 mt-2 bg-white border border-slate-200 rounded-md shadow-lg overflow-hidden">
                                    <ul id="ddStorageList" class="py-1 max-h-48 overflow-y-auto custom-scrollbar">
                                        <li class="dd-option flex items-center px-4 py-2.5 text-[14px] cursor-pointer hover:bg-slate-50 text-slate-600" data-value="" data-label="Select storage location">Select storage location</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        {{-- Trays/Boxes# --}}
                        <div>
                            <label class="block text-[13px] text-slate-700 mb-1.5">Trays/Boxes#</label>
                            <div class="relative w-full searchable-dropdown" id="ddTraysWrapper">
                                <input type="hidden" name="trays" id="ddTraysHidden">
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
                                <input type="hidden" name="supplier" id="ddSupplierHidden">
                                <button type="button" id="ddSupplierBtn" class="form-control flex items-center pl-3 pr-8 text-left">
                                    <span id="ddSupplierLabel" class="truncate text-slate-400">Select Supplier ref/name</span>
                                </button>
                                <div class="absolute inset-y-0 right-3 flex items-center pointer-events-none">
                                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </div>
                                <div id="ddSupplierPanel" class="hidden absolute z-50 left-0 right-0 mt-2 bg-white border border-slate-200 rounded-md shadow-lg overflow-hidden">
                                    <ul id="ddSupplierList" class="py-1 max-h-48 overflow-y-auto custom-scrollbar">
                                        <li class="dd-option flex items-center px-4 py-2.5 text-[14px] cursor-pointer hover:bg-slate-50 text-slate-600" data-value="" data-label="Select Supplier ref/name">Select Supplier ref/name</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        {{-- Date of purchase --}}
                        <div>
                            <label class="block text-[13px] text-slate-700 mb-1.5">Date of purchase</label>
                            <input type="text" placeholder="Date of purchase" class="form-control px-3">
                        </div>

                        {{-- Ownership type --}}
                        <div>
                            <label class="block text-[13px] text-slate-700 mb-1.5">Ownership type</label>
                            <div class="relative w-full searchable-dropdown" id="ddOwnershipWrapper">
                                <input type="hidden" name="ownership_type" id="ddOwnershipHidden">
                                <button type="button" id="ddOwnershipBtn" class="form-control flex items-center pl-3 pr-8 text-left">
                                    <span id="ddOwnershipLabel" class="truncate text-slate-400">Select Ownership Type</span>
                                </button>
                                <div class="absolute inset-y-0 right-3 flex items-center pointer-events-none">
                                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </div>
                                <div id="ddOwnershipPanel" class="hidden absolute z-50 left-0 right-0 mt-2 bg-white border border-slate-200 rounded-md shadow-lg overflow-hidden">
                                    <ul id="ddOwnershipList" class="py-1 max-h-48 overflow-y-auto custom-scrollbar">
                                        <li class="dd-option flex items-center px-4 py-2.5 text-[14px] cursor-pointer hover:bg-slate-50 text-slate-600" data-value="" data-label="Select Ownership Type">Select Ownership Type</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        {{-- Partners --}}
                        <div>
                            <label class="block text-[13px] text-slate-700 mb-1.5">Partners</label>
                            <div class="relative">
                                <input type="text" value="My company" class="form-control pl-3 pr-8">
                                <div class="absolute inset-y-0 right-3 flex items-center pointer-events-none">
                                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                                </div>
                            </div>
                        </div>

                        {{-- % of ownership --}}
                        <div>
                            <label class="block text-[13px] text-slate-700 mb-1.5">% of ownership</label>
                            <div class="relative">
                                <input type="text" value="100" class="form-control pl-3 pr-8">
                                <div class="absolute inset-y-0 right-3 flex items-center pointer-events-none">
                                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                                </div>
                            </div>
                        </div>

                        {{-- % of profit share --}}
                        <div>
                            <label class="block text-[13px] text-slate-700 mb-1.5">% of profit share</label>
                            <div class="flex items-center gap-2">
                                <div class="relative flex-1">
                                    <input type="text" value="100" class="form-control pl-3 pr-8">
                                    <div class="absolute inset-y-0 right-3 flex items-center pointer-events-none">
                                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                                    </div>
                                </div>
                                <button type="button" class="p-1.5 text-blue-800 hover:bg-slate-100 rounded-md">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                </button>
                            </div>
                            <div class="flex justify-end mt-2">
                                <button type="button" class="px-3 py-1.5 bg-[#f1f5f9] text-[13px] text-slate-700 font-medium rounded-md hover:bg-slate-200">Add partner</button>
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
                            <input type="text" placeholder="Cost Per/unit" class="form-control px-3">
                        </div>
                        <div>
                            <label class="block text-[13px] text-slate-700 mb-1.5 flex items-center gap-1">Total cost <svg class="w-3.5 h-3.5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg></label>
                            <input type="text" placeholder="Total Cost" class="form-control px-3">
                        </div>
                        <div>
                            <label class="block text-[13px] text-slate-700 mb-1.5">My cost/unit</label>
                            <input type="text" placeholder="My cost Per/unit" class="form-control px-3">
                        </div>
                        <div>
                            <label class="block text-[13px] text-slate-700 mb-1.5 flex items-center gap-1">My total cost <svg class="w-3.5 h-3.5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg></label>
                            <input type="text" placeholder="My total cost" class="form-control px-3">
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
                            <input type="text" placeholder="Wholesale Cost Per/unit" class="form-control px-3">
                        </div>
                        <div>
                            <label class="block text-[13px] text-slate-700 mb-1.5">Wholesale total</label>
                            <input type="text" placeholder="Total Wholesale Cost" class="form-control px-3">
                        </div>
                        <div>
                            <label class="block text-[13px] text-slate-700 mb-1.5">Retail / unit</label>
                            <input type="text" placeholder="Retail Cost Per/unit" class="form-control px-3">
                        </div>
                        <div>
                            <label class="block text-[13px] text-slate-700 mb-1.5">Retail total</label>
                            <input type="text" placeholder="Total Retail Cost" class="form-control px-3">
                        </div>
                        <div>
                            <label class="block text-[13px] text-slate-700 mb-1.5">Matrix / unit</label>
                            <input type="text" placeholder="Matrix Price Per/unit" class="form-control px-3">
                        </div>
                        <div>
                            <label class="block text-[13px] text-slate-700 mb-1.5">Matrix total</label>
                            <input type="text" placeholder="Total Matrix Price" class="form-control px-3">
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
                                </tr>
                            </thead>
                            <tbody class="text-slate-700 bg-white">
                                <tr class="border-b border-slate-50 hover:bg-slate-50">
                                    <td class="px-4 py-3">2026-04-23</td>
                                    <td class="px-4 py-3">13:37:24</td>
                                    <td class="px-4 py-3">Sachintha Kaveen</td>
                                    <td class="px-4 py-3">Created</td>
                                    <td class="px-4 py-3">-</td>
                                    <td class="px-4 py-3">-</td>
                                    <td class="px-4 py-3 truncate max-w-[200px]">Manually created From a...</td>
                                </tr>
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

{{-- ===== JAVASCRIPT FOR MODAL & DROPDOWNS ===== --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {

        // --- Modal Toggle Logic ---
        const modal = document.getElementById('createGemstoneModal');
        const closeBtn = document.getElementById('closeGemstoneModalBtn');
        const cancelBtn = document.getElementById('cancelGemstoneModalBtn');

        function toggleModal(show) {
            if (show) {
                modal.classList.remove('hidden');
                modal.classList.add('flex');
                document.body.style.overflow = 'hidden';
            } else {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
                document.body.style.overflow = '';
            }
        }

        // Dropdown Logic
        const dropdownBtn = document.getElementById('createProductDropdownBtn');
        const dropdownMenu = document.getElementById('createProductDropdownMenu');
        
        if (dropdownBtn && dropdownMenu) {
            dropdownBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                dropdownMenu.classList.toggle('hidden');
            });
            
            document.addEventListener('click', (e) => {
                if (!dropdownBtn.contains(e.target) && !dropdownMenu.contains(e.target)) {
                    dropdownMenu.classList.add('hidden');
                }
            });
        }

        document.querySelectorAll('.openGemstoneModalBtnItem').forEach(item => {
            item.addEventListener('click', function(e) {
                e.preventDefault();
                dropdownMenu.classList.add('hidden');
                toggleModal(true);
            });
        });

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

                // Hide all tab contents using Tailwind's 'hidden' class
                tabContents.forEach(c => {
                    c.classList.add('hidden');
                    c.classList.remove('block');
                });

                // Set active state on clicked button
                btn.classList.add('active');
                btn.classList.remove('text-slate-500');

                // Show targeted tab content using Tailwind's 'block' class
                const target = document.querySelector(btn.dataset.target);
                if (target) {
                    target.classList.remove('hidden');
                    target.classList.add('block');
                }
            });
        });

        // --- Searchable Dropdowns Logic ---
        function setupSearchableDropdown(wrapperId) {
            const wrapper = document.getElementById(wrapperId);
            if (!wrapper) return;

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

        // --- Add Partner Simulation ---
        const addPartnerBtn = Array.from(document.querySelectorAll('button')).find(b => b.textContent && b.textContent.includes('Add partner'));
        if (addPartnerBtn) {
            addPartnerBtn.addEventListener('click', () => {
                const grid = addPartnerBtn.closest('.grid');
                if(grid) {
                    const children = Array.from(grid.children);
                    const partnersDiv = children[children.length - 3].cloneNode(true);
                    const ownershipDiv = children[children.length - 2].cloneNode(true);
                    const profitDiv = children[children.length - 1].cloneNode(true);

                    const btnContainer = profitDiv.querySelector('.flex.mt-2');
                    if(btnContainer) btnContainer.remove();

                    partnersDiv.querySelector('input').value = '';
                    ownershipDiv.querySelector('input').value = '';
                    profitDiv.querySelector('input').value = '';

                    grid.appendChild(partnersDiv);
                    grid.appendChild(ownershipDiv);
                    grid.appendChild(profitDiv);
                }
            });
        }

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

    });
</script>
@endsection
