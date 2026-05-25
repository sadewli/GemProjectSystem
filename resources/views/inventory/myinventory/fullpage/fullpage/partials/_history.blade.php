<div id="tab-history" class="tab-content hidden flex-col gap-6">
    <div class="card !mb-0 shadow-sm">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="form-group">
                <label>Created Date</label>
                <span class="sub-label">Date and time of creation</span>
                <input type="text" value="{{ date('d M Y, h:i A') }}" readonly class="form-control px-3 bg-slate-50/50 text-slate-500">
            </div>
        </div>

        <div class="flex justify-between items-center mb-6">
            <h2 class="card-title !mb-0">History</h2>
            <div class="relative w-64 custom-select-wrapper">
                <button type="button" class="form-control flex items-center pl-3 pr-8 text-left bg-slate-50">
                    <span class="truncate text-slate-800 selected-text">All Activities</span>
                </button>
                <div class="absolute inset-y-0 right-3 flex items-center pointer-events-none">
                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </div>
                <div class="custom-dropdown-panel">
                    <div class="p-2 hover:bg-slate-50 cursor-pointer text-[13px] px-3 dd-item">All Activities</div>
                    <div class="p-2 hover:bg-slate-50 cursor-pointer text-[13px] px-3 dd-item">Status Changes</div>
                    <div class="p-2 hover:bg-slate-50 cursor-pointer text-[13px] px-3 dd-item">Price Updates</div>
                </div>
            </div>
        </div>

        <div class="border border-slate-200 rounded-lg overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-[11px] text-slate-600 font-semibold uppercase tracking-wider">
                        <th class="p-4">Date & Time</th>
                        <th class="p-4">User</th>
                        <th class="p-4">Action</th>
                        <th class="p-4">Details</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="border-b border-slate-100">
                        <td class="p-4 text-[13px] text-slate-800">{{ date('d M Y, h:i A') }}</td>
                        <td class="p-4 text-[13px] text-slate-800 font-medium">Sachintha Kaveen</td>
                        <td class="p-4"><span class="bg-blue-50 text-blue-700 px-2.5 py-1 rounded-md text-[12px] font-semibold">Created</span></td>
                        <td class="p-4 text-[13px] text-slate-600">Product draft created.</td>
                    </tr>
                </tbody>
            </table>
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
