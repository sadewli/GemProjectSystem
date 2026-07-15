<div id="tab-history" class="tab-content hidden flex-col gap-6">
    <div class="card !mb-0 shadow-sm">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="form-group">
                <label>Created Date</label>
                <span class="sub-label">Date and time of creation</span>
                <input type="text" value="{{ isset($product) && $product->insertdatetime ? \Carbon\Carbon::parse($product->insertdatetime)->format('d M Y, h:i A') : date('d M Y, h:i A') }}" readonly
                    class="form-control px-3 bg-slate-50/50 text-slate-500">
            </div>
        </div>

        @if(isset($product) && !empty($product->photos))
        <div class="mb-8">
            <h2 class="text-[14px] font-bold text-slate-800 uppercase tracking-wide border-b border-slate-100 pb-2 mb-4">Media Gallery</h2>
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                @foreach($product->photos as $photo)
                    <div class="aspect-square rounded-lg border border-slate-200 overflow-hidden bg-slate-50 shadow-sm hover:shadow-md transition-all">
                        <img src="{{ $photo }}" class="w-full h-full object-cover cursor-pointer hover:scale-105 transition-transform" alt="Product Photo" onclick="window.open('{{ $photo }}', '_blank')">
                    </div>
                @endforeach
            </div>
        </div>
        @endif

        <div class="flex justify-between items-center mb-6">
            <h2 class="card-title !mb-0">History</h2>
            <div class="relative w-64 custom-select-wrapper">
                <button type="button" class="form-control flex items-center pl-3 pr-8 text-left bg-slate-50">
                    <span class="truncate text-slate-800 selected-text">All Activities</span>
                </button>
                <div class="absolute inset-y-0 right-3 flex items-center pointer-events-none">
                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
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
                    <tr
                        class="bg-slate-50 border-b border-slate-200 text-[11px] text-slate-600 font-semibold uppercase tracking-wider">
                        <th class="p-4">Date & Time</th>
                        <th class="p-4">User</th>
                        <th class="p-4">Action</th>
                        <th class="p-4">Details</th>
                        <th class="p-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($auditLogs ?? [] as $log)
                        <tr class="border-b border-slate-100 hover:bg-slate-50/50 transition-colors">
                            <td class="p-4 text-[13px] text-slate-800">
                                {{ \Carbon\Carbon::parse($log->insertdatetime)->format('d M Y, h:i A') }}
                            </td>
                            <td class="p-4 text-[13px] text-slate-800 font-medium">{{ $log->user_name ?? 'System' }}</td>
                            <td class="p-4">
                                <span
                                    class="px-2.5 py-1 rounded-md text-[12px] font-semibold {{ $log->action === 'Created' ? 'bg-blue-50 text-blue-700' : 'bg-amber-50 text-amber-700' }}">
                                    {{ $log->action }}
                                </span>
                            </td>
                            <td class="p-4 text-[13px] text-slate-600 max-w-xs truncate">
                                {{ $log->note ?? 'Product ID: ' . $log->entity_id }}
                                
                                <div id="log-details-{{ $loop->index }}" class="hidden text-left">
                                    <div class="font-bold text-[16px] text-slate-800 mb-4 border-b pb-2">{{ $log->note ?? 'Activity Details (Product ID: ' . $log->entity_id . ')' }}</div>
                                    @php
                                        $newValues = json_decode($log->new_values, true) ?? [];
                                        $oldValues = json_decode($log->old_values, true) ?? [];
                                        
                                        $categories = [
                                            'Overview' => ['sku_number', 'product_title', 'product_description', 'length_mm', 'width_mm', 'height_mm', 'idtbl_product_types', 'idtbl_categories', 'idtbl_sub_categories', 'idtbl_varieties', 'idtbl_colors', 'idtbl_shapes', 'idtbl_cuts', 'idtbl_treatments', 'idtbl_origins', 'idtbl_color_grade', 'idtbl_cuttinggrade', 'idtbl_clarity_grade', 'idtbl_storage_locations', 'idtbl_tray_box'],
                                            'Advance Details' => ['color_distribution', 'size_length_from', 'size_length_to', 'color_grade_from', 'clarity_grade_to', 'rfid', 'tolerance_mm', 'allow_selection', 'direct_sales'],
                                            'Memo & Purchases' => ['idtbl_suppliers', 'supplier_stone_ref', 'date_of_purchase', 'idtbl_ownership_type', 'my_company_id', 'my_ownership_percentage', 'my_profit_share_percentage', 'partner_ids', 'ownership_percentages', 'profit_percentages'],
                                            'Pricing' => ['weight', 'quantity', 'cost_per_unit', 'total_cost', 'my_cost_per_unit', 'my_total_cost', 'wholesale_per_unit', 'wholesale_total', 'retail_per_unit', 'retail_total', 'matrix_per_unit', 'matrix_total', 'idtbl_weight_units'],
                                            'System' => ['insertdatetime', 'updatedatetime', 'insertuser', 'updateuser', 'idtbl_products']
                                        ];

                                        $allCategorizedKeys = [];
                                        foreach($categories as $cat => $keys) {
                                            $allCategorizedKeys = array_merge($allCategorizedKeys, $keys);
                                        }

                                        // Any key not explicitly categorized goes to 'Other'
                                        $otherKeys = array_diff(array_keys($newValues), $allCategorizedKeys);
                                        if(!empty($otherKeys)) {
                                            $categories['Other'] = $otherKeys;
                                        }
                                    @endphp
                                    
                                    @if(!empty($newValues))
                                        <div class="space-y-6">
                                            @foreach($categories as $categoryName => $keys)
                                                @php
                                                    $hasData = false;
                                                    foreach($keys as $k) {
                                                        if(isset($newValues[$k]) && $newValues[$k] !== null && $newValues[$k] !== '') {
                                                            if(in_array($k, ['insertdatetime', 'updatedatetime', 'insertuser', 'updateuser', 'idtbl_products']) && $categoryName === 'System') continue; // Skip system noise
                                                            $hasData = true; break;
                                                        }
                                                    }
                                                @endphp
                                                
                                                @if($hasData && $categoryName !== 'System')
                                                    <div class="bg-white border border-slate-200 rounded-lg overflow-hidden shadow-sm">
                                                        <div class="bg-slate-50 px-4 py-2 border-b border-slate-200">
                                                            <h3 class="text-[13px] font-bold text-slate-700 uppercase tracking-wide">{{ $categoryName }}</h3>
                                                        </div>
                                                        <div class="p-4 grid grid-cols-1 sm:grid-cols-2 gap-4 bg-white">
                                                            @foreach($keys as $key)
                                                                @php
                                                                    $value = $newValues[$key] ?? null;
                                                                    $oldVal = $oldValues[$key] ?? null;
                                                                    if($value === null || $value === '') continue;
                                                                    if($oldVal == $value && $log->action !== 'Created') continue;
                                                                @endphp
                                                                <div class="flex flex-col">
                                                                    <span class="text-[11px] text-slate-400 font-semibold uppercase tracking-wider mb-1">{{ str_replace(['idtbl_', '_'], ['', ' '], $key) }}</span>
                                                                    <div class="flex items-center gap-2 text-[13px]">
                                                                        @if($oldVal !== null && $oldVal != $value)
                                                                            <span class="text-rose-500 line-through">{{ is_array($oldVal) ? json_encode($oldVal) : $oldVal }}</span>
                                                                            <svg class="w-3.5 h-3.5 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                                                        @endif
                                                                        <span class="text-slate-800 font-medium">{{ is_array($value) ? json_encode($value) : $value }}</span>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                @endif
                                            @endforeach
                                    @endif
                                    
                                    {{-- Display Photos and Videos in Activity Details Modal --}}
                                    @if(isset($product) && (!empty($product->photos) || !empty($product->video) || !empty($product->view360)))
                                        <div class="mt-6">
                                            <div class="font-bold text-[14px] text-slate-800 mb-3 border-b pb-2 uppercase tracking-wide">Product Media</div>
                                            
                                            {{-- Photos --}}
                                            @if(!empty($product->photos))
                                            <div class="mb-4">
                                                <div class="text-[12px] font-semibold text-slate-500 mb-2">Photos</div>
                                                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-3">
                                                    @foreach($product->photos as $photo)
                                                        <div class="aspect-square rounded-lg border border-slate-200 overflow-hidden bg-slate-50 shadow-sm hover:shadow-md transition-all">
                                                            <img src="{{ $photo }}" class="w-full h-full object-cover cursor-pointer" onclick="window.open('{{ $photo }}', '_blank')">
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                            @endif

                                            {{-- Video --}}
                                            @if(!empty($product->video))
                                            <div class="mb-4">
                                                <div class="text-[12px] font-semibold text-slate-500 mb-2">Video</div>
                                                <div class="aspect-video w-full max-w-sm rounded-lg border border-slate-200 overflow-hidden bg-black shadow-sm">
                                                    <video src="{{ $product->video }}" controls class="w-full h-full"></video>
                                                </div>
                                            </div>
                                            @endif

                                            {{-- 360 View --}}
                                            @if(!empty($product->view360))
                                            <div class="mb-4">
                                                <div class="text-[12px] font-semibold text-slate-500 mb-2">360° View</div>
                                                <div class="flex items-center gap-2 p-3 bg-slate-50 border border-slate-200 rounded-lg w-fit hover:bg-slate-100 transition-colors">
                                                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path></svg>
                                                    <a href="{{ $product->view360->file_path ?? '#' }}" target="_blank" class="text-[13px] text-blue-600 font-medium hover:underline">
                                                        {{ $product->view360->file_name ?? 'View 360° File' }}
                                                    </a>
                                                </div>
                                            </div>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                            </td>
                            <td class="p-4 text-right">
                                <button type="button" onclick="viewHistoryDetails({{ $loop->index }})" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-[13px] font-semibold text-blue-700 bg-blue-50 hover:bg-blue-100 rounded-md transition-colors border border-blue-100">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    View
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-4 text-center text-slate-400">No activity history found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    function viewHistoryDetails(index) {
        const contentHtml = document.getElementById('log-details-' + index).innerHTML;
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                title: 'Activity Details',
                html: contentHtml,
                showCloseButton: true,
                showConfirmButton: false,
                customClass: {
                    container: 'font-sans',
                    popup: 'rounded-xl',
                    htmlContainer: 'text-left'
                },
                width: '600px'
            });
        } else {
            // Fallback if sweetalert is not loaded
            const win = window.open('', '_blank', 'width=600,height=400');
            win.document.write('<html><head><title>Activity Details</title><style>body{font-family:sans-serif;padding:20px;}</style><link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet"></head><body>' + contentHtml + '</body></html>');
        }
    }
</script>