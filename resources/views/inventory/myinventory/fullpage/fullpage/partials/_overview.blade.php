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
                            <div class="p-2 hover:bg-slate-50 cursor-pointer text-[13px] px-3 dd-item" data-value="{{ $ownershipType->idtbl_ownership_type }}">{{ $ownershipType->ownership_type ?? $ownershipType->name ?? $ownershipType->idtbl_ownership_type }}</div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        {{-- Partners section --}}
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-[15px] font-bold text-slate-800">Partners</h3>
            <button type="button" class="px-3 py-1.5 bg-[#f1f5f9] text-[12px] text-slate-700 font-semibold rounded-lg hover:bg-slate-200">Add partner</button>
        </div>

        <div class="grid grid-cols-12 gap-4 text-[12px] font-medium text-slate-500 mb-2 px-1">
            <div class="col-span-5">Partner</div>
            <div class="col-span-3">% of ownership</div>
            <div class="col-span-3">% of profit share</div>
            <div class="col-span-1 text-center">Actions</div>
        </div>

        <div class="grid grid-cols-12 gap-4 items-center mb-3">
            <div class="col-span-5 relative">
                <input type="text" value="My company" readonly class="form-control px-3 bg-slate-50/50 text-slate-600">
                <div class="absolute inset-y-0 right-3 flex items-center pointer-events-none">
                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                </div>
            </div>
            <div class="col-span-3 relative">
                <input type="text" value="100" readonly class="form-control px-3 bg-slate-50/50 text-slate-600">
                <div class="absolute inset-y-0 right-3 flex items-center pointer-events-none">
                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                </div>
            </div>
            <div class="col-span-3 relative">
                <input type="text" value="100" readonly class="form-control px-3 bg-slate-50/50 text-slate-600">
                <div class="absolute inset-y-0 right-3 flex items-center pointer-events-none">
                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                </div>
            </div>
            <div class="col-span-1 flex justify-center">
                <button type="button" class="text-slate-400 hover:text-slate-600">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                </button>
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
