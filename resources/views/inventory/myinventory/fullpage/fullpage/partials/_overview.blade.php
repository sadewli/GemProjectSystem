<div id="tab-overview" class="tab-content active flex flex-col gap-6">
    {{-- Basic Information --}}
    <div class="card !mb-0">
        <h2 class="card-title">Basic information</h2>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-x-6 gap-y-6">
            {{-- Row 1 --}}
            <div class="form-group">
                <label>SKU</label>
                <span class="sub-label">Your unique stock keeping number</span>
                <div class="flex gap-2">
                    <div class="relative w-[100px] custom-select-wrapper">
                    <input type="hidden" name="idtbl_skus" id="hiddenPrefixIdFullpage" value="">
                    <button type="button" id="prefixDropdownBtnFullpage" class="form-control flex items-center pl-3 pr-6 text-left">
                            <span class="truncate text-slate-800 selected-text" id="skuPrefixTextFullpage">Prefix</span>
                        </button>
                        <div class="absolute inset-y-0 right-2 flex items-center pointer-events-none">
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </div>
                        <div class="custom-dropdown-panel">
                            <div class="p-2 hover:bg-slate-50 cursor-pointer text-[13px] px-3 dd-item" data-value="">Prefix</div>
                        @foreach($skus as $sku)
                            <div class="p-2 hover:bg-slate-50 cursor-pointer text-[13px] px-3 dd-item" data-value="{{ $sku->idtbl_skus }}">{{ $sku->name ?? $sku->idtbl_skus }}</div>
                        @endforeach
                        </div>
                    </div>
                    <input type="text" name="sku_number" id="skuNumberInputFullpage" value="{{ old('sku_number','') }}" class="form-control flex-1 px-3 text-slate-800">
                </div>
            </div>

            <div class="form-group">
                <label>Category</label>
                <span class="sub-label">Category e.g "Single, Parcel, Pair, Set"</span>
                <div class="relative">
                    <input type="hidden" name="idtbl_product_types" value="{{ $productTypes->first()->idtbl_product_types ?? '' }}">
                    <input type="text" value="{{ $productTypes->first()->product_type ?? 'Gemstone' }}" readonly class="form-control px-3 bg-slate-50/50 text-slate-500">
                    <div class="absolute inset-y-0 right-3 flex items-center pointer-events-none">
                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label>Sub-Category</label>
                <span class="sub-label">Product sub-category e.g "Single, Parcel, Pair, Set"</span>
                <div class="relative w-full custom-select-wrapper">
                    <input type="hidden" name="idtbl_sub_categories" value="">
                    <button type="button" class="form-control flex items-center pl-3 pr-8 text-left">
                        <span class="truncate text-slate-800 selected-text">Unspecified</span>
                    </button>
                    <div class="absolute inset-y-0 right-3 flex items-center pointer-events-none">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </div>
                    <div class="custom-dropdown-panel">
                        <div class="p-2 hover:bg-slate-50 cursor-pointer text-[13px] px-3 dd-item" data-value="">Unspecified</div>
                        @foreach($subCategories as $subCategory)
                            <div class="p-2 hover:bg-slate-50 cursor-pointer text-[13px] px-3 dd-item" data-value="{{ $subCategory->idtbl_sub_categories }}">{{ $subCategory->subcategory ?? $subCategory->name ?? $subCategory->idtbl_sub_categories }}</div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Row 2 --}}
            <div class="form-group">
                <label>Variety</label>
                <span class="sub-label">Type of gemstone(s) e.g "Sapphire, Ruby, Emerald"</span>
                <div class="relative w-full custom-select-wrapper">
                    <input type="hidden" name="idtbl_varieties" value="">
                    <button type="button" class="form-control flex items-center pl-3 pr-8 text-left">
                        <span class="truncate text-slate-400 selected-text">Select variety</span>
                    </button>
                    <div class="absolute inset-y-0 right-3 flex items-center pointer-events-none">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </div>
                    <div class="custom-dropdown-panel">
                        <div class="p-2 hover:bg-slate-50 cursor-pointer text-[13px] px-3 dd-item" data-value="">Select variety</div>
                        @foreach($varieties as $variety)
                            <div class="p-2 hover:bg-slate-50 cursor-pointer text-[13px] px-3 dd-item" data-value="{{ $variety->idtbl_varieties }}">{{ $variety->variety ?? $variety->name ?? $variety->idtbl_varieties }}</div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label>Color</label>
                <span class="sub-label">Color of your gemstone(s) e.g "Blue, Red, Green"</span>
                <div class="relative w-full custom-select-wrapper">
                    <input type="hidden" name="idtbl_colors" value="">
                    <button type="button" class="form-control flex items-center pl-3 pr-8 text-left">
                        <span class="truncate text-slate-400 selected-text">Select color</span>
                    </button>
                    <div class="absolute inset-y-0 right-3 flex items-center pointer-events-none">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </div>
                    <div class="custom-dropdown-panel">
                        <div class="p-2 hover:bg-slate-50 cursor-pointer text-[13px] px-3 dd-item" data-value="">Select color</div>
                        @foreach($colors as $color)
                            <div class="p-2 hover:bg-slate-50 cursor-pointer text-[13px] px-3 dd-item" data-value="{{ $color->idtbl_colors }}">{{ $color->color ?? $color->name ?? $color->idtbl_colors }}</div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label>Shape</label>
                <span class="sub-label">Shape of your gemstone(s) e.g "Round, Oval, Cushion, Pear"</span>
                <div class="relative w-full custom-select-wrapper">
                    <input type="hidden" name="idtbl_shapes" value="">
                    <button type="button" class="form-control flex items-center pl-3 pr-8 text-left">
                        <span class="truncate text-slate-400 selected-text">Select shape</span>
                    </button>
                    <div class="absolute inset-y-0 right-3 flex items-center pointer-events-none">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </div>
                    <div class="custom-dropdown-panel">
                        <div class="p-2 hover:bg-slate-50 cursor-pointer text-[13px] px-3 dd-item" data-value="">Select shape</div>
                        @foreach($shapes as $shape)
                            <div class="p-2 hover:bg-slate-50 cursor-pointer text-[13px] px-3 dd-item" data-value="{{ $shape->idtbl_shapes }}">{{ $shape->shape ?? $shape->name ?? $shape->idtbl_shapes }}</div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Row 3 --}}
            <div class="form-group">
                <label>Cutting type</label>
                <span class="sub-label">Cutting type of your gemstone(s) e.g "Diamond cut, Step ..."</span>
                <div class="relative w-full custom-select-wrapper">
                    <input type="hidden" name="idtbl_cuts" value="">
                    <button type="button" class="form-control flex items-center pl-3 pr-8 text-left">
                        <span class="truncate text-slate-400 selected-text">Select cutting type</span>
                    </button>
                    <div class="absolute inset-y-0 right-3 flex items-center pointer-events-none">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </div>
                    <div class="custom-dropdown-panel">
                        <div class="p-2 hover:bg-slate-50 cursor-pointer text-[13px] px-3 dd-item" data-value="">Select cutting type</div>
                        @foreach($cuts as $cut)
                            <div class="p-2 hover:bg-slate-50 cursor-pointer text-[13px] px-3 dd-item" data-value="{{ $cut->idtbl_cuts }}">{{ $cut->cut ?? $cut->name ?? $cut->idtbl_cuts }}</div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label>Treatment</label>
                <span class="sub-label">Type of treatment e.g "Unheated, Heated, Oiled"</span>
                <div class="relative w-full custom-select-wrapper">
                    <input type="hidden" name="idtbl_treatments" value="">
                    <button type="button" class="form-control flex items-center pl-3 pr-8 text-left">
                        <span class="truncate text-slate-400 selected-text">Select treatment</span>
                    </button>
                    <div class="absolute inset-y-0 right-3 flex items-center pointer-events-none">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </div>
                    <div class="custom-dropdown-panel">
                        <div class="p-2 hover:bg-slate-50 cursor-pointer text-[13px] px-3 dd-item" data-value="">Select treatment</div>
                        @foreach($treatments as $treatment)
                            <div class="p-2 hover:bg-slate-50 cursor-pointer text-[13px] px-3 dd-item" data-value="{{ $treatment->idtbl_treatments }}">{{ $treatment->treatment ?? $treatment->name ?? $treatment->idtbl_treatments }}</div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label>Origin</label>
                <span class="sub-label">Geographic origin of your gemstone(s) e.g "Sri Lanka, Mya..."</span>
                <div class="relative w-full custom-select-wrapper">
                    <input type="hidden" name="idtbl_origins" value="">
                    <button type="button" class="form-control flex items-center pl-3 pr-8 text-left">
                        <span class="truncate text-slate-400 selected-text">Select origin</span>
                    </button>
                    <div class="absolute inset-y-0 right-3 flex items-center pointer-events-none">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </div>
                    <div class="custom-dropdown-panel">
                        <div class="p-2 hover:bg-slate-50 cursor-pointer text-[13px] px-3 dd-item" data-value="">Select origin</div>
                        @foreach($origins as $origin)
                            <div class="p-2 hover:bg-slate-50 cursor-pointer text-[13px] px-3 dd-item" data-value="{{ $origin->idtbl_origins }}">{{ $origin->origin ?? $origin->name ?? $origin->idtbl_origins }}</div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Row 4 --}}
            <div class="form-group">
                <label>Color grade</label>
                <span class="sub-label">Enter your own color grade. To manage your color grades <a href="#" class="text-blue-600 hover:underline">clic...</a></span>
                <div class="relative w-full custom-select-wrapper">
                    <input type="hidden" name="idtbl_color_grade" value="">
                    <button type="button" class="form-control flex items-center pl-3 pr-8 text-left">
                        <span class="truncate text-slate-400 selected-text">Select color grade</span>
                    </button>
                    <div class="absolute inset-y-0 right-3 flex items-center pointer-events-none">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </div>
                    <div class="custom-dropdown-panel">
                        <div class="p-2 hover:bg-slate-50 cursor-pointer text-[13px] px-3 dd-item" data-value="">Select color grade</div>
                        @foreach($colorGrades as $colorGrade)
                            <div class="p-2 hover:bg-slate-50 cursor-pointer text-[13px] px-3 dd-item" data-value="{{ $colorGrade->idtbl_color_grade }}">{{ $colorGrade->color_grade ?? $colorGrade->name ?? $colorGrade->idtbl_color_grade }}</div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label>Cut grade</label>
                <span class="sub-label">Enter your own cut grade. To manage your cut grades <a href="#" class="text-blue-600 hover:underline">clic...</a></span>
                <div class="relative w-full custom-select-wrapper">
                    <input type="hidden" name="idtbl_cuttinggrade" value="">
                    <button type="button" class="form-control flex items-center pl-3 pr-8 text-left">
                        <span class="truncate text-slate-400 selected-text">Select cut grade</span>
                    </button>
                    <div class="absolute inset-y-0 right-3 flex items-center pointer-events-none">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </div>
                    <div class="custom-dropdown-panel">
                        <div class="p-2 hover:bg-slate-50 cursor-pointer text-[13px] px-3 dd-item" data-value="">Select cut grade</div>
                        @foreach($cutGrades as $cutGrade)
                            <div class="p-2 hover:bg-slate-50 cursor-pointer text-[13px] px-3 dd-item" data-value="{{ $cutGrade->idtbl_cuttinggrade }}">{{ $cutGrade->cuttinggrade ?? $cutGrade->name ?? $cutGrade->idtbl_cuttinggrade }}</div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label>Clarity grade</label>
                <span class="sub-label">Enter your own clarity grade. To manage your clarity grad...</span>
                <div class="relative w-full custom-select-wrapper">
                    <input type="hidden" name="idtbl_clarity_grade" value="">
                    <button type="button" class="form-control flex items-center pl-3 pr-8 text-left">
                        <span class="truncate text-slate-400 selected-text">Select clarity grade</span>
                    </button>
                    <div class="absolute inset-y-0 right-3 flex items-center pointer-events-none">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </div>
                    <div class="custom-dropdown-panel">
                        <div class="p-2 hover:bg-slate-50 cursor-pointer text-[13px] px-3 dd-item" data-value="">Select clarity grade</div>
                        @foreach($clarityGrades as $clarityGrade)
                            <div class="p-2 hover:bg-slate-50 cursor-pointer text-[13px] px-3 dd-item" data-value="{{ $clarityGrade->idtbl_clarity_grade }}">{{ $clarityGrade->clarity_grade ?? $clarityGrade->name ?? $clarityGrade->idtbl_clarity_grade }}</div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Row 5 --}}
            <div class="form-group">
                <label>Dimensions</label>
                <span class="sub-label">Dimensions of your gemstone(s) in millimeters</span>
                <div class="flex items-center gap-1.5">
                    <input type="text" name="length_mm" placeholder="Length(mm)" class="form-control px-2 text-center text-[12px] !rounded-lg">
                    <span class="text-slate-600 font-bold text-[11px]">x</span>
                    <input type="text" name="width_mm" placeholder="Width(mm)" class="form-control px-2 text-center text-[12px] !rounded-lg">
                    <span class="text-slate-600 font-bold text-[11px]">x</span>
                    <input type="text" name="height_mm" placeholder="Height(mm)" class="form-control px-2 text-center text-[12px] !rounded-lg">
                </div>
            </div>

            <div class="form-group">
                <label>Storage locations</label>
                <span class="sub-label">Storage location of your product.</span>
                <div class="relative w-full custom-select-wrapper">
                    <input type="hidden" name="idtbl_storage_locations" value="">
                    <button type="button" class="form-control flex items-center pl-3 pr-8 text-left">
                        <span class="truncate text-slate-400 selected-text">Select storage location</span>
                    </button>
                    <div class="absolute inset-y-0 right-3 flex items-center pointer-events-none">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </div>
                    <div class="custom-dropdown-panel">
                        <div class="p-2 hover:bg-slate-50 cursor-pointer text-[13px] px-3 dd-item" data-value="">Select storage location</div>
                        @foreach($storageLocations as $storageLocation)
                            <div class="p-2 hover:bg-slate-50 cursor-pointer text-[13px] px-3 dd-item" data-value="{{ $storageLocation->idtbl_storage_locations }}">{{ $storageLocation->storage_location ?? $storageLocation->name ?? $storageLocation->idtbl_storage_locations }}</div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label>Select tray / box#</label>
                <span class="sub-label">Tray/Box numbe rof your product.</span>
                <div class="relative w-full custom-select-wrapper">
                    <input type="hidden" name="idtbl_tray_box" value="">
                    <button type="button" class="form-control flex items-center pl-3 pr-8 text-left">
                        <span class="truncate text-slate-400 selected-text">Select tray / box#</span>
                    </button>
                    <div class="absolute inset-y-0 right-3 flex items-center pointer-events-none">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </div>
                    <div class="custom-dropdown-panel">
                        <div class="p-2 hover:bg-slate-50 cursor-pointer text-[13px] px-3 dd-item" data-value="">Select tray / box#</div>
                        @foreach($trayBoxes as $trayBox)
                            <div class="p-2 hover:bg-slate-50 cursor-pointer text-[13px] px-3 dd-item" data-value="{{ $trayBox->idtbl_tray_box }}">{{ $trayBox->tray_box ?? $trayBox->name ?? $trayBox->idtbl_tray_box }}</div>
                        @endforeach
                    </div>
                </div>
            </div>

        </div>
    </div>

    {{-- Product Summary & Description --}}
    <div class="card">
        <h2 class="card-title">Product summary & description</h2>
        <div class="form-group mb-5">
            <label>Product title</label>
            <span class="sub-label">Name of the gemstone for listing and identification</span>
            <input type="text" name="product_title" placeholder="Product title" class="form-control px-3">
        </div>
        <div class="form-group">
            <label>Product description</label>
            <span class="sub-label">Product description specific to your gemstone(s) e.g "The overall quality of this gemstone(s) is exceptional and very rare"</span>
            <textarea name="product_description" placeholder="Product description" class="form-control px-3 py-2 h-24 resize-none"></textarea>
        </div>
    </div>

    {{-- Purchasing Details --}}
    <div class="card">
        <h2 class="card-title">Purchasing details</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-x-6 gap-y-6 mb-8">
            <div class="form-group">
                <label>Supplier ref/name</label>
                <span class="sub-label">Identifies the reference or name of the supplier who provi...</span>
                <div class="relative w-full custom-select-wrapper">
                    <input type="hidden" name="idtbl_suppliers" value="">
                    <button type="button" class="form-control flex items-center pl-3 pr-8 text-left">
                        <span class="truncate text-slate-400 selected-text">Select Supplier ref/name</span>
                    </button>
                    <div class="absolute inset-y-0 right-3 flex items-center pointer-events-none">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </div>
                    <div class="custom-dropdown-panel">
                        <div class="p-2 hover:bg-slate-50 cursor-pointer text-[13px] px-3 dd-item" data-value="">Select Supplier ref/name</div>
                        @foreach($suppliers as $supplier)
                            <div class="p-2 hover:bg-slate-50 cursor-pointer text-[13px] px-3 dd-item" data-value="{{ $supplier->idtbl_suppliers }}">{{ $supplier->supplier_name ?? $supplier->name ?? $supplier->idtbl_suppliers }}</div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label>Supplier stone ref.</label>
                <span class="sub-label">A unique reference for the specific stone provided by the ...</span>
                <input type="text" name="supplier_stone_ref" placeholder="Supplier stone ref." class="form-control px-3">
            </div>

            <div class="form-group">
                <label>Date of purchase</label>
                <span class="sub-label">The date on which the gemstone or product was acquired...</span>
                <input type="text" name="date_of_purchase" placeholder="Date of purchase" class="form-control px-3">
            </div>

            <div class="form-group">
                <label>Ownership Type</label>
                <span class="sub-label">Typically who is the actual purchaser and owner of the ge...</span>
                <div class="relative w-full custom-select-wrapper">
                    <input type="hidden" name="idtbl_ownership_type" value="">
                    <button type="button" class="form-control flex items-center pl-3 pr-8 text-left">
                        <span class="truncate text-slate-400 selected-text">Select Ownership Type</span>
                    </button>
                    <div class="absolute inset-y-0 right-3 flex items-center pointer-events-none">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </div>
                        <div class="custom-dropdown-panel">
                            <div class="p-2 hover:bg-slate-50 cursor-pointer text-[13px] px-3 dd-item" data-value="">Select Ownership Type</div>
                            @foreach($ownershipTypes as $ownershipType)
                                <div class="p-2 hover:bg-slate-50 cursor-pointer text-[13px] px-3 dd-item" data-value="{{ $ownershipType->idtbl_ownership_type }}">{{ $ownershipType->ownership_type_name ?? $ownershipType->ownership_type ?? $ownershipType->name ?? $ownershipType->idtbl_ownership_type }}</div>
                            @endforeach
                        </div>
                </div>
            </div>
        </div>

        {{-- Manage Partners Button (Appears when Partner is selected) --}}
        <div id="manage_partners_section" style="display: none;" class="mb-6">
            <div class="p-4 bg-slate-50 border border-slate-200 rounded-lg flex justify-between items-center">
                <div>
                    <h4 class="text-slate-800 font-semibold text-[14px]">Partnership Configured</h4>
                    <p class="text-slate-500 text-[12px]">Ownership is split with partners. Click manage to adjust.</p>
                </div>
                <button type="button" id="open_partners_modal" class="px-4 py-2 bg-white border border-slate-200 rounded-lg text-[13px] font-semibold text-slate-700 hover:bg-slate-100">Manage Partners</button>
            </div>
                <div id="partners_preview" class="mt-4">
                    <div class="table-responsive">
                        <table class="table table-sm align-middle">
                            <thead class="text-muted small">
                                <tr>
                                    <th style="width:52%">Partner</th>
                                    <th style="width:16%">% of ownership</th>
                                    <th style="width:16%">% of profit share</th>
                                    <th style="width:16%" class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody id="partners_preview_rows">
                                {{-- preview rows will be injected here by JS to mirror modal rows --}}
                            </tbody>
                        </table>
                    </div>
                    <!-- Inline Add Partner button, shown only when Partners section is active -->
                    <div class="text-right mt-2" id="inline_add_partner_wrapper" style="display:none;">
                        <button type="button" id="add_partner_inline_btn" class="px-3 py-1.5 bg-slate-200 text-sm rounded hover:bg-slate-300">Add Partner</button>
                    </div>
                </div>
            </div>
        </div>

        {{-- Partners Modal --}}
        <div id="partners_modal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50" style="display: none;">
            <div class="bg-white rounded-xl shadow-xl w-full max-w-4xl p-6 relative max-h-[90vh] overflow-y-auto">
                <button type="button" id="close_partners_modal" class="absolute top-4 right-4 text-slate-400 hover:text-slate-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
                
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-[18px] font-bold text-slate-800">Add Partners</h3>
                    <button type="button" id="add_partner_btn" class="px-3 py-1.5 bg-blue-50 text-[12px] text-blue-600 font-semibold rounded-lg hover:bg-blue-100">+ Add partner</button>
                </div>

                <div class="grid grid-cols-12 gap-4 text-[12px] font-medium text-slate-500 mb-2 px-1">
                    <div class="col-span-5">Partner</div>
                    <div class="col-span-3">% of ownership</div>
                    <div class="col-span-3">% of profit share</div>
                    <div class="col-span-1 text-center">Actions</div>
                </div>

                <div id="partners_table_body">
                    <div class="grid grid-cols-12 gap-4 items-center mb-3 partner-row" id="my_company_row">
                        <div class="col-span-5 relative">
                            <input type="hidden" name="my_company_id" value="1">
                            <input type="text" value="My company" readonly class="form-control px-3 bg-slate-50/50 text-slate-600">
                        </div>
                        <div class="col-span-3 relative">
                            <input type="number" step="0.01" name="my_ownership_percentage" value="100.00" readonly class="form-control px-3 bg-slate-50/50 text-slate-600 my-ownership">
                        </div>
                        <div class="col-span-3 relative">
                            <input type="number" step="0.01" name="my_profit_share_percentage" value="100.00" readonly class="form-control px-3 bg-slate-50/50 text-slate-600 my-profit-share">
                        </div>
                        <div class="col-span-1 flex justify-center">
                            <button type="button" class="text-slate-300 cursor-not-allowed" disabled>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            </button>
                        </div>
                    </div>
                </div>
                
                <div id="partner_error" class="text-red-500 text-[12px] mt-2 font-medium" style="display: none;">
                    Total percentages must exactly equal 100%. My Company percentage cannot be negative.
                </div>

                <div class="mt-6 flex justify-end gap-3 border-t border-slate-100 pt-4">
                    <button type="button" id="done_partners_modal" class="px-6 py-2 bg-slate-800 text-white rounded-lg font-semibold hover:bg-slate-700">Done</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Pricing Section (Appended) --}}
    <div class="card !mb-0 shadow-sm" id="pricing-module">
        <div class="flex justify-between items-center mb-6">
            <h2 class="card-title !mb-0">Pricing</h2>
            <button type="button" class="bg-white border border-slate-200 px-3 py-1.5 rounded-lg text-[12px] font-semibold text-slate-700 hover:bg-slate-50 flex items-center gap-2 transition-colors">
                Manage Pricing fields
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" /></svg>
            </button>
        </div>

        <div class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="form-group">
                    <label>Selling unit</label>
                    <span class="sub-label">By weight or quantity.</span>
                    <div class="relative w-full custom-select-wrapper">
                    <input type="hidden" name="idtbl_weight_units" value="">
                    <button type="button" class="form-control flex items-center pl-3 pr-8 text-left">
                            <span class="truncate text-slate-800 selected-text" id="selected-selling-unit">Weight</span>
                        </button>
                        <div class="absolute inset-y-0 right-3 flex items-center pointer-events-none">
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </div>
                        <div class="custom-dropdown-panel">
                            <div class="p-2 hover:bg-slate-50 cursor-pointer text-[13px] px-3 dd-item" data-value="weight">Weight</div>
                            <div class="p-2 hover:bg-slate-50 cursor-pointer text-[13px] px-3 dd-item" data-value="quantity">Quantity</div>
                        </div>
                    </div>
                </div>
                
                <div class="form-group">
                    <label>Weight</label>
                    <span class="sub-label">Weight of the product</span>
                    <div class="flex gap-2">
                        <input type="number" step="0.001" name="weight" id="input-weight" placeholder='Weight e.g. "1.2"' class="form-control flex-1 px-3 calc-trigger">
                        <div class="relative w-[100px] custom-select-wrapper">
                            <button type="button" class="form-control flex items-center pl-3 pr-6 text-left">
                                <span class="truncate text-slate-800 selected-text">ct</span>
                            </button>
                            <div class="absolute inset-y-0 right-2 flex items-center pointer-events-none">
                                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </div>
                            <div class="custom-dropdown-panel">
                                <div class="p-2 hover:bg-slate-50 cursor-pointer text-[13px] px-3 dd-item" data-value="">ct</div>
                        @foreach($weightUnits as $weightUnit)
                            <div class="p-2 hover:bg-slate-50 cursor-pointer text-[13px] px-3 dd-item" data-value="{{ $weightUnit->idtbl_weight_units }}">{{ $weightUnit->unit_name ?? $weightUnit->name ?? $weightUnit->idtbl_weight_units }}</div>
                        @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="form-group">
                    <label>Average weight per piece</label>
                    <span class="sub-label">Automatically calculated</span>
                    <div class="relative">
                        <input type="text" id="input-avg-weight" placeholder='e.g. "1.2ct"' readonly class="form-control px-3 bg-slate-50/50 text-slate-500">
                        <div class="absolute inset-y-0 right-3 flex items-center text-slate-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label>Quantity</label>
                    <span class="sub-label">Number of pieces</span>
                    <input type="number" name="quantity" id="input-quantity" placeholder="Quantity" class="form-control px-3 calc-trigger">
                </div>
            </div>

            <div class="form-group">
                <label class="flex items-center gap-1">Cost <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg></label>
                <span class="sub-label">Cost per unit and total cost</span>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <input type="number" step="0.01" name="cost_per_unit" id="input-cost-unit" placeholder="Cost Per/unit" class="form-control px-3 calc-trigger">
                    <input type="number" step="0.01" name="total_cost" id="input-total-cost" placeholder="Total Cost" class="form-control px-3 calc-trigger">
                </div>
            </div>

            <div class="form-group">
                <label class="flex items-center gap-1">My cost <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg></label>
                <span class="sub-label">Your personal cost tracking</span>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <input type="number" step="0.01" name="my_cost_per_unit" id="input-my-cost-unit" placeholder="My cost Per/unit" class="form-control px-3 calc-trigger">
                    <input type="number" step="0.01" name="my_total_cost" id="input-my-total-cost" placeholder="My total cost" class="form-control px-3 calc-trigger">
                </div>
            </div>

            <div class="form-group">
                <label>Wholesale price VEF</label>
                <span class="sub-label">Wholesale unit and total pricing</span>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <input type="number" step="0.01" name="wholesale_per_unit" id="input-wholesale-unit" placeholder="Wholesale Cost Per/unit" class="form-control px-3 calc-trigger">
                    <input type="number" step="0.01" name="wholesale_total" id="input-wholesale-total" placeholder="Total Wholesale Cost" class="form-control px-3 calc-trigger">
                </div>
            </div>

            <div class="form-group">
                <label>Retail price VEF</label>
                <span class="sub-label">Retail unit and total pricing</span>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <input type="number" step="0.01" name="retail_per_unit" id="input-retail-unit" placeholder="Retail Cost Per/unit" class="form-control px-3 calc-trigger">
                    <input type="number" step="0.01" name="retail_total" id="input-retail-total" placeholder="Total Retail Cost" class="form-control px-3 calc-trigger">
                </div>
            </div>

            <div class="form-group">
                <label>Matrix price VEF</label>
                <span class="sub-label">Matrix unit and total pricing</span>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <input type="number" step="0.01" name="matrix_per_unit" id="input-matrix-unit" placeholder="Matrix Price Per/unit" class="form-control px-3 calc-trigger">
                    <input type="number" step="0.01" name="matrix_total" id="input-matrix-total" placeholder="Total Matrix Price" class="form-control px-3 calc-trigger">
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // We assume jQuery is available ($)
    if (typeof $ !== 'undefined') {
        const ownershipDropdown = $('input[name="idtbl_ownership_type"]');
        const managePartnersSection = $('#manage_partners_section');
        const partnersModal = $('#partners_modal');
        const partnersTableBody = $('#partners_table_body');
        const addPartnerBtn = $('#add_partner_btn');
        const partnerError = $('#partner_error');

        // Watch for changes in the dropdown
        $(document).on('click', '.dd-item', function() {
            const parentWrapper = $(this).closest('.custom-select-wrapper');
            if (parentWrapper.find('input[name="idtbl_ownership_type"]').length > 0) {
                const val = $(this).attr('data-value');
                handleOwnershipChange(val);
            }
        });

        if (ownershipDropdown.val()) {
            handleOwnershipChange(ownershipDropdown.val());
        }

        function handleOwnershipChange(val) {
            // "3" is Partner
            if (val === '3' || val === '') {
                managePartnersSection.show();
                partnersModal.find('input, select').prop('disabled', false);
                // Automatically open modal when Partner is selected and add an initial partner row
                if (val === '3') {
                    openModal();
                    // If there are no partner rows (other than My Company), add one
                    const existingPartners = $('.partner-row').not('#my_company_row');
                    if (existingPartners.length === 0) {
                        addPartnerBtn.trigger('click');
                    }
                }
                calculateTotals();
            } else {
                managePartnersSection.hide();
                partnersModal.hide();
                partnersModal.find('input:not([name^="my_"]), select').prop('disabled', true);
            }
        }

        // Modal Triggers
        $('#open_partners_modal, #add_partner_inline_btn').on('click', function() {
            openModal();
        });

        $('#close_partners_modal, #done_partners_modal').on('click', function() {
            if (validateForm()) {
                closeModal();
            } else {
                alert("Please fix the errors before closing the modal.");
            }
        });

        function openModal() {
            partnersModal.css('display', 'flex');
        }

        function closeModal() {
            partnersModal.css('display', 'none');
        }

        let partnerCount = 0;

        addPartnerBtn.on('click', function() {
            partnerCount++;
            const newRow = `
                <div class="grid grid-cols-12 gap-4 items-center mb-3 partner-row">
                    <div class="col-span-5 relative">
                        <select name="partner_ids[]" class="form-control px-3 bg-slate-50/50 text-slate-600 border border-slate-200 rounded-lg h-[38px]" required>
                            <option value="">Select Partner</option>
                            @foreach($partners ?? [] as $partner)
                                <option value="{{ $partner->idtbl_partners ?? '' }}">{{ $partner->partner_name ?? 'Partner' }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-span-3 relative">
                        <input type="number" step="0.01" name="partner_ownership[]" value="0.00" class="form-control px-3 bg-white text-slate-600 partner-ownership border border-slate-200 rounded-lg">
                    </div>
                    <div class="col-span-3 relative">
                        <input type="number" step="0.01" name="partner_profit[]" value="0.00" class="form-control px-3 bg-white text-slate-600 partner-profit border border-slate-200 rounded-lg">
                    </div>
                    <div class="col-span-1 flex justify-center">
                        <button type="button" class="text-red-400 hover:text-red-600 remove-partner-btn">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        </button>
                    </div>
                </div>
            `;
            partnersTableBody.append(newRow);
            redistributeShares();
            renderPreviewFromModal();
        });

        $(document).on('click', '.remove-partner-btn', function() {
            $(this).closest('.partner-row').remove();
            partnerCount = Math.max(0, $('.partner-row').length - 1); // exclude my company row
            redistributeShares();
            renderPreviewFromModal();
        });

        $(document).on('input', '.partner-ownership, .partner-profit', function() {
            calculateTotals();
        });

        function redistributeShares() {
            // When partners exist, default My Company to 60% and split remaining equally among partners
            const partnerRows = $('.partner-row').not('#my_company_row');
            const numPartners = partnerRows.length;

            if (numPartners === 0) {
                // no partners - My company keeps 100%
                $('.partner-ownership').val((100).toFixed(2));
                $('.partner-profit').val((100).toFixed(2));
                calculateTotals();
                return;
            }

            const myShare = 60.00;
            const remaining = Math.max(0, 100.00 - myShare);
            const perPartner = remaining / numPartners;

            // set partner ownership and profit defaults
            partnerRows.each(function() {
                $(this).find('input.partner-ownership').val(perPartner.toFixed(2));
                $(this).find('input.partner-profit').val(perPartner.toFixed(2));
            });

            $('.my-ownership').val(myShare.toFixed(2));
            $('.my-profit-share').val(myShare.toFixed(2));

            calculateTotals();
            renderPreviewFromModal();
        }

        function calculateTotals() {
            let totalOwnershipOthers = 0;
            let totalProfitOthers = 0;

            $('.partner-ownership').each(function() {
                totalOwnershipOthers += parseFloat($(this).val()) || 0;
            });

            $('.partner-profit').each(function() {
                totalProfitOthers += parseFloat($(this).val()) || 0;
            });

            let myOwnership = 100.00 - totalOwnershipOthers;
            let myProfit = 100.00 - totalProfitOthers;

            $('.my-ownership').val(myOwnership.toFixed(2));
            $('.my-profit-share').val(myProfit.toFixed(2));

            validateForm();
        }

        function renderPreviewFromModal() {
            // Build a lightweight preview of partner rows from modal's partner rows
            const previewContainer = $('#partners_preview_rows');
            const inlineAddWrapper = $('#inline_add_partner_wrapper');
            previewContainer.empty();
            // Show inline button only when partners section is visible
            if (managePartnersSection.is(':visible')) {
                inlineAddWrapper.show();
            } else {
                inlineAddWrapper.hide();
            }

            // iterate modal rows except My Company row
            $('#partners_table_body .partner-row').not('#my_company_row').each(function () {
                const partnerSelect = $(this).find('select[name="partner_ids[]"]');
                const partnerText   = partnerSelect.length ? partnerSelect.find('option:selected').text() : 'Partner';
                const ownership = $(this).find('input.partner-ownership').val() || '0.00';
                const profit    = $(this).find('input.partner-profit').val() || '0.00';

                const row = `
                    <tr>
                        <td><input type="text" readonly class="form-control-plaintext" value="${partnerText}"></td>
                        <td><input type="text" readonly class="form-control-plaintext text-end" value="${parseFloat(ownership).toFixed(2)}"></td>
                        <td><input type="text" readonly class="form-control-plaintext text-end" value="${parseFloat(profit).toFixed(2)}"></td>
                        <td class="text-center"><button type="button" class="btn btn-sm btn-link open-partner-edit">Edit</button></td>
                    </tr>
                `;
                previewContainer.append(row);
            });

            // bind edit buttons to open modal
            previewContainer.find('.open-partner-edit').on('click', openModal);
        }

        function validateForm() {
            let isValid = true;
            let myOwnership = parseFloat($('.my-ownership').val());
            let myProfit = parseFloat($('.my-profit-share').val());

            if (myOwnership < 0 || myProfit < 0) {
                isValid = false;
            }

            let totalOwnership = myOwnership;
            $('.partner-ownership').each(function() { totalOwnership += parseFloat($(this).val()) || 0; });

            let totalProfit = myProfit;
            $('.partner-profit').each(function() { totalProfit += parseFloat($(this).val()) || 0; });

            if (Math.abs(totalOwnership - 100) > 0.01 || Math.abs(totalProfit - 100) > 0.01) {
                isValid = false;
            }

            if (!isValid) {
                partnerError.show();
            } else {
                partnerError.hide();
            }
            
            return isValid;
        }
        // Global submit guard for partners totals
        $('form').on('submit', function(e){
            // Only validate if managePartnersSection is visible
            if (managePartnersSection.is(':visible')) {
                const myOwnership = parseFloat($('.my-ownership').val()) || 0;
                const myProfit = parseFloat($('.my-profit-share').val()) || 0;
                let totalOwnership = myOwnership;
                let totalProfit = myProfit;
                $('input[name="ownership_percentages[]"]').each(function(){ totalOwnership += parseFloat($(this).val()) || 0; });
                $('input[name="profit_percentages[]"]').each(function(){ totalProfit += parseFloat($(this).val()) || 0; });

                if (totalOwnership < 0 || totalProfit < 0) {
                    e.preventDefault();
                    Swal.fire({icon:'error',title:'Invalid values',text:'Percentages cannot be negative.'});
                    return false;
                }

                if (Math.abs(totalOwnership - 100) > 0.01 || Math.abs(totalProfit - 100) > 0.01) {
                    e.preventDefault();
                    Swal.fire({icon:'warning',title:'Totals must equal 100%',text:'Please ensure Ownership and Profit share totals equal 100%.'});
                    return false;
                }
            }
        });
    }
});
</script>
