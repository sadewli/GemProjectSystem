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
                                    <input id="search-creator" type="text" placeholder="Search..."
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
                        <p class="text-xs text-slate-500">items: <span class="font-semibold text-slate-700">{{ $counts['all'] ?? '0' }}</span></p>
                        <p class="text-xs text-blue-600 font-semibold mt-0.5">VEF: {{ $totals['all'] ?? '0.00 VEF' }}</p>
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
                        <p class="text-xs text-slate-500">items: <span class="font-semibold text-slate-700">{{ $counts['in_production'] ?? '0' }}</span></p>
                        <p class="text-xs text-amber-600 font-semibold mt-0.5">VEF: {{ $totals['in_production'] ?? '0.00 VEF' }}</p>
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
                        <p class="text-xs text-slate-500">items: <span class="font-semibold text-slate-700">{{ $counts['completed'] ?? '0' }}</span></p>
                        <p class="text-xs text-green-600 font-semibold mt-0.5">VEF: {{ $totals['completed'] ?? '0.00 VEF' }}</p>
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
                        <p class="text-xs text-slate-500">items: <span class="font-semibold text-slate-700">{{ $counts['deleted'] ?? '0' }}</span></p>
                        <p class="text-xs text-red-500 font-semibold mt-0.5">VEF: {{ $totals['deleted'] ?? '0.00 VEF' }}</p>
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

    {{-- ===== CREATE PRODUCTION SHEET MODAL ===== --}}
    <div id="create-modal" class="fixed inset-0 z-50 hidden items-center justify-center p-4 sm:p-6" style="background:rgba(0,0,0,0.5); z-index: 9999;">
        <div class="bg-white rounded-md shadow-2xl w-full max-w-5xl flex flex-col relative overflow-hidden" style="height:95vh;">

            {{-- Header --}}
            <div class="px-6 py-4 flex-shrink-0 bg-[#f8fafc] rounded-t-md border-b border-slate-200">
                <div class="flex justify-between items-start">
                    <button type="button" id="create-close" class="text-slate-500 hover:text-slate-700 transition-colors p-1 -ml-1">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                    <div class="flex items-center gap-2">
                        <span class="bg-amber-100 text-amber-800 text-[12px] font-semibold px-2.5 py-0.5 rounded-full">Draft</span>
                        <span id="mc-badge-type" class="bg-blue-100 text-blue-800 text-[12px] font-semibold px-2.5 py-0.5 rounded-full hidden"></span>
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
                <button type="button" class="mc-tab-btn active py-3.5 font-semibold text-[14px] flex-1 text-center" data-target="mc-tab-details">Details</button>
                <button type="button" class="mc-tab-btn py-3.5 font-semibold text-[14px] flex-1 text-center text-slate-500" data-target="mc-tab-items">Items</button>
                <button type="button" class="mc-tab-btn py-3.5 font-semibold text-[14px] flex-1 text-center text-slate-500" data-target="mc-tab-costs">Costs</button>
                <button type="button" class="mc-tab-btn py-3.5 font-semibold text-[14px] flex-1 text-center text-slate-500" data-target="mc-tab-history">History</button>
            </div>

            {{-- Scrollable Body --}}
            <div class="flex-1 overflow-y-auto custom-scrollbar bg-white relative">
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

                        <div class="w-[120px] h-[90px] bg-[#f1f5f9] rounded-md flex flex-col items-center justify-center cursor-pointer hover:bg-slate-200 transition-colors mb-6 border border-transparent hover:border-blue-200">
                            <svg class="w-8 h-8 text-blue-600 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812-1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            <span class="text-blue-600 text-[12px] font-medium">Upload</span>
                        </div>

                        <div class="text-[13px] font-bold text-slate-800 uppercase tracking-wide border-b border-slate-100 pb-2 mb-4">Production attributes</div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-x-6 gap-y-5">

                            {{-- Production Type --}}
                            <div>
                                <label class="block text-[13px] text-slate-700 mb-1.5">Production type <span class="text-rose-500">*</span></label>
                                <div class="relative searchable-dropdown" id="ddMcTypeWrapper">
                                    <input type="hidden" name="production_type" id="ddMcTypeHidden">
                                    <button type="button" id="ddMcTypeBtn" class="form-control flex items-center pl-3 pr-8 text-left">
                                        <span id="ddMcTypeLabel" class="truncate text-slate-400">Select type</span>
                                    </button>
                                    <div class="absolute inset-y-0 right-3 flex items-center pointer-events-none">
                                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                                    </div>
                                    <div id="ddMcTypePanel" class="hidden absolute left-0 z-50 mt-1 w-full bg-white border border-slate-200 rounded-md shadow-lg overflow-hidden" style="top:100%;">
                                        <div class="p-2 border-b border-slate-100">
                                            <input type="text" id="ddMcTypeSearch" placeholder="Search..." class="form-control !h-9 px-3">
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
                                <label class="block text-[13px] text-slate-700 mb-1.5">Production category <span class="text-rose-500">*</span></label>
                                <div class="relative searchable-dropdown" id="ddMcCatWrapper">
                                    <input type="hidden" name="production_category" id="ddMcCatHidden">
                                    <button type="button" id="ddMcCatBtn" class="form-control flex items-center pl-3 pr-8 text-left">
                                        <span id="ddMcCatLabel" class="truncate text-slate-400">Select category</span>
                                    </button>
                                    <div class="absolute inset-y-0 right-3 flex items-center pointer-events-none">
                                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                                    </div>
                                    <div id="ddMcCatPanel" class="hidden absolute left-0 z-50 mt-1 w-full bg-white border border-slate-200 rounded-md shadow-lg overflow-hidden" style="top:100%;">
                                        <div class="p-2 border-b border-slate-100">
                                            <input type="text" id="ddMcCatSearch" placeholder="Search..." class="form-control !h-9 px-3">
                                        </div>
                                        <ul class="py-1 max-h-48 overflow-y-auto custom-scrollbar">
                                            <li class="dd-option flex items-center px-4 py-2.5 text-[14px] cursor-pointer hover:bg-slate-50 text-slate-600" data-value="" data-label="Select category">Select category</li>
                                            <li class="dd-option flex items-center px-4 py-2.5 text-[14px] cursor-pointer hover:bg-slate-50 text-slate-600" data-value="gemstones" data-label="Gemstones">Gemstones</li>
                                            <li class="dd-option flex items-center px-4 py-2.5 text-[14px] cursor-pointer hover:bg-slate-50 text-slate-600" data-value="rough" data-label="Rough &amp; Specimen">Rough &amp; Specimen</li>
                                            <li class="dd-option flex items-center px-4 py-2.5 text-[14px] cursor-pointer hover:bg-slate-50 text-slate-600" data-value="diamond" data-label="Diamond">Diamond</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            {{-- Template --}}
                            <div>
                                <label class="block text-[13px] text-slate-700 mb-1.5">Template</label>
                                <div class="relative searchable-dropdown" id="ddMcTplWrapper">
                                    <input type="hidden" name="template" id="ddMcTplHidden" value="default">
                                    <button type="button" id="ddMcTplBtn" class="form-control flex items-center pl-3 pr-8 text-left">
                                        <span id="ddMcTplLabel" class="truncate text-slate-800">Default</span>
                                    </button>
                                    <div class="absolute inset-y-0 right-3 flex items-center pointer-events-none">
                                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                                    </div>
                                    <div id="ddMcTplPanel" class="hidden absolute left-0 z-50 mt-1 w-full bg-white border border-slate-200 rounded-md shadow-lg overflow-hidden" style="top:100%;">
                                        <ul class="py-1 max-h-48 overflow-y-auto custom-scrollbar">
                                            <li class="dd-option flex items-center px-4 py-2.5 text-[14px] cursor-pointer bg-slate-100 text-slate-800 font-semibold" data-value="default" data-label="Default">Default</li>
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

                            {{-- Creator --}}
                            <div>
                                <label class="block text-[13px] text-slate-700 mb-1.5">Creator</label>
                                <div class="relative searchable-dropdown" id="ddMcCreatorWrapper">
                                    <input type="hidden" name="creator_id" id="ddMcCreatorHidden">
                                    <button type="button" id="ddMcCreatorBtn" class="form-control flex items-center pl-3 pr-8 text-left">
                                        <span id="ddMcCreatorLabel" class="truncate text-slate-400">Select creator</span>
                                    </button>
                                    <div class="absolute inset-y-0 right-3 flex items-center pointer-events-none">
                                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                                    </div>
                                    <div id="ddMcCreatorPanel" class="hidden absolute left-0 z-50 mt-1 w-full bg-white border border-slate-200 rounded-md shadow-lg overflow-hidden" style="top:100%;">
                                        <div class="p-2 border-b border-slate-100">
                                            <input type="text" id="ddMcCreatorSearch" placeholder="Search..." class="form-control !h-9 px-3">
                                        </div>
                                        <ul class="py-1 max-h-48 overflow-y-auto custom-scrollbar">
                                            @foreach($creators as $c)
                                                <li class="dd-option flex items-center px-4 py-2.5 text-[14px] cursor-pointer hover:bg-slate-50 text-slate-600"
                                                    data-value="{{ $c['value'] ?? $c['label'] }}"
                                                    data-label="{{ $c['label'] }}">{{ $c['label'] }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            {{-- Original Quantity --}}
                            <div>
                                <label class="block text-[13px] text-slate-700 mb-1.5">Original quantity</label>
                                <input type="number" name="original_quantity" placeholder="e.g. 10" class="form-control px-3">
                            </div>

                            {{-- Original Weight --}}
                            <div>
                                <label class="block text-[13px] text-slate-700 mb-1.5">Original weight</label>
                                <div class="flex gap-2">
                                    <input type="text" name="original_weight" placeholder='e.g. "5.20"' class="form-control flex-1 px-3">
                                    <div class="relative w-[85px] searchable-dropdown" id="ddMcWeightUnitWrapper">
                                        <input type="hidden" name="weight_unit" id="ddMcWeightUnitHidden" value="ct">
                                        <button type="button" id="ddMcWeightUnitBtn" class="form-control flex items-center pl-3 pr-7 text-left">
                                            <span id="ddMcWeightUnitLabel" class="truncate text-slate-800">ct</span>
                                        </button>
                                        <div class="absolute inset-y-0 right-2.5 flex items-center pointer-events-none">
                                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                                        </div>
                                        <div id="ddMcWeightUnitPanel" class="hidden absolute left-0 z-50 mt-1 w-full bg-white border border-slate-200 rounded-md shadow-lg overflow-hidden" style="top:100%;">
                                            <ul class="py-1 max-h-48 overflow-y-auto custom-scrollbar">
                                                <li class="dd-option flex items-center px-4 py-2.5 text-[14px] cursor-pointer bg-slate-100 text-slate-800 font-semibold" data-value="ct" data-label="ct">ct</li>
                                                <li class="dd-option flex items-center px-4 py-2.5 text-[14px] cursor-pointer hover:bg-slate-50 text-slate-600" data-value="g" data-label="g">g</li>
                                                <li class="dd-option flex items-center px-4 py-2.5 text-[14px] cursor-pointer hover:bg-slate-50 text-slate-600" data-value="kg" data-label="kg">kg</li>
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
                                        <input type="hidden" name="currency" id="ddMcCurrencyHidden" value="VEF">
                                        <button type="button" id="ddMcCurrencyBtn" class="form-control flex items-center pl-3 pr-7 text-left">
                                            <span id="ddMcCurrencyLabel" class="truncate text-slate-800">VEF</span>
                                        </button>
                                        <div class="absolute inset-y-0 right-2.5 flex items-center pointer-events-none">
                                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                                        </div>
                                        <div id="ddMcCurrencyPanel" class="hidden absolute left-0 z-50 mt-1 w-full bg-white border border-slate-200 rounded-md shadow-lg overflow-hidden" style="top:100%;">
                                            <ul class="py-1 max-h-48 overflow-y-auto custom-scrollbar">
                                                <li class="dd-option flex items-center px-4 py-2.5 text-[14px] cursor-pointer bg-slate-100 text-slate-800 font-semibold" data-value="VEF" data-label="VEF">VEF</li>
                                                <li class="dd-option flex items-center px-4 py-2.5 text-[14px] cursor-pointer hover:bg-slate-50 text-slate-600" data-value="USD" data-label="USD">USD</li>
                                                <li class="dd-option flex items-center px-4 py-2.5 text-[14px] cursor-pointer hover:bg-slate-50 text-slate-600" data-value="EUR" data-label="EUR">EUR</li>
                                            </ul>
                                        </div>
                                    </div>
                                    <input type="text" name="original_total_cost" placeholder="0.00" class="form-control flex-1 px-3">
                                </div>
                            </div>

                        </div>

                        <div class="text-[13px] font-bold text-slate-800 uppercase tracking-wide border-b border-slate-100 pb-2 mb-4 mt-6">Discrepancy</div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-5">
                            <div>
                                <label class="block text-[13px] text-slate-700 mb-1.5">Discrepancy reason</label>
                                <div class="relative searchable-dropdown" id="ddMcDiscWrapper">
                                    <input type="hidden" name="discrepancy_reason" id="ddMcDiscHidden">
                                    <button type="button" id="ddMcDiscBtn" class="form-control flex items-center pl-3 pr-8 text-left">
                                        <span id="ddMcDiscLabel" class="truncate text-slate-400">Select reason</span>
                                    </button>
                                    <div class="absolute inset-y-0 right-3 flex items-center pointer-events-none">
                                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                                    </div>
                                    <div id="ddMcDiscPanel" class="hidden absolute left-0 z-50 mt-1 w-full bg-white border border-slate-200 rounded-md shadow-lg overflow-hidden" style="top:100%;">
                                        <ul class="py-1 max-h-48 overflow-y-auto custom-scrollbar">
                                            <li class="dd-option flex items-center px-4 py-2.5 text-[14px] cursor-pointer hover:bg-slate-50 text-slate-600" data-value="" data-label="Select reason">Select reason</li>
                                            <li class="dd-option flex items-center px-4 py-2.5 text-[14px] cursor-pointer hover:bg-slate-50 text-slate-600" data-value="natural_loss" data-label="Natural loss">Natural loss</li>
                                            <li class="dd-option flex items-center px-4 py-2.5 text-[14px] cursor-pointer hover:bg-slate-50 text-slate-600" data-value="cutting_loss" data-label="Cutting loss">Cutting loss</li>
                                            <li class="dd-option flex items-center px-4 py-2.5 text-[14px] cursor-pointer hover:bg-slate-50 text-slate-600" data-value="breakage" data-label="Breakage">Breakage</li>
                                            <li class="dd-option flex items-center px-4 py-2.5 text-[14px] cursor-pointer hover:bg-slate-50 text-slate-600" data-value="other" data-label="Other">Other</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <label class="block text-[13px] text-slate-700 mb-1.5">Notes</label>
                                <input type="text" name="notes" placeholder="Optional notes..." class="form-control px-3">
                            </div>
                        </div>

                        <div class="text-[13px] font-bold text-slate-800 uppercase tracking-wide border-b border-slate-100 pb-2 mb-4 mt-6">Documents</div>
                        <div class="w-[180px] h-[90px] bg-white border border-slate-200 rounded-md flex flex-col items-center justify-center cursor-pointer hover:bg-slate-50 transition-colors shadow-sm">
                            <svg class="w-6 h-6 text-blue-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            <span class="text-slate-800 text-[13px] font-medium">Add document(s)</span>
                        </div>

                    </div>

                    {{-- ===== TAB 2: ITEMS ===== --}}
                    <div id="mc-tab-items" class="mc-tab-content hidden px-6 py-6 pb-20">

                        <div class="text-[13px] font-bold text-slate-800 uppercase tracking-wide border-b border-slate-100 pb-2 mb-4">Production items</div>
                        <p class="text-[13px] text-slate-400 mb-4">Add the items to be processed in this production sheet.</p>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-x-6 gap-y-5 mb-4">
                            <div>
                                <label class="block text-[13px] text-slate-700 mb-1.5">Item / SKU</label>
                                <input type="text" class="form-control px-3" placeholder="Search SKU...">
                            </div>
                            <div>
                                <label class="block text-[13px] text-slate-700 mb-1.5">Quantity</label>
                                <input type="number" class="form-control px-3" placeholder="0">
                            </div>
                            <div>
                                <label class="block text-[13px] text-slate-700 mb-1.5">Weight</label>
                                <div class="flex gap-2">
                                    <input type="text" class="form-control flex-1 px-3" placeholder="0.00">
                                    <div class="relative w-[85px] searchable-dropdown" id="ddMcItemUnitWrapper">
                                        <input type="hidden" name="item_weight_unit" id="ddMcItemUnitHidden" value="ct">
                                        <button type="button" id="ddMcItemUnitBtn" class="form-control flex items-center pl-3 pr-7 text-left">
                                            <span id="ddMcItemUnitLabel" class="truncate text-slate-800">ct</span>
                                        </button>
                                        <div class="absolute inset-y-0 right-2.5 flex items-center pointer-events-none">
                                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                                        </div>
                                        <div id="ddMcItemUnitPanel" class="hidden absolute left-0 z-50 mt-1 w-full bg-white border border-slate-200 rounded-md shadow-lg overflow-hidden" style="top:100%;">
                                            <ul class="py-1 max-h-48 overflow-y-auto custom-scrollbar">
                                                <li class="dd-option flex items-center px-4 py-2.5 text-[14px] cursor-pointer bg-slate-100 text-slate-800 font-semibold" data-value="ct" data-label="ct">ct</li>
                                                <li class="dd-option flex items-center px-4 py-2.5 text-[14px] cursor-pointer hover:bg-slate-50 text-slate-600" data-value="g" data-label="g">g</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <button type="button" class="px-4 py-2 bg-[#f1f5f9] border border-slate-200 rounded-md text-[13px] font-medium text-slate-700 hover:bg-slate-200 mb-5">+ Add item</button>

                        <div class="border border-slate-200 rounded-md overflow-hidden">
                            <table class="w-full text-left text-[13px]">
                                <thead class="bg-[#f8fafc] text-slate-700 font-semibold border-b border-slate-200">
                                    <tr>
                                        <th class="px-4 py-3">SKU</th>
                                        <th class="px-4 py-3">Description</th>
                                        <th class="px-4 py-3">Qty</th>
                                        <th class="px-4 py-3">Weight</th>
                                        <th class="px-4 py-3">Cost</th>
                                        <th class="px-4 py-3"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr><td colspan="6" class="px-4 py-10 text-center text-slate-400 text-[13px]">No items added yet</td></tr>
                                </tbody>
                            </table>
                        </div>

                    </div>

                    {{-- ===== TAB 3: COSTS ===== --}}
                    <div id="mc-tab-costs" class="mc-tab-content hidden px-6 py-6 pb-20">

                        <div class="text-[13px] font-bold text-slate-800 uppercase tracking-wide border-b border-slate-100 pb-2 mb-4">Costing module</div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-5 mb-3">
                            <div>
                                <label class="block text-[13px] text-slate-700 mb-1.5">Cost / unit</label>
                                <input type="text" name="cost_per_unit" id="mc-cost-unit" placeholder="Cost per unit" class="form-control px-3">
                            </div>
                            <div>
                                <label class="block text-[13px] text-slate-700 mb-1.5">Total cost</label>
                                <input type="text" name="total_cost" id="mc-cost-total" placeholder="Total cost" class="form-control px-3 bg-slate-50" readonly>
                            </div>
                            <div>
                                <label class="block text-[13px] text-slate-700 mb-1.5">My cost / unit</label>
                                <input type="text" name="my_cost_per_unit" id="mc-my-cost-unit" placeholder="My cost per unit" class="form-control px-3">
                            </div>
                            <div>
                                <label class="block text-[13px] text-slate-700 mb-1.5">My total cost</label>
                                <input type="text" name="my_total_cost" id="mc-my-cost-total" placeholder="My total cost" class="form-control px-3 bg-slate-50" readonly>
                            </div>
                        </div>

                        <div class="flex justify-end mb-6">
                            <button type="button" class="px-4 py-2 bg-[#f1f5f9] text-[13px] text-slate-800 font-medium rounded-md hover:bg-slate-200">Add cost</button>
                        </div>

                        <div class="text-[13px] font-bold text-slate-800 uppercase tracking-wide border-b border-slate-100 pb-2 mb-4">Output value</div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-5">
                            <div>
                                <label class="block text-[13px] text-slate-700 mb-1.5">Expected output weight</label>
                                <div class="flex gap-2">
                                    <input type="text" name="expected_output_weight" placeholder="0.00" class="form-control flex-1 px-3">
                                    <div class="relative w-[85px] searchable-dropdown" id="ddMcOutUnitWrapper">
                                        <input type="hidden" name="output_weight_unit" id="ddMcOutUnitHidden" value="ct">
                                        <button type="button" id="ddMcOutUnitBtn" class="form-control flex items-center pl-3 pr-7 text-left">
                                            <span id="ddMcOutUnitLabel" class="truncate text-slate-800">ct</span>
                                        </button>
                                        <div class="absolute inset-y-0 right-2.5 flex items-center pointer-events-none">
                                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                                        </div>
                                        <div id="ddMcOutUnitPanel" class="hidden absolute left-0 z-50 mt-1 w-full bg-white border border-slate-200 rounded-md shadow-lg overflow-hidden" style="top:100%;">
                                            <ul class="py-1 max-h-48 overflow-y-auto custom-scrollbar">
                                                <li class="dd-option flex items-center px-4 py-2.5 text-[14px] cursor-pointer bg-slate-100 text-slate-800 font-semibold" data-value="ct" data-label="ct">ct</li>
                                                <li class="dd-option flex items-center px-4 py-2.5 text-[14px] cursor-pointer hover:bg-slate-50 text-slate-600" data-value="g" data-label="g">g</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <label class="block text-[13px] text-slate-700 mb-1.5">Expected output quantity</label>
                                <input type="number" name="expected_output_quantity" placeholder="0" class="form-control px-3">
                            </div>
                            <div>
                                <label class="block text-[13px] text-slate-700 mb-1.5">Loss %</label>
                                <input type="text" name="loss_percent" id="mc-loss-pct" placeholder="0.00 %" class="form-control px-3 bg-slate-50" readonly>
                            </div>
                            <div>
                                <label class="block text-[13px] text-slate-700 mb-1.5">Loss weight</label>
                                <input type="text" name="loss_weight" id="mc-loss-wt" placeholder="0.00" class="form-control px-3 bg-slate-50" readonly>
                            </div>
                        </div>

                    </div>

                    {{-- ===== TAB 4: HISTORY ===== --}}
                    <div id="mc-tab-history" class="mc-tab-content hidden px-6 py-6 pb-20">

                        <div class="flex justify-between items-center mb-5">
                            <div class="text-[13px] font-bold text-slate-800 uppercase tracking-wide">History</div>
                            <div class="flex">
                                <input type="text" placeholder="Search history..." class="form-control !rounded-r-none !border-r-0 w-56 px-3">
                                <button type="button" class="bg-blue-700 hover:bg-blue-800 text-white px-4 rounded-r-md h-[42px] flex items-center justify-center">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                                </button>
                            </div>
                        </div>

                        <div class="border border-slate-200 rounded-md overflow-hidden shadow-sm">
                            <table class="w-full text-left text-[13px]">
                                <thead class="bg-[#f8fafc] text-slate-700 font-semibold border-b border-slate-200">
                                    <tr>
                                        <th class="px-4 py-3">Date</th>
                                        <th class="px-4 py-3">Time</th>
                                        <th class="px-4 py-3">User</th>
                                        <th class="px-4 py-3">Action</th>
                                        <th class="px-4 py-3">Note</th>
                                    </tr>
                                </thead>
                                <tbody class="text-slate-600 bg-white">
                                    <tr><td colspan="5" class="px-4 py-10 text-center text-slate-400 text-[13px]">No history yet — save the sheet to begin tracking.</td></tr>
                                </tbody>
                            </table>
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
                <button type="submit" form="createProductionForm"
                    class="px-8 py-2.5 text-[14px] font-medium text-white bg-blue-700 rounded-md hover:bg-blue-800 transition-colors shadow-sm active:scale-95">
                    Create
                </button>
            </div>

        </div>
    </div>
@endsection

@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', function () {

            // —— Dropdown Manager —————————————————————————————————————————————
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

            bindOptions('.opt-prodtype', 'lbl-prodtype');
            bindOptions('.opt-template', 'lbl-template');
            bindOptions('.opt-creator', 'lbl-creator');

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
            var modal   = document.getElementById('create-modal');
            var btnOpen = document.getElementById('btn-create');

            function openModal() {
                modal.classList.remove('hidden');
                modal.classList.add('flex');
                document.body.style.overflow = 'hidden';
            }

            function closeModal() {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
                document.body.style.overflow = '';
                resetModal();
            }

            function resetModal() {
                var resets = [
                    ['ddMcTypeLabel',    'Select type',     'ddMcTypeHidden'],
                    ['ddMcCatLabel',     'Select category', 'ddMcCatHidden'],
                    ['ddMcTplLabel',     'Default',         'ddMcTplHidden'],
                    ['ddMcCreatorLabel', 'Select creator',  'ddMcCreatorHidden'],
                    ['ddMcDiscLabel',    'Select reason',   'ddMcDiscHidden'],
                ];
                resets.forEach(function (r) {
                    var lbl = document.getElementById(r[0]);
                    var hid = document.getElementById(r[2]);
                    if (lbl) { lbl.textContent = r[1]; lbl.className = 'truncate text-slate-400'; }
                    if (hid) hid.value = '';
                });
                var badge = document.getElementById('mc-badge-type');
                badge.classList.add('hidden');
                badge.textContent = '';
                document.getElementById('createProductionForm').reset();
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
                var type  = document.getElementById('ddMcTypeLabel')  ? document.getElementById('ddMcTypeLabel').textContent  : '';
                var cat   = document.getElementById('ddMcCatLabel')   ? document.getElementById('ddMcCatLabel').textContent   : '';
                var badge = document.getElementById('mc-badge-type');
                var parts = [];
                if (type && type !== 'Select type')     parts.push(type);
                if (cat  && cat  !== 'Select category') parts.push(cat);
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

                var btn    = wrapper.querySelector('button');
                var panel  = wrapper.querySelector('[id$="Panel"]');
                var hidden = wrapper.querySelector('input[type="hidden"]');
                var label  = wrapper.querySelector('.truncate');
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
                    if (label)  { label.textContent = opt.dataset.label || opt.textContent.trim(); label.className = 'truncate text-slate-800'; }

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
                'ddMcTypeWrapper', 'ddMcCatWrapper', 'ddMcTplWrapper', 'ddMcCreatorWrapper',
                'ddMcWeightUnitWrapper', 'ddMcCurrencyWrapper', 'ddMcDiscWrapper',
                'ddMcItemUnitWrapper', 'ddMcOutUnitWrapper'
            ].forEach(setupDropdown);

            // —— Modal Form Submission ————————————————————————————————————————
            document.getElementById('createProductionForm').addEventListener('submit', function (e) {
                var type = document.getElementById('ddMcTypeHidden') ? document.getElementById('ddMcTypeHidden').value : '';
                var cat  = document.getElementById('ddMcCatHidden')  ? document.getElementById('ddMcCatHidden').value  : '';
                if (!type || !cat) {
                    e.preventDefault();
                    alert('Please select a production type and category before creating.');
                }
            });

            document.getElementById('create-save-draft').addEventListener('click', function () {
                var form  = document.getElementById('createProductionForm');
                var input = document.createElement('input');
                input.type  = 'hidden';
                input.name  = 'status';
                input.value = 'draft';
                form.appendChild(input);
                form.submit();
            });

        });
    </script>
@endsection
