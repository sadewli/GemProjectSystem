@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6 max-w-7xl">
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Lot Splits</h1>
            <p class="text-slate-500 text-sm mt-1">History of all split parcels</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('inventory.myinventory.index') }}" class="px-4 py-2 bg-slate-100 text-slate-700 rounded-lg font-medium hover:bg-slate-200 transition-colors">
                Back to Inventory
            </a>
            <button data-bs-toggle="modal" data-bs-target="#splitModal" class="px-4 py-2 bg-blue-600 text-white rounded-lg font-medium hover:bg-blue-700 transition-colors shadow-sm flex items-center gap-2">
                <i class="fa-solid fa-scissors"></i> New Lot Split
            </button>
        </div>
    </div>

    <!-- Lot Splits List -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Parent LOT</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Child LOT</th>
                        <th class="px-6 py-3 text-right text-xs font-semibold text-slate-500 uppercase tracking-wider">Quantity</th>
                        <th class="px-6 py-3 text-right text-xs font-semibold text-slate-500 uppercase tracking-wider">Weight (ct)</th>
                        <th class="px-6 py-3 text-right text-xs font-semibold text-slate-500 uppercase tracking-wider">Cost ($)</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-slate-200">
                    @forelse($lotSplits ?? [] as $split)
                        <tr class="hover:bg-slate-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">
                                {{ \Carbon\Carbon::parse($split->created_at)->format('Y-m-d H:i') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="font-medium text-slate-900">{{ $split->parent_sku }}</div>
                                <div class="text-xs text-slate-500">{{ $split->parent_title ?: 'No Title' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="font-medium text-blue-600 cursor-pointer hover:text-blue-800 editable-sku" data-id="{{ $split->child_product_id }}" title="Click to edit SKU">
                                    <span class="sku-text border-b border-dashed border-blue-400">{{ $split->child_sku }}</span>
                                    <input type="text" class="sku-input hidden form-control form-control-sm w-32 d-none" value="{{ $split->child_sku }}">
                                </div>
                                <div class="text-xs text-slate-500">{{ $split->child_title ?: 'No Title' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-700 text-right font-medium">
                                {{ $split->split_quantity }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-700 text-right font-medium">
                                {{ number_format($split->split_weight_ct, 3) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-700 text-right font-medium">
                                {{ number_format($split->split_cost, 2) }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-10 text-center text-slate-500 text-sm">
                                <i class="fa-solid fa-inbox text-3xl mb-3 text-slate-300 block"></i>
                                No lot splits recorded yet.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Bootstrap / Metronic Modal for Lot Split -->
<div class="modal fade" id="splitModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-1000px" style="position: absolute; left: 60%; transform: translateX(-50%); width: 90%; max-width: 1000px; margin: 1.75rem 0;">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="fw-bold">Split a Bulk Parcel</h2>
                <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                    <i class="fa-solid fa-times fs-1"></i>
                </div>
            </div>
            
            <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                <!-- Step 1: Select Parent LOT -->
                <div class="card shadow-sm border border-slate-200 mb-6">
                    <div class="card-header min-h-50px py-3">
                        <h3 class="card-title text-lg font-semibold text-slate-800">
                            <span class="badge badge-light-primary rounded-circle w-25px h-25px me-2 text-center fs-7">1</span>
                            Select Parent LOT
                        </h3>
                    </div>
                    <div class="card-body p-5">
                        <div class="mb-5">
                            <label class="form-label fs-6 fw-semibold text-slate-700">Search active LOTs by SKU or Name</label>
                            <select id="lotSearch" class="form-select" data-control="select2" data-placeholder="Select a LOT..." data-allow-clear="true" data-dropdown-parent="#splitModal">
                                <option value="">Select a LOT...</option>
                                @if(isset($initialLots))
                                    @foreach($initialLots as $lot)
                                        <option value="{{ $lot->id }}" data-item="{{ json_encode($lot) }}">
                                            {{ $lot->sku_number }} - {{ $lot->product_title ?? 'No Title' }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>

                        <!-- Selected LOT Details -->
                        <div id="selectedLotContainer" class="d-none bg-light rounded border border-secondary p-4 mt-4">
                            <div class="row g-4">
                                <div class="col-6 col-md-3">
                                    <span class="d-block text-muted text-uppercase fs-8 fw-bold">SKU</span>
                                    <span id="lblSku" class="fw-bold text-dark"></span>
                                </div>
                                <div class="col-6 col-md-3">
                                    <span class="d-block text-muted text-uppercase fs-8 fw-bold">Product Title</span>
                                    <span id="lblTitle" class="fw-bold text-dark"></span>
                                </div>
                                <div class="col-6 col-md-3">
                                    <span class="d-block text-muted text-uppercase fs-8 fw-bold">Total Quantity</span>
                                    <span id="lblQty" class="fw-bold text-dark"></span>
                                </div>
                                <div class="col-6 col-md-3">
                                    <span class="d-block text-muted text-uppercase fs-8 fw-bold">Total Weight (ct)</span>
                                    <span id="lblWeight" class="fw-bold text-dark"></span>
                                </div>
                                <div class="col-12 mt-4">
                                    <span class="d-block text-muted text-uppercase fs-8 fw-bold">Total Cost ($)</span>
                                    <span id="lblCost" class="fw-bold text-primary fs-4"></span>
                                </div>
                            </div>
                            <input type="hidden" id="selectedParentId">
                        </div>
                    </div>
                </div>

                <!-- Step 2: Split Configuration -->
                <div id="step2" class="card shadow-sm border border-slate-200 mb-6 opacity-50" style="pointer-events: none;">
                    <div class="card-header min-h-50px py-3">
                        <h3 class="card-title text-lg font-semibold text-slate-800">
                            <span class="badge badge-light-primary rounded-circle w-25px h-25px me-2 text-center fs-7">2</span>
                            Split Configuration
                        </h3>
                    </div>
                    <div class="card-body p-5">
                        <div class="w-100 mw-300px">
                            <label class="form-label fs-6 fw-semibold text-slate-700">Number of parts to split into</label>
                            <input type="number" id="splitCount" min="2" max="20" placeholder="e.g. 2" class="form-control">
                            <div class="form-text mt-2">Enter a number to automatically generate rows.</div>
                        </div>
                    </div>
                </div>

                <!-- Step 3 & 4: Output Rows & Reconciliation -->
                <div id="step3" class="card shadow-sm border border-slate-200 mb-6 d-none">
                    <div class="card-header min-h-50px py-3">
                        <h3 class="card-title text-lg font-semibold text-slate-800">
                            <span class="badge badge-light-primary rounded-circle w-25px h-25px me-2 text-center fs-7">3</span>
                            Adjust Output Rows & Reconcile
                        </h3>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-row-bordered table-row-gray-200 align-middle gs-4 gy-4 mb-0">
                                <thead class="bg-light">
                                    <tr class="fw-bold text-muted text-uppercase">
                                        <th class="min-w-100px">Part</th>
                                        <th class="min-w-150px">Quantity</th>
                                        <th class="min-w-150px">Weight (ct)</th>
                                        <th class="min-w-150px">Cost ($)</th>
                                    </tr>
                                </thead>
                                <tbody id="splitRowsContainer">
                                    <!-- Dynamic Rows -->
                                </tbody>
                                <tfoot class="bg-light border-top-2 border-secondary">
                                    <tr>
                                        <td class="text-end fw-bold text-dark">TOTAL INPUT:</td>
                                        <td class="fw-bold text-dark" id="parentTotalQty">0</td>
                                        <td class="fw-bold text-dark" id="parentTotalWeight">0.00</td>
                                        <td class="fw-bold text-dark" id="parentTotalCost">0.00</td>
                                    </tr>
                                    <tr>
                                        <td class="text-end fw-bold text-dark">TOTAL OUTPUT:</td>
                                        <td class="fw-bold" id="calcTotalQty">0</td>
                                        <td class="fw-bold" id="calcTotalWeight">0.00</td>
                                        <td class="fw-bold" id="calcTotalCost">0.00</td>
                                    </tr>
                                    <tr>
                                        <td class="text-end fw-bold text-dark">DIFFERENCE:</td>
                                        <td class="fw-bold" id="diffQty">0</td>
                                        <td class="fw-bold" id="diffWeight">0.00</td>
                                        <td class="fw-bold" id="diffCost">0.00</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        <!-- Status -->
                        <div id="reconciliationStatus" class="d-flex align-items-center gap-2 text-warning fw-bold p-5">
                            <i class="fa-solid fa-circle-exclamation fs-4 text-warning"></i>
                            Totals do not match Parent LOT. Adjust values above.
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="modal-footer flex-end">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                <button type="button" id="btnSubmitSplit" disabled class="btn btn-primary">
                    <i class="fa-solid fa-scissors me-2"></i> Complete Split
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        let parentData = null;
        let generateTimeout = null;
        const lotSearch = $('#lotSearch');
        
        lotSearch.select2({
            placeholder: 'e.g. LT-001 or Sapphire Parcel',
            allowClear: true,
            dropdownParent: $('#splitModal'), // Ensure select2 dropdown is visible in modal
            ajax: {
                url: '/Inventory/LotSplit/search',
                dataType: 'json',
                delay: 300,
                data: function (params) {
                    return {
                        q: params.term
                    };
                },
                processResults: function (data) {
                    return {
                        results: data.map(function(item) {
                            return {
                                id: item.id,
                                text: item.sku_number + ' - ' + (item.product_title || 'No Title'),
                                itemData: item
                            };
                        })
                    };
                },
                cache: true
            },
            templateResult: function (item) {
                if (!item.itemData && item.element && $(item.element).data('item')) {
                    item.itemData = $(item.element).data('item');
                    if (typeof item.itemData === 'string') {
                        item.itemData = JSON.parse(item.itemData);
                    }
                }
                
                if (item.loading || !item.itemData) {
                    return item.text;
                }
                var $container = $(
                    "<div class='p-1'>" +
                        "<div class='font-semibold text-slate-800'>" + item.itemData.sku_number + " <span class='text-slate-500 text-sm font-normal'>- " + (item.itemData.product_title || 'No Title') + "</span></div>" +
                        "<div class='text-xs text-slate-500 mt-1'>Qty: " + item.itemData.quantity + " | Wt: " + item.itemData.weight_ct + "ct | Cost: $" + parseFloat(item.itemData.total_cost).toFixed(2) + "</div>" +
                    "</div>"
                );
                return $container;
            },
            templateSelection: function (item) {
                return item.text;
            }
        });

        lotSearch.on('select2:select', function (e) {
            let itemData = e.params.data.itemData;
            if (!itemData && e.params.data.element) {
                let dataAttr = $(e.params.data.element).data('item');
                if (dataAttr) {
                    itemData = typeof dataAttr === 'string' ? JSON.parse(dataAttr) : dataAttr;
                }
            }
            if (itemData) {
                selectLot(itemData);
            }
        });

        lotSearch.on('select2:unselect', function (e) {
            parentData = null;
            document.getElementById('selectedLotContainer').classList.add('d-none');
            document.getElementById('step2').classList.add('opacity-50');
            document.getElementById('step2').style.pointerEvents = 'none';
            document.getElementById('step3').classList.add('d-none');
            document.getElementById('splitCount').value = '';
        });

        function selectLot(item) {
            parentData = item;
            
            document.getElementById('selectedParentId').value = item.id;
            document.getElementById('lblSku').innerText = item.sku_number;
            document.getElementById('lblTitle').innerText = item.product_title || '-';
            document.getElementById('lblQty').innerText = item.quantity;
            document.getElementById('lblWeight').innerText = item.weight_ct;
            document.getElementById('lblCost').innerText = parseFloat(item.total_cost || 0).toFixed(2);
            
            document.getElementById('parentTotalQty').innerText = item.quantity;
            document.getElementById('parentTotalWeight').innerText = item.weight_ct;
            document.getElementById('parentTotalCost').innerText = parseFloat(item.total_cost || 0).toFixed(2);
            
            document.getElementById('selectedLotContainer').classList.remove('d-none');
            
            // Enable Step 2
            document.getElementById('step2').classList.remove('opacity-50');
            document.getElementById('step2').style.pointerEvents = 'auto';
            
            // Auto generate if there's already a value in splitCount
            if(document.getElementById('splitCount').value) {
                generateRows();
            }
        }

        // Auto-Generate Rows on Input change with slight debounce
        document.getElementById('splitCount').addEventListener('input', function() {
            clearTimeout(generateTimeout);
            generateTimeout = setTimeout(generateRows, 400);
        });

        function generateRows() {
            if(!parentData) return;
            
            const count = parseInt(document.getElementById('splitCount').value);
            const container = document.getElementById('splitRowsContainer');
            
            if(!count || count < 2 || count > 100) {
                container.innerHTML = '';
                document.getElementById('step3').classList.add('d-none');
                return;
            }
            
            container.innerHTML = '';
            
            // Calculate even splits for defaults
            const baseQty = Math.floor(parentData.quantity / count);
            const extraQty = parentData.quantity % count;
            
            const baseWeight = (parentData.weight_ct / count).toFixed(3);
            const baseCost = (parseFloat(parentData.total_cost || 0) / count).toFixed(2);
            
            for(let i=0; i<count; i++) {
                const tr = document.createElement('tr');
                const defaultQty = i === 0 ? baseQty + extraQty : baseQty;
                
                tr.innerHTML = `
                    <td class="text-dark fw-bold">Part ${i+1}</td>
                    <td>
                        <input type="number" class="split-qty form-control form-control-sm" value="${defaultQty}" min="0">
                    </td>
                    <td>
                        <input type="number" class="split-weight form-control form-control-sm" value="${baseWeight}" min="0" step="0.01">
                    </td>
                    <td>
                        <input type="number" class="split-cost form-control form-control-sm" value="${baseCost}" min="0" step="0.01">
                    </td>
                `;
                container.appendChild(tr);
            }
            
            document.getElementById('step3').classList.remove('d-none');
            attachRowListeners();
            calculateTotals();
        }

        // Step 3 & 4: Recalculate Totals
        function attachRowListeners() {
            document.querySelectorAll('.split-qty, .split-weight, .split-cost').forEach(input => {
                input.addEventListener('input', calculateTotals);
            });
        }

        function calculateTotals() {
            if(!parentData) return;
            
            let tQty = 0;
            let tWeight = 0;
            let tCost = 0;
            
            document.querySelectorAll('.split-qty').forEach(i => tQty += (parseInt(i.value) || 0));
            document.querySelectorAll('.split-weight').forEach(i => tWeight += (parseFloat(i.value) || 0));
            document.querySelectorAll('.split-cost').forEach(i => tCost += (parseFloat(i.value) || 0));
            
            document.getElementById('calcTotalQty').innerText = tQty;
            document.getElementById('calcTotalWeight').innerText = tWeight.toFixed(3);
            document.getElementById('calcTotalCost').innerText = tCost.toFixed(2);
            
            const diffQty = parentData.quantity - tQty;
            const diffWeight = parseFloat(parentData.weight_ct) - tWeight;
            const diffCost = parseFloat(parentData.total_cost || 0) - tCost;
            
            const eDiffQty = document.getElementById('diffQty');
            const eDiffWt = document.getElementById('diffWeight');
            const eDiffCt = document.getElementById('diffCost');
            
            eDiffQty.innerText = diffQty;
            eDiffWt.innerText = diffWeight.toFixed(3);
            eDiffCt.innerText = diffCost.toFixed(2);
            
            const colorClass = (val) => Math.abs(val) < 0.01 ? 'text-green-600' : 'text-red-600';
            
            eDiffQty.className = `px-3 py-4 font-bold ${colorClass(diffQty)}`;
            eDiffWt.className = `px-3 py-4 font-bold ${colorClass(diffWeight)}`;
            eDiffCt.className = `px-3 py-4 font-bold ${colorClass(diffCost)}`;
            
            const isBalanced = diffQty === 0 && Math.abs(diffWeight) < 0.01 && Math.abs(diffCost) < 0.01;
            
            const statusDiv = document.getElementById('reconciliationStatus');
            const submitBtn = document.getElementById('btnSubmitSplit');
            
            if(isBalanced) {
                statusDiv.className = "mt-4 flex items-center gap-2 text-green-600 font-semibold";
                statusDiv.innerHTML = '<i class="fa-solid fa-circle-check"></i> Balanced! Ready to split.';
                submitBtn.disabled = false;
            } else {
                statusDiv.className = "mt-4 flex items-center gap-2 text-red-600 font-semibold";
                statusDiv.innerHTML = '<i class="fa-solid fa-circle-exclamation"></i> Totals do not match Parent LOT. Adjust values above.';
                submitBtn.disabled = true;
            }
        }

        // Submit
        document.getElementById('btnSubmitSplit').addEventListener('click', function() {
            this.disabled = true;
            this.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Processing...';
            
            const splits = [];
            document.querySelectorAll('#splitRowsContainer tr').forEach(tr => {
                splits.push({
                    quantity: parseInt(tr.querySelector('.split-qty').value),
                    weight_ct: parseFloat(tr.querySelector('.split-weight').value),
                    cost: parseFloat(tr.querySelector('.split-cost').value)
                });
            });
            
            fetch("{{ route('inventory.lotsplit.store') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    parent_product_id: parentData.id,
                    splits: splits
                })
            })
            .then(res => res.json())
            .then(data => {
                if(data.success) {
                    alert('Success: ' + data.message);
                    window.location.reload(); // Reload to show new list
                } else {
                    alert('Error: ' + data.message);
                    document.getElementById('btnSubmitSplit').disabled = false;
                    document.getElementById('btnSubmitSplit').innerHTML = '<i class="fa-solid fa-scissors"></i> Complete Split';
                }
            })
            .catch(err => {
                console.error(err);
                alert('An error occurred during submission.');
                document.getElementById('btnSubmitSplit').disabled = false;
                document.getElementById('btnSubmitSplit').innerHTML = '<i class="fa-solid fa-scissors"></i> Complete Split';
            });
        });

        document.querySelectorAll('.editable-sku').forEach(el => {
            const textSpan = el.querySelector('.sku-text');
            const input = el.querySelector('.sku-input');
            const productId = el.dataset.id;

            textSpan.addEventListener('click', () => {
                textSpan.classList.add('d-none');
                input.classList.remove('d-none', 'hidden');
                input.focus();
            });

            const submitEdit = () => {
                const newSku = input.value.trim();
                if (!newSku || newSku === textSpan.innerText) {
                    input.classList.add('d-none');
                    textSpan.classList.remove('d-none');
                    return;
                }

                fetch('{{ route('inventory.lotsplit.update-sku') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        id: productId,
                        sku_number: newSku
                    })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        textSpan.innerText = newSku;
                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            icon: 'success',
                            title: 'SKU updated successfully',
                            showConfirmButton: false,
                            timer: 2000
                        });
                    } else {
                        Swal.fire('Error', data.message, 'error');
                        input.value = textSpan.innerText;
                    }
                    input.classList.add('d-none');
                    textSpan.classList.remove('d-none');
                })
                .catch(err => {
                    Swal.fire('Error', 'Failed to update SKU', 'error');
                    input.classList.add('d-none');
                    textSpan.classList.remove('d-none');
                });
            };

            input.addEventListener('blur', submitEdit);
            input.addEventListener('keydown', (e) => {
                if (e.key === 'Enter') {
                    input.blur();
                } else if (e.key === 'Escape') {
                    input.value = textSpan.innerText;
                    input.classList.add('d-none');
                    textSpan.classList.remove('d-none');
                }
            });
        });

    });
</script>
@endsection
