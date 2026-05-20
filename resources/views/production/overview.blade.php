@extends('layouts.app')
@section('title', 'Production Overview')
@section('content')
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .prod-panel {
            min-width: 100%;
        }

        .tab-all {
            border-bottom: 2.5px solid #2563eb;
        }

        .tab-prod {
            border-bottom: 2.5px solid #f59e0b;
        }

        .tab-done {
            border-bottom: 2.5px solid #22c55e;
        }

        .tab-del {
            border-bottom: 2.5px solid #ef4444;
        }

        input[type=date]::-webkit-calendar-picker-indicator {
            opacity: .5;
            cursor: pointer;
        }

        ::-webkit-scrollbar {
            height: 8px;
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f5f9;
            border-radius: 6px;
        }

        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 6px;
        }
    </style>

    <div class="p-6 min-h-screen bg-slate-50">

        {{-- HEADER --}}
        <div class="flex items-center justify-between mb-5">
            <h1 class="text-2xl font-bold text-slate-800">Production overview</h1>
            <div class="flex gap-3">
                <a href="{{ route('production.excelsheet.index') }}"
                    class="flex items-center gap-2 px-4 h-9 text-[13px] font-semibold text-slate-700 bg-white border border-slate-300 rounded-md hover:bg-slate-50 shadow-sm transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                    </svg>
                    Excel Import
                </a>
                <button id="btn-create"
                    class="flex items-center gap-2 px-5 h-9 text-[13px] font-bold text-white bg-[#2563eb] rounded-md hover:bg-blue-700 shadow-sm transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Create production sheet
                </button>
            </div>
        </div>

        {{-- FILTER CARD --}}
        <div class="bg-white rounded-md border border-slate-200 p-5 mb-5 shadow-sm" style="overflow:visible;">
            <div class="flex items-center gap-2 mb-4">
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                </svg>
                <span class="text-[15px] font-medium text-blue-700">Filter by</span>
            </div>

            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 items-end">

                {{-- Production Type --}}
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Production Type:</label>
                    <div class="relative" id="w-prodtype">
                        <button id="btn-prodtype" type="button"
                            class="w-full flex items-center justify-between pl-3 pr-8 py-2.5 text-sm bg-slate-100 border border-slate-200 rounded-md hover:border-blue-400 transition-colors">
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                </svg>
                                <span id="lbl-prodtype" class="text-slate-500 text-sm">Select</span>
                            </div>
                        </button>
                        <div class="absolute inset-y-0 right-3 flex items-center pointer-events-none">
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                        <div id="panel-prodtype"
                            class="prod-panel hidden absolute left-0 z-50 mt-1 w-full bg-white border border-slate-200 rounded-md shadow-lg overflow-hidden">
                            <ul class="py-1">
                                @foreach($productionTypes as $t)
                                    <li class="opt-prodtype px-4 py-2.5 text-sm cursor-pointer hover:bg-slate-50 text-slate-700"
                                        data-label="{{ $t['label'] }}">{{ $t['label'] }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>

                {{-- Template --}}
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Template:</label>
                    <div class="relative" id="w-template">
                        <button id="btn-template" type="button"
                            class="w-full flex items-center justify-between pl-3 pr-8 py-2.5 text-sm bg-slate-100 border border-slate-200 rounded-md hover:border-blue-400 transition-colors">
                            <span id="lbl-template" class="text-slate-400 text-sm">Select</span>
                        </button>
                        <div class="absolute inset-y-0 right-3 flex items-center pointer-events-none">
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                        <div id="panel-template"
                            class="prod-panel hidden absolute left-0 z-50 mt-1 w-full bg-white border border-slate-200 rounded-md shadow-lg overflow-hidden">
                            <ul class="py-1">
                                <li class="opt-template px-4 py-2.5 text-sm cursor-pointer hover:bg-slate-50 text-slate-700"
                                    data-label="Default">Default</li>
                            </ul>
                        </div>
                    </div>
                </div>

                {{-- Creation Date --}}
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Creation date:</label>
                    <div class="flex items-center gap-2">
                        <input type="date" id="date-from"
                            class="w-full bg-white border border-slate-300 text-slate-700 py-2.5 px-3 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm hover:border-blue-400 transition-colors">
                        <span class="text-slate-400 font-medium flex-shrink-0">-</span>
                        <input type="date" id="date-to"
                            class="w-full bg-white border border-slate-300 text-slate-700 py-2.5 px-3 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm hover:border-blue-400 transition-colors">
                    </div>
                </div>


                {{-- Creator + Buttons --}}
                <div class="flex items-end gap-2">
                    <div class="flex-1">
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Creator:</label>
                        <div class="relative" id="w-creator">
                            <button id="btn-creator" type="button"
                                class="w-full flex items-center justify-between pl-3 pr-8 py-2.5 text-sm bg-slate-100 border border-slate-200 rounded-md hover:border-blue-400 transition-colors">
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    <span id="lbl-creator" class="text-slate-600 text-sm">All</span>
                                </div>
                            </button>
                            <div class="absolute inset-y-0 right-3 flex items-center pointer-events-none">
                                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </div>
                            <div id="panel-creator"
                                class="prod-panel hidden absolute left-0 z-50 mt-1 w-full bg-white border border-slate-200 rounded-md shadow-lg overflow-hidden">
                                <div class="p-2 border-b border-slate-100">
                                    <input id="search-creator" type="text" placeholder=""
                                        class="w-full px-3 py-1.5 text-sm border border-slate-200 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400">
                                </div>
                                <ul class="py-1 max-h-40 overflow-y-auto">
                                    @foreach($creators as $c)
                                        <li class="opt-creator px-4 py-2.5 text-sm cursor-pointer hover:bg-slate-50 text-slate-700"
                                            data-label="{{ $c['label'] }}">{{ $c['label'] }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                    <button id="btn-reset" title="Clear"
                        class="flex-shrink-0 flex items-center justify-center w-[42px] h-[42px] bg-white border border-slate-200 rounded-md hover:bg-slate-50 text-slate-500 shadow-sm transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                    </button>
                    <button id="btn-apply"
                        class="flex-shrink-0 inline-flex items-center justify-center px-7 h-[42px] text-[13px] font-bold text-white bg-[#2563eb] rounded-md hover:bg-blue-700 shadow-sm transition-colors">
                        Apply
                    </button>
                </div>

            </div>
        </div>

        {{-- MAIN CARD --}}
        <div class="bg-white rounded-md border border-slate-200 shadow-sm overflow-hidden">

            {{-- STATUS TABS --}}
            <div class="grid grid-cols-4 border-b border-slate-200">

                <button data-tab="all"
                    class="status-tab tab-all flex items-start justify-between px-5 py-4 border-r border-slate-200 hover:bg-slate-50 transition-colors bg-slate-50">
                    <div class="text-left">
                        <p class="text-sm font-bold text-blue-700 mb-1">All</p>
                        <p class="text-xs text-slate-500">items: <span class="font-semibold text-slate-700">—</span></p>
                        <p class="text-xs text-blue-600 font-semibold mt-0.5">VEF: — VEF</p>
                    </div>
                    <svg class="w-5 h-5 text-slate-400 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
                    </svg>
                </button>

                <button data-tab="in_production"
                    class="status-tab tab-prod flex items-start justify-between px-5 py-4 border-r border-slate-200 hover:bg-slate-50 transition-colors">
                    <div class="text-left">
                        <p class="text-sm font-bold text-amber-600 mb-1">In production</p>
                        <p class="text-xs text-slate-500">items: <span class="font-semibold text-slate-700">—</span></p>
                        <p class="text-xs text-amber-600 font-semibold mt-0.5">VEF: — VEF</p>
                    </div>
                    <svg class="w-5 h-5 text-amber-400 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                    </svg>
                </button>

                <button data-tab="completed"
                    class="status-tab tab-done flex items-start justify-between px-5 py-4 border-r border-slate-200 hover:bg-slate-50 transition-colors">
                    <div class="text-left">
                        <p class="text-sm font-bold text-green-600 mb-1">Completed</p>
                        <p class="text-xs text-slate-500">items: <span class="font-semibold text-slate-700">—</span></p>
                        <p class="text-xs text-green-600 font-semibold mt-0.5">VEF: — VEF</p>
                    </div>
                    <svg class="w-5 h-5 text-green-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </button>

                <button data-tab="deleted"
                    class="status-tab tab-del flex items-start justify-between px-5 py-4 hover:bg-slate-50 transition-colors">
                    <div class="text-left">
                        <p class="text-sm font-bold text-red-500 mb-1">Deleted</p>
                        <p class="text-xs text-slate-500">items: <span class="font-semibold text-slate-700">—</span></p>
                        <p class="text-xs text-red-500 font-semibold mt-0.5">VEF: — VEF</p>
                    </div>
                    <svg class="w-5 h-5 text-red-400 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                </button>

            </div>

            {{-- TOOLBAR --}}
            <div class="flex items-center justify-between px-4 py-3 border-b border-slate-100">
                <button id="btn-manage-cols"
                    class="inline-flex items-center gap-2 px-4 py-2 text-[13px] font-semibold text-slate-600 bg-white border border-slate-300 rounded-md hover:bg-slate-50 transition-colors">
                    Manage columns
                </button>
                <div class="relative flex items-center">
                    <input id="prod-search" type="text" placeholder="e.g Production sheet #, refer"
                        class="w-64 pl-4 pr-10 py-2 text-sm border border-slate-200 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-500 placeholder-slate-400">
                    <button
                        class="absolute right-0 top-0 bottom-0 px-3 bg-[#2563eb] hover:bg-blue-700 text-white rounded-r-md flex items-center justify-center transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </button>
                </div>
            </div>

            {{-- TABLE --}}
            <div class="overflow-x-auto">
                <table class="w-full text-left whitespace-nowrap">
                    <thead class="bg-[#f8fafc] border-b border-slate-200 text-[13px] text-slate-700 font-semibold">
                        <tr>
                            <th class="px-4 py-3">Production sheet #</th>
                            <th class="px-4 py-3">Production type</th>
                            <th class="px-4 py-3">Reference</th>
                            <th class="px-4 py-3">Status</th>
                            <th class="px-4 py-3">Creation date</th>
                            <th class="px-4 py-3">Due date</th>
                            <th class="px-4 py-3">Closed date</th>
                            <th class="px-4 py-3">Original quantity</th>
                            <th class="px-4 py-3">Original weight</th>
                            <th class="px-4 py-3">Original total cost</th>
                            <th class="px-4 py-3 flex items-center gap-1">
                                Discrepancy reason
                                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-[13px] text-slate-600 bg-white">
                        <tr>
                            <td colspan="11" class="px-4 py-12 text-center text-slate-400 text-sm">No records found</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            {{-- PAGINATION FOOTER --}}
            <div
                class="px-5 py-3 border-t border-slate-100 flex items-center justify-between text-[13px] text-slate-600 bg-white">
                <div class="flex items-center gap-2">
                    <span>Show</span>
                    <select
                        class="border border-slate-300 rounded-md py-1.5 pl-2 pr-7 text-[13px] focus:ring-2 focus:ring-blue-100 focus:border-blue-500 appearance-none bg-white cursor-pointer">
                        <option>50</option>
                        <option>100</option>
                    </select>
                    <span>items per page</span>
                </div>
                <div>Showing 0 results</div>
                <div class="flex items-center gap-1">
                    <button
                        class="px-3 py-1.5 border border-slate-200 rounded-md text-slate-400 bg-slate-50 cursor-not-allowed">Previous</button>
                    <button
                        class="px-3 py-1.5 border border-slate-200 rounded-md text-slate-400 bg-slate-50 cursor-not-allowed">1</button>
                    <button
                        class="px-3 py-1.5 border border-slate-200 rounded-md text-slate-400 bg-slate-50 cursor-not-allowed">Next</button>
                </div>
            </div>

        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {

            // ── Dropdown Manager ──────────────────────────────────────────
            const DROPS = [
                { btn: 'btn-prodtype', panel: 'panel-prodtype' },
                { btn: 'btn-template', panel: 'panel-template' },
                { btn: 'btn-creator', panel: 'panel-creator' },
            ];

            function closeAll() {
                DROPS.forEach(d => {
                    const p = document.getElementById(d.panel);
                    if (p) p.classList.add('hidden');
                });
            }

            DROPS.forEach(d => {
                const btn = document.getElementById(d.btn);
                const panel = document.getElementById(d.panel);
                if (!btn || !panel) return;

                btn.addEventListener('click', e => {
                    e.stopPropagation();
                    const wasHidden = panel.classList.contains('hidden');
                    closeAll();
                    if (wasHidden) panel.classList.remove('hidden');
                });

                panel.addEventListener('click', e => e.stopPropagation());
            });

            document.addEventListener('click', closeAll);

            // ── Option selection helpers ──────────────────────────────────
            function bindOptions(selector, labelId) {
                document.querySelectorAll(selector).forEach(el => {
                    el.addEventListener('click', function () {
                        const lbl = document.getElementById(labelId);
                        lbl.textContent = this.dataset.label;
                        lbl.classList.remove('text-slate-400');
                        lbl.classList.add('text-slate-600');
                        closeAll();
                    });
                });
            }

            bindOptions('.opt-prodtype', 'lbl-prodtype');
            bindOptions('.opt-template', 'lbl-template');
            bindOptions('.opt-creator', 'lbl-creator');

            // ── Creator search ────────────────────────────────────────────
            const cs = document.getElementById('search-creator');
            if (cs) {
                cs.addEventListener('click', e => e.stopPropagation());
                cs.addEventListener('input', function () {
                    const q = this.value.toLowerCase();
                    document.querySelectorAll('.opt-creator').forEach(o => {
                        o.style.display = o.dataset.label.toLowerCase().includes(q) ? '' : 'none';
                    });
                });
            }

            // ── Reset ─────────────────────────────────────────────────────
            document.getElementById('btn-reset').addEventListener('click', () => {
                document.getElementById('lbl-prodtype').textContent = 'Select';
                ['lbl-template', 'lbl-creator'].forEach(id => {
                    const el = document.getElementById(id);
                    el.textContent = 'Select';
                    el.classList.add('text-slate-400');
                    el.classList.remove('text-slate-600');
                });
                document.getElementById('date-from').value = '';
                document.getElementById('date-to').value = '';
            });

            // ── Date guard ────────────────────────────────────────────────
            const df = document.getElementById('date-from');
            const dt = document.getElementById('date-to');
            df.addEventListener('change', () => { if (dt.value && df.value > dt.value) dt.value = df.value; });
            dt.addEventListener('change', () => { if (df.value && dt.value < df.value) df.value = dt.value; });

            // ── Status tabs ───────────────────────────────────────────────
            document.querySelectorAll('.status-tab').forEach(btn => {
                btn.addEventListener('click', function () {
                    document.querySelectorAll('.status-tab').forEach(b => b.classList.remove('bg-slate-50'));
                    this.classList.add('bg-slate-50');
                });
            });

            // ── Placeholder actions ───────────────────────────────────────
            ['btn-excel', 'btn-manage-cols'].forEach(id => {
                const el = document.getElementById(id);
                if (el) el.addEventListener('click', () => alert(id + ' — coming soon.'));
            });

            // ── Create Modal Toggle ───────────────────────────────────────
            const createModal = document.getElementById('create-modal');
            const modalContent = document.getElementById('create-modal-content');
            const backdrop = document.getElementById('create-backdrop');

            function openCreateModal() {
                createModal.classList.remove('hidden');
                setTimeout(() => {
                    modalContent.classList.remove('scale-95', 'opacity-0');
                    modalContent.classList.add('scale-100', 'opacity-100');
                }, 10);
            }

            function closeCreateModal() {
                modalContent.classList.remove('scale-100', 'opacity-100');
                modalContent.classList.add('scale-95', 'opacity-0');
                setTimeout(() => {
                    createModal.classList.add('hidden');
                    // reset labels
                    const typeLbl = document.getElementById('mc-type-lbl');
                    typeLbl.textContent = 'Select product type';
                    typeLbl.classList.add('text-slate-400');
                    typeLbl.classList.remove('text-slate-700');

                    const catLbl = document.getElementById('mc-cat-lbl');
                    catLbl.textContent = 'Select product category';
                    catLbl.classList.add('text-slate-400');
                    catLbl.classList.remove('text-slate-700');

                    document.getElementById('mc-type-search').value = '';
                    document.getElementById('mc-cat-search').value = '';

                    document.querySelectorAll('.mc-type-opt').forEach(opt => opt.style.display = '');
                    document.querySelectorAll('.mc-cat-opt').forEach(opt => opt.style.display = '');
                }, 200);
            }

            const btnCreate = document.getElementById('btn-create');
            if (btnCreate) btnCreate.addEventListener('click', openCreateModal);

            [document.getElementById('create-close'),
            document.getElementById('create-cancel'),
                backdrop
            ].forEach(el => { if (el) el.addEventListener('click', closeCreateModal); });

            document.getElementById('create-submit').addEventListener('click', () => {
                const type = document.getElementById('mc-type-lbl').textContent;
                const cat = document.getElementById('mc-cat-lbl').textContent;
                if (type === 'Select product type' || cat === 'Select product category') {
                    alert('Please select both a production type and category.');
                    return;
                }
                alert('Production sheet created successfully!\nType: ' + type + '\nCategory: ' + cat);
                closeCreateModal();
            });

            // Prevent clicks inside modal content from bubbling to backdrop
            modalContent.addEventListener('click', e => e.stopPropagation());

            // ── Create Modal Dropdowns ────────────────────────────────────
            const createDrops = [
                { btn: 'mc-type-btn', panel: 'mc-type-panel', opts: '.mc-type-opt', lbl: 'mc-type-lbl', search: 'mc-type-search' },
                { btn: 'mc-cat-btn', panel: 'mc-cat-panel', opts: '.mc-cat-opt', lbl: 'mc-cat-lbl', search: 'mc-cat-search' }
            ];

            function closeCreateDrops() {
                createDrops.forEach(d => {
                    const p = document.getElementById(d.panel);
                    if (p) p.classList.add('hidden');
                });
            }

            createDrops.forEach(d => {
                const btn = document.getElementById(d.btn);
                const panel = document.getElementById(d.panel);
                const searchInput = document.getElementById(d.search);
                if (!btn || !panel) return;

                btn.addEventListener('click', e => {
                    e.stopPropagation();
                    const wasHidden = panel.classList.contains('hidden');
                    closeCreateDrops();
                    if (wasHidden) {
                        panel.classList.remove('hidden');
                        if (searchInput) searchInput.focus();
                    }
                });

                panel.addEventListener('click', e => e.stopPropagation());

                document.querySelectorAll(d.opts).forEach(opt => {
                    opt.addEventListener('click', function () {
                        const lbl = document.getElementById(d.lbl);
                        lbl.textContent = this.dataset.label;
                        lbl.classList.remove('text-slate-400');
                        lbl.classList.add('text-slate-700');
                        closeCreateDrops();
                    });
                });

                if (searchInput) {
                    searchInput.addEventListener('input', function () {
                        const q = this.value.toLowerCase();
                        document.querySelectorAll(d.opts).forEach(opt => {
                            opt.style.display = opt.dataset.label.toLowerCase().includes(q) ? '' : 'none';
                        });
                    });
                }
            });

            // Close dropdowns on document click
            document.addEventListener('click', closeCreateDrops);

        });
    </script>

    {{-- ===== CREATE NEW SHEET MODAL ===== --}}
    <div id="create-modal" class="fixed inset-0 z-50 hidden flex items-center justify-center">
        <div class="absolute inset-0 bg-slate-900/40 backdrop-blur-sm" id="create-backdrop"></div>
        <div id="create-modal-content"
            class="relative bg-white rounded-md shadow-2xl w-full max-w-[540px] z-10 transform scale-95 opacity-0 transition-all duration-200">
            {{-- Header --}}
            <div class="flex items-center justify-between px-5 py-3 border-b border-slate-100">
                <h3 class="text-[15px] font-bold text-slate-800">Create new</h3>
                <button type="button" id="create-close" class="text-slate-400 hover:text-slate-600 transition-colors">
                    <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            {{-- Amber Note --}}
            <div class="px-5 pt-3">
                <div class="bg-amber-50/50 border-l-4 border-amber-500 rounded-md p-3 flex items-start gap-2">
                    <div class="text-xs text-slate-700 leading-relaxed">
                        <span class="font-bold text-slate-800">Note:</span> You will only be able to work on only one
                        product category at a time.
                    </div>
                </div>
            </div>

            {{-- Body --}}
            <div class="px-5 py-3.5 flex flex-col gap-3.5">
                {{-- Production Type --}}
                <div class="relative" id="mc-type-wrapper">
                    <label class="block text-xs font-bold text-slate-700 mb-1">Production type</label>
                    <button type="button" id="mc-type-btn"
                        class="w-full flex items-center justify-between pl-3 pr-8 py-2 text-sm bg-white border border-slate-300 rounded-md hover:border-blue-400 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors">
                        <span id="mc-type-lbl" class="text-slate-400">Select product type</span>
                    </button>
                    <div class="absolute inset-y-0 right-3 top-5 flex items-center pointer-events-none"
                        style="top:auto;bottom:0;height:38px;">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </div>
                    <div id="mc-type-panel"
                        class="hidden absolute left-0 z-50 mt-1 w-full bg-white border border-slate-200 rounded-md shadow-lg overflow-hidden"
                        style="top:100%;">
                        {{-- Search --}}
                        <div class="p-2 border-b border-slate-100">
                            <input type="text" id="mc-type-search" placeholder="Search..."
                                class="w-full px-3 py-1.5 text-sm border border-slate-200 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                        </div>
                        <ul class="py-1 max-h-40 overflow-y-auto" id="mc-type-list">
                            <li class="mc-type-opt px-4 py-2 text-sm text-slate-700 cursor-pointer hover:bg-slate-50 transition-colors"
                                data-label="Re-assortment">Re-assortment</li>
                            <li class="mc-type-opt px-4 py-2 text-sm text-slate-700 cursor-pointer hover:bg-slate-50 transition-colors"
                                data-label="Cutting">Cutting</li>
                            <li class="mc-type-opt px-4 py-2 text-sm text-slate-700 cursor-pointer hover:bg-slate-50 transition-colors"
                                data-label="Re-cutting">Re-cutting</li>
                            <li class="mc-type-opt px-4 py-2 text-sm text-slate-700 cursor-pointer hover:bg-slate-50 transition-colors"
                                data-label="Product transfer">Product transfer</li>
                            <li class="mc-type-opt px-4 py-2 text-sm text-slate-700 cursor-pointer hover:bg-slate-50 transition-colors"
                                data-label="Treatment">Treatment</li>
                        </ul>
                    </div>
                </div>

                {{-- Production Category --}}
                <div class="relative" id="mc-cat-wrapper">
                    <label class="block text-xs font-bold text-slate-700 mb-1">Production category</label>
                    <button type="button" id="mc-cat-btn"
                        class="w-full flex items-center justify-between pl-3 pr-8 py-2 text-sm bg-white border border-slate-300 rounded-md hover:border-blue-400 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors">
                        <span id="mc-cat-lbl" class="text-slate-400">Select product category</span>
                    </button>
                    <div class="absolute inset-y-0 right-3 top-5 flex items-center pointer-events-none"
                        style="top:auto;bottom:0;height:38px;">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </div>
                    <div id="mc-cat-panel"
                        class="hidden absolute left-0 z-50 mt-1 w-full bg-white border border-slate-200 rounded-md shadow-lg overflow-hidden"
                        style="top:100%;">
                        {{-- Search --}}
                        <div class="p-2 border-b border-slate-100">
                            <input type="text" id="mc-cat-search" placeholder="Search..."
                                class="w-full px-3 py-1.5 text-sm border border-slate-200 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                        </div>
                        <ul class="py-1 max-h-40 overflow-y-auto" id="mc-cat-list">
                            <li class="mc-cat-opt px-4 py-2 text-sm text-slate-700 cursor-pointer hover:bg-slate-50 transition-colors"
                                data-label="Gemstones">Gemstones</li>
                            <li class="mc-cat-opt px-4 py-2 text-sm text-slate-700 cursor-pointer hover:bg-slate-50 transition-colors"
                                data-label="Rough &amp; Specimen">Rough &amp; Specimen</li>
                            <li class="mc-cat-opt px-4 py-2 text-sm text-slate-700 cursor-pointer hover:bg-slate-50 transition-colors"
                                data-label="Diamond">Diamond</li>
                        </ul>
                    </div>
                </div>
            </div>

            {{-- Footer --}}
            <div class="px-5 pb-4 flex items-center gap-3">
                <button type="button" id="create-cancel"
                    class="px-4.5 py-1.5 text-sm font-semibold text-red-500 bg-white border border-red-400 rounded-md hover:bg-red-50 transition-colors">
                    Cancel
                </button>
                <button type="button" id="create-submit"
                    class="px-5 py-1.5 text-sm font-bold text-white bg-[#2563eb] rounded-md hover:bg-blue-700 shadow-sm transition-colors">
                    Create
                </button>
            </div>
        </div>
    </div>
@endsection