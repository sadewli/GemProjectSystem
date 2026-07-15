@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6 max-w-5xl">
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Lot Split</h1>
            <p class="text-slate-500 text-sm mt-1">Split a bulk parcel into multiple distinct products</p>
        </div>
        <a href="{{ route('inventory.myinventory.index') }}" class="px-4 py-2 bg-slate-100 text-slate-700 rounded-lg font-medium hover:bg-slate-200 transition-colors">
            Back to Inventory
        </a>
    </div>

    <!-- Step 1: Select Parent LOT -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 mb-6">
        <h2 class="text-lg font-semibold text-slate-800 border-b border-slate-100 pb-3 mb-4">
            <span class="bg-blue-100 text-blue-700 w-6 h-6 inline-flex items-center justify-center rounded-full text-xs mr-2">1</span> 
            Select Parent LOT
        </h2>
        
        <div class="mb-6">
            <label class="block text-sm font-medium text-slate-700 mb-1">Search active LOTs by SKU or Name</label>
            <select id="lotSearch" class="block w-full border border-slate-300 rounded-lg sm:text-sm">
                <option value="">Select a LOT...</option>
            </select>
        </div>

        <!-- Selected LOT Details -->
        <div id="selectedLotContainer" class="hidden bg-slate-50 p-4 rounded-lg border border-slate-200">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div>
                    <span class="block text-xs font-semibold text-slate-500 uppercase">SKU</span>
                    <span id="lblSku" class="text-slate-800 font-medium"></span>
                </div>
                <div>
                    <span class="block text-xs font-semibold text-slate-500 uppercase">Product Title</span>
                    <span id="lblTitle" class="text-slate-800 font-medium"></span>
                </div>
                <div>
                    <span class="block text-xs font-semibold text-slate-500 uppercase">Total Quantity</span>
                    <span id="lblQty" class="text-slate-800 font-medium"></span>
                </div>
                <div>
                    <span class="block text-xs font-semibold text-slate-500 uppercase">Total Weight (ct)</span>
                    <span id="lblWeight" class="text-slate-800 font-medium"></span>
                </div>
                <div class="col-span-2 md:col-span-4">
                    <span class="block text-xs font-semibold text-slate-500 uppercase">Total Cost ($)</span>
                    <span id="lblCost" class="text-slate-800 font-medium text-lg text-blue-600"></span>
                </div>
            </div>
            <input type="hidden" id="selectedParentId">
        </div>
    </div>

    <!-- Step 2: Split Configuration -->
    <div id="step2" class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 mb-6 opacity-50 pointer-events-none transition-opacity">
        <h2 class="text-lg font-semibold text-slate-800 border-b border-slate-100 pb-3 mb-4">
            <span class="bg-blue-100 text-blue-700 w-6 h-6 inline-flex items-center justify-center rounded-full text-xs mr-2">2</span> 
            Split Configuration
        </h2>
        
        <div class="flex items-end gap-4">
            <div class="w-48">
                <label class="block text-sm font-medium text-slate-700 mb-1">Number of parts to split into</label>
                <input type="number" id="splitCount" min="2" max="20" value="2" class="block w-full border border-slate-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 sm:text-sm py-2 px-3">
            </div>
            <button id="btnGenerate" class="px-5 py-2 bg-slate-800 text-white rounded-lg font-medium hover:bg-slate-900 transition-colors h-[38px]">
                Generate Rows
            </button>
        </div>
    </div>

    <!-- Step 3 & 4: Output Rows & Reconciliation -->
    <div id="step3" class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 mb-6 hidden">
        <h2 class="text-lg font-semibold text-slate-800 border-b border-slate-100 pb-3 mb-4">
            <span class="bg-blue-100 text-blue-700 w-6 h-6 inline-flex items-center justify-center rounded-full text-xs mr-2">3</span> 
            Adjust Output Rows & Reconcile
        </h2>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-3 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Part</th>
                        <th class="px-3 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider w-1/4">Quantity</th>
                        <th class="px-3 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider w-1/4">Weight (ct)</th>
                        <th class="px-3 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider w-1/4">Cost ($)</th>
                    </tr>
                </thead>
                <tbody id="splitRowsContainer" class="bg-white divide-y divide-slate-200">
                    <!-- Dynamic Rows -->
                </tbody>
                <tfoot class="bg-slate-50 border-t-2 border-slate-300">
                    <tr>
                        <td class="px-3 py-4 text-right font-bold text-slate-700">TOTAL INPUT:</td>
                        <td class="px-3 py-4 font-bold text-slate-700" id="parentTotalQty">0</td>
                        <td class="px-3 py-4 font-bold text-slate-700" id="parentTotalWeight">0.00</td>
                        <td class="px-3 py-4 font-bold text-slate-700" id="parentTotalCost">0.00</td>
                    </tr>
                    <tr>
                        <td class="px-3 py-4 text-right font-bold text-slate-700">TOTAL OUTPUT:</td>
                        <td class="px-3 py-4 font-bold" id="calcTotalQty">0</td>
                        <td class="px-3 py-4 font-bold" id="calcTotalWeight">0.00</td>
                        <td class="px-3 py-4 font-bold" id="calcTotalCost">0.00</td>
                    </tr>
                    <tr>
                        <td class="px-3 py-4 text-right font-bold text-slate-700">DIFFERENCE:</td>
                        <td class="px-3 py-4 font-bold" id="diffQty">0</td>
                        <td class="px-3 py-4 font-bold" id="diffWeight">0.00</td>
                        <td class="px-3 py-4 font-bold" id="diffCost">0.00</td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <!-- Status & Submit -->
        <div class="mt-6 flex flex-col md:flex-row items-center justify-between border-t border-slate-100 pt-6">
            <div id="reconciliationStatus" class="flex items-center gap-2 mb-4 md:mb-0 text-amber-600 font-semibold">
                <i class="fa-solid fa-circle-exclamation"></i>
                Totals do not match Parent LOT. Adjust values above.
            </div>
            
            <button id="btnSubmitSplit" disabled class="px-6 py-3 bg-blue-600 text-white rounded-lg font-bold hover:bg-blue-700 disabled:opacity-50 disabled:cursor-not-allowed transition-colors shadow-sm flex items-center gap-2">
                <i class="fa-solid fa-scissors"></i> Complete & Add to Inventory
            </button>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        let parentData = null;
        const lotSearch = $('#lotSearch');
        
        lotSearch.select2({
            placeholder: 'e.g. LT-001 or Sapphire Parcel',
            allowClear: true,
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
                if (item.loading) {
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
            selectLot(e.params.data.itemData);
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
            
            document.getElementById('selectedLotContainer').classList.remove('hidden');
            
            // Enable Step 2
            document.getElementById('step2').classList.remove('opacity-50', 'pointer-events-none');
        }

        // Step 2: Generate Rows
        document.getElementById('btnGenerate').addEventListener('click', function() {
            if(!parentData) return;
            
            const count = parseInt(document.getElementById('splitCount').value) || 2;
            const container = document.getElementById('splitRowsContainer');
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
                    <td class="px-3 py-3 text-sm font-medium text-slate-700">Part ${i+1}</td>
                    <td class="px-3 py-3">
                        <input type="number" class="split-qty block w-full border border-slate-300 rounded-md focus:ring-blue-500 focus:border-blue-500 sm:text-sm px-2 py-1" value="${defaultQty}" min="0">
                    </td>
                    <td class="px-3 py-3">
                        <input type="number" class="split-weight block w-full border border-slate-300 rounded-md focus:ring-blue-500 focus:border-blue-500 sm:text-sm px-2 py-1" value="${baseWeight}" min="0" step="0.01">
                    </td>
                    <td class="px-3 py-3">
                        <input type="number" class="split-cost block w-full border border-slate-300 rounded-md focus:ring-blue-500 focus:border-blue-500 sm:text-sm px-2 py-1" value="${baseCost}" min="0" step="0.01">
                    </td>
                `;
                container.appendChild(tr);
            }
            
            document.getElementById('step3').classList.remove('hidden');
            attachRowListeners();
            calculateTotals();
        });

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
                statusDiv.className = "flex items-center gap-2 mb-4 md:mb-0 text-green-600 font-semibold";
                statusDiv.innerHTML = '<i class="fa-solid fa-circle-check"></i> Balanced! Ready to split.';
                submitBtn.disabled = false;
            } else {
                statusDiv.className = "flex items-center gap-2 mb-4 md:mb-0 text-red-600 font-semibold";
                statusDiv.innerHTML = '<i class="fa-solid fa-circle-exclamation"></i> Totals do not match Parent LOT. Adjust values above.';
                submitBtn.disabled = true;
            }
        }

        // Step 5: Submit
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
                    window.location.href = "{{ route('inventory.myinventory.index') }}";
                } else {
                    alert('Error: ' + data.message);
                    document.getElementById('btnSubmitSplit').disabled = false;
                    document.getElementById('btnSubmitSplit').innerHTML = '<i class="fa-solid fa-scissors"></i> Complete & Add to Inventory';
                }
            })
            .catch(err => {
                console.error(err);
                alert('An error occurred during submission.');
                document.getElementById('btnSubmitSplit').disabled = false;
                document.getElementById('btnSubmitSplit').innerHTML = '<i class="fa-solid fa-scissors"></i> Complete & Add to Inventory';
            });
        });
    });
</script>
@endsection
