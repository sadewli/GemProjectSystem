@extends('layouts.app')

@section('title', 'Production - Lot Split')

@section('content')
<script src="https://cdn.tailwindcss.com"></script>
<!-- Include Google Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>
    body {
        font-family: 'Inter', sans-serif;
        background-color: #f8fafc;
    }
    
    .glass-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
    }
    
    .step-content {
        display: none;
        animation: fadeIn 0.4s ease-out forwards;
    }
    
    .step-content.active {
        display: block;
    }
    
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    .form-input {
        @apply w-full rounded-lg border-slate-200 bg-slate-50 px-4 py-2.5 text-sm text-slate-800 focus:border-blue-500 focus:bg-white focus:ring-2 focus:ring-blue-500/20 transition-all outline-none;
    }
</style>

<div class="container mx-auto px-4 py-8 max-w-5xl">
    
    <!-- Header -->
    <div class="flex items-center justify-between mb-8">
        <div>
            <a href="#" class="text-sm font-medium text-slate-500 hover:text-slate-800 transition-colors flex items-center gap-1 mb-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Back to Production
            </a>
            <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Production Sheet</h1>
            <p class="text-sm text-slate-500 mt-1">New Re-assortment / Lot Split</p>
        </div>
        <div class="flex items-center gap-3">
            <span class="px-3 py-1 bg-amber-100 text-amber-800 text-xs font-semibold rounded-full border border-amber-200">Draft</span>
            <button class="px-4 py-2 text-sm font-semibold text-slate-700 bg-white border border-slate-300 rounded-lg shadow-sm hover:bg-slate-50 transition-colors flex items-center gap-2">
                Save <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
            </button>
        </div>
    </div>

    <!-- Stepper Indicator -->
    <div class="mb-8">
        <div class="flex items-center justify-center space-x-4">
            <div id="step1-indicator" class="flex items-center text-blue-600">
                <span class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center font-semibold text-sm mr-2 ring-4 ring-blue-50">1</span>
                <span class="font-medium text-sm">Parent Lot</span>
            </div>
            <div class="w-16 h-0.5 bg-slate-200"></div>
            <div id="step2-indicator" class="flex items-center text-slate-400">
                <span class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center font-semibold text-sm mr-2">2</span>
                <span class="font-medium text-sm">Split Output</span>
            </div>
            <div class="w-16 h-0.5 bg-slate-200"></div>
            <div id="step3-indicator" class="flex items-center text-slate-400">
                <span class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center font-semibold text-sm mr-2">3</span>
                <span class="font-medium text-sm">Confirm</span>
            </div>
        </div>
    </div>

    <!-- ============================================== -->
    <!-- SCREEN 1: Input / Parent Lot                   -->
    <!-- ============================================== -->
    <div id="step-1" class="step-content active glass-card rounded-2xl p-8 mb-6">
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="col-span-1 md:col-span-3">
                <h3 class="text-lg font-semibold text-slate-800 mb-4 border-b border-slate-100 pb-2">Production Details</h3>
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Production Type</label>
                <div class="relative">
                    <select class="form-input appearance-none cursor-pointer w-full rounded-lg border-slate-200 bg-slate-50 px-4 py-2.5 text-sm text-slate-800 focus:border-blue-500 focus:bg-white focus:ring-2 focus:ring-blue-500/20 transition-all outline-none">
                        <option>Re-assortment (Lot Split)</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-slate-500">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </div>
                </div>
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Reference</label>
                <input type="text" class="form-input w-full rounded-lg border-slate-200 bg-slate-50 px-4 py-2.5 text-sm text-slate-800 focus:border-blue-500 focus:bg-white focus:ring-2 focus:ring-blue-500/20 transition-all outline-none" value="LS-2026-001" readonly>
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Due Date</label>
                <input type="date" class="form-input w-full rounded-lg border-slate-200 bg-slate-50 px-4 py-2.5 text-sm text-slate-800 focus:border-blue-500 focus:bg-white focus:ring-2 focus:ring-blue-500/20 transition-all outline-none" value="2026-07-15">
            </div>
        </div>

        <div class="mb-4 flex items-center justify-between border-b border-slate-100 pb-2">
            <h3 class="text-lg font-semibold text-slate-800">Input / Parent Lot</h3>
            <button type="button" class="text-sm font-medium text-slate-500 hover:text-slate-700 transition-colors">Change</button>
        </div>

        <!-- Search SKU Dropdown (Mockup) -->
        <div class="mb-6 relative">
            <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Search SKU</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-4 w-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                <input type="text" class="form-input pl-10 w-full rounded-lg border-slate-200 bg-white px-4 py-2.5 text-sm text-slate-800 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all outline-none" placeholder="Search by SKU..." value="gm5">
            </div>
            
            <!-- Live Search Dropdown -->
            <div class="absolute z-10 mt-1 w-full bg-white shadow-lg max-h-60 rounded-md py-1 text-base ring-1 ring-black ring-opacity-5 overflow-auto focus:outline-none sm:text-sm">
                <ul class="divide-y divide-slate-100">
                    <li class="cursor-pointer select-none relative py-2 pl-3 pr-9 hover:bg-slate-50 transition-colors">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <span class="font-bold text-slate-800">gm50</span>
                                <span class="ml-2 text-slate-500">- Sapphire - 100pcs - 50.00ct</span>
                            </div>
                            <button class="text-blue-600 bg-blue-50 hover:bg-blue-100 font-semibold px-2 py-1 rounded text-xs transition-colors">Select</button>
                        </div>
                    </li>
                    <li class="cursor-pointer select-none relative py-2 pl-3 pr-9 hover:bg-slate-50 transition-colors">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <span class="font-bold text-slate-800">gm51</span>
                                <span class="ml-2 text-slate-500">- Sapphire - 50pcs - 25.00ct</span>
                            </div>
                            <button class="text-blue-600 bg-blue-50 hover:bg-blue-100 font-semibold px-2 py-1 rounded text-xs transition-colors">Select</button>
                        </div>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Selected Parent Lot Card -->
        <div class="bg-gradient-to-br from-emerald-50 to-emerald-100/30 border border-emerald-200 rounded-xl p-6 relative group overflow-hidden mb-8">
            <div class="absolute left-0 top-0 bottom-0 w-1.5 bg-emerald-500"></div>
            
            <button class="absolute top-4 right-4 text-slate-400 hover:text-rose-500 transition-colors p-2 hover:bg-rose-50 rounded-lg">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
            </button>

            <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 pl-4">
                <div>
                    <div class="flex items-center gap-3 mb-1">
                        <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        <span class="px-2.5 py-1 bg-emerald-100 text-emerald-700 text-xs font-bold rounded shadow-sm">Selected</span>
                        <h4 class="text-xl font-bold text-slate-900 tracking-tight">gm50</h4>
                    </div>
                    <p class="text-sm font-medium text-slate-500 mt-2">Variety: <span class="text-slate-800">Sapphire</span> &bull; Origin: <span class="text-slate-800">Sri Lanka</span></p>
                </div>
                
                <div class="flex gap-4">
                    <div class="bg-white px-4 py-3 rounded-lg border border-slate-200 shadow-sm min-w-[100px] text-center">
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Qty</p>
                        <p class="text-lg font-bold text-slate-800">100</p>
                    </div>
                    <div class="bg-white px-4 py-3 rounded-lg border border-slate-200 shadow-sm min-w-[100px] text-center">
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Weight</p>
                        <p class="text-lg font-bold text-slate-800">50.00<span class="text-xs text-slate-500 font-medium ml-1">ct</span></p>
                    </div>
                    <div class="bg-slate-800 px-5 py-3 rounded-lg border border-slate-700 shadow-sm min-w-[140px] text-center text-white">
                        <p class="text-[10px] font-semibold text-slate-300 uppercase tracking-wider mb-1">Total Cost</p>
                        <p class="text-lg font-bold">$150,000.00</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Split Configuration -->
        <div class="bg-slate-50 border border-slate-200 rounded-xl p-6">
            <h3 class="text-lg font-semibold text-slate-800 mb-2">Split Configuration</h3>
            <p class="text-sm text-slate-500 mb-4">How many parts do you want to split this lot into?</p>
            
            <div class="flex items-center gap-4">
                <div class="w-32">
                    <input type="number" id="split-parts-input" class="form-input text-center font-bold text-lg" value="2" min="2" max="10">
                </div>
                <button type="button" onclick="generateSplitRows()" class="px-6 py-3 text-sm font-semibold text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition-colors shadow-sm shadow-blue-600/20 flex items-center gap-2">
                    Generate Split Rows 
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </button>
            </div>
        </div>

        <!-- Footer Actions -->
        <div class="mt-10 flex justify-start gap-3 pt-6 border-t border-slate-100">
            <button class="px-6 py-2.5 text-sm font-medium text-slate-600 bg-white border border-slate-300 rounded-lg hover:bg-slate-50 transition-colors">Cancel</button>
        </div>
    </div>


    <!-- ============================================== -->
    <!-- SCREEN 2: Split Output                         -->
    <!-- ============================================== -->
    <div id="step-2" class="step-content glass-card rounded-2xl p-8 mb-6">
        
        <!-- Parent Summary Ribbon -->
        <div class="bg-slate-800 rounded-xl p-4 mb-8 flex items-center justify-between text-white shadow-lg">
            <div class="flex items-center gap-4">
                <span class="bg-blue-500/20 text-blue-300 px-2 py-1 rounded text-xs font-bold uppercase tracking-wider border border-blue-500/30">Parent</span>
                <span class="font-bold text-lg tracking-wide">gm50</span>
            </div>
            <div class="flex items-center gap-6 text-sm">
                <div class="flex items-center gap-2"><svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg> 100 pcs</div>
                <div class="flex items-center gap-2"><svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"></path></svg> 50.00 ct</div>
                <div class="font-bold text-emerald-400 bg-emerald-400/10 px-3 py-1 rounded-md">$150,000.00</div>
            </div>
        </div>

        <!-- Split Outputs -->
        <div class="mb-4 flex items-center justify-between border-b border-slate-100 pb-2">
            <h3 id="split-outputs-title" class="text-lg font-semibold text-slate-800">Split Outputs</h3>
            <button onclick="addSplitRow()" type="button" class="text-sm font-medium text-emerald-600 hover:text-emerald-800 flex items-center gap-1 transition-colors bg-emerald-50 hover:bg-emerald-100 px-3 py-1.5 rounded-lg shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Add Part
            </button>
        </div>
        <p class="text-sm text-slate-500 flex items-center gap-2 mb-4 bg-blue-50 text-blue-700 px-3 py-2 rounded-lg border border-blue-100 w-fit">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <strong>Tip:</strong> Adjusting Part 1 auto-recalculates remaining parts (mockup feature)
        </p>

        <div id="split-rows-container" class="space-y-4 mb-8">
            <!-- Rows are auto-generated here by JS -->
        </div>

        <!-- Reconciliation Dashboard -->
        <div class="bg-slate-50 border-2 border-slate-200 rounded-xl p-5 mb-2 relative overflow-hidden transition-all" id="reconciliation-panel">
            <!-- decorative overlay for status -->
            <div id="recon-status-bar" class="absolute left-0 top-0 bottom-0 w-2 bg-emerald-500 transition-colors"></div>
            
            <h4 class="text-sm font-bold text-slate-800 mb-4 pl-4 uppercase tracking-wider flex items-center gap-2">
                Reconciliation Check
                <span id="recon-badge" class="px-2 py-0.5 rounded text-[10px] bg-emerald-100 text-emerald-700 border border-emerald-200">Balanced</span>
            </h4>
            
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 pl-4">
                <div>
                    <p class="text-[11px] text-slate-500 font-semibold uppercase mb-1">Total Qty (Output)</p>
                    <p class="text-lg font-bold text-slate-800" id="total-qty">100 / 100 <span class="text-xs text-slate-500 font-medium">pcs</span></p>
                </div>
                <div>
                    <p class="text-[11px] text-slate-500 font-semibold uppercase mb-1">Total Wgt (Output)</p>
                    <p class="text-lg font-bold text-slate-800" id="total-weight">50.00 / 50.00 <span class="text-xs text-slate-500 font-medium">ct</span></p>
                </div>
                <div>
                    <p class="text-[11px] text-slate-500 font-semibold uppercase mb-1">Variance (Wgt)</p>
                    <p class="text-lg font-bold text-emerald-600" id="variance-weight">0.00 <span class="text-xs text-emerald-600/70 font-medium">ct</span></p>
                </div>
                <div class="flex items-center">
                    <p id="recon-message" class="text-sm font-semibold text-emerald-600 flex items-center gap-1.5">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        No discrepancy
                    </p>
                </div>
            </div>
        </div>

        <!-- Footer Actions -->
        <div class="mt-8 flex justify-between pt-6 border-t border-slate-100">
            <button onclick="goToStep(1)" class="px-6 py-2.5 text-sm font-medium text-slate-600 bg-white border border-slate-300 rounded-lg hover:bg-slate-50 transition-colors flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Back
            </button>
            <button onclick="openConfirmModal()" class="px-6 py-2.5 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition-colors shadow-sm shadow-blue-600/20">
                Complete & Add to Inventory
            </button>
        </div>
    </div>


    <!-- ============================================== -->
    <!-- SCREEN 4: Mock Result View                     -->
    <!-- ============================================== -->
    <div id="step-4" class="step-content glass-card rounded-2xl p-8 mb-6 relative overflow-hidden">
        <div class="absolute top-0 inset-x-0 h-1 bg-gradient-to-r from-emerald-400 to-teal-500"></div>
        
        <div class="flex items-center gap-4 mb-6">
            <div class="w-12 h-12 bg-emerald-100 rounded-full flex items-center justify-center border border-emerald-200 flex-shrink-0">
                <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            </div>
            <div>
                <h2 class="text-xl font-bold text-slate-800">Lot Split Completed Successfully</h2>
                <p class="text-sm text-slate-500">Production ref LS-2026-001 has been processed.</p>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-slate-200 overflow-hidden shadow-sm mb-6">
            <div class="px-4 py-3 bg-slate-50 border-b border-slate-200 font-semibold text-slate-700 text-sm">
                Updated Inventory Status
            </div>
            <table class="w-full text-left text-sm text-slate-600">
                <thead class="bg-slate-50/50 text-xs uppercase font-semibold text-slate-500 border-b border-slate-200">
                    <tr>
                        <th class="px-4 py-3">SKU</th>
                        <th class="px-4 py-3">Variety</th>
                        <th class="px-4 py-3 text-right">Qty</th>
                        <th class="px-4 py-3 text-right">Weight</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <tr class="bg-slate-50/50">
                        <td class="px-4 py-3 font-semibold text-slate-400 line-through">gm50</td>
                        <td class="px-4 py-3 text-slate-400">Sapphire</td>
                        <td class="px-4 py-3 text-right text-slate-400">0</td>
                        <td class="px-4 py-3 text-right text-slate-400">0.00ct</td>
                        <td class="px-4 py-3">
                            <span class="inline-flex items-center gap-1.5 px-2 py-1 rounded text-[10px] font-bold bg-slate-200 text-slate-600">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                                Split (Parent)
                            </span>
                        </td>
                        <td class="px-4 py-3 text-center">
                            <button class="text-blue-500 hover:text-blue-700 font-medium text-xs">View</button>
                        </td>
                    </tr>
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-4 py-3 font-bold text-slate-800">gm51 <span class="ml-2 text-[10px] font-bold bg-amber-100 text-amber-700 px-1.5 py-0.5 rounded uppercase">New</span></td>
                        <td class="px-4 py-3">Sapphire</td>
                        <td class="px-4 py-3 text-right font-medium">50</td>
                        <td class="px-4 py-3 text-right font-medium">25.00ct</td>
                        <td class="px-4 py-3">
                            <span class="inline-flex items-center gap-1.5 px-2 py-1 rounded text-[10px] font-bold bg-emerald-100 text-emerald-700">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                Available
                            </span>
                        </td>
                        <td class="px-4 py-3 text-center">
                            <button class="text-blue-600 hover:text-blue-800 font-medium text-xs">Edit</button>
                        </td>
                    </tr>
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-4 py-3 font-bold text-slate-800">gm52 <span class="ml-2 text-[10px] font-bold bg-amber-100 text-amber-700 px-1.5 py-0.5 rounded uppercase">New</span></td>
                        <td class="px-4 py-3">Sapphire</td>
                        <td class="px-4 py-3 text-right font-medium">50</td>
                        <td class="px-4 py-3 text-right font-medium">25.00ct</td>
                        <td class="px-4 py-3">
                            <span class="inline-flex items-center gap-1.5 px-2 py-1 rounded text-[10px] font-bold bg-emerald-100 text-emerald-700">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                Available
                            </span>
                        </td>
                        <td class="px-4 py-3 text-center">
                            <button class="text-blue-600 hover:text-blue-800 font-medium text-xs">Edit</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="flex justify-center mt-8">
             <a href="#" class="px-6 py-2.5 text-sm font-medium text-white bg-slate-800 rounded-lg hover:bg-slate-900 transition-colors shadow-sm">
                Go to My Inventory
            </a>
        </div>
    </div>


</div> <!-- End Container -->


<!-- ============================================== -->
<!-- SCREEN 3: Confirmation Modal                   -->
<!-- ============================================== -->
<div id="confirmModal" class="fixed inset-0 z-[1000] hidden items-center justify-center p-4">
    <!-- Backdrop -->
    <div class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm transition-opacity" onclick="closeConfirmModal()"></div>
    
    <!-- Modal Content -->
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md relative z-10 transform transition-all overflow-hidden">
        <!-- Accent bar -->
        <div class="h-1.5 w-full bg-amber-500"></div>
        
        <div class="p-6">
            <div class="flex items-start gap-4 mb-5">
                <div class="w-10 h-10 rounded-full bg-amber-100 flex items-center justify-center flex-shrink-0 text-amber-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-slate-800 mb-1">Confirm Lot Split</h3>
                    <p class="text-sm text-slate-500">Please review the actions that will be performed. This action cannot be undone.</p>
                </div>
            </div>
            
            <div class="bg-slate-50 border border-slate-100 rounded-lg p-4 mb-6">
                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">This will:</p>
                <ul class="space-y-2 text-sm text-slate-700">
                    <li class="flex items-start gap-2">
                        <svg class="w-4 h-4 text-rose-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path></svg>
                        <span>Archive <strong>gm50</strong> (mark as "Split - Parent") and deduct stock to 0.</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <svg class="w-4 h-4 text-emerald-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        <div>
                            <span>Create <strong class="text-emerald-700">2</strong> new products in inventory:</span>
                            <ul class="list-disc list-inside mt-1 ml-1 text-slate-500 text-xs font-medium space-y-0.5">
                                <li>gm51 (50 pcs, 25.00 ct)</li>
                                <li>gm52 (50 pcs, 25.00 ct)</li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </div>
            
            <div class="flex gap-3 justify-end">
                <button onclick="closeConfirmModal()" type="button" class="px-5 py-2 text-sm font-medium text-slate-600 bg-white border border-slate-300 rounded-lg hover:bg-slate-50 transition-colors">Cancel</button>
                <button onclick="executeSplit()" type="button" class="px-5 py-2 text-sm font-medium text-white bg-amber-600 border border-amber-600 rounded-lg hover:bg-amber-700 transition-colors shadow-sm">Confirm Split</button>
            </div>
        </div>
    </div>
</div>


<script>
    // Navigation Logic
    function goToStep(step) {
        // Hide all steps
        document.querySelectorAll('.step-content').forEach(el => el.classList.remove('active'));
        // Show target step
        document.getElementById('step-' + step).classList.add('active');
        
        // Update Indicator
        if(step <= 3) {
            updateIndicator(step);
        }
    }
    
    function updateIndicator(step) {
        const indicators = [
            document.getElementById('step1-indicator'),
            document.getElementById('step2-indicator'),
            document.getElementById('step3-indicator')
        ];
        
        indicators.forEach((ind, index) => {
            const numSpan = ind.querySelector('span:first-child');
            if (index + 1 < step) {
                // Completed
                ind.className = 'flex items-center text-blue-600';
                numSpan.className = 'w-8 h-8 rounded-full bg-blue-600 text-white flex items-center justify-center font-semibold text-sm mr-2 shadow-sm';
                numSpan.innerHTML = '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>';
            } else if (index + 1 === step) {
                // Active
                ind.className = 'flex items-center text-blue-600';
                numSpan.className = 'w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center font-semibold text-sm mr-2 ring-4 ring-blue-50';
                numSpan.innerHTML = (index + 1);
            } else {
                // Upcoming
                ind.className = 'flex items-center text-slate-400';
                numSpan.className = 'w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center font-semibold text-sm mr-2';
                numSpan.innerHTML = (index + 1);
            }
        });
    }

    // Modal Logic
    function openConfirmModal() {
        goToStep(3); // Update indicator
        document.getElementById('confirmModal').classList.remove('hidden');
        document.getElementById('confirmModal').classList.add('flex');
    }
    
    function closeConfirmModal() {
        goToStep(2); // Revert indicator
        document.getElementById('confirmModal').classList.add('hidden');
        document.getElementById('confirmModal').classList.remove('flex');
    }
    
    function executeSplit() {
        closeConfirmModal();
        goToStep(4);
    }

    // Dynamic Rows & Calculation Mockup
    let rowCount = 0;
    const parentWeight = 50.00;
    const parentQty = 100;
    const parentCost = 150000;
    
    function generateSplitRows() {
        const partsCount = parseInt(document.getElementById('split-parts-input').value) || 2;
        
        // Update header
        document.getElementById('split-outputs-title').innerText = `Split Outputs (${partsCount} parts)`;
        
        // Clear container
        const container = document.getElementById('split-rows-container');
        container.innerHTML = '';
        rowCount = 0;

        // Add N parts evenly divided (for mockup purposes)
        const qtyPerPart = Math.floor(parentQty / partsCount);
        const wgtPerPart = (parentWeight / partsCount).toFixed(2);
        
        for (let i = 0; i < partsCount; i++) {
            // Adjust last row to ensure total matches exactly
            let qty = qtyPerPart;
            let wgt = parseFloat(wgtPerPart);
            
            if (i === partsCount - 1) {
                qty = parentQty - (qtyPerPart * (partsCount - 1));
                wgt = parentWeight - (wgtPerPart * (partsCount - 1));
            }
            
            addSplitRow(qty, wgt.toFixed(2), i === 0 ? "Better clarity batch" : "Standard batch");
        }
        
        // Proceed to step 2
        goToStep(2);
        calculateTotals();
    }

    function addSplitRow(qty = 0, wgt = "0.00", notes = "") {
        rowCount++;
        const container = document.getElementById('split-rows-container');
        const rowHTML = `
            <div class="split-row bg-white border border-slate-200 rounded-xl p-5 shadow-sm relative transition-all hover:border-blue-200 hover:shadow-md animate-[fadeIn_0.3s_ease-out]">
                <div class="absolute -left-2.5 -top-2.5 bg-blue-600 text-white w-6 h-6 rounded-full flex items-center justify-center text-xs font-bold shadow-sm">${rowCount}</div>
                <button onclick="this.closest('.split-row').remove(); calculateTotals();" class="absolute top-4 right-4 text-slate-300 hover:text-rose-500 transition-colors p-1.5 hover:bg-rose-50 rounded-md">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                </button>
                
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 pr-8">
                    <div>
                        <label class="block text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">Quantity (pcs)</label>
                        <input type="number" class="form-input qty-input w-full rounded-lg border-slate-200 bg-slate-50 px-4 py-2.5 text-sm text-slate-800 focus:border-blue-500 focus:bg-white focus:ring-2 focus:ring-blue-500/20 transition-all outline-none" value="${qty}" oninput="calculateTotals()">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">Weight (ct)</label>
                        <input type="number" step="0.01" class="form-input weight-input w-full rounded-lg border-slate-200 bg-slate-50 px-4 py-2.5 text-sm text-slate-800 focus:border-blue-500 focus:bg-white focus:ring-2 focus:ring-blue-500/20 transition-all outline-none" value="${wgt}" oninput="calculateTotals()">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-1.5 flex items-center gap-1">
                            Cost (Auto-calc)
                            <svg class="w-3 h-3 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </label>
                        <div class="relative">
                            <span class="absolute left-3 top-2.5 text-slate-400">$</span>
                            <input type="text" class="form-input pl-7 bg-slate-50 border-slate-200 cost-input text-slate-600 font-medium w-full rounded-lg border-slate-200 bg-slate-50 px-4 py-2.5 text-sm text-slate-800 focus:border-blue-500 focus:bg-white focus:ring-2 focus:ring-blue-500/20 transition-all outline-none" value="0.00" readonly>
                        </div>
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">Notes</label>
                        <input type="text" class="form-input text-sm w-full rounded-lg border-slate-200 bg-slate-50 px-4 py-2.5 text-sm text-slate-800 focus:border-blue-500 focus:bg-white focus:ring-2 focus:ring-blue-500/20 transition-all outline-none" value="${notes}" placeholder="Optional notes">
                    </div>
                </div>
            </div>
        `;
        container.insertAdjacentHTML('beforeend', rowHTML);
        
        // Re-number rows
        updateRowNumbers();
    }
    
    function updateRowNumbers() {
        const rows = document.querySelectorAll('.split-row');
        rows.forEach((row, index) => {
            const badge = row.querySelector('.bg-blue-600.rounded-full');
            if (badge) badge.textContent = index + 1;
        });
        rowCount = rows.length;
    }

    function calculateTotals() {
        const weightInputs = document.querySelectorAll('.weight-input');
        const qtyInputs = document.querySelectorAll('.qty-input');
        const costInputs = document.querySelectorAll('.cost-input');
        
        let totalWgt = 0;
        let totalQty = 0;
        
        weightInputs.forEach((input, index) => {
            const w = parseFloat(input.value) || 0;
            totalWgt += w;
            
            // Auto calc cost proportionally based on weight (simplified for mockup)
            const ratio = parentWeight > 0 ? (w / parentWeight) : 0;
            const cost = ratio * parentCost;
            
            // Format number with commas
            costInputs[index].value = cost.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2});
        });
        
        qtyInputs.forEach(input => {
            totalQty += parseInt(input.value) || 0;
        });
        
        // Update DOM
        document.getElementById('total-qty').innerHTML = `${totalQty} / ${parentQty} <span class="text-xs text-slate-500 font-medium">pcs</span>`;
        document.getElementById('total-weight').innerHTML = `${totalWgt.toFixed(2)} / ${parentWeight.toFixed(2)} <span class="text-xs text-slate-500 font-medium">ct</span>`;
        
        const varianceWgt = parentWeight - totalWgt;
        
        // Update UI states based on balance
        const panel = document.getElementById('reconciliation-panel');
        const statusBar = document.getElementById('recon-status-bar');
        const badge = document.getElementById('recon-badge');
        const message = document.getElementById('recon-message');
        const varianceEl = document.getElementById('variance-weight');
        
        // Format variance
        let varStr = Math.abs(varianceWgt).toFixed(2);
        if (varianceWgt > 0) varStr = '-' + varStr;
        else if (varianceWgt < 0) varStr = '+' + varStr;
        
        if (Math.abs(varianceWgt) < 0.01) {
            // Balanced
            panel.className = "bg-slate-50 border-2 border-slate-200 rounded-xl p-5 mb-2 relative overflow-hidden transition-all";
            statusBar.className = "absolute left-0 top-0 bottom-0 w-2 bg-emerald-500 transition-colors";
            badge.className = "px-2 py-0.5 rounded text-[10px] bg-emerald-100 text-emerald-700 border border-emerald-200";
            badge.textContent = "Balanced";
            message.className = "text-sm font-semibold text-emerald-600 flex items-center gap-1.5";
            message.innerHTML = `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg> No discrepancy`;
            varianceEl.className = "text-lg font-bold text-emerald-600";
            varianceEl.innerHTML = `0.00 <span class="text-xs text-emerald-600/70 font-medium">ct</span>`;
        } else {
            // Unbalanced
            panel.className = "bg-rose-50/50 border-2 border-rose-200 rounded-xl p-5 mb-2 relative overflow-hidden transition-all";
            statusBar.className = "absolute left-0 top-0 bottom-0 w-2 bg-rose-500 transition-colors";
            badge.className = "px-2 py-0.5 rounded text-[10px] bg-rose-100 text-rose-700 border border-rose-200";
            badge.textContent = "Discrepancy";
            message.className = "text-sm font-semibold text-rose-600 flex items-center gap-1.5";
            message.innerHTML = `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg> Please check weight distribution`;
            varianceEl.className = "text-lg font-bold text-rose-600";
            varianceEl.innerHTML = `${varStr} <span class="text-xs text-rose-600/70 font-medium">ct</span>`;
        }
    }
</script>
@endsection
