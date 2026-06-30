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

        {{-- FLASH MESSAGES --}}
        @if(session('success'))
            <div id="flash-success"
                class="flex items-center gap-3 mb-4 px-4 py-3 bg-green-50 border border-green-200 rounded-md text-green-800 text-[13px] font-medium">
                <svg class="w-4 h-4 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                {{ session('success') }}
                <button onclick="document.getElementById('flash-success').remove()"
                    class="ml-auto text-green-500 hover:text-green-700">&times;</button>
            </div>
        @endif
        @if(session('error'))
            <div id="flash-error"
                class="flex items-center gap-3 mb-4 px-4 py-3 bg-red-50 border border-red-200 rounded-md text-red-800 text-[13px] font-medium">
                <svg class="w-4 h-4 text-red-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
                {{ session('error') }}
                <button onclick="document.getElementById('flash-error').remove()"
                    class="ml-auto text-red-500 hover:text-red-700">&times;</button>
            </div>
        @endif

        {{-- HEADER --}}
        <div class="flex items-center justify-between mb-5">
            <h1 class="text-2xl font-bold text-slate-800">Production overview</h1>
            <div class="flex gap-3">
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
                                        data-label="{{ $t['label'] }}" data-value="{{ $t['value'] }}">{{ $t['label'] }}</li>
                                @endforeach
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

                {{-- Supplier + Buttons --}}
                <div class="flex items-end gap-2">
                    <div class="flex-1">
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Supplier:</label>
                        <div class="relative" id="w-supplier">
                            <input type="hidden" id="filter-supplier-id" value="all">
                            <button id="btn-supplier" type="button"
                                class="w-full flex items-center justify-between pl-3 pr-8 py-2.5 text-sm bg-slate-100 border border-slate-200 rounded-md hover:border-blue-400 transition-colors">
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                    <span id="lbl-supplier" class="text-slate-600 text-sm">All</span>
                                </div>
                            </button>
                            <div class="absolute inset-y-0 right-3 flex items-center pointer-events-none">
                                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </div>
                            <div id="panel-supplier"
                                class="prod-panel hidden absolute left-0 z-50 mt-1 w-full bg-white border border-slate-200 rounded-md shadow-lg overflow-hidden">
                                <div class="p-2 border-b border-slate-100">
                                    <input id="search-supplier" type="text" placeholder="Search..."
                                        class="w-full px-3 py-1.5 text-sm border border-slate-200 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400">
                                </div>
                                <ul class="py-1 max-h-40 overflow-y-auto">
                                    @foreach($suppliers as $s)
                                        <li class="opt-supplier px-4 py-2.5 text-sm cursor-pointer hover:bg-slate-50 text-slate-700"
                                            data-label="{{ $s['label'] }}" data-value="{{ $s['value'] }}">{{ $s['label'] }}</li>
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
                        <p class="text-xs text-slate-500">items: <span id="cnt-all"
                                class="font-semibold text-slate-700">{{ $counts['all'] ?? '0' }}</span></p>
                        <p class="text-xs text-blue-600 font-semibold mt-0.5">VEF: <span
                                id="tot-all">{{ $totals['all'] ?? '0.00 VEF' }}</span></p>
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
                        <p class="text-xs text-slate-500">items: <span id="cnt-in_production"
                                class="font-semibold text-slate-700">{{ $counts['in_production'] ?? '0' }}</span></p>
                        <p class="text-xs text-amber-600 font-semibold mt-0.5">VEF: <span
                                id="tot-in_production">{{ $totals['in_production'] ?? '0.00 VEF' }}</span></p>
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
                        <p class="text-xs text-slate-500">items: <span id="cnt-completed"
                                class="font-semibold text-slate-700">{{ $counts['completed'] ?? '0' }}</span></p>
                        <p class="text-xs text-green-600 font-semibold mt-0.5">VEF: <span
                                id="tot-completed">{{ $totals['completed'] ?? '0.00 VEF' }}</span></p>
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
                        <p class="text-xs text-slate-500">items: <span id="cnt-deleted"
                                class="font-semibold text-slate-700">{{ $counts['deleted'] ?? '0' }}</span></p>
                        <p class="text-xs text-red-500 font-semibold mt-0.5">VEF: <span
                                id="tot-deleted">{{ $totals['deleted'] ?? '0.00 VEF' }}</span></p>
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
                    <tbody id="prod-table-body" class="divide-y divide-slate-100 text-[13px] text-slate-600 bg-white">
                        <tr id="prod-empty-row">
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
                    <select id="prod-per-page"
                        class="border border-slate-300 rounded-md py-1.5 pl-2 pr-7 text-[13px] focus:ring-2 focus:ring-blue-100 focus:border-blue-500 appearance-none bg-white cursor-pointer">
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                    <span>items per page</span>
                </div>
                <div id="prod-result-count">Showing 0 results</div>
                <div class="flex items-center gap-1" id="prod-pagination">
                    <button id="btn-prev"
                        class="px-3 py-1.5 border border-slate-200 rounded-md text-slate-400 bg-slate-50 cursor-not-allowed">Previous</button>
                    <span id="prod-page-info"
                        class="px-3 py-1.5 border border-slate-200 rounded-md text-slate-500 bg-white text-[13px]">1</span>
                    <button id="btn-next"
                        class="px-3 py-1.5 border border-slate-200 rounded-md text-slate-400 bg-slate-50 cursor-not-allowed">Next</button>
                </div>
            </div>

        </div>
    </div>

    {{-- ===== CREATE PRODUCTION SHEET MODAL ===== --}}
    <div id="create-modal" class="fixed inset-0 z-50 hidden items-center justify-center p-4 sm:p-6"
        style="background:rgba(0,0,0,0.5); z-index: 9999;">
        <div class="bg-white rounded-md shadow-2xl w-full max-w-5xl flex flex-col relative overflow-hidden"
            style="height:95vh;">

            {{-- Header --}}
            <div class="px-6 py-4 flex-shrink-0 bg-[#f8fafc] rounded-t-md border-b border-slate-200">
                <div class="flex justify-between items-start">
                    <button type="button" id="create-close"
                        class="text-slate-500 hover:text-slate-700 transition-colors p-1 -ml-1">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                    <div class="flex items-center gap-2">
                        <span
                            class="bg-amber-100 text-amber-800 text-[12px] font-semibold px-2.5 py-0.5 rounded-full">Draft</span>
                        <span id="mc-badge-type"
                            class="bg-blue-100 text-blue-800 text-[12px] font-semibold px-2.5 py-0.5 rounded-full hidden"></span>
                    </div>
                </div>
                <div class="mt-2">
                    <h2 class="text-[20px] font-bold text-slate-800 leading-tight">Create production sheet</h2>
                    <p class="text-[13px] text-slate-500 mt-1">
                        Created by {{ auth()->user()->name ?? 'User' }} &nbsp;&middot;&nbsp; {{ date('d M Y') }}
                    </p>
                </div>
            </div>

            {{-- Tab Navigation --}}
            <div class="px-6 border-b border-slate-200 flex-shrink-0 bg-white flex w-full">
                <button type="button" class="mc-tab-btn active py-3.5 font-semibold text-[14px] flex-1 text-center"
                    data-target="mc-tab-details">Details</button>
                <button type="button" class="mc-tab-btn py-3.5 font-semibold text-[14px] flex-1 text-center text-slate-500"
                    data-target="mc-tab-items">Items</button>
                <button type="button" class="mc-tab-btn py-3.5 font-semibold text-[14px] flex-1 text-center text-slate-500"
                    data-target="mc-tab-costs">Costs</button>
            </div>

            {{-- Scrollable Body --}}
            <div class="flex-1 overflow-y-auto custom-scrollbar bg-white relative">
                {{-- Form submits via AJAX from JS --}}
                <form id="createProductionForm" action="{{ route('production.store') }}" method="POST">
                    @csrf

                    {{-- ===== TAB 1: DETAILS ===== --}}
                    <div id="mc-tab-details" class="mc-tab-content block px-6 py-6 pb-20">

                        <div class="bg-amber-50 border-l-4 border-amber-500 rounded-md p-3 mb-5">
                            <p class="text-[13px] text-slate-700">
                                <span class="font-bold text-slate-800">Note:</span>
                                You will only be able to work on one product category at a time.
                            </p>
                        </div>

                        {{-- ── Photos Upload Area ──────────────────────────── --}}
                        <div class="mb-6">
                            <div
                                class="text-[13px] font-bold text-slate-800 uppercase tracking-wide border-b border-slate-100 pb-2 mb-3">
                                Photos</div>
                            <div id="photo-drop-area"
                                class="flex flex-col items-center justify-center gap-2 w-full h-[100px] bg-[#f1f5f9] rounded-md border-2 border-dashed border-slate-300 cursor-pointer hover:border-blue-400 hover:bg-blue-50 transition-colors mb-3">
                                <svg class="w-7 h-7 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <span class="text-[13px] text-slate-500">Click or drag photos here</span>
                                <span class="text-[11px] text-slate-400">JPG, PNG, WEBP, GIF — max 20 MB each</span>
                            </div>
                            <input type="file" id="photo-file-input" class="hidden" accept="image/*" multiple>
                            <div id="photo-preview-list" class="hidden border border-slate-200 rounded-md overflow-hidden">
                                <table class="w-full text-[12px] text-left">
                                    <thead class="bg-slate-50 text-slate-600 font-semibold border-b border-slate-200">
                                        <tr>
                                            <th class="px-3 py-2">File name</th>
                                            <th class="px-3 py-2">Size</th>
                                            <th class="px-3 py-2">Status</th>
                                            <th class="px-3 py-2 w-8"></th>
                                        </tr>
                                    </thead>
                                    <tbody id="photo-preview-tbody" class="divide-y divide-slate-100 bg-white"></tbody>
                                </table>
                            </div>
                        </div>

                        <div
                            class="text-[13px] font-bold text-slate-800 uppercase tracking-wide border-b border-slate-100 pb-2 mb-4">
                            Production attributes</div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-x-6 gap-y-5">

                            {{-- Production Type --}}
                            <div>
                                <label class="block text-[13px] text-slate-700 mb-1.5">Production type <span
                                        class="text-rose-500">*</span></label>
                                <div class="relative searchable-dropdown" id="ddMcTypeWrapper">
                                    <input type="hidden" name="production_type" id="ddMcTypeHidden">
                                    <button type="button" id="ddMcTypeBtn"
                                        class="form-control flex items-center pl-3 pr-8 text-left">
                                        <span id="ddMcTypeLabel" class="truncate text-slate-400">Select type</span>
                                    </button>
                                    <div class="absolute inset-y-0 right-3 flex items-center pointer-events-none">
                                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </div>
                                    <div id="ddMcTypePanel"
                                        class="hidden absolute left-0 z-50 mt-1 w-full bg-white border border-slate-200 rounded-md shadow-lg overflow-hidden"
                                        style="top:100%;">
                                        <div class="p-2 border-b border-slate-100">
                                            <input type="text" id="ddMcTypeSearch" placeholder="Search..."
                                                class="form-control !h-9 px-3">
                                        </div>
                                        <ul class="py-1 max-h-48 overflow-y-auto custom-scrollbar">
                                            @foreach($productionTypes as $t)
                                                <li class="dd-option flex items-center px-4 py-2.5 text-[14px] cursor-pointer hover:bg-slate-50 text-slate-600"
                                                    data-value="{{ $t['value'] ?? $t['label'] }}"
                                                    data-label="{{ $t['label'] }}">{{ $t['label'] }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            {{-- Production Category --}}
                            <div>
                                <label class="block text-[13px] text-slate-700 mb-1.5">Production category <span
                                        class="text-rose-500">*</span></label>
                                <div class="relative searchable-dropdown" id="ddMcCatWrapper">
                                    <input type="hidden" name="production_category" id="ddMcCatHidden">
                                    <button type="button" id="ddMcCatBtn"
                                        class="form-control flex items-center pl-3 pr-8 text-left">
                                        <span id="ddMcCatLabel" class="truncate text-slate-400">Select category</span>
                                    </button>
                                    <div class="absolute inset-y-0 right-3 flex items-center pointer-events-none">
                                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </div>
                                    <div id="ddMcCatPanel"
                                        class="hidden absolute left-0 z-50 mt-1 w-full bg-white border border-slate-200 rounded-md shadow-lg overflow-hidden"
                                        style="top:100%;">
                                        <div class="p-2 border-b border-slate-100">
                                            <input type="text" id="ddMcCatSearch" placeholder="Search..."
                                                class="form-control !h-9 px-3">
                                        </div>
                                        <ul class="py-1 max-h-48 overflow-y-auto custom-scrollbar">
                                            <li class="dd-option flex items-center px-4 py-2.5 text-[14px] cursor-pointer hover:bg-slate-50 text-slate-600"
                                                data-value="" data-label="Select category">Select category</li>
                                            <li class="dd-option flex items-center px-4 py-2.5 text-[14px] cursor-pointer hover:bg-slate-50 text-slate-600"
                                                data-value="gemstones" data-label="Gemstones">Gemstones</li>
                                            <li class="dd-option flex items-center px-4 py-2.5 text-[14px] cursor-pointer hover:bg-slate-50 text-slate-600"
                                                data-value="rough" data-label="Rough &amp; Specimen">Rough &amp; Specimen
                                            </li>
                                            <li class="dd-option flex items-center px-4 py-2.5 text-[14px] cursor-pointer hover:bg-slate-50 text-slate-600"
                                                data-value="diamond" data-label="Diamond">Diamond</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>


                            {{-- Reference --}}
                            <div>
                                <label class="block text-[13px] text-slate-700 mb-1.5">Reference</label>
                                <input type="text" name="reference" placeholder="e.g. REF-0001" class="form-control px-3">
                            </div>

                            {{-- Due Date --}}
                            <div>
                                <label class="block text-[13px] text-slate-700 mb-1.5">Due date</label>
                                <input type="date" name="due_date" class="form-control px-3">
                            </div>

                            {{-- Supplier --}}
                            <div>
                                <label class="block text-[13px] text-slate-700 mb-1.5">Supplier</label>
                                <div class="relative searchable-dropdown" id="ddMcSupplierWrapper">
                                    <input type="hidden" name="supplier_id" id="ddMcSupplierHidden">
                                    <button type="button" id="ddMcSupplierBtn"
                                        class="form-control flex items-center pl-3 pr-8 text-left">
                                        <span id="ddMcSupplierLabel" class="truncate text-slate-400">Select supplier</span>
                                    </button>
                                    <div class="absolute inset-y-0 right-3 flex items-center pointer-events-none">
                                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </div>
                                    <div id="ddMcSupplierPanel"
                                        class="hidden absolute left-0 z-50 mt-1 w-full bg-white border border-slate-200 rounded-md shadow-lg overflow-hidden"
                                        style="top:100%;">
                                        <div class="p-2 border-b border-slate-100">
                                            <input type="text" id="ddMcSupplierSearch" placeholder="Search..."
                                                class="form-control !h-9 px-3">
                                        </div>
                                        <ul class="py-1 max-h-48 overflow-y-auto custom-scrollbar">
                                            @foreach($suppliers as $s)
                                                @if($s['value'] !== 'all')
                                                    <li class="dd-option flex items-center px-4 py-2.5 text-[14px] cursor-pointer hover:bg-slate-50 text-slate-600"
                                                        data-value="{{ $s['value'] }}"
                                                        data-label="{{ $s['label'] }}">{{ $s['label'] }}</li>
                                                @endif
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            {{-- Original Quantity --}}
                            <div>
                                <label class="block text-[13px] text-slate-700 mb-1.5">Original quantity</label>
                                <input type="number" name="original_quantity" placeholder="e.g. 10"
                                    class="form-control px-3">
                            </div>

                            {{-- Original Weight --}}
                            <div>
                                <label class="block text-[13px] text-slate-700 mb-1.5">Original weight</label>
                                <div class="flex gap-2">
                                    <input type="text" name="original_weight" placeholder='e.g. "5.20"'
                                        class="form-control flex-1 px-3">
                                    <div class="relative w-[85px] searchable-dropdown" id="ddMcWeightUnitWrapper">
                                        <input type="hidden" name="weight_unit" id="ddMcWeightUnitHidden" value="ct">
                                        <button type="button" id="ddMcWeightUnitBtn"
                                            class="form-control flex items-center pl-3 pr-7 text-left">
                                            <span id="ddMcWeightUnitLabel" class="truncate text-slate-800">ct</span>
                                        </button>
                                        <div class="absolute inset-y-0 right-2.5 flex items-center pointer-events-none">
                                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 9l-7 7-7-7" />
                                            </svg>
                                        </div>
                                        <div id="ddMcWeightUnitPanel"
                                            class="hidden absolute left-0 z-50 mt-1 w-full bg-white border border-slate-200 rounded-md shadow-lg overflow-hidden"
                                            style="top:100%;">
                                            <ul class="py-1 max-h-48 overflow-y-auto custom-scrollbar">
                                                <li class="dd-option flex items-center px-4 py-2.5 text-[14px] cursor-pointer bg-slate-100 text-slate-800 font-semibold"
                                                    data-value="ct" data-label="ct">ct</li>
                                                <li class="dd-option flex items-center px-4 py-2.5 text-[14px] cursor-pointer hover:bg-slate-50 text-slate-600"
                                                    data-value="g" data-label="g">g</li>
                                                <li class="dd-option flex items-center px-4 py-2.5 text-[14px] cursor-pointer hover:bg-slate-50 text-slate-600"
                                                    data-value="kg" data-label="kg">kg</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Original Total Cost --}}
                            <div>
                                <label class="block text-[13px] text-slate-700 mb-1.5">Original total cost</label>
                                <div class="flex gap-2">
                                    <div class="relative w-[90px] searchable-dropdown" id="ddMcCurrencyWrapper">
                                        <input type="hidden" name="currency" id="ddMcCurrencyHidden" value="LKR">
                                        <button type="button" id="ddMcCurrencyBtn"
                                            class="form-control flex items-center pl-3 pr-7 text-left">
                                            <span id="ddMcCurrencyLabel" class="truncate text-slate-800">LKR</span>
                                        </button>
                                        <div class="absolute inset-y-0 right-2.5 flex items-center pointer-events-none">
                                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 9l-7 7-7-7" />
                                            </svg>
                                        </div>
                                        <div id="ddMcCurrencyPanel"
                                            class="hidden absolute left-0 z-50 mt-1 w-full bg-white border border-slate-200 rounded-md shadow-lg overflow-hidden"
                                            style="top:100%;">
                                            <ul class="py-1 max-h-48 overflow-y-auto custom-scrollbar">
                                                <li class="dd-option flex items-center px-4 py-2.5 text-[14px] cursor-pointer bg-slate-100 text-slate-800 font-semibold"
                                                    data-value="LKR" data-label="LKR">LKR</li>
                                                <li class="dd-option flex items-center px-4 py-2.5 text-[14px] cursor-pointer hover:bg-slate-50 text-slate-600"
                                                    data-value="USD" data-label="USD">USD</li>
                                                <li class="dd-option flex items-center px-4 py-2.5 text-[14px] cursor-pointer hover:bg-slate-50 text-slate-600"
                                                    data-value="EUR" data-label="EUR">EUR</li>
                                            </ul>
                                        </div>
                                    </div>
                                    <input type="text" name="original_total_cost" placeholder="0.00"
                                        class="form-control flex-1 px-3">
                                </div>
                            </div>

                        </div>

                        <div
                            class="text-[13px] font-bold text-slate-800 uppercase tracking-wide border-b border-slate-100 pb-2 mb-4 mt-6">
                            Discrepancy</div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-5">
                            <div>
                                <label class="block text-[13px] text-slate-700 mb-1.5">Discrepancy reason</label>
                                <div class="relative searchable-dropdown" id="ddMcDiscWrapper">
                                    <input type="hidden" name="discrepancy_reason" id="ddMcDiscHidden">
                                    <button type="button" id="ddMcDiscBtn"
                                        class="form-control flex items-center pl-3 pr-8 text-left">
                                        <span id="ddMcDiscLabel" class="truncate text-slate-400">Select reason</span>
                                    </button>
                                    <div class="absolute inset-y-0 right-3 flex items-center pointer-events-none">
                                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </div>
                                    <div id="ddMcDiscPanel"
                                        class="hidden absolute left-0 z-50 mt-1 w-full bg-white border border-slate-200 rounded-md shadow-lg overflow-hidden"
                                        style="top:100%;">
                                        <ul class="py-1 max-h-48 overflow-y-auto custom-scrollbar">
                                            <li class="dd-option flex items-center px-4 py-2.5 text-[14px] cursor-pointer hover:bg-slate-50 text-slate-600"
                                                data-value="" data-label="Select reason">Select reason</li>
                                            <li class="dd-option flex items-center px-4 py-2.5 text-[14px] cursor-pointer hover:bg-slate-50 text-slate-600"
                                                data-value="natural_loss" data-label="Natural loss">Natural loss</li>
                                            <li class="dd-option flex items-center px-4 py-2.5 text-[14px] cursor-pointer hover:bg-slate-50 text-slate-600"
                                                data-value="cutting_loss" data-label="Cutting loss">Cutting loss</li>
                                            <li class="dd-option flex items-center px-4 py-2.5 text-[14px] cursor-pointer hover:bg-slate-50 text-slate-600"
                                                data-value="breakage" data-label="Breakage">Breakage</li>
                                            <li class="dd-option flex items-center px-4 py-2.5 text-[14px] cursor-pointer hover:bg-slate-50 text-slate-600"
                                                data-value="other" data-label="Other">Other</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <label class="block text-[13px] text-slate-700 mb-1.5">Notes</label>
                                <input type="text" name="notes" placeholder="Optional notes..." class="form-control px-3">
                            </div>
                        </div>

                        <div class="mt-6">
                            <div
                                class="text-[13px] font-bold text-slate-800 uppercase tracking-wide border-b border-slate-100 pb-2 mb-3">
                                Documents</div>
                            <div id="doc-drop-area"
                                class="flex flex-col items-center justify-center gap-2 w-full h-[100px] bg-white border-2 border-dashed border-slate-300 rounded-md cursor-pointer hover:border-blue-400 hover:bg-blue-50 transition-colors mb-3 shadow-sm">
                                <svg class="w-7 h-7 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                <span class="text-[13px] text-slate-500">Click or drag documents here</span>
                                <span class="text-[11px] text-slate-400">PDF, DOCX, XLSX, CSV, TXT — max 20 MB each</span>
                            </div>
                            <input type="file" id="doc-file-input" class="hidden"
                                accept=".pdf,.doc,.docx,.xls,.xlsx,.csv,.txt,application/pdf,application/msword" multiple>
                            <div id="doc-preview-list" class="hidden border border-slate-200 rounded-md overflow-hidden">
                                <table class="w-full text-[12px] text-left">
                                    <thead class="bg-slate-50 text-slate-600 font-semibold border-b border-slate-200">
                                        <tr>
                                            <th class="px-3 py-2">File name</th>
                                            <th class="px-3 py-2">Size</th>
                                            <th class="px-3 py-2">Status</th>
                                            <th class="px-3 py-2 w-8"></th>
                                        </tr>
                                    </thead>
                                    <tbody id="doc-preview-tbody" class="divide-y divide-slate-100 bg-white"></tbody>
                                </table>
                            </div>
                        </div>

                    </div>

                    {{-- ===== TAB 2: ITEMS ===== --}}
                    <div id="mc-tab-items" class="mc-tab-content hidden px-6 py-6 pb-20">

                        <div
                            class="text-[13px] font-bold text-slate-800 uppercase tracking-wide border-b border-slate-100 pb-2 mb-4">
                            Production items</div>
                        <p class="text-[13px] text-slate-400 mb-4">Add the items to be processed in this production sheet.
                        </p>

                        {{-- ── Item entry row ─────────────────────────────── --}}
                        <div class="bg-slate-50 border border-slate-200 rounded-md p-4 mb-4">
                            <div class="grid grid-cols-1 md:grid-cols-4 gap-x-4 gap-y-4">

                                <div class="md:col-span-1">
                                    <label
                                        class="block text-[12px] font-semibold text-slate-600 mb-1.5 uppercase tracking-wide">SKU
                                        / Item</label>
                                    {{-- Select2 AJAX search — populated by /production/product-search --}}
                                    <select id="item-select-product" class="w-full" style="width:100%;">
                                        <option></option>
                                    </select>
                                    {{-- hidden fields filled by Select2 on selection --}}
                                    <input type="hidden" id="item-input-sku">
                                    <input type="hidden" id="item-input-product-id">
                                </div>

                                <div class="md:col-span-1">
                                    <label
                                        class="block text-[12px] font-semibold text-slate-600 mb-1.5 uppercase tracking-wide">Description</label>
                                    <input type="text" id="item-input-desc" class="form-control px-3 bg-white"
                                        placeholder="Optional description">
                                </div>

                                <div>
                                    <label
                                        class="block text-[12px] font-semibold text-slate-600 mb-1.5 uppercase tracking-wide">Quantity</label>
                                    <input type="number" id="item-input-qty" min="0" class="form-control px-3 bg-white"
                                        placeholder="0">
                                </div>

                                <div>
                                    <label
                                        class="block text-[12px] font-semibold text-slate-600 mb-1.5 uppercase tracking-wide">Weight</label>
                                    <div class="flex gap-2">
                                        <input type="text" id="item-input-weight" class="form-control flex-1 px-3 bg-white"
                                            placeholder="0.00">
                                        <div class="relative w-[80px] searchable-dropdown" id="ddMcItemUnitWrapper">
                                            <input type="hidden" id="ddMcItemUnitHidden" value="ct">
                                            <button type="button" id="ddMcItemUnitBtn"
                                                class="form-control flex items-center pl-3 pr-7 text-left bg-white">
                                                <span id="ddMcItemUnitLabel" class="truncate text-slate-800">ct</span>
                                            </button>
                                            <div class="absolute inset-y-0 right-2.5 flex items-center pointer-events-none">
                                                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 9l-7 7-7-7" />
                                                </svg>
                                            </div>
                                            <div id="ddMcItemUnitPanel"
                                                class="hidden absolute left-0 z-50 mt-1 w-full bg-white border border-slate-200 rounded-md shadow-lg overflow-hidden"
                                                style="top:100%;">
                                                <ul class="py-1 max-h-48 overflow-y-auto custom-scrollbar">
                                                    <li class="dd-option flex items-center px-4 py-2.5 text-[14px] cursor-pointer bg-slate-100 text-slate-800 font-semibold"
                                                        data-value="ct" data-label="ct">ct</li>
                                                    <li class="dd-option flex items-center px-4 py-2.5 text-[14px] cursor-pointer hover:bg-slate-50 text-slate-600"
                                                        data-value="g" data-label="g">g</li>
                                                    <li class="dd-option flex items-center px-4 py-2.5 text-[14px] cursor-pointer hover:bg-slate-50 text-slate-600"
                                                        data-value="kg" data-label="kg">kg</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <label
                                        class="block text-[12px] font-semibold text-slate-600 mb-1.5 uppercase tracking-wide">Cost</label>
                                    <input type="text" id="item-input-cost" class="form-control px-3 bg-white"
                                        placeholder="0.00">
                                </div>

                                <div class="md:col-span-3 flex items-end">
                                    <button type="button" id="btn-add-item"
                                        class="inline-flex items-center gap-2 px-5 h-[42px] bg-blue-600 hover:bg-blue-700 text-white rounded-md text-[13px] font-semibold transition-colors shadow-sm">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 4v16m8-8H4" />
                                        </svg>
                                        Add item
                                    </button>
                                </div>

                            </div>
                            <p id="item-add-error" class="hidden mt-2 text-[12px] text-red-500 font-medium">Please enter at
                                least a SKU or description before adding.</p>
                        </div>

                        {{-- Hidden container where JS writes serialized items for form POST --}}
                        <div id="items-hidden-container"></div>

                        {{-- ── Items table ────────────────────────────────── --}}
                        <div class="border border-slate-200 rounded-md overflow-hidden">
                            <div
                                class="flex items-center justify-between px-4 py-2.5 bg-[#f8fafc] border-b border-slate-200">
                                <span class="text-[12px] font-semibold text-slate-600 uppercase tracking-wide">
                                    Added items
                                    <span id="item-count-badge"
                                        class="ml-2 bg-blue-600 text-white text-[11px] font-bold rounded-full px-1.5 py-0.5">0</span>
                                </span>
                                <button type="button" id="btn-clear-items"
                                    class="text-[12px] text-red-400 hover:text-red-600 font-medium transition-colors hidden">
                                    Clear all
                                </button>
                            </div>
                            <table class="w-full text-left text-[13px]">
                                <thead class="bg-[#f8fafc] text-slate-700 font-semibold border-b border-slate-200">
                                    <tr>
                                        <th class="px-4 py-3 w-10">#</th>
                                        <th class="px-4 py-3">SKU</th>
                                        <th class="px-4 py-3">Description</th>
                                        <th class="px-4 py-3 text-right">Qty</th>
                                        <th class="px-4 py-3 text-right">Weight</th>
                                        <th class="px-4 py-3 text-right">Cost</th>
                                        <th class="px-4 py-3 w-10"></th>
                                    </tr>
                                </thead>
                                <tbody id="items-table-body" class="divide-y divide-slate-100 bg-white">
                                    <tr id="items-empty-row">
                                        <td colspan="7" class="px-4 py-10 text-center text-slate-400 text-[13px]">No items
                                            added yet</td>
                                    </tr>
                                </tbody>
                                <tfoot id="items-table-foot"
                                    class="hidden bg-slate-50 border-t border-slate-200 text-[13px] font-semibold text-slate-700">
                                    <tr>
                                        <td colspan="3" class="px-4 py-2.5 text-slate-500 text-[12px]">Totals</td>
                                        <td class="px-4 py-2.5 text-right" id="items-total-qty">0</td>
                                        <td class="px-4 py-2.5 text-right" id="items-total-weight">—</td>
                                        <td class="px-4 py-2.5 text-right" id="items-total-cost">—</td>
                                        <td></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                    </div>

                    {{-- ===== TAB 3: COSTS ===== --}}
                    <div id="mc-tab-costs" class="mc-tab-content hidden px-6 py-6 pb-20">

                        <div
                            class="text-[13px] font-bold text-slate-800 uppercase tracking-wide border-b border-slate-100 pb-2 mb-4">
                            Costing module</div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-5 mb-3">
                            <div>
                                <label class="block text-[13px] text-slate-700 mb-1.5">Cost / unit</label>
                                <input type="text" name="cost_per_unit" id="mc-cost-unit" placeholder="Cost per unit"
                                    class="form-control px-3">
                            </div>
                            <div>
                                <label class="block text-[13px] text-slate-700 mb-1.5">Total cost</label>
                                <input type="text" name="total_cost" id="mc-cost-total" placeholder="Total cost"
                                    class="form-control px-3 bg-slate-50" readonly>
                            </div>
                            <div>
                                <label class="block text-[13px] text-slate-700 mb-1.5">My cost / unit</label>
                                <input type="text" name="my_cost_per_unit" id="mc-my-cost-unit"
                                    placeholder="My cost per unit" class="form-control px-3">
                            </div>
                            <div>
                                <label class="block text-[13px] text-slate-700 mb-1.5">My total cost</label>
                                <input type="text" name="my_total_cost" id="mc-my-cost-total" placeholder="My total cost"
                                    class="form-control px-3 bg-slate-50" readonly>
                            </div>
                        </div>

                        <div class="flex justify-end mb-6">
                            <button type="button"
                                class="px-4 py-2 bg-[#f1f5f9] text-[13px] text-slate-800 font-medium rounded-md hover:bg-slate-200">Add
                                cost</button>
                        </div>

                        <div
                            class="text-[13px] font-bold text-slate-800 uppercase tracking-wide border-b border-slate-100 pb-2 mb-4">
                            Output value</div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-5">
                            <div>
                                <label class="block text-[13px] text-slate-700 mb-1.5">Expected output weight</label>
                                <div class="flex gap-2">
                                    <input type="text" name="expected_output_weight" placeholder="0.00"
                                        class="form-control flex-1 px-3">
                                    <div class="relative w-[85px] searchable-dropdown" id="ddMcOutUnitWrapper">
                                        <input type="hidden" name="output_weight_unit" id="ddMcOutUnitHidden" value="ct">
                                        <button type="button" id="ddMcOutUnitBtn"
                                            class="form-control flex items-center pl-3 pr-7 text-left">
                                            <span id="ddMcOutUnitLabel" class="truncate text-slate-800">ct</span>
                                        </button>
                                        <div class="absolute inset-y-0 right-2.5 flex items-center pointer-events-none">
                                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 9l-7 7-7-7" />
                                            </svg>
                                        </div>
                                        <div id="ddMcOutUnitPanel"
                                            class="hidden absolute left-0 z-50 mt-1 w-full bg-white border border-slate-200 rounded-md shadow-lg overflow-hidden"
                                            style="top:100%;">
                                            <ul class="py-1 max-h-48 overflow-y-auto custom-scrollbar">
                                                <li class="dd-option flex items-center px-4 py-2.5 text-[14px] cursor-pointer bg-slate-100 text-slate-800 font-semibold"
                                                    data-value="ct" data-label="ct">ct</li>
                                                <li class="dd-option flex items-center px-4 py-2.5 text-[14px] cursor-pointer hover:bg-slate-50 text-slate-600"
                                                    data-value="g" data-label="g">g</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <label class="block text-[13px] text-slate-700 mb-1.5">Expected output quantity</label>
                                <input type="number" name="expected_output_quantity" placeholder="0"
                                    class="form-control px-3">
                            </div>
                            <div>
                                <label class="block text-[13px] text-slate-700 mb-1.5">Loss %</label>
                                <input type="text" name="loss_percent" id="mc-loss-pct" placeholder="0.00 %"
                                    class="form-control px-3 bg-slate-50" readonly>
                            </div>
                            <div>
                                <label class="block text-[13px] text-slate-700 mb-1.5">Loss weight</label>
                                <input type="text" name="loss_weight" id="mc-loss-wt" placeholder="0.00"
                                    class="form-control px-3 bg-slate-50" readonly>
                            </div>
                        </div>

                    </div>

                </form>
            </div>

            {{-- Footer --}}
            <div class="px-6 py-4 border-t border-slate-200 bg-white flex justify-end gap-3 flex-shrink-0">
                <button type="button" id="create-cancel"
                    class="px-5 py-2.5 text-[14px] font-medium text-rose-500 bg-white border border-rose-300 rounded-md hover:bg-rose-50 transition-colors">
                    Cancel
                </button>
                <button type="button" id="create-save-draft"
                    class="px-5 py-2.5 text-[14px] font-medium text-slate-700 bg-[#f1f5f9] border border-slate-200 rounded-md hover:bg-slate-200 transition-colors">
                    Save as draft
                </button>
                <button type="button" id="btn-create-submit"
                    class="px-8 py-2.5 text-[14px] font-medium text-white bg-blue-700 rounded-md hover:bg-blue-800 transition-colors shadow-sm active:scale-95">
                    Create
                </button>
            </div>

        </div>
    </div>

    {{-- ===== VIEW PRODUCTION SHEET DETAILS MODAL ===== --}}
    <div id="view-modal" class="fixed inset-0 z-50 hidden items-center justify-center p-4 sm:p-6"
        style="background:rgba(0,0,0,0.5); z-index: 9999;">
        <div class="bg-white rounded-md shadow-2xl w-full max-w-5xl flex flex-col relative overflow-hidden"
            style="height:95vh;">

            {{-- Header --}}
            <div class="px-6 py-4 flex-shrink-0 bg-[#f8fafc] rounded-t-md border-b border-slate-200">
                <div class="flex justify-between items-start">
                    <button type="button" id="view-close"
                        class="text-slate-500 hover:text-slate-700 transition-colors p-1 -ml-1">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                    <div class="flex items-center gap-2">
                        <span id="view-badge-status" class="text-[12px] font-semibold px-2.5 py-0.5 rounded-full"></span>
                        <span id="view-badge-type"
                            class="bg-blue-100 text-blue-800 text-[12px] font-semibold px-2.5 py-0.5 rounded-full"></span>
                    </div>
                </div>
                <div class="mt-2">
                    <h2 class="text-[20px] font-bold text-slate-800 leading-tight" id="view-title-sheet-number">PS-XXXX</h2>
                    <p class="text-[13px] text-slate-500 mt-1">
                        Created by <span id="view-creator-name" class="font-semibold"></span> &nbsp;&middot;&nbsp; <span
                            id="view-creation-date"></span>
                    </p>
                </div>
            </div>

            {{-- Tab Navigation --}}
            <div class="px-6 border-b border-slate-200 flex-shrink-0 bg-white flex w-full">
                <button type="button"
                    class="view-tab-btn active py-3.5 font-semibold text-[14px] flex-1 text-center border-b-2 border-blue-600 text-blue-600"
                    data-target="view-tab-details">Details</button>
                <button type="button"
                    class="view-tab-btn py-3.5 font-semibold text-[14px] flex-1 text-center text-slate-500 border-b-2 border-transparent hover:text-slate-700"
                    data-target="view-tab-items">Items</button>
                <button type="button"
                    class="view-tab-btn py-3.5 font-semibold text-[14px] flex-1 text-center text-slate-500 border-b-2 border-transparent hover:text-slate-700"
                    data-target="view-tab-media">Photos &amp; Documents</button>
            </div>

            {{-- Scrollable Body --}}
            <div class="flex-1 overflow-y-auto custom-scrollbar bg-white relative p-6">

                {{-- Loader spinner inside modal --}}
                <div id="view-modal-loader" class="absolute inset-0 bg-white flex items-center justify-center z-10">
                    <svg class="animate-spin w-8 h-8 text-blue-600" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path>
                    </svg>
                </div>

                {{-- ===== TAB 1: DETAILS ===== --}}
                <div id="view-tab-details" class="view-tab-content block">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                        <div>
                            <span
                                class="block text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Reference</span>
                            <span id="view-reference" class="text-sm font-semibold text-slate-800">—</span>
                        </div>
                        <div>
                            <span class="block text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Due
                                Date</span>
                            <span id="view-due-date" class="text-sm font-semibold text-slate-800">—</span>
                        </div>
                        <div>
                            <span class="block text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Closed
                                Date</span>
                            <span id="view-closed-date" class="text-sm font-semibold text-slate-800">—</span>
                        </div>
                        <div>
                            <span class="block text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Original
                                Quantity</span>
                            <span id="view-orig-qty" class="text-sm font-semibold text-slate-800">—</span>
                        </div>
                        <div>
                            <span class="block text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Original
                                Weight</span>
                            <span id="view-orig-weight" class="text-sm font-semibold text-slate-800">—</span>
                        </div>
                        <div>
                            <span class="block text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Original
                                Total Cost</span>
                            <span id="view-orig-cost" class="text-sm font-semibold text-slate-800">—</span>
                        </div>
                        <div>
                            <span class="block text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Supplier</span>
                            <span id="view-supplier" class="text-sm font-semibold text-slate-800">—</span>
                        </div>
                    </div>

                    <div class="border-t border-slate-100 pt-5 mb-5">
                        <span
                            class="block text-[11px] font-semibold text-slate-400 uppercase tracking-wider mb-1.5">Discrepancy
                            Reason</span>
                        <span id="view-discrepancy-reason"
                            class="inline-block text-xs font-semibold px-2.5 py-0.5 rounded bg-slate-100 text-slate-700">—</span>
                    </div>

                    <div class="border-t border-slate-100 pt-5">
                        <span
                            class="block text-[11px] font-semibold text-slate-400 uppercase tracking-wider mb-1.5">Notes</span>
                        <div id="view-notes"
                            class="text-sm text-slate-600 bg-slate-50 border border-slate-200 rounded-md p-4 min-h-[80px]">—
                        </div>
                    </div>
                </div>

                {{-- ===== TAB 2: ITEMS ===== --}}
                <div id="view-tab-items" class="view-tab-content hidden">
                    <div class="border border-slate-200 rounded-md overflow-hidden bg-white shadow-sm">
                        <table class="w-full text-[13px] text-left">
                            <thead class="bg-slate-50 text-slate-700 font-semibold border-b border-slate-200">
                                <tr>
                                    <th class="px-4 py-3 w-12">#</th>
                                    <th class="px-4 py-3">SKU / Item</th>
                                    <th class="px-4 py-3">Description</th>
                                    <th class="px-4 py-3 text-right">Quantity</th>
                                    <th class="px-4 py-3 text-right">Weight</th>
                                    <th class="px-4 py-3 text-right">Cost</th>
                                </tr>
                            </thead>
                            <tbody id="view-items-tbody" class="divide-y divide-slate-100 bg-white">
                                <tr>
                                    <td colspan="6" class="px-4 py-10 text-center text-slate-400">No items added to this
                                        sheet.</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- ===== TAB 3: MEDIA ===== --}}
                <div id="view-tab-media" class="view-tab-content hidden">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        {{-- Photos Grid --}}
                        <div>
                            <h3
                                class="text-sm font-bold text-slate-800 uppercase tracking-wide border-b border-slate-100 pb-2 mb-4">
                                Photos</h3>
                            <div id="view-photos-container" class="grid grid-cols-3 gap-3">
                                <p class="text-slate-400 text-sm col-span-3">No photos uploaded.</p>
                            </div>
                        </div>

                        {{-- Documents List --}}
                        <div>
                            <h3
                                class="text-sm font-bold text-slate-800 uppercase tracking-wide border-b border-slate-100 pb-2 mb-4">
                                Documents</h3>
                            <div id="view-docs-container" class="flex flex-col gap-2">
                                <p class="text-slate-400 text-sm">No documents uploaded.</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            {{-- Footer --}}
            <div class="px-6 py-4 border-t border-slate-200 bg-[#f8fafc] flex justify-end gap-3 flex-shrink-0">
                <button type="button" id="view-close-btn"
                    class="px-6 py-2.5 text-[14px] font-medium text-slate-700 bg-white border border-slate-300 rounded-md hover:bg-slate-50 transition-colors shadow-sm">
                    Close
                </button>
            </div>

        </div>
    </div>
@endsection

{{-- Select2 CSS for SKU autocomplete (JS already loaded in layout) --}}
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
<style>
    /* Make Select2 match the existing form-control style */
    .select2-container .select2-selection--single {
        height: 42px !important;
        border-radius: 6px !important;
        border: 1px solid #e2e8f0 !important;
        display: flex;
        align-items: center;
        font-size: 14px !important;
        background: #fff;
        transition: all 0.2s;
    }

    .select2-container .select2-selection--single .select2-selection__rendered {
        line-height: 42px !important;
        padding-left: 12px !important;
        color: #334155;
    }

    .select2-container .select2-selection--single .select2-selection__arrow {
        height: 42px !important;
    }

    .select2-container--default.select2-container--focus .select2-selection--single,
    .select2-container--default.select2-container--open .select2-selection--single {
        border-color: #3b82f6 !important;
        box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1) !important;
    }

    .select2-results__option {
        font-size: 13px;
        padding: 8px 12px;
    }

    .select2-results__option--highlighted {
        background: #eff6ff !important;
        color: #1e40af !important;
    }

    .select2-search--dropdown .select2-search__field {
        border: 1px solid #e2e8f0 !important;
        border-radius: 4px !important;
        font-size: 13px !important;
        padding: 6px 10px !important;
    }
</style>

@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', function () {

            const DROPS = [
                { btn: 'btn-prodtype', panel: 'panel-prodtype' },
                { btn: 'btn-supplier', panel: 'panel-supplier' },
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

            // —— Option selection helpers —————————————————————————————————————
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

            // Production type: custom bind that marks selected option with text-slate-800 for getFilters()
            document.querySelectorAll('.opt-prodtype').forEach(function (el) {
                el.addEventListener('click', function () {
                    // Deselect all
                    document.querySelectorAll('.opt-prodtype').forEach(function (o) {
                        o.classList.remove('text-slate-800', 'bg-slate-100', 'font-semibold');
                        o.classList.add('text-slate-700');
                    });
                    // Mark this one as selected
                    this.classList.add('text-slate-800', 'bg-slate-100', 'font-semibold');
                    this.classList.remove('text-slate-700');
                    // Update visible label
                    var lbl = document.getElementById('lbl-prodtype');
                    if (lbl) {
                        lbl.textContent = this.dataset.label;
                        lbl.classList.remove('text-slate-500');
                        lbl.classList.add('text-slate-800');
                    }
                    closeAll();
                });
            });

            bindOptions('.opt-creator', 'lbl-creator'); // Kept as fallback if needed, but not used

            // Supplier filter option click
            document.querySelectorAll('.opt-supplier').forEach(function (el) {
                el.addEventListener('click', function () {
                    var lbl = document.getElementById('lbl-supplier');
                    if (lbl) {
                        lbl.textContent = this.dataset.label;
                        lbl.classList.remove('text-slate-400');
                        lbl.classList.add('text-slate-600');
                    }
                    var hid = document.getElementById('filter-supplier-id');
                    if (hid) hid.value = this.dataset.value || 'all';
                    closeAll();
                });
            });

            // —— Supplier search ───────────────────────────────────────────────
            const ss = document.getElementById('search-supplier');
            if (ss) {
                ss.addEventListener('click', e => e.stopPropagation());
                ss.addEventListener('input', function () {
                    const q = this.value.toLowerCase();
                    document.querySelectorAll('.opt-supplier').forEach(o => {
                        o.style.display = o.dataset.label.toLowerCase().includes(q) ? '' : 'none';
                    });
                });
            }

            // —— Creator search ———————————————————————————————————————————————
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

            // —— Reset ————————————————————————————————————————————————————————
            document.getElementById('btn-reset').addEventListener('click', () => {
                // Clear prodtype selection marker
                document.querySelectorAll('.opt-prodtype').forEach(function (o) {
                    o.classList.remove('text-slate-800', 'bg-slate-100', 'font-semibold');
                    o.classList.add('text-slate-700');
                });
                var ptLbl = document.getElementById('lbl-prodtype');
                if (ptLbl) { ptLbl.textContent = 'Select'; ptLbl.classList.add('text-slate-500'); ptLbl.classList.remove('text-slate-800'); }
                ['lbl-supplier'].forEach(id => {
                    const el = document.getElementById(id);
                    if (el) {
                        el.textContent = 'Select';
                        el.classList.add('text-slate-400');
                        el.classList.remove('text-slate-600');
                    }
                });
                var filterSupId = document.getElementById('filter-supplier-id');
                if (filterSupId) filterSupId.value = 'all';
                document.getElementById('date-from').value = '';
                document.getElementById('date-to').value = '';
            });

            // —— Date guard ———————————————————————————————————————————————————
            const df = document.getElementById('date-from');
            const dt = document.getElementById('date-to');
            df.addEventListener('change', () => { if (dt.value && df.value > dt.value) dt.value = df.value; });
            dt.addEventListener('change', () => { if (df.value && dt.value < df.value) df.value = dt.value; });

            // —— Status tabs ——————————————————————————————————————————————————
            document.querySelectorAll('.status-tab').forEach(btn => {
                btn.addEventListener('click', function () {
                    document.querySelectorAll('.status-tab').forEach(b => b.classList.remove('bg-slate-50'));
                    this.classList.add('bg-slate-50');
                });
            });

            // —— Placeholder actions ——————————————————————————————————————————
            ['btn-excel', 'btn-manage-cols'].forEach(id => {
                const el = document.getElementById(id);
                if (el) el.addEventListener('click', () => alert(id + ' — coming soon.'));
            });

            // —— Create Modal Open/Close ——————————————————————————————————————
            var modal = document.getElementById('create-modal');
            var btnOpen = document.getElementById('btn-create');
            var _skuSelect2Inited = false;

            function _initSkuSelect2() {
                if (_skuSelect2Inited || !window.jQuery) return;
                var $sel = $('#item-select-product');
                if (!$sel.length) return;
                _skuSelect2Inited = true;

                $sel.select2({
                    placeholder: 'Search by SKU or name…',
                    allowClear: true,
                    minimumInputLength: 1,
                    dropdownParent: $('#create-modal'),
                    ajax: {
                        url: '/production/product-search',
                        dataType: 'json',
                        delay: 250,
                        data: function (params) { return { q: params.term }; },
                        processResults: function (data) { return { results: data.results }; },
                        cache: true
                    }
                });

                $sel.on('select2:select', function (e) {
                    var d = e.params.data;
                    var val = d.id || '';
                    if (val.indexOf(':::') !== -1) {
                        var parts = val.split(':::');
                        $('#item-input-sku').val(parts[1]);
                        $('#item-input-product-id').val(parts[0]);
                    } else {
                        $('#item-input-sku').val(d.sku || '');
                        $('#item-input-product-id').val(d.id || '');
                    }
                    var descEl = document.getElementById('item-input-desc');
                    if (descEl && !descEl.value && d.description) descEl.value = d.description;
                });

                $sel.on('select2:clear', function () {
                    $('#item-input-sku').val('');
                    $('#item-input-product-id').val('');
                });
            }

            function openModal() {
                modal.classList.remove('hidden');
                modal.classList.add('flex');
                document.body.style.overflow = 'hidden';
                // Initialize Select2 lazily — after modal is visible
                setTimeout(_initSkuSelect2, 50);
            }

            function closeModal() {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
                document.body.style.overflow = '';
                resetModal();
            }

            function resetModal() {
                var resets = [
                    ['ddMcTypeLabel', 'Select type', 'ddMcTypeHidden', ''],
                    ['ddMcCatLabel', 'Select category', 'ddMcCatHidden', ''],
                    ['ddMcSupplierLabel', 'Select supplier', 'ddMcSupplierHidden', ''],
                    ['ddMcDiscLabel', 'Select reason', 'ddMcDiscHidden', ''],
                ];
                resets.forEach(function (r) {
                    var lbl = document.getElementById(r[0]);
                    var hid = document.getElementById(r[2]);
                    if (lbl) { lbl.textContent = r[1]; lbl.className = 'truncate text-slate-400'; }
                    if (hid) hid.value = r[3];
                });

                // Reset badge
                var badge = document.getElementById('mc-badge-type');
                if (badge) { badge.classList.add('hidden'); badge.textContent = ''; }

                // Reset the HTML form fields
                var form = document.getElementById('createProductionForm');
                if (form) form.reset();

                // Reset Costs tab calculated fields
                ['mc-cost-total', 'mc-my-cost-total', 'mc-loss-pct', 'mc-loss-wt'].forEach(function (id) {
                    var el = document.getElementById(id);
                    if (el) el.value = '';
                });

                // Reset items list (defined later in ITEMS section)
                if (typeof window._resetItemsList === 'function') window._resetItemsList();

                // Reset media queues (defined later in MEDIA section)
                if (typeof window._resetMediaQueues === 'function') window._resetMediaQueues();

                // Go back to Details tab
                activateTab('mc-tab-details');
            }

            if (btnOpen) btnOpen.addEventListener('click', openModal);
            document.getElementById('create-close').addEventListener('click', closeModal);
            document.getElementById('create-cancel').addEventListener('click', closeModal);
            modal.addEventListener('click', function (e) { if (e.target === modal) closeModal(); });

            // —— Create Modal Tab Navigation —————————————————————————————————
            function activateTab(targetId) {
                document.querySelectorAll('.mc-tab-btn').forEach(function (b) {
                    b.classList.remove('active');
                    b.classList.add('text-slate-500');
                });
                document.querySelectorAll('.mc-tab-content').forEach(function (c) {
                    c.classList.add('hidden');
                    c.classList.remove('block');
                });
                var target = document.getElementById(targetId);
                if (target) { target.classList.remove('hidden'); target.classList.add('block'); }
                var btn = document.querySelector('.mc-tab-btn[data-target="' + targetId + '"]');
                if (btn) { btn.classList.add('active'); btn.classList.remove('text-slate-500'); }
            }

            document.querySelectorAll('.mc-tab-btn').forEach(function (btn) {
                btn.addEventListener('click', function () { activateTab(btn.dataset.target); });
            });

            // —— Create Modal Custom Searchable Dropdowns —————————————————————
            function closeAllDropdowns() {
                document.querySelectorAll('.searchable-dropdown [id$="Panel"]').forEach(function (p) {
                    p.classList.add('hidden');
                });
            }

            function updateBadge() {
                var type = document.getElementById('ddMcTypeLabel') ? document.getElementById('ddMcTypeLabel').textContent : '';
                var cat = document.getElementById('ddMcCatLabel') ? document.getElementById('ddMcCatLabel').textContent : '';
                var badge = document.getElementById('mc-badge-type');
                var parts = [];
                if (type && type !== 'Select type') parts.push(type);
                if (cat && cat !== 'Select category') parts.push(cat);
                if (parts.length) {
                    badge.textContent = parts.join(' · ');
                    badge.classList.remove('hidden');
                } else {
                    badge.classList.add('hidden');
                }
            }

            function setupDropdown(wrapperId) {
                var wrapper = document.getElementById(wrapperId);
                if (!wrapper) return;

                var btn = wrapper.querySelector('button');
                var panel = wrapper.querySelector('[id$="Panel"]');
                var hidden = wrapper.querySelector('input[type="hidden"]');
                var label = wrapper.querySelector('.truncate');
                var search = wrapper.querySelector('input[type="text"]');

                if (!btn || !panel) return;

                btn.addEventListener('click', function (e) {
                    e.stopPropagation();
                    var wasHidden = panel.classList.contains('hidden');
                    closeAllDropdowns();
                    if (wasHidden) {
                        panel.classList.remove('hidden');
                        if (search) setTimeout(function () { search.focus(); }, 50);
                    }
                });

                if (search) {
                    search.addEventListener('click', function (e) { e.stopPropagation(); });
                    search.addEventListener('input', function () {
                        var q = this.value.toLowerCase();
                        wrapper.querySelectorAll('.dd-option').forEach(function (o) {
                            o.style.display = (o.dataset.label || '').toLowerCase().includes(q) ? '' : 'none';
                        });
                    });
                }

                wrapper.addEventListener('click', function (e) {
                    var opt = e.target.closest('.dd-option');
                    if (!opt) return;

                    if (hidden) hidden.value = opt.dataset.value || '';
                    if (label) { label.textContent = opt.dataset.label || opt.textContent.trim(); label.className = 'truncate text-slate-800'; }

                    wrapper.querySelectorAll('.dd-option').forEach(function (o) {
                        o.classList.remove('bg-slate-100', 'text-slate-800', 'font-semibold');
                        o.classList.add('text-slate-600');
                    });
                    opt.classList.add('bg-slate-100', 'text-slate-800', 'font-semibold');
                    opt.classList.remove('text-slate-600');

                    if (search) {
                        search.value = '';
                        wrapper.querySelectorAll('.dd-option').forEach(function (o) { o.style.display = ''; });
                    }
                    panel.classList.add('hidden');

                    if (wrapperId === 'ddMcTypeWrapper' || wrapperId === 'ddMcCatWrapper') updateBadge();
                });

                document.addEventListener('click', function (e) {
                    if (!wrapper.contains(e.target)) panel.classList.add('hidden');
                });
            }

            [
                'ddMcTypeWrapper', 'ddMcCatWrapper', 'ddMcSupplierWrapper',
                'ddMcWeightUnitWrapper', 'ddMcCurrencyWrapper', 'ddMcDiscWrapper',
                'ddMcItemUnitWrapper', 'ddMcOutUnitWrapper'
            ].forEach(setupDropdown);

            // —— AJAX Form Submission (handles media upload after sheet creation) ——
            function submitProductionForm(statusOverride) {
                var type = document.getElementById('ddMcTypeHidden') ? document.getElementById('ddMcTypeHidden').value : '';
                var cat = document.getElementById('ddMcCatHidden') ? document.getElementById('ddMcCatHidden').value : '';
                var typeBtn = document.getElementById('ddMcTypeBtn');
                var catBtn = document.getElementById('ddMcCatBtn');
                var valid = true;

                if (!type) {
                    if (typeBtn) { typeBtn.classList.add('ring-2', 'ring-red-400'); setTimeout(function () { typeBtn.classList.remove('ring-2', 'ring-red-400'); }, 3000); }
                    valid = false;
                }
                if (!cat) {
                    if (catBtn) { catBtn.classList.add('ring-2', 'ring-red-400'); setTimeout(function () { catBtn.classList.remove('ring-2', 'ring-red-400'); }, 3000); }
                    valid = false;
                }
                if (!valid) {
                    // Switch to Details tab to show the error fields
                    activateTab('mc-tab-details');
                    return;
                }

                var form = document.getElementById('createProductionForm');
                var formData = new FormData(form);

                if (statusOverride) {
                    formData.set('status', statusOverride);
                }

                // Disable buttons & show spinner
                var btnSubmit = document.getElementById('btn-create-submit');
                var btnDraft = document.getElementById('create-save-draft');
                if (btnSubmit) { btnSubmit.disabled = true; btnSubmit.textContent = 'Creating…'; }
                if (btnDraft) { btnDraft.disabled = true; }

                fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                    },
                    body: formData,
                })
                    .then(function (r) { return r.json(); })
                    .then(function (json) {
                        if (!json.success) {
                            alert('Failed to create sheet: ' + (json.message || 'Unknown error'));
                            if (btnSubmit) { btnSubmit.disabled = false; btnSubmit.textContent = 'Create'; }
                            if (btnDraft) { btnDraft.disabled = false; }
                            return;
                        }

                        var sheetId = json.sheet_id;
                        var sheetNum = json.sheet_number;
                        var allQueued = mediaQueued.photos.concat(mediaQueued.documents);

                        function onAllDone() {
                            // Close modal and reset
                            closeModal();
                            // Refresh table and counts without full page reload
                            currentPage = 1;
                            loadTable(getFilters());
                            refreshCounts();
                            // Show success toast
                            showToast(sheetNum + ' created successfully!', 'success');
                        }

                        if (allQueued.length === 0) {
                            onAllDone();
                            return;
                        }

                        // Upload files sequentially, then refresh
                        function uploadNext(index) {
                            if (index >= allQueued.length) {
                                onAllDone();
                                return;
                            }
                            var item = allQueued[index];
                            var fd = new FormData();
                            fd.append('sheet_id', sheetId);
                            fd.append('file_type', item.type);
                            fd.append('file', item.file);

                            // Update status in table
                            var statusCell = document.getElementById('media-status-' + item.uid);
                            if (statusCell) statusCell.innerHTML = '<span class="text-blue-500 font-medium">Uploading…</span>';

                            fetch('{{ route("production.media.upload") }}', {
                                method: 'POST',
                                headers: {
                                    'X-Requested-With': 'XMLHttpRequest',
                                    'Accept': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                                },
                                body: fd,
                            })
                                .then(function (r) { return r.json(); })
                                .then(function (res) {
                                    if (statusCell) {
                                        statusCell.innerHTML = res.success
                                            ? '<span class="text-green-600 font-medium">✓ Uploaded</span>'
                                            : '<span class="text-red-500 font-medium">✗ Failed</span>';
                                    }
                                })
                                .catch(function () {
                                    if (statusCell) statusCell.innerHTML = '<span class="text-red-500 font-medium">✗ Error</span>';
                                })
                                .finally(function () {
                                    uploadNext(index + 1);
                                });
                        }

                        uploadNext(0);
                    })
                    .catch(function () {
                        alert('Network error. Please try again.');
                        if (btnSubmit) { btnSubmit.disabled = false; btnSubmit.textContent = 'Create'; }
                        if (btnDraft) { btnDraft.disabled = false; }
                    });
            }

            document.getElementById('btn-create-submit').addEventListener('click', function () {
                submitProductionForm(null);
            });

            document.getElementById('create-save-draft').addEventListener('click', function () {
                submitProductionForm('draft');
            });

            // ══════════════════════════════════════════════════════════════════
            // AJAX TABLE LOADING
            // ══════════════════════════════════════════════════════════════════

            var currentStatus = 'all';
            var currentPage = 1;

            // ── Helpers ──────────────────────────────────────────────────────
            function statusBadge(status) {
                var map = {
                    'draft': '<span class="px-2 py-0.5 rounded-full text-[11px] font-semibold bg-amber-100 text-amber-800">Draft</span>',
                    'in_production': '<span class="px-2 py-0.5 rounded-full text-[11px] font-semibold bg-blue-100 text-blue-800">In production</span>',
                    'completed': '<span class="px-2 py-0.5 rounded-full text-[11px] font-semibold bg-green-100 text-green-800">Completed</span>',
                    'deleted': '<span class="px-2 py-0.5 rounded-full text-[11px] font-semibold bg-red-100 text-red-800">Deleted</span>',
                };
                return map[status] || '<span class="px-2 py-0.5 rounded-full text-[11px] font-semibold bg-slate-100 text-slate-600">' + status + '</span>';
            }

            function getFilters() {
                // Read selected prodtype — send data-value (type_value) to match controller filter
                var selectedTypeValue = '';
                var activeOpt = document.querySelector('#w-prodtype .opt-prodtype.text-slate-800');
                if (activeOpt) {
                    selectedTypeValue = activeOpt.dataset.value || '';
                }
                return {
                    status: currentStatus,
                    production_type: selectedTypeValue,
                    date_from: document.getElementById('date-from').value,
                    date_to: document.getElementById('date-to').value,
                    creator: (function () {
                        var lbl = document.getElementById('lbl-creator');
                        return lbl ? lbl.textContent : '';
                    })(),
                    search: document.getElementById('prod-search').value,
                    per_page: document.getElementById('prod-per-page').value,
                    page: currentPage,
                };
            }

            // ── Pre-select production type from URL ?type= param ──────────────
            function preSelectTypeFromUrl() {
                var urlParams = new URLSearchParams(window.location.search);
                var typeParam = urlParams.get('type'); // e.g. 're-assortment'
                if (!typeParam) return;

                var opts = document.querySelectorAll('#w-prodtype .opt-prodtype');
                var matched = null;
                opts.forEach(function (opt) {
                    var val = (opt.dataset.value || '').toLowerCase();
                    if (val === typeParam.toLowerCase()) matched = opt;
                });

                if (matched) {
                    // Deselect all
                    opts.forEach(function (o) {
                        o.classList.remove('text-slate-800', 'bg-slate-100', 'font-semibold');
                        o.classList.add('text-slate-700');
                    });
                    // Highlight matched
                    matched.classList.add('text-slate-800', 'bg-slate-100', 'font-semibold');
                    matched.classList.remove('text-slate-700');
                    // Update label
                    var lbl = document.getElementById('lbl-prodtype');
                    if (lbl) {
                        lbl.textContent = matched.dataset.label || matched.textContent.trim();
                        lbl.classList.remove('text-slate-500');
                        lbl.classList.add('text-slate-800');
                    }
                }
            }

            function loadTable(params) {
                var tbody = document.getElementById('prod-table-body');
                var countEl = document.getElementById('prod-result-count');
                var pageEl = document.getElementById('prod-page-info');
                var btnPrev = document.getElementById('btn-prev');
                var btnNext = document.getElementById('btn-next');

                // Loading indicator
                tbody.innerHTML = '<tr><td colspan="11" class="px-4 py-12 text-center text-slate-400 text-sm">' +
                    '<svg class="animate-spin w-5 h-5 mx-auto text-blue-400" fill="none" viewBox="0 0 24 24">' +
                    '<circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>' +
                    '<path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path></svg></td></tr>';

                var qs = Object.keys(params).map(function (k) {
                    return encodeURIComponent(k) + '=' + encodeURIComponent(params[k] || '');
                }).join('&');

                fetch('{{ route("production.data") }}?' + qs, {
                    headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
                })
                    .then(function (r) { return r.json(); })
                    .then(function (json) {
                        var rows = json.data;
                        currentPage = json.current_page;

                        if (!rows || rows.length === 0) {
                            tbody.innerHTML = '<tr><td colspan="11" class="px-4 py-12 text-center text-slate-400 text-sm">No records found</td></tr>';
                        } else {
                            tbody.innerHTML = rows.map(function (r) {
                                return '<tr class="hover:bg-slate-50 transition-colors">' +
                                    '<td class="px-4 py-3 font-medium">' +
                                    '<button type="button" class="text-blue-600 hover:text-blue-800 hover:underline font-semibold focus:outline-none" onclick="openViewModal(' + r.id + ')">' + r.sheet_number + '</button>' +
                                    '</td>' +
                                    '<td class="px-4 py-3">' + r.production_type + '</td>' +
                                    '<td class="px-4 py-3">' + r.reference + '</td>' +
                                    '<td class="px-4 py-3">' + statusBadge(r.status) + '</td>' +
                                    '<td class="px-4 py-3">' + r.creation_date + '</td>' +
                                    '<td class="px-4 py-3">' + r.due_date + '</td>' +
                                    '<td class="px-4 py-3">' + r.closed_date + '</td>' +
                                    '<td class="px-4 py-3">' + r.original_quantity + '</td>' +
                                    '<td class="px-4 py-3">' + r.original_weight + '</td>' +
                                    '<td class="px-4 py-3">' + r.original_total_cost + '</td>' +
                                    '<td class="px-4 py-3">' + (r.discrepancy_reason !== '—' ? r.discrepancy_reason : '—') + '</td>' +
                                    '</tr>';
                            }).join('');
                        }

                        // Update count label
                        if (countEl) countEl.textContent = 'Showing ' + json.total + ' result' + (json.total !== 1 ? 's' : '');
                        if (pageEl) pageEl.textContent = json.current_page + ' / ' + json.last_page;

                        // Prev/Next buttons
                        if (btnPrev) {
                            if (json.current_page <= 1) {
                                btnPrev.classList.add('cursor-not-allowed', 'text-slate-400', 'bg-slate-50');
                                btnPrev.classList.remove('cursor-pointer', 'text-slate-700', 'bg-white', 'hover:bg-slate-50');
                                btnPrev.onclick = null;
                            } else {
                                btnPrev.classList.remove('cursor-not-allowed', 'text-slate-400', 'bg-slate-50');
                                btnPrev.classList.add('cursor-pointer', 'text-slate-700', 'bg-white', 'hover:bg-slate-50');
                                btnPrev.onclick = function () { currentPage--; loadTable(getFilters()); };
                            }
                        }
                        if (btnNext) {
                            if (json.current_page >= json.last_page) {
                                btnNext.classList.add('cursor-not-allowed', 'text-slate-400', 'bg-slate-50');
                                btnNext.classList.remove('cursor-pointer', 'text-slate-700', 'bg-white', 'hover:bg-slate-50');
                                btnNext.onclick = null;
                            } else {
                                btnNext.classList.remove('cursor-not-allowed', 'text-slate-400', 'bg-slate-50');
                                btnNext.classList.add('cursor-pointer', 'text-slate-700', 'bg-white', 'hover:bg-slate-50');
                                btnNext.onclick = function () { currentPage++; loadTable(getFilters()); };
                            }
                        }
                    })
                    .catch(function () {
                        tbody.innerHTML = '<tr><td colspan="11" class="px-4 py-12 text-center text-red-400 text-sm">Failed to load data. Please try again.</td></tr>';
                    });
            }

            function refreshCounts() {
                fetch('{{ route("production.counts") }}', {
                    headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
                })
                    .then(function (r) { return r.json(); })
                    .then(function (json) {
                        ['all', 'in_production', 'completed', 'deleted'].forEach(function (key) {
                            var cEl = document.getElementById('cnt-' + key);
                            var tEl = document.getElementById('tot-' + key);
                            if (cEl) cEl.textContent = json.counts[key];
                            if (tEl) tEl.textContent = json.totals[key];
                        });
                    });
            }

            // ── Status tab wiring ────────────────────────────────────────────
            document.querySelectorAll('.status-tab').forEach(function (btn) {
                btn.addEventListener('click', function () {
                    currentStatus = this.dataset.tab;
                    currentPage = 1;
                    loadTable(getFilters());
                });
            });

            // ── Apply filter ─────────────────────────────────────────────────
            document.getElementById('btn-apply').addEventListener('click', function () {
                currentPage = 1;
                loadTable(getFilters());
            });

            // ── Search (enter key) ────────────────────────────────────────────
            document.getElementById('prod-search').addEventListener('keydown', function (e) {
                if (e.key === 'Enter') { currentPage = 1; loadTable(getFilters()); }
            });
            document.querySelector('#prod-search + button').addEventListener('click', function () {
                currentPage = 1; loadTable(getFilters());
            });

            // ── Per-page change ───────────────────────────────────────────────
            document.getElementById('prod-per-page').addEventListener('change', function () {
                currentPage = 1; loadTable(getFilters());
            });

            // ── Initial load on page ready (with optional URL type pre-select) ──
            preSelectTypeFromUrl();
            loadTable(getFilters());

            // ══════════════════════════════════════════════════════════════════
            // ITEMS TAB — fully functional add/remove/totals/serialize
            // ══════════════════════════════════════════════════════════════════
            var itemsList = [];   // in-memory array of added items
            var itemIndex = 0;    // ever-incrementing row key

            function renderItems() {
                var tbody = document.getElementById('items-table-body');
                var tfoot = document.getElementById('items-table-foot');
                var emptyRow = document.getElementById('items-empty-row');
                var badge = document.getElementById('item-count-badge');
                var clearBtn = document.getElementById('btn-clear-items');
                var hidden = document.getElementById('items-hidden-container');

                // Badge
                badge.textContent = itemsList.length;

                // Clear button visibility
                if (clearBtn) {
                    if (itemsList.length > 0) clearBtn.classList.remove('hidden');
                    else clearBtn.classList.add('hidden');
                }

                // Empty-row toggle
                if (itemsList.length === 0) {
                    if (!emptyRow) {
                        tbody.innerHTML = '<tr id="items-empty-row"><td colspan="7" class="px-4 py-10 text-center text-slate-400 text-[13px]">No items added yet</td></tr>';
                    }
                    if (tfoot) tfoot.classList.add('hidden');
                } else {
                    if (tfoot) tfoot.classList.remove('hidden');
                    // Rebuild tbody rows (only the data rows — NOT emptyRow)
                    var rowsHtml = itemsList.map(function (item, idx) {
                        return '<tr class="hover:bg-slate-50 transition-colors">' +
                            '<td class="px-4 py-3 text-slate-400 text-[12px]">' + (idx + 1) + '</td>' +
                            '<td class="px-4 py-3 font-medium text-slate-800">' + (item.sku || '<span class="text-slate-400">—</span>') + '</td>' +
                            '<td class="px-4 py-3 text-slate-600">' + (item.desc || '<span class="text-slate-400">—</span>') + '</td>' +
                            '<td class="px-4 py-3 text-right">' + (item.qty !== '' ? item.qty : '—') + '</td>' +
                            '<td class="px-4 py-3 text-right">' + (item.weight !== '' ? item.weight + ' ' + item.unit : '—') + '</td>' +
                            '<td class="px-4 py-3 text-right">' + (item.cost !== '' ? item.cost : '—') + '</td>' +
                            '<td class="px-4 py-3 text-center">' +
                            '<button type="button" data-key="' + item.key + '" class="btn-remove-item text-slate-300 hover:text-red-500 transition-colors">' +
                            '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>' +
                            '</button>' +
                            '</td>' +
                            '</tr>';
                    }).join('');
                    tbody.innerHTML = rowsHtml;

                    // Bind remove buttons
                    tbody.querySelectorAll('.btn-remove-item').forEach(function (btn) {
                        btn.addEventListener('click', function () {
                            var key = parseInt(this.dataset.key);
                            itemsList = itemsList.filter(function (i) { return i.key !== key; });
                            renderItems();
                            serializeItems();
                        });
                    });

                    // Update totals footer
                    var totalQty = 0;
                    var totalWeight = 0;
                    var totalCost = 0;
                    var hasWeight = false;
                    var hasCost = false;

                    itemsList.forEach(function (item) {
                        if (item.qty !== '') totalQty += parseFloat(item.qty) || 0;
                        if (item.weight !== '') { totalWeight += parseFloat(item.weight) || 0; hasWeight = true; }
                        if (item.cost !== '') { totalCost += parseFloat(item.cost) || 0; hasCost = true; }
                    });

                    var qtyEl = document.getElementById('items-total-qty');
                    var weightEl = document.getElementById('items-total-weight');
                    var costEl = document.getElementById('items-total-cost');

                    if (qtyEl) qtyEl.textContent = totalQty > 0 ? totalQty : '—';
                    if (weightEl) weightEl.textContent = hasWeight ? totalWeight.toFixed(4) : '—';
                    if (costEl) costEl.textContent = hasCost ? totalCost.toFixed(2) : '—';
                }

                // Always rebuild hidden inputs for form submission
                serializeItems();
            }

            function serializeItems() {
                var container = document.getElementById('items-hidden-container');
                if (!container) return;
                container.innerHTML = '';
                itemsList.forEach(function (item, idx) {
                    var fields = { sku: item.sku, product_id: item.product_id, description: item.desc, quantity: item.qty, weight: item.weight, weight_unit: item.unit, cost: item.cost };
                    Object.keys(fields).forEach(function (key) {
                        var inp = document.createElement('input');
                        inp.type = 'hidden';
                        inp.name = 'items[' + idx + '][' + key + ']';
                        inp.value = fields[key] || '';
                        container.appendChild(inp);
                    });
                });
            }

            // ── Add Item button ──────────────────────────────────────────────
            var btnAddItem = document.getElementById('btn-add-item');
            if (btnAddItem) {
                btnAddItem.addEventListener('click', function () {
                    // Try to get SKU and Product ID directly from Select2 first (failsafe)
                    var sku = '';
                    var productId = '';
                    if (window.jQuery && $('#item-select-product').length && $('#item-select-product').val()) {
                        var selectedVal = $('#item-select-product').val();
                        if (selectedVal && selectedVal.indexOf(':::') !== -1) {
                            var parts = selectedVal.split(':::');
                            productId = parts[0];
                            sku = parts[1];
                        }
                    }

                    // Fallback to hidden inputs if Select2 query returned nothing
                    if (!sku) {
                        sku = (document.getElementById('item-input-sku') || {}).value || '';
                    }
                    if (!productId) {
                        productId = (document.getElementById('item-input-product-id') || {}).value || '';
                    }

                    var desc = (document.getElementById('item-input-desc') || {}).value || '';
                    var qty = (document.getElementById('item-input-qty') || {}).value || '';
                    var weight = (document.getElementById('item-input-weight') || {}).value || '';
                    var unit = (document.getElementById('ddMcItemUnitHidden') || {}).value || 'ct';
                    var cost = (document.getElementById('item-input-cost') || {}).value || '';
                    var errEl = document.getElementById('item-add-error');

                    if (!sku.trim() && !desc.trim()) {
                        if (errEl) errEl.classList.remove('hidden');
                        return;
                    }
                    if (errEl) errEl.classList.add('hidden');

                    itemsList.push({ key: itemIndex++, sku: sku.trim(), product_id: productId, desc: desc.trim(), qty: qty, weight: weight, unit: unit, cost: cost });

                    // Clear input fields
                    ['item-input-sku', 'item-input-desc', 'item-input-qty', 'item-input-weight', 'item-input-cost', 'item-input-product-id'].forEach(function (id) {
                        var el = document.getElementById(id);
                        if (el) el.value = '';
                    });
                    // Also reset the Select2 visual dropdown
                    if (window.jQuery && $('#item-select-product').length) {
                        $('#item-select-product').val(null).trigger('change');
                    }

                    renderItems();
                });
            }

            // ── Enter key in item inputs triggers Add ────────────────────────
            ['item-input-desc', 'item-input-qty', 'item-input-weight', 'item-input-cost'].forEach(function (id) {
                var el = document.getElementById(id);
                if (el) {
                    el.addEventListener('keydown', function (e) {
                        if (e.key === 'Enter') { e.preventDefault(); document.getElementById('btn-add-item').click(); }
                    });
                }
            });

            // ── Clear all items ──────────────────────────────────────────────
            var btnClear = document.getElementById('btn-clear-items');
            if (btnClear) {
                btnClear.addEventListener('click', function () {
                    if (itemsList.length === 0) return;
                    if (!confirm('Remove all ' + itemsList.length + ' item(s)?')) return;
                    itemsList = [];
                    renderItems();
                });
            }

            // ── Also reset items on modal reset ──────────────────────────────
            var origResetModal = window._resetModal || function () { };
            window._resetItemsList = function () {
                itemsList = [];
                itemIndex = 0;
                renderItems();
                ['item-input-sku', 'item-input-product-id', 'item-input-desc', 'item-input-qty', 'item-input-weight', 'item-input-cost'].forEach(function (id) {
                    var el = document.getElementById(id);
                    if (el) el.value = '';
                });
                // Reset Select2 visual state
                if (window.jQuery && $('#item-select-product').length) {
                    $('#item-select-product').val(null).trigger('change');
                }
                var errEl = document.getElementById('item-add-error');
                if (errEl) errEl.classList.add('hidden');
            };

            // Hook into existing closeModal to also reset items
            var origClose = document.getElementById('create-close');
            var origCancel = document.getElementById('create-cancel');
            [origClose, origCancel].forEach(function (btn) {
                if (btn) {
                    btn.addEventListener('click', function () { window._resetItemsList(); });
                }
            });

            // Initial render (shows empty state)
            renderItems();

            // ══════════════════════════════════════════════════════════════════
            // MEDIA UPLOAD — photos & documents queue (pre-submit)
            // ══════════════════════════════════════════════════════════════════
            var mediaQueued = { photos: [], documents: [] };
            var mediaUidCounter = 0;

            function humanSize(bytes) {
                if (bytes < 1024) return bytes + ' B';
                if (bytes < 1048576) return (bytes / 1024).toFixed(1) + ' KB';
                return (bytes / 1048576).toFixed(2) + ' MB';
            }

            function renderMediaTable(type) {
                var list = type === 'photo' ? mediaQueued.photos : mediaQueued.documents;
                var tbodyId = type === 'photo' ? 'photo-preview-tbody' : 'doc-preview-tbody';
                var wrapId = type === 'photo' ? 'photo-preview-list' : 'doc-preview-list';
                var tbody = document.getElementById(tbodyId);
                var wrap = document.getElementById(wrapId);
                if (!tbody || !wrap) return;

                if (list.length === 0) {
                    wrap.classList.add('hidden');
                    return;
                }
                wrap.classList.remove('hidden');

                tbody.innerHTML = list.map(function (item) {
                    return '<tr>' +
                        '<td class="px-3 py-2 text-slate-700 truncate max-w-[200px]" title="' + item.name + '">' + item.name + '</td>' +
                        '<td class="px-3 py-2 text-slate-500">' + humanSize(item.file.size) + '</td>' +
                        '<td class="px-3 py-2" id="media-status-' + item.uid + '"><span class="text-slate-400">Queued</span></td>' +
                        '<td class="px-3 py-2 text-center">' +
                        '<button type="button" data-uid="' + item.uid + '" data-mtype="' + type + '"' +
                        ' class="media-remove-btn text-slate-300 hover:text-red-500 transition-colors">' +
                        '<svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>' +
                        '</button></td>' +
                        '</tr>';
                }).join('');

                // Bind remove buttons
                tbody.querySelectorAll('.media-remove-btn').forEach(function (btn) {
                    btn.addEventListener('click', function () {
                        var uid = parseInt(this.dataset.uid);
                        var mtype = this.dataset.mtype;
                        if (mtype === 'photo') {
                            mediaQueued.photos = mediaQueued.photos.filter(function (i) { return i.uid !== uid; });
                        } else {
                            mediaQueued.documents = mediaQueued.documents.filter(function (i) { return i.uid !== uid; });
                        }
                        renderMediaTable(mtype);
                    });
                });
            }

            function enqueueFiles(files, type) {
                Array.from(files).forEach(function (file) {
                    var item = { uid: mediaUidCounter++, name: file.name, file: file, type: type };
                    if (type === 'photo') {
                        mediaQueued.photos.push(item);
                    } else {
                        mediaQueued.documents.push(item);
                    }
                });
                renderMediaTable(type);
            }

            // ── Bind photo drop area ────────────────────────────────────────
            (function () {
                var dropArea = document.getElementById('photo-drop-area');
                var fileInput = document.getElementById('photo-file-input');
                if (!dropArea || !fileInput) return;

                dropArea.addEventListener('click', function () { fileInput.click(); });
                fileInput.addEventListener('change', function () {
                    if (this.files.length) enqueueFiles(this.files, 'photo');
                    this.value = '';
                });
                dropArea.addEventListener('dragover', function (e) {
                    e.preventDefault();
                    this.classList.add('border-blue-500', 'bg-blue-50');
                });
                dropArea.addEventListener('dragleave', function () {
                    this.classList.remove('border-blue-500', 'bg-blue-50');
                });
                dropArea.addEventListener('drop', function (e) {
                    e.preventDefault();
                    this.classList.remove('border-blue-500', 'bg-blue-50');
                    if (e.dataTransfer.files.length) enqueueFiles(e.dataTransfer.files, 'photo');
                });
            })();

            // ── Bind document drop area ─────────────────────────────────────
            (function () {
                var dropArea = document.getElementById('doc-drop-area');
                var fileInput = document.getElementById('doc-file-input');
                if (!dropArea || !fileInput) return;

                dropArea.addEventListener('click', function () { fileInput.click(); });
                fileInput.addEventListener('change', function () {
                    if (this.files.length) enqueueFiles(this.files, 'document');
                    this.value = '';
                });
                dropArea.addEventListener('dragover', function (e) {
                    e.preventDefault();
                    this.classList.add('border-blue-500', 'bg-blue-50');
                });
                dropArea.addEventListener('dragleave', function () {
                    this.classList.remove('border-blue-500', 'bg-blue-50');
                });
                dropArea.addEventListener('drop', function (e) {
                    e.preventDefault();
                    this.classList.remove('border-blue-500', 'bg-blue-50');
                    if (e.dataTransfer.files.length) enqueueFiles(e.dataTransfer.files, 'document');
                });
            })();

            // ── Reset media queues when modal closes ────────────────────────
            window._resetMediaQueues = function () {
                mediaQueued.photos = [];
                mediaQueued.documents = [];
                renderMediaTable('photo');
                renderMediaTable('document');
            };

            // ── Also expose for resetModal ─────────────────────────────────
            var origCloseMedia = document.getElementById('create-close');
            var origCancelMedia = document.getElementById('create-cancel');
            [origCloseMedia, origCancelMedia].forEach(function (btn) {
                if (btn) {
                    btn.addEventListener('click', function () {
                        window._resetMediaQueues();
                    });
                }
            });

            // ══════════════════════════════════════════════════════════════════
            // VIEW MODAL (DETAILS, ITEMS, MEDIA)
            // ══════════════════════════════════════════════════════════════════
            var viewModal = document.getElementById('view-modal');

            window.openViewModal = function (id) {
                if (!viewModal) return;
                viewModal.classList.remove('hidden');
                viewModal.classList.add('flex');
                document.body.style.overflow = 'hidden';

                // Show loader
                document.getElementById('view-modal-loader').classList.remove('hidden');

                // Default tab is details
                activateViewTab('view-tab-details');

                // Fetch details via AJAX
                var url = '{{ route("production.show", ["id" => ":id"]) }}'.replace(':id', id);
                fetch(url, {
                    headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
                })
                    .then(function (r) { return r.json(); })
                    .then(function (res) {
                        // Hide loader
                        document.getElementById('view-modal-loader').classList.add('hidden');

                        if (!res.success) {
                            alert('Failed to load sheet details.');
                            closeViewModal();
                            return;
                        }

                        var s = res.sheet;

                        // Header data
                        document.getElementById('view-title-sheet-number').textContent = s.sheet_number;
                        document.getElementById('view-creator-name').textContent = s.creator;
                        document.getElementById('view-creation-date').textContent = s.creation_date;
                        document.getElementById('view-supplier').textContent = s.supplier;

                        // Badges
                        var typeBadge = document.getElementById('view-badge-type');
                        typeBadge.textContent = s.production_type;

                        var statusBadge = document.getElementById('view-badge-status');
                        statusBadge.textContent = s.status === 'in_production' ? 'In production' : s.status.charAt(0).toUpperCase() + s.status.slice(1);
                        statusBadge.className = 'text-[12px] font-semibold px-2.5 py-0.5 rounded-full ' + (
                            s.status === 'draft' ? 'bg-amber-100 text-amber-800' :
                                s.status === 'in_production' ? 'bg-blue-100 text-blue-800' :
                                    s.status === 'completed' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'
                        );

                        // Tab 1: Details
                        document.getElementById('view-reference').textContent = s.reference;
                        document.getElementById('view-due-date').textContent = s.due_date;
                        document.getElementById('view-closed-date').textContent = s.closed_date;
                        document.getElementById('view-orig-qty').textContent = s.original_quantity;
                        document.getElementById('view-orig-weight').textContent = s.original_weight;
                        document.getElementById('view-orig-cost').textContent = s.original_total_cost;

                        var discEl = document.getElementById('view-discrepancy-reason');
                        discEl.textContent = s.discrepancy_reason !== '—' ? s.discrepancy_reason.replace('_', ' ').charAt(0).toUpperCase() + s.discrepancy_reason.replace('_', ' ').slice(1) : '—';

                        document.getElementById('view-notes').textContent = s.notes || '—';

                        // Tab 2: Items
                        var itemsTbody = document.getElementById('view-items-tbody');
                        if (s.items && s.items.length > 0) {
                            itemsTbody.innerHTML = s.items.map(function (item, idx) {
                                return '<tr>' +
                                    '<td class="px-4 py-3 text-slate-400 font-medium">' + (idx + 1) + '</td>' +
                                    '<td class="px-4 py-3 text-slate-800 font-semibold">' + item.sku + '</td>' +
                                    '<td class="px-4 py-3 text-slate-600">' + item.description + '</td>' +
                                    '<td class="px-4 py-3 text-right font-medium">' + item.quantity + '</td>' +
                                    '<td class="px-4 py-3 text-right font-medium">' + item.weight + '</td>' +
                                    '<td class="px-4 py-3 text-right font-medium">' + item.cost + '</td>' +
                                    '</tr>';
                            }).join('');
                        } else {
                            itemsTbody.innerHTML = '<tr><td colspan="6" class="px-4 py-10 text-center text-slate-400">No items added to this sheet.</td></tr>';
                        }

                        // Tab 3: Media
                        // Photos Grid
                        var photosCont = document.getElementById('view-photos-container');
                        if (s.photos && s.photos.length > 0) {
                            photosCont.innerHTML = s.photos.map(function (photo) {
                                return '<a href="' + photo.url + '" target="_blank" class="group block relative border border-slate-200 rounded-md overflow-hidden hover:shadow-md transition-shadow bg-slate-50">' +
                                    '<div class="aspect-square w-full overflow-hidden">' +
                                    '<img src="' + photo.url + '" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-200">' +
                                    '</div>' +
                                    '<div class="p-2 bg-white border-t border-slate-100 text-[11px] text-slate-600 truncate" title="' + photo.original_name + '">' +
                                    photo.original_name +
                                    '</div>' +
                                    '</a>';
                            }).join('');
                        } else {
                            photosCont.innerHTML = '<p class="text-slate-400 text-sm col-span-3">No photos uploaded.</p>';
                        }

                        // Documents List
                        var docsCont = document.getElementById('view-docs-container');
                        if (s.documents && s.documents.length > 0) {
                            docsCont.innerHTML = s.documents.map(function (doc) {
                                return '<a href="' + doc.url + '" target="_blank" class="flex items-center justify-between p-3 border border-slate-200 rounded-md hover:bg-slate-50 transition-colors shadow-xs">' +
                                    '<div class="flex items-center gap-3 overflow-hidden">' +
                                    '<svg class="w-5 h-5 text-blue-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>' +
                                    '<span class="text-xs font-semibold text-slate-700 truncate" title="' + doc.original_name + '">' + doc.original_name + '</span>' +
                                    '</div>' +
                                    '<span class="text-[11px] font-medium text-slate-400 flex-shrink-0 bg-slate-100 rounded px-1.5 py-0.5">' + doc.file_size + '</span>' +
                                    '</a>';
                            }).join('');
                        } else {
                            docsCont.innerHTML = '<p class="text-slate-400 text-sm">No documents uploaded.</p>';
                        }
                    })
                    .catch(function () {
                        document.getElementById('view-modal-loader').classList.add('hidden');
                        alert('Network error. Failed to retrieve details.');
                        closeViewModal();
                    });
            };

            function closeViewModal() {
                if (!viewModal) return;
                viewModal.classList.add('hidden');
                viewModal.classList.remove('flex');
                document.body.style.overflow = '';
            }

            document.getElementById('view-close').addEventListener('click', closeViewModal);
            document.getElementById('view-close-btn').addEventListener('click', closeViewModal);
            viewModal.addEventListener('click', function (e) { if (e.target === viewModal) closeViewModal(); });

            // Tab switching
            function activateViewTab(targetId) {
                document.querySelectorAll('.view-tab-btn').forEach(function (b) {
                    b.classList.remove('active', 'border-blue-600', 'text-blue-600');
                    b.classList.add('text-slate-500', 'border-transparent');
                });
                document.querySelectorAll('.view-tab-content').forEach(function (c) {
                    c.classList.add('hidden');
                    c.classList.remove('block');
                });
                var target = document.getElementById(targetId);
                if (target) { target.classList.remove('hidden'); target.classList.add('block'); }
                var btn = document.querySelector('.view-tab-btn[data-target="' + targetId + '"]');
                if (btn) {
                    btn.classList.add('active', 'border-blue-600', 'text-blue-600');
                    btn.classList.remove('text-slate-500', 'border-transparent');
                }
            }

            document.querySelectorAll('.view-tab-btn').forEach(function (btn) {
                btn.addEventListener('click', function () { activateViewTab(btn.dataset.target); });
            });

            // ══════════════════════════════════════════════════════════════════
            // COSTS TAB — Auto-calculate totals, loss % and loss weight
            // ══════════════════════════════════════════════════════════════════
            (function () {
                var costUnit = document.getElementById('mc-cost-unit');
                var costTotal = document.getElementById('mc-cost-total');
                var myCostUnit = document.getElementById('mc-my-cost-unit');
                var myCostTotal = document.getElementById('mc-my-cost-total');
                var origWtInp = document.querySelector('[name="original_weight"]');
                var outWtInp = document.querySelector('[name="expected_output_weight"]');
                var origQtyInp = document.querySelector('[name="original_quantity"]');
                var outQtyInp = document.querySelector('[name="expected_output_quantity"]');
                var lossPctEl = document.getElementById('mc-loss-pct');
                var lossWtEl = document.getElementById('mc-loss-wt');

                function recalcCosts() {
                    // Qty-based total cost
                    var cpuVal = parseFloat((costUnit && costUnit.value) || 0);
                    var qty = parseFloat((origQtyInp && origQtyInp.value) || 0);
                    if (costTotal) {
                        costTotal.value = (cpuVal && qty) ? (cpuVal * qty).toFixed(2) : '';
                    }

                    // My total cost
                    var mcpuVal = parseFloat((myCostUnit && myCostUnit.value) || 0);
                    if (myCostTotal) {
                        myCostTotal.value = (mcpuVal && qty) ? (mcpuVal * qty).toFixed(2) : '';
                    }

                    // Loss % and loss weight (weight-based)
                    var inWt = parseFloat((origWtInp && origWtInp.value) || 0);
                    var outWt = parseFloat((outWtInp && outWtInp.value) || 0);
                    if (lossPctEl) {
                        if (inWt > 0 && outWt >= 0 && outWt <= inWt) {
                            lossPctEl.value = (((inWt - outWt) / inWt) * 100).toFixed(2) + ' %';
                        } else {
                            lossPctEl.value = '';
                        }
                    }
                    if (lossWtEl) {
                        if (inWt > 0 && outWt >= 0 && outWt <= inWt) {
                            lossWtEl.value = (inWt - outWt).toFixed(4);
                        } else {
                            lossWtEl.value = '';
                        }
                    }
                }

                // Bind to all relevant inputs
                [costUnit, myCostUnit, origWtInp, outWtInp, origQtyInp, outQtyInp].forEach(function (el) {
                    if (el) el.addEventListener('input', recalcCosts);
                });
            })();

            // ══════════════════════════════════════════════════════════════════
            // FORM VALIDATION — inline highlight required fields
            // ══════════════════════════════════════════════════════════════════
            function highlightRequired(elementId, valid) {
                var el = document.getElementById(elementId);
                if (!el) return;
                if (valid) {
                    el.classList.remove('ring-2', 'ring-red-400');
                } else {
                    el.classList.add('ring-2', 'ring-red-400');
                    setTimeout(function () { el.classList.remove('ring-2', 'ring-red-400'); }, 3000);
                }
            }

        });

        // ── Global Toast Helper ───────────────────────────────────────────────
        // Usage: showToast('Message', 'success' | 'error' | 'info')
        function showToast(message, type) {
            var existing = document.getElementById('prod-toast');
            if (existing) existing.remove();

            var colors = {
                success: 'bg-green-600',
                error: 'bg-red-600',
                info: 'bg-blue-600',
            };
            var color = colors[type] || colors.info;

            var toast = document.createElement('div');
            toast.id = 'prod-toast';
            toast.className = 'fixed bottom-6 right-6 z-[99999] flex items-center gap-3 px-5 py-3.5 rounded-lg shadow-2xl text-white text-[14px] font-semibold transition-all duration-300 opacity-0 translate-y-4 ' + color;
            toast.innerHTML =
                '<svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">' +
                '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>' +
                '</svg>' +
                '<span>' + message + '</span>';

            document.body.appendChild(toast);

            // Animate in
            requestAnimationFrame(function () {
                requestAnimationFrame(function () {
                    toast.classList.remove('opacity-0', 'translate-y-4');
                    toast.classList.add('opacity-100', 'translate-y-0');
                });
            });

            // Auto-dismiss after 3.5s
            setTimeout(function () {
                toast.classList.add('opacity-0', 'translate-y-4');
                setTimeout(function () { toast.remove(); }, 350);
            }, 3500);
        }
    </script>
@endsection