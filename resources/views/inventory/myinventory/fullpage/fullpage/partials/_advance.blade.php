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
                <input type="text" name="rfid" placeholder='e.g. "A2B200000000"' class="form-control px-3">
            </div>

            <div class="form-group">
                <label>Color distribution</label>
                <span class="sub-label">Color distribution of your gemstone(s) e.g "Even, uneven"</span>
                <div class="relative w-full custom-select-wrapper">
                    <input type="hidden" name="color_distribution" value="">
                    <button type="button" class="form-control flex items-center pl-3 pr-8 text-left">
                        <span class="truncate text-slate-400 selected-text">Select color distribution</span>
                    </button>
                    <div class="absolute inset-y-0 right-3 flex items-center pointer-events-none">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                            </path>
                        </svg>
                    </div>
                    <div class="custom-dropdown-panel">
                        <div class="p-2 hover:bg-slate-50 cursor-pointer text-[13px] px-3 dd-item">Select color
                            distribution</div>
                        <div class="p-2 hover:bg-slate-50 cursor-pointer text-[13px] px-3 dd-item">Even</div>
                        <div class="p-2 hover:bg-slate-50 cursor-pointer text-[13px] px-3 dd-item">Uneven (color zoning)
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label>Size range Length (mm)</label>
                <span class="sub-label">Size range (in mm) from smallest to largest stone</span>
                <div class="flex items-center gap-1.5">
                    <input type="text" name="size_length_from" placeholder='From e.g. "1"'
                        class="form-control px-2 text-center text-[12px]">
                    <span class="text-slate-400">-</span>
                    <input type="text" name="size_length_to" placeholder='To e.g. "2"'
                        class="form-control px-2 text-center text-[12px]">
                </div>
            </div>

            <div class="form-group">
                <label>Size range Width (mm)</label>
                <span class="sub-label">Size range (in mm) from smallest to largest stone</span>
                <div class="flex items-center gap-1.5">
                    <input type="text" name="size_width_from" placeholder='From e.g. "1"'
                        class="form-control px-2 text-center text-[12px]">
                    <span class="text-slate-400">-</span>
                    <input type="text" name="size_width_to" placeholder='To e.g. "2"'
                        class="form-control px-2 text-center text-[12px]">
                </div>
            </div>

            <div class="form-group">
                <label>Color grade range</label>
                <span class="sub-label">Enter your own color grade range.To manage your...</span>
                <div class="flex items-center gap-1.5">
                    <div class="relative flex-1 custom-select-wrapper">
                        <input type="hidden" name="color_grade_from" value="">
                        <button type="button" class="form-control flex items-center pl-2 pr-6 text-left">
                            <span class="truncate text-slate-400 selected-text text-[11px]">Select color from</span>
                        </button>
                        <div class="absolute inset-y-0 right-2 flex items-center pointer-events-none">
                            <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </div>
                        <div class="custom-dropdown-panel">
                            <div class="p-2 hover:bg-slate-50 cursor-pointer text-[11px] dd-item" data-value="">Select color from</div>
                            @foreach($colorGrades ?? [] as $colorGrade)
                                <div class="p-2 hover:bg-slate-50 cursor-pointer text-[11px] dd-item" data-value="{{ $colorGrade->idtbl_color_grade }}">
                                    {{ $colorGrade->grade_name ?? $colorGrade->color_grade ?? $colorGrade->name ?? $colorGrade->idtbl_color_grade }}
                                </div>
                            @endforeach
                        <div class="border-t border-slate-100 mt-1 pt-1">
                            <button type="button" class="create-new-btn flex items-center gap-2 text-[13px] font-semibold text-[#2563eb] hover:text-blue-800 w-full px-3 py-2 transition-colors" data-table="tbl_color_grade">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                Create New
                            </button>
                        </div>
                        </div>
                    </div>
                    <span class="text-slate-400">-</span>
                    <div class="relative flex-1 custom-select-wrapper">
                        <input type="hidden" name="color_grade_to" value="">
                        <button type="button" class="form-control flex items-center pl-2 pr-6 text-left">
                            <span class="truncate text-slate-400 selected-text text-[11px]">Select color to</span>
                        </button>
                        <div class="absolute inset-y-0 right-2 flex items-center pointer-events-none">
                            <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </div>
                        <div class="custom-dropdown-panel">
                            <div class="p-2 hover:bg-slate-50 cursor-pointer text-[11px] dd-item" data-value="">Select color to</div>
                            @foreach($colorGrades ?? [] as $colorGrade)
                                <div class="p-2 hover:bg-slate-50 cursor-pointer text-[11px] dd-item" data-value="{{ $colorGrade->idtbl_color_grade }}">
                                    {{ $colorGrade->grade_name ?? $colorGrade->color_grade ?? $colorGrade->name ?? $colorGrade->idtbl_color_grade }}
                                </div>
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
            </div>

            <div class="form-group">
                <label>Clarity grade range</label>
                <span class="sub-label">Enter your own clarity grade range.To manage yo...</span>
                <div class="flex items-center gap-1.5">
                    <div class="relative flex-1 custom-select-wrapper">
                        <input type="hidden" name="clarity_grade_from" value="">
                        <button type="button" class="form-control flex items-center pl-2 pr-6 text-left">
                            <span class="truncate text-slate-400 selected-text text-[11px]">Select clarity from</span>
                        </button>
                        <div class="absolute inset-y-0 right-2 flex items-center pointer-events-none">
                            <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </div>
                        <div class="custom-dropdown-panel">
                            <div class="p-2 hover:bg-slate-50 cursor-pointer text-[11px] dd-item" data-value="">Select clarity from</div>
                            @foreach($clarityGrades ?? [] as $clarityGrade)
                                <div class="p-2 hover:bg-slate-50 cursor-pointer text-[11px] dd-item" data-value="{{ $clarityGrade->idtbl_clarity_grade }}">
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
                    <span class="text-slate-400">-</span>
                    <div class="relative flex-1 custom-select-wrapper">
                        <input type="hidden" name="clarity_grade_to" value="">
                        <button type="button" class="form-control flex items-center pl-2 pr-6 text-left">
                            <span class="truncate text-slate-400 selected-text text-[11px]">Select clarity to</span>
                        </button>
                        <div class="absolute inset-y-0 right-2 flex items-center pointer-events-none">
                            <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </div>
                        <div class="custom-dropdown-panel">
                            <div class="p-2 hover:bg-slate-50 cursor-pointer text-[11px] dd-item" data-value="">Select clarity to</div>
                            @foreach($clarityGrades ?? [] as $clarityGrade)
                                <div class="p-2 hover:bg-slate-50 cursor-pointer text-[11px] dd-item" data-value="{{ $clarityGrade->idtbl_clarity_grade }}">
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
            </div>

            <div class="form-group">
                <label>Tolerance (mm)</label>
                <span class="sub-label">Specify the tolerance of your parcel (in mm) e.g "...</span>
                <input type="text" name="tolerance_mm" placeholder='Amount e.g. "0.2"' class="form-control px-3">
            </div>

            <div class="form-group">
                <label>Allow selection?</label>
                <span class="sub-label">Specify if you allow selection to be made onto yo...</span>
                <div class="relative w-full custom-select-wrapper">
                    <input type="hidden" name="allow_selection" value="">
                    <button type="button" class="form-control flex items-center pl-3 pr-8 text-left">
                        <span class="truncate text-slate-400 selected-text">Select allow selection?</span>
                    </button>
                    <div class="absolute inset-y-0 right-3 flex items-center pointer-events-none">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                            </path>
                        </svg>
                    </div>
                    <div class="custom-dropdown-panel">
                        <div class="p-2 hover:bg-slate-50 cursor-pointer text-[13px] px-3 dd-item" data-value="1">Yes
                        </div>
                        <div class="p-2 hover:bg-slate-50 cursor-pointer text-[13px] px-3 dd-item" data-value="2">No
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label>Cut grade range</label>
                <span class="sub-label">Enter your own cut grade range.To manage your c...</span>
                <div class="flex items-center gap-1.5">
                    <div class="relative flex-1 custom-select-wrapper">
                        <input type="hidden" name="cut_grade_from" value="">
                        <button type="button" class="form-control flex items-center pl-2 pr-6 text-left">
                            <span class="truncate text-slate-400 selected-text text-[11px]">Select cut from</span>
                        </button>
                        <div class="absolute inset-y-0 right-2 flex items-center pointer-events-none">
                            <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </div>
                        <div class="custom-dropdown-panel">
                            <div class="p-2 hover:bg-slate-50 cursor-pointer text-[11px] dd-item" data-value="">Select cut from</div>
                            @foreach($cutGrades ?? [] as $cutGrade)
                                <div class="p-2 hover:bg-slate-50 cursor-pointer text-[11px] dd-item" data-value="{{ $cutGrade->idtbl_cuttinggrade }}">
                                    {{ $cutGrade->cuttinggradename ?? $cutGrade->cuttinggrade ?? $cutGrade->name ?? $cutGrade->idtbl_cuttinggrade }}
                                </div>
                            @endforeach
                        <div class="border-t border-slate-100 mt-1 pt-1">
                            <button type="button" class="create-new-btn flex items-center gap-2 text-[13px] font-semibold text-[#2563eb] hover:text-blue-800 w-full px-3 py-2 transition-colors" data-table="tbl_cuttinggrade">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                Create New
                            </button>
                        </div>
                        </div>
                    </div>
                    <span class="text-slate-400">-</span>
                    <div class="relative flex-1 custom-select-wrapper">
                        <input type="hidden" name="cut_grade_to" value="">
                        <button type="button" class="form-control flex items-center pl-2 pr-6 text-left">
                            <span class="truncate text-slate-400 selected-text text-[11px]">Select cut to grade</span>
                        </button>
                        <div class="absolute inset-y-0 right-2 flex items-center pointer-events-none">
                            <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </div>
                        <div class="custom-dropdown-panel">
                            <div class="p-2 hover:bg-slate-50 cursor-pointer text-[11px] dd-item" data-value="">Select cut to grade</div>
                            @foreach($cutGrades ?? [] as $cutGrade)
                                <div class="p-2 hover:bg-slate-50 cursor-pointer text-[11px] dd-item" data-value="{{ $cutGrade->idtbl_cuttinggrade }}">
                                    {{ $cutGrade->cuttinggradename ?? $cutGrade->cuttinggrade ?? $cutGrade->name ?? $cutGrade->idtbl_cuttinggrade }}
                                </div>
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
            </div>
        </div>

        <div class="mt-10 mb-6">
            <div class="flex justify-between items-center mb-4">
                <div>
                    <h3 class="text-[15px] font-bold text-slate-800">Custom Fields</h3>
                    <p class="text-[11px] text-slate-400">Additional product information and specifications</p>
                </div>
                <button type="button"
                    class="px-3 py-1.5 bg-white border border-slate-200 text-[12px] text-slate-700 font-semibold rounded-lg hover:bg-slate-50 flex items-center gap-2">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                    </svg>
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
                        <tr
                            class="bg-slate-50 border-b border-slate-200 text-[11px] text-slate-600 font-semibold uppercase tracking-wider">
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
                            <td class="p-3 text-center text-slate-400 text-[12px]" colspan="7">No traceability found.
                            </td>
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
                        <tr
                            class="bg-slate-50 border-b border-slate-200 text-[11px] text-slate-600 font-semibold uppercase tracking-wider">
                            <th class="p-3">Action</th>
                            <th class="p-3">Parent Stone</th>
                            <th class="p-3">Images</th>
                            <th class="p-3">Certificates</th>
                            <th class="p-3">Notes</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="p-3 text-center text-slate-400 text-[12px]" colspan="5">No transformation history
                                found.</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>


</div>