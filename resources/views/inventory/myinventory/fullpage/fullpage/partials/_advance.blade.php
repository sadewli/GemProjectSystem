<div id="tab-advance" class="tab-content hidden flex-col gap-6">
    <div class="card !mb-0">
        <h2 class="card-title">Advance Details</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-x-6 gap-y-6">
            <div class="form-group">
                <label>Barcode #</label>
                <span class="sub-label">Automatically generated</span>
                <input type="text" value="479361" readonly class="form-control px-3 bg-slate-50/50 text-slate-500">
            </div>
            <div class="form-group">
                <label>Traceability #</label>
                <span class="sub-label">Automatically generated traceability #</span>
                <input type="text" value="CPG9" readonly class="form-control px-3 bg-slate-50/50 text-slate-500">
            </div>
            <div class="form-group">
                <label>RFID</label>
                <span class="sub-label">Enter custom RFID number</span>
                <input type="text" placeholder='e.g. "A2B200000000"' class="form-control px-3">
            </div>

            <div class="form-group">
                <label>Color distribution</label>
                <span class="sub-label">Color distribution of your gemstone(s) e.g "Even, uneven"</span>
                <div class="relative w-full custom-select-wrapper">
                    <button type="button" class="form-control flex items-center pl-3 pr-8 text-left">
                        <span class="truncate text-slate-400 selected-text">Select color distribution</span>
                    </button>
                    <div class="absolute inset-y-0 right-3 flex items-center pointer-events-none">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </div>
                    <div class="custom-dropdown-panel">
                        <div class="p-2 hover:bg-slate-50 cursor-pointer text-[13px] px-3 dd-item">Select color distribution</div>
                        <div class="p-2 hover:bg-slate-50 cursor-pointer text-[13px] px-3 dd-item">Even</div>
                        <div class="p-2 hover:bg-slate-50 cursor-pointer text-[13px] px-3 dd-item">Uneven (color zoning)</div>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label>Size range Length (mm)</label>
                <span class="sub-label">Size range (in mm) from smallest to largest stone</span>
                <div class="flex items-center gap-1.5">
                    <input type="text" placeholder='From e.g. "1"' class="form-control px-2 text-center text-[12px]">
                    <span class="text-slate-400">-</span>
                    <input type="text" placeholder='To e.g. "2"' class="form-control px-2 text-center text-[12px]">
                </div>
            </div>

            <div class="form-group">
                <label>Size range Width (mm)</label>
                <span class="sub-label">Size range (in mm) from smallest to largest stone</span>
                <div class="flex items-center gap-1.5">
                    <input type="text" placeholder='From e.g. "1"' class="form-control px-2 text-center text-[12px]">
                    <span class="text-slate-400">-</span>
                    <input type="text" placeholder='To e.g. "2"' class="form-control px-2 text-center text-[12px]">
                </div>
            </div>

            <div class="form-group">
                <label>Color grade range</label>
                <span class="sub-label">Enter your own color grade range.</span>
                <div class="flex items-center gap-1.5">
                    <div class="relative flex-1 custom-select-wrapper">
                        <button type="button" class="form-control flex items-center pl-2 pr-6 text-left">
                            <span class="truncate text-slate-400 selected-text text-[11px]">From</span>
                        </button>
                        <div class="custom-dropdown-panel">
                            <div class="p-2 hover:bg-slate-50 cursor-pointer text-[11px] dd-item">Grade A</div>
                        </div>
                    </div>
                    <span class="text-slate-400">-</span>
                    <div class="relative flex-1 custom-select-wrapper">
                        <button type="button" class="form-control flex items-center pl-2 pr-6 text-left">
                            <span class="truncate text-slate-400 selected-text text-[11px]">To</span>
                        </button>
                        <div class="custom-dropdown-panel">
                            <div class="p-2 hover:bg-slate-50 cursor-pointer text-[11px] dd-item">Grade B</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label>Clarity grade range</label>
                <span class="sub-label">Enter your own clarity grade range.</span>
                <div class="flex items-center gap-1.5">
                    <div class="relative flex-1 custom-select-wrapper">
                        <button type="button" class="form-control flex items-center pl-2 pr-6 text-left">
                            <span class="truncate text-slate-400 selected-text text-[11px]">From</span>
                        </button>
                        <div class="custom-dropdown-panel">
                            <div class="p-2 hover:bg-slate-50 cursor-pointer text-[11px] dd-item">IF</div>
                        </div>
                    </div>
                    <span class="text-slate-400">-</span>
                    <div class="relative flex-1 custom-select-wrapper">
                        <button type="button" class="form-control flex items-center pl-2 pr-6 text-left">
                            <span class="truncate text-slate-400 selected-text text-[11px]">To</span>
                        </button>
                        <div class="custom-dropdown-panel">
                            <div class="p-2 hover:bg-slate-50 cursor-pointer text-[11px] dd-item">VVS1</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label>Tolerance (mm)</label>
                <span class="sub-label">Specify the tolerance of your parcel (in mm)</span>
                <input type="text" placeholder='Amount e.g. "0.2"' class="form-control px-3">
            </div>

            <div class="form-group">
                <label>Allow selection?</label>
                <span class="sub-label">Specify if you allow selection to be made</span>
                <div class="relative w-full custom-select-wrapper">
                    <button type="button" class="form-control flex items-center pl-3 pr-8 text-left">
                        <span class="truncate text-slate-400 selected-text">Select allow selection?</span>
                    </button>
                    <div class="absolute inset-y-0 right-3 flex items-center pointer-events-none">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </div>
                    <div class="custom-dropdown-panel">
                        <div class="p-2 hover:bg-slate-50 cursor-pointer text-[13px] px-3 dd-item">Yes</div>
                        <div class="p-2 hover:bg-slate-50 cursor-pointer text-[13px] px-3 dd-item">No</div>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label>Cut grade range</label>
                <span class="sub-label">Enter your own cut grade range.</span>
                <div class="flex items-center gap-1.5">
                    <div class="relative flex-1 custom-select-wrapper">
                        <button type="button" class="form-control flex items-center pl-2 pr-6 text-left">
                            <span class="truncate text-slate-400 selected-text text-[11px]">From</span>
                        </button>
                        <div class="custom-dropdown-panel">
                            <div class="p-2 hover:bg-slate-50 cursor-pointer text-[11px] dd-item">Ideal</div>
                        </div>
                    </div>
                    <span class="text-slate-400">-</span>
                    <div class="relative flex-1 custom-select-wrapper">
                        <button type="button" class="form-control flex items-center pl-2 pr-6 text-left">
                            <span class="truncate text-slate-400 selected-text text-[11px]">To</span>
                        </button>
                        <div class="custom-dropdown-panel">
                            <div class="p-2 hover:bg-slate-50 cursor-pointer text-[11px] dd-item">Excellent</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-10 mb-6">
            <div class="flex justify-between items-center mb-4">
                <div>
                    <h3 class="text-[15px] font-bold text-slate-800">Custom Fields</h3>
                    <p class="text-[11px] text-slate-400">Additional product information and specifications</p>
                </div>
                <button type="button" class="px-3 py-1.5 bg-white border border-slate-200 text-[12px] text-slate-700 font-semibold rounded-lg hover:bg-slate-50 flex items-center gap-2">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" /></svg>
                    Create new custom field
                </button>
            </div>
            <div class="border border-slate-100 rounded-lg p-8 text-center bg-slate-50/30">
                <p class="text-slate-400 text-[13px]">No custom fields added yet.</p>
            </div>
        </div>

        <div class="mt-10 mb-6">
            <h3 class="text-[15px] font-bold text-slate-800">Traceability</h3>
            <p class="text-[11px] text-slate-400 mb-4">Track the origin and chain of custody</p>
            <div class="border border-slate-200 rounded-lg overflow-hidden">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-200 text-[11px] text-slate-600 font-semibold uppercase tracking-wider">
                            <th class="p-3">SKU</th>
                            <th class="p-3">Action</th>
                            <th class="p-3">Quantity</th>
                            <th class="p-3">Weight</th>
                            <th class="p-3">Loss</th>
                            <th class="p-3">Reference</th>
                            <th class="p-3">Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="p-3 text-center text-slate-400 text-[12px]" colspan="7">No traceability found.</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-10 mb-6">
            <h3 class="text-[15px] font-bold text-slate-800">Traceability chart</h3>
            <p class="text-[11px] text-slate-400 mb-4">Visual representation of traceability flow</p>
            <div class="border border-slate-100 rounded-lg p-8 text-center bg-slate-50/30">
                <p class="text-slate-400 text-[13px]">No traceability chart data available.</p>
            </div>
        </div>

        <div class="mt-10">
            <h3 class="text-[15px] font-bold text-slate-800">Transformation history</h3>
            <p class="text-[11px] text-slate-400 mb-4">View product transformation and changes</p>
            <div class="border border-slate-200 rounded-lg overflow-hidden">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-200 text-[11px] text-slate-600 font-semibold uppercase tracking-wider">
                            <th class="p-3">Action</th>
                            <th class="p-3">Parent Stone</th>
                            <th class="p-3">Images</th>
                            <th class="p-3">Certificates</th>
                            <th class="p-3">Notes</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="p-3 text-center text-slate-400 text-[12px]" colspan="5">No transformation history found.</td>
                        </tr>
                    </tbody>
                </table>
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
                                <div class="p-2 hover:bg-slate-50 cursor-pointer text-[13px] px-3 dd-item">ct</div>
                                <div class="p-2 hover:bg-slate-50 cursor-pointer text-[13px] px-3 dd-item">g</div>
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
