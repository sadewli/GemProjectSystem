<div id="tab-overview" class="tab-content active flex flex-col gap-6">
    {{-- Inventory Type --}}
    <div class="card !mb-0">
        <h2 class="card-title mb-4" style="text-transform: uppercase;">Inventory Type</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <label
                class="relative flex cursor-pointer rounded-lg border bg-white p-4 shadow-sm focus:outline-none inventory-type-label {{ ($product->inventory_type ?? 'individual') === 'individual' ? 'border-blue-500 ring-1 ring-blue-500' : 'border-slate-300 hover:border-slate-400' }}">
                <input type="radio" name="inventory_type" value="individual"
                    class="sr-only inventory-type-radio" {{ ($product->inventory_type ?? 'individual') === 'individual' ? 'checked' : '' }}>
                <span class="flex flex-1">
                    <span class="flex flex-col">
                        <span class="block text-sm font-medium text-slate-900 flex items-center gap-2"><i
                                class="fa-regular fa-gem {{ ($product->inventory_type ?? 'individual') === 'individual' ? 'text-blue-500' : 'text-slate-400' }}"></i> Individual (Single
                            piece)</span>
                        <span class="mt-1 flex items-center text-xs text-slate-500">
                            <ul class="list-disc pl-4 mt-1 space-y-1">

                            </ul>
                        </span>
                    </span>
                </span>
                <svg class="h-5 w-5 text-blue-600 check-icon {{ ($product->inventory_type ?? 'individual') === 'individual' ? '' : 'hidden' }}" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z"
                        clip-rule="evenodd" />
                </svg>
            </label>
            <label
                class="relative flex cursor-pointer rounded-lg border bg-white p-4 shadow-sm focus:outline-none inventory-type-label {{ ($product->inventory_type ?? 'individual') === 'lot' ? 'border-blue-500 ring-1 ring-blue-500' : 'border-slate-300 hover:border-slate-400' }}">
                <input type="radio" name="inventory_type" value="lot" class="sr-only inventory-type-radio" {{ ($product->inventory_type ?? 'individual') === 'lot' ? 'checked' : '' }}>
                <span class="flex flex-1">
                    <span class="flex flex-col">
                        <span class="block text-sm font-medium text-slate-900 flex items-center gap-2"><i
                                class="fa-solid fa-boxes-stacked {{ ($product->inventory_type ?? 'individual') === 'lot' ? 'text-blue-500' : 'text-slate-400' }}"></i> Lot (Multiple
                            pieces)</span>
                        <span class="mt-1 flex items-center text-xs text-slate-500">
                            <ul class="list-disc pl-4 mt-1 space-y-1">

                            </ul>
                        </span>
                    </span>
                </span>
                <svg class="h-5 w-5 text-blue-600 check-icon {{ ($product->inventory_type ?? 'individual') === 'lot' ? '' : 'hidden' }}" viewBox="0 0 20 20"
                    fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z"
                        clip-rule="evenodd" />
                </svg>
            </label>
        </div>
    </div>

    <script>
        document.querySelectorAll('.inventory-type-radio').forEach(radio => {
            radio.addEventListener('change', function () {
                document.querySelectorAll('.inventory-type-label').forEach(label => {
                    label.classList.remove('border-blue-500', 'ring-1', 'ring-blue-500');
                    label.classList.add('border-slate-300', 'hover:border-slate-400');
                    label.querySelector('.check-icon').classList.add('hidden');
                    label.querySelector('i').classList.remove('text-blue-500');
                    label.querySelector('i').classList.add('text-slate-400');
                });
                if (this.checked) {
                    const parent = this.closest('.inventory-type-label');
                    parent.classList.remove('border-slate-300', 'hover:border-slate-400');
                    parent.classList.add('border-blue-500', 'ring-1', 'ring-blue-500');
                    parent.querySelector('.check-icon').classList.remove('hidden');
                    parent.querySelector('i').classList.add('text-blue-500');
                    parent.querySelector('i').classList.remove('text-slate-400');
                }
            });
        });
    </script>

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
                        <button type="button" id="prefixDropdownBtnFullpage"
                            class="form-control flex items-center pl-3 pr-6 text-left">
                            <span class="truncate text-slate-800 selected-text" id="skuPrefixTextFullpage">Prefix</span>
                        </button>
                        <div class="absolute inset-y-0 right-2 flex items-center pointer-events-none">
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                        <div class="custom-dropdown-panel">
                            <div class="p-2 hover:bg-slate-50 cursor-pointer text-[13px] px-3 dd-item" data-value="">
                                Prefix</div>
                            @foreach($skus as $sku)
                                <div class="p-2 hover:bg-slate-50 cursor-pointer text-[13px] px-3 dd-item"
                                    data-value="{{ $sku->idtbl_skus }}">{{ $sku->name ?? $sku->idtbl_skus }}</div>
                            @endforeach
                        </div>
                    </div>
                    <input type="text" name="sku_number" id="skuNumberInputFullpage" value="{{ old('sku_number', '') }}"
                        class="form-control flex-1 px-3 text-slate-800">
                </div>
            </div>

            <div class="form-group">
                <label>Category</label>
                <span class="sub-label">Category e.g "Single, Parcel, Pair, Set"</span>
                <div class="relative">
                    <input type="hidden" name="idtbl_product_types"
                        value="{{ $productTypes->first()->idtbl_product_types ?? '' }}">
                    <input type="text" value="{{ $productTypes->first()->product_type ?? 'Gemstone' }}" readonly
                        class="form-control px-3 bg-slate-50/50 text-slate-500">
                    <div class="absolute inset-y-0 right-3 flex items-center pointer-events-none">
                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                            </path>
                        </svg>
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
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                            </path>
                        </svg>
                    </div>
                    <div class="custom-dropdown-panel">
                        <div class="p-2 hover:bg-slate-50 cursor-pointer text-[13px] px-3 dd-item" data-value="">
                            Unspecified</div>
                        @foreach($subCategories as $subCategory)
                            <div class="p-2 hover:bg-slate-50 cursor-pointer text-[13px] px-3 dd-item"
                                data-value="{{ $subCategory->idtbl_sub_categories }}">
                                {{ $subCategory->subcategory ?? $subCategory->name ?? $subCategory->idtbl_sub_categories }}
                            </div>
                        @endforeach
                        <div class="border-t border-slate-100 mt-1 pt-1">
                            <button type="button" class="create-new-btn flex items-center gap-2 text-[13px] font-semibold text-[#2563eb] hover:text-blue-800 w-full px-3 py-2 transition-colors" data-table="tbl_sub_categories">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                Create New
                            </button>
                        </div>
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
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                            </path>
                        </svg>
                    </div>
                    <div class="custom-dropdown-panel">
                        <div class="p-2 hover:bg-slate-50 cursor-pointer text-[13px] px-3 dd-item" data-value="">Select
                            variety</div>
                        @foreach($varieties as $variety)
                            <div class="p-2 hover:bg-slate-50 cursor-pointer text-[13px] px-3 dd-item"
                                data-value="{{ $variety->idtbl_varieties }}">
                                {{ $variety->variety ?? $variety->name ?? $variety->idtbl_varieties }}</div>
                        @endforeach
                        <div class="border-t border-slate-100 mt-1 pt-1">
                            <button type="button" class="create-new-btn flex items-center gap-2 text-[13px] font-semibold text-[#2563eb] hover:text-blue-800 w-full px-3 py-2 transition-colors" data-table="tbl_varieties">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                Create New
                            </button>
                        </div>
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
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                            </path>
                        </svg>
                    </div>
                    <div class="custom-dropdown-panel">
                        <div class="p-2 hover:bg-slate-50 cursor-pointer text-[13px] px-3 dd-item" data-value="">Select
                            color</div>
                        @foreach($colors as $color)
                            <div class="p-2 hover:bg-slate-50 cursor-pointer text-[13px] px-3 dd-item"
                                data-value="{{ $color->idtbl_colors }}">
                                                                     {{ $color->color_name ?? $color->color ?? $color->name ?? $color->idtbl_colors }}</div>
                        @endforeach
                        <div class="border-t border-slate-100 mt-1 pt-1">
                            <button type="button" class="create-new-btn flex items-center gap-2 text-[13px] font-semibold text-[#2563eb] hover:text-blue-800 w-full px-3 py-2 transition-colors" data-table="tbl_colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                Create New
                            </button>
                        </div>
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
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                            </path>
                        </svg>
                    </div>
                    <div class="custom-dropdown-panel">
                        <div class="p-2 hover:bg-slate-50 cursor-pointer text-[13px] px-3 dd-item" data-value="">Select
                            shape</div>
                        @foreach($shapes as $shape)
                            <div class="p-2 hover:bg-slate-50 cursor-pointer text-[13px] px-3 dd-item"
                                data-value="{{ $shape->idtbl_shapes }}">
                                {{ $shape->shape ?? $shape->name ?? $shape->idtbl_shapes }}</div>
                        @endforeach
                        <div class="border-t border-slate-100 mt-1 pt-1">
                            <button type="button" class="create-new-btn flex items-center gap-2 text-[13px] font-semibold text-[#2563eb] hover:text-blue-800 w-full px-3 py-2 transition-colors" data-table="tbl_shapes">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                Create New
                            </button>
                        </div>
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
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                            </path>
                        </svg>
                    </div>
                    <div class="custom-dropdown-panel">
                        <div class="p-2 hover:bg-slate-50 cursor-pointer text-[13px] px-3 dd-item" data-value="">Select
                            cutting type</div>
                        @foreach($cuts as $cut)
                            <div class="p-2 hover:bg-slate-50 cursor-pointer text-[13px] px-3 dd-item"
                                data-value="{{ $cut->idtbl_cuts }}">{{ $cut->cut ?? $cut->name ?? $cut->idtbl_cuts }}</div>
                        @endforeach
                        <div class="border-t border-slate-100 mt-1 pt-1">
                            <button type="button" class="create-new-btn flex items-center gap-2 text-[13px] font-semibold text-[#2563eb] hover:text-blue-800 w-full px-3 py-2 transition-colors" data-table="tbl_cuts">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                Create New
                            </button>
                        </div>
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
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                            </path>
                        </svg>
                    </div>
                    <div class="custom-dropdown-panel">
                        <div class="p-2 hover:bg-slate-50 cursor-pointer text-[13px] px-3 dd-item" data-value="">Select
                            treatment</div>
                        @foreach($treatments as $treatment)
                            <div class="p-2 hover:bg-slate-50 cursor-pointer text-[13px] px-3 dd-item"
                                data-value="{{ $treatment->idtbl_treatments }}">
                                {{ $treatment->treatment_name ?? $treatment->treatment ?? $treatment->name ?? $treatment->idtbl_treatments }}</div>
                        @endforeach
                        <div class="border-t border-slate-100 mt-1 pt-1">
                            <button type="button" class="create-new-btn flex items-center gap-2 text-[13px] font-semibold text-[#2563eb] hover:text-blue-800 w-full px-3 py-2 transition-colors" data-table="tbl_treatments">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                Create New
                            </button>
                        </div>
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
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                            </path>
                        </svg>
                    </div>
                    <div class="custom-dropdown-panel">
                        <div class="p-2 hover:bg-slate-50 cursor-pointer text-[13px] px-3 dd-item" data-value="">Select
                            origin</div>
                        @foreach($origins as $origin)
                            <div class="p-2 hover:bg-slate-50 cursor-pointer text-[13px] px-3 dd-item"
                                data-value="{{ $origin->idtbl_origins }}">
                                {{ $origin->origin_name ?? $origin->origin ?? $origin->name ?? $origin->idtbl_origins }}</div>
                        @endforeach
                        <div class="border-t border-slate-100 mt-1 pt-1">
                            <button type="button" class="create-new-btn flex items-center gap-2 text-[13px] font-semibold text-[#2563eb] hover:text-blue-800 w-full px-3 py-2 transition-colors" data-table="tbl_origins">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                Create New
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Row 4 --}}
            <div class="form-group">
                <label>Color grade</label>
                <span class="sub-label">Enter your own color grade. To manage your color grades <a href="#"
                        class="text-blue-600 hover:underline">clic...</a></span>
                <div class="relative w-full custom-select-wrapper">
                    <input type="hidden" name="idtbl_color_grade" value="">
                    <button type="button" class="form-control flex items-center pl-3 pr-8 text-left">
                        <span class="truncate text-slate-400 selected-text">Select color grade</span>
                    </button>
                    <div class="absolute inset-y-0 right-3 flex items-center pointer-events-none">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                            </path>
                        </svg>
                    </div>
                    <div class="custom-dropdown-panel">
                        <div class="p-2 hover:bg-slate-50 cursor-pointer text-[13px] px-3 dd-item" data-value="">Select
                            color grade</div>
                        @foreach($colorGrades as $colorGrade)
                            <div class="p-2 hover:bg-slate-50 cursor-pointer text-[13px] px-3 dd-item"
                                data-value="{{ $colorGrade->idtbl_color_grade }}">
                                {{ $colorGrade->grade_name ?? $colorGrade->color_grade ?? $colorGrade->name ?? $colorGrade->idtbl_color_grade }}</div>
                        @endforeach
                        <div class="border-t border-slate-100 mt-1 pt-1">
                            <button type="button" class="create-new-btn flex items-center gap-2 text-[13px] font-semibold text-[#2563eb] hover:text-blue-800 w-full px-3 py-2 transition-colors" data-table="tbl_color_grade">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                Create New
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label>Cut grade</label>
                <span class="sub-label">Enter your own cut grade. To manage your cut grades <a href="#"
                        class="text-blue-600 hover:underline">clic...</a></span>
                <div class="relative w-full custom-select-wrapper">
                    <input type="hidden" name="idtbl_cuttinggrade" value="">
                    <button type="button" class="form-control flex items-center pl-3 pr-8 text-left">
                        <span class="truncate text-slate-400 selected-text">Select cut grade</span>
                    </button>
                    <div class="absolute inset-y-0 right-3 flex items-center pointer-events-none">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                            </path>
                        </svg>
                    </div>
                    <div class="custom-dropdown-panel">
                        <div class="p-2 hover:bg-slate-50 cursor-pointer text-[13px] px-3 dd-item" data-value="">Select
                            cut grade</div>
                        @foreach($cutGrades as $cutGrade)
                            <div class="p-2 hover:bg-slate-50 cursor-pointer text-[13px] px-3 dd-item"
                                data-value="{{ $cutGrade->idtbl_cuttinggrade }}">
                                {{ $cutGrade->cuttinggradename ?? $cutGrade->cuttinggrade ?? $cutGrade->name ?? $cutGrade->idtbl_cuttinggrade }}</div>
                        @endforeach
                        <div class="border-t border-slate-100 mt-1 pt-1">
                            <button type="button" class="create-new-btn flex items-center gap-2 text-[13px] font-semibold text-[#2563eb] hover:text-blue-800 w-full px-3 py-2 transition-colors" data-table="tbl_cuttinggrade">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                Create New
                            </button>
                        </div>
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
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                            </path>
                        </svg>
                    </div>
                    <div class="custom-dropdown-panel">
                        <div class="p-2 hover:bg-slate-50 cursor-pointer text-[13px] px-3 dd-item" data-value="">Select
                            clarity grade</div>
                        @foreach($clarityGrades as $clarityGrade)
                            <div class="p-2 hover:bg-slate-50 cursor-pointer text-[13px] px-3 dd-item"
                                data-value="{{ $clarityGrade->idtbl_clarity_grade }}">
                                {{ $clarityGrade->clarity_grade_name ?? $clarityGrade->clarity_grade ?? $clarityGrade->name ?? $clarityGrade->idtbl_clarity_grade }}
                            </div>
                        @endforeach
                        <div class="border-t border-slate-100 mt-1 pt-1">
                            <button type="button" class="create-new-btn flex items-center gap-2 text-[13px] font-semibold text-[#2563eb] hover:text-blue-800 w-full px-3 py-2 transition-colors" data-table="tbl_clarity_grade">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                Create New
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Row 5 --}}
            <div class="form-group">
                <label>Dimensions</label>
                <span class="sub-label">Dimensions of your gemstone(s) in millimeters</span>
                <div class="flex items-center gap-1.5">
                    <input type="text" name="length_mm" placeholder="Length(mm)"
                        class="form-control px-2 text-center text-[12px] !rounded-lg">
                    <span class="text-slate-600 font-bold text-[11px]">x</span>
                    <input type="text" name="width_mm" placeholder="Width(mm)"
                        class="form-control px-2 text-center text-[12px] !rounded-lg">
                    <span class="text-slate-600 font-bold text-[11px]">x</span>
                    <input type="text" name="height_mm" placeholder="Height(mm)"
                        class="form-control px-2 text-center text-[12px] !rounded-lg">
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
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                            </path>
                        </svg>
                    </div>
                    <div class="custom-dropdown-panel">
                        <div class="p-2 hover:bg-slate-50 cursor-pointer text-[13px] px-3 dd-item" data-value="">Select
                            storage location</div>
                        @foreach($storageLocations as $storageLocation)
                            <div class="p-2 hover:bg-slate-50 cursor-pointer text-[13px] px-3 dd-item"
                                data-value="{{ $storageLocation->idtbl_storage_locations }}">
                                {{ $storageLocation->location_name ?? $storageLocation->storage_location ?? $storageLocation->name ?? $storageLocation->idtbl_storage_locations }}
                            </div>
                        @endforeach
                        <div class="border-t border-slate-100 mt-1 pt-1">
                            <button type="button" class="create-new-btn flex items-center gap-2 text-[13px] font-semibold text-[#2563eb] hover:text-blue-800 w-full px-3 py-2 transition-colors" data-table="tbl_storage_locations">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                Create New
                            </button>
                        </div>
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
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                            </path>
                        </svg>
                    </div>
                    <div class="custom-dropdown-panel">
                        <div class="p-2 hover:bg-slate-50 cursor-pointer text-[13px] px-3 dd-item" data-value="">Select
                            tray / box#</div>
                        @foreach($trayBoxes as $trayBox)
                            <div class="p-2 hover:bg-slate-50 cursor-pointer text-[13px] px-3 dd-item"
                                data-value="{{ $trayBox->idtbl_tray_box }}">
                                {{ $trayBox->tray_box_number ?? $trayBox->tray_box ?? $trayBox->name ?? $trayBox->idtbl_tray_box }}</div>
                        @endforeach
                        <div class="border-t border-slate-100 mt-1 pt-1">
                            <button type="button" class="create-new-btn flex items-center gap-2 text-[13px] font-semibold text-[#2563eb] hover:text-blue-800 w-full px-3 py-2 transition-colors" data-table="tbl_tray_box">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                Create New
                            </button>
                        </div>
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
            <span class="sub-label">Product description specific to your gemstone(s) e.g "The overall quality of this
                gemstone(s) is exceptional and very rare"</span>
            <textarea name="product_description" placeholder="Product description"
                class="form-control px-3 py-2 h-24 resize-none"></textarea>
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
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                            </path>
                        </svg>
                    </div>
                    <div class="custom-dropdown-panel">
                        <div class="p-2 hover:bg-slate-50 cursor-pointer text-[13px] px-3 dd-item" data-value="">Select
                            Supplier ref/name</div>
                        @foreach($suppliers as $supplier)
                            <div class="p-2 hover:bg-slate-50 cursor-pointer text-[13px] px-3 dd-item"
                                data-value="{{ $supplier->idtbl_suppliers }}">
                                {{ $supplier->supplier_name ?? $supplier->name ?? $supplier->idtbl_suppliers }}</div>
                        @endforeach
                        <div class="border-t border-slate-100 mt-1 pt-1">
                            <button type="button" class="create-new-btn flex items-center gap-2 text-[13px] font-semibold text-[#2563eb] hover:text-blue-800 w-full px-3 py-2 transition-colors" data-table="tbl_suppliers">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                Create New
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label>Supplier stone ref.</label>
                <span class="sub-label">A unique reference for the specific stone provided by the ...</span>
                <input type="text" name="supplier_stone_ref" placeholder="Supplier stone ref."
                    class="form-control px-3">
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
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                            </path>
                        </svg>
                    </div>
                    <div class="custom-dropdown-panel">
                        <div class="p-2 hover:bg-slate-50 cursor-pointer text-[13px] px-3 dd-item" data-value="">Select
                            Ownership Type</div>
                        @foreach($ownershipTypes as $ownershipType)
                            <div class="p-2 hover:bg-slate-50 cursor-pointer text-[13px] px-3 dd-item"
                                data-value="{{ $ownershipType->idtbl_ownership_type }}">
                                {{ $ownershipType->ownership_type_name ?? $ownershipType->ownership_type ?? $ownershipType->name ?? $ownershipType->idtbl_ownership_type }}
                            </div>
                        @endforeach
                        <div class="border-t border-slate-100 mt-1 pt-1">
                            <button type="button" class="create-new-btn flex items-center gap-2 text-[13px] font-semibold text-[#2563eb] hover:text-blue-800 w-full px-3 py-2 transition-colors" data-table="tbl_ownership_type">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                Create New
                            </button>
                        </div>
                    </div>
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

    {{-- Add Partner Modal --}}
    <div id="addPartnerModal"
        class="fixed inset-0 z-[10000] hidden items-center justify-center bg-slate-900/40 backdrop-blur-sm transition-opacity">
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-[500px] transform transition-all p-7">
            <div class="flex justify-between items-center mb-5">
                <h3 class="text-[18px] font-bold text-slate-800">Add Partner</h3>
                <button type="button" onclick="toggleAddPartnerModal(false)"
                    class="text-slate-400 hover:text-slate-600 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <div
                class="bg-[#FFF6ec] border-l-4 border-[#ca8a04] text-[#854d0e] text-[13.5px] px-4 py-3.5 rounded-r-md mb-6">
                <strong class="font-bold text-[#854d0e]">Note:</strong> If the percentage of profit sharing is not
                specified, it will be auto-calculated based on the percentage of ownership.
            </div>

            <div class="mb-5">
                <label class="block text-[13px] font-medium text-slate-600 mb-1.5">Select Partner <span
                        class="text-rose-500">*</span></label>
                <div class="relative w-full" id="ddAddPartnerWrapper">
                    <input type="hidden" id="ddAddPartnerHidden">
                    <button type="button" id="ddAddPartnerBtn"
                        class="w-full h-[42px] border border-slate-300 rounded-md flex items-center justify-between px-3 bg-white text-left focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-all">
                        <span id="ddAddPartnerLabel" class="truncate text-slate-400 text-[14px]">Select Partner</span>
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                            </path>
                        </svg>
                    </button>
                    <div id="ddAddPartnerPanel"
                        class="hidden absolute z-[10001] left-0 right-0 mt-1 bg-white border border-slate-200 rounded-md shadow-lg overflow-hidden">
                        <div class="p-2 border-b border-slate-100">
                            <input type="text" id="ddAddPartnerSearch" placeholder="Search partner..."
                                class="w-full h-[36px] border border-slate-200 rounded-md px-3 text-[14px] focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-all">
                        </div>
                        <ul id="ddAddPartnerList" class="py-1 max-h-48 overflow-y-auto custom-scrollbar">
                            <li class="dd-option flex items-center px-4 py-2 text-[14px] cursor-pointer hover:bg-slate-50 text-slate-500"
                                data-value="" data-label="Select Partner">Select Partner</li>
                            @foreach($partners ?? [] as $partner)
                                <li class="dd-option flex items-center px-4 py-2 text-[14px] cursor-pointer hover:bg-slate-50 text-slate-700"
                                    data-value="{{ $partner->idtbl_partners }}" data-label="{{ $partner->partner_name }}">
                                    {{ $partner->partner_name }}</li>
                            @endforeach
                        </ul>
                        <div class="border-t border-slate-100 mt-1 pt-1">
                            <button type="button" class="create-new-btn flex items-center gap-2 text-[13px] font-semibold text-[#2563eb] hover:text-blue-800 w-full px-3 py-2 transition-colors" data-table="tbl_partners">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                Create New
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-5 mb-8">
                <div>
                    <label class="block text-[13px] font-medium text-slate-600 mb-1.5">% of ownership <span
                            class="text-rose-500">*</span></label>
                    <input type="number" id="addPartnerOwnership" placeholder="E.g 20"
                        class="w-full h-[42px] border border-slate-300 rounded-md px-3 text-[14px] text-slate-700 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-all"
                        min="0" max="100">
                </div>
                <div>
                    <label class="block text-[13px] font-medium text-slate-600 mb-1.5">% of profit sharing</label>
                    <input type="number" id="addPartnerProfit" placeholder="E.g 20"
                        class="w-full h-[42px] border border-slate-300 rounded-md px-3 text-[14px] text-slate-700 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-all"
                        min="0" max="100">
                </div>
            </div>

            <div class="flex justify-between items-center mt-2">
                <button type="button" onclick="toggleAddPartnerModal(false)"
                    class="px-6 py-2.5 text-[14px] font-medium text-[#ef4444] bg-white border border-[#ef4444] rounded-lg hover:bg-red-50 transition-colors">
                    Cancel
                </button>
                <button type="button" id="confirmAddPartnerBtn"
                    class="px-7 py-2.5 text-[14px] font-medium text-white bg-[#2563eb] rounded-lg hover:bg-blue-700 transition-colors shadow-sm">
                    Update
                </button>
            </div>
        </div>
    </div>

    {{-- Wizard Navigation --}}
    <div class="flex justify-end mt-2 pt-4 border-t border-slate-200">
        <button type="button" class="btn-next bg-[#2563eb] hover:bg-blue-700 text-white px-6 py-2.5 rounded-lg text-[13px] font-medium flex items-center gap-2 transition-colors shadow-sm" data-next="tab-advance">
            Next
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
        </button>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
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
        const ownershipInput = document.getElementById('addPartnerOwnership');
        if (ownershipInput) {
            ownershipInput.addEventListener('input', function() {
                const ownershipVal = this.value;
                const profitInput = document.getElementById('addPartnerProfit');
                if(profitInput.value === '' && ownershipVal !== '') {
                    profitInput.placeholder = 'E.g ' + ownershipVal;
                }
            });
        }

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

            if (myOwnershipInput) myOwnershipInput.value = Math.max(0, 100 - totalOwnership);
            if (myProfitInput) myProfitInput.value = Math.max(0, 100 - totalProfit);
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
                panel.classList.toggle('hidden');
                if (!panel.classList.contains('hidden') && search) {
                    search.focus();
                    search.value = '';
                    // Show all items
                    list.querySelectorAll('.dd-option').forEach(opt => opt.style.display = '');
                }
            });

            if (search) {
                search.addEventListener('input', function() {
                    const term = this.value.toLowerCase();
                    list.querySelectorAll('.dd-option').forEach(opt => {
                        const text = (opt.getAttribute('data-label') || opt.textContent).toLowerCase();
                        opt.style.display = text.includes(term) ? '' : 'none';
                    });
                });
                search.addEventListener('click', function(e) { e.stopPropagation(); });
            }

            list.addEventListener('click', function(e) {
                const opt = e.target.closest('.dd-option');
                if (!opt) return;
                hidden.value = opt.getAttribute('data-value');
                label.textContent = opt.getAttribute('data-label');
                label.classList.toggle('text-slate-400', !hidden.value);
                label.classList.toggle('text-slate-800', !!hidden.value);
                panel.classList.add('hidden');
            });

            document.addEventListener('click', function(e) {
                if (!wrapper.contains(e.target)) {
                    panel.classList.add('hidden');
                }
            });
        })();

        // --- Pricing Auto-Calc Logic ---
        function bindCalc(unitName, totalName) {
            const unitInput = document.querySelector(`input[placeholder="${unitName}"]`);
            const totalInput = document.querySelector(`input[placeholder="${totalName}"]`);
            const weightInput = document.getElementById('input-weight');
            const quantityInput = document.getElementById('input-quantity');

            if (!unitInput || !totalInput) return;

            function calc() {
                const unit = parseFloat(unitInput.value) || 0;
                const weight = parseFloat(weightInput?.value) || 0;
                const quantity = parseFloat(quantityInput?.value) || 0;
                const multiplier = weight || quantity || 1;
                totalInput.value = unit && multiplier ? (unit * multiplier).toFixed(2) : '';
            }

            unitInput.addEventListener('input', calc);
            if (weightInput) weightInput.addEventListener('input', calc);
            if (quantityInput) quantityInput.addEventListener('input', calc);
        }

        bindCalc("Cost Per/unit", "Total Cost");
        bindCalc("My cost Per/unit", "My total cost");
        bindCalc("Wholesale Cost Per/unit", "Total Wholesale Cost");
        bindCalc("Retail Cost Per/unit", "Total Retail Cost");
        bindCalc("Matrix Price Per/unit", "Total Matrix Price");
    });
</script>
