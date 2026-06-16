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

                        <div
                            class="w-[120px] h-[90px] bg-[#f1f5f9] rounded-md flex flex-col items-center justify-center cursor-pointer hover:bg-slate-200 transition-colors mb-6 border border-transparent hover:border-blue-200">
                            <svg class="w-8 h-8 text-blue-600 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812-1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <span class="text-blue-600 text-[12px] font-medium">Upload</span>
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

                            {{-- Template --}}
                            <div>
                                <label class="block text-[13px] text-slate-700 mb-1.5">Template</label>
                                <div class="relative searchable-dropdown" id="ddMcTplWrapper">
                                    <input type="hidden" name="template" id="ddMcTplHidden" value="default">
                                    <button type="button" id="ddMcTplBtn"
                                        class="form-control flex items-center pl-3 pr-8 text-left">
                                        <span id="ddMcTplLabel" class="truncate text-slate-800">Default</span>
                                    </button>
                                    <div class="absolute inset-y-0 right-3 flex items-center pointer-events-none">
                                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </div>
                                    <div id="ddMcTplPanel"
                                        class="hidden absolute left-0 z-50 mt-1 w-full bg-white border border-slate-200 rounded-md shadow-lg overflow-hidden"
                                        style="top:100%;">
                                        <ul class="py-1 max-h-48 overflow-y-auto custom-scrollbar">
                                            <li class="dd-option flex items-center px-4 py-2.5 text-[14px] cursor-pointer bg-slate-100 text-slate-800 font-semibold"
                                                data-value="default" data-label="Default">Default</li>
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
                                    <button type="button" id="ddMcCreatorBtn"
                                        class="form-control flex items-center pl-3 pr-8 text-left">
                                        <span id="ddMcCreatorLabel" class="truncate text-slate-400">Select creator</span>
                                    </button>
                                    <div class="absolute inset-y-0 right-3 flex items-center pointer-events-none">
                                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </div>
                                    <div id="ddMcCreatorPanel"
                                        class="hidden absolute left-0 z-50 mt-1 w-full bg-white border border-slate-200 rounded-md shadow-lg overflow-hidden"
                                        style="top:100%;">
                                        <div class="p-2 border-b border-slate-100">
                                            <input type="text" id="ddMcCreatorSearch" placeholder="Search..."
                                                class="form-control !h-9 px-3">
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
                                        <input type="hidden" name="currency" id="ddMcCurrencyHidden" value="VEF">
                                        <button type="button" id="ddMcCurrencyBtn"
                                            class="form-control flex items-center pl-3 pr-7 text-left">
                                            <span id="ddMcCurrencyLabel" class="truncate text-slate-800">VEF</span>
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
                                                    data-value="VEF" data-label="VEF">VEF</li>
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

                        <div
                            class="text-[13px] font-bold text-slate-800 uppercase tracking-wide border-b border-slate-100 pb-2 mb-4 mt-6">
                            Documents</div>
                        <div
                            class="w-[180px] h-[90px] bg-white border border-slate-200 rounded-md flex flex-col items-center justify-center cursor-pointer hover:bg-slate-50 transition-colors shadow-sm">
                            <svg class="w-6 h-6 text-blue-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <span class="text-slate-800 text-[13px] font-medium">Add document(s)</span>
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
                                    <input type="text" id="item-input-sku" class="form-control px-3 bg-white"
                                        placeholder="e.g. GEM-001">
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
                // Clear prodtype selection marker
                document.querySelectorAll('.opt-prodtype').forEach(function (o) {
                    o.classList.remove('text-slate-800', 'bg-slate-100', 'font-semibold');
                    o.classList.add('text-slate-700');
                });
                var ptLbl = document.getElementById('lbl-prodtype');
                if (ptLbl) { ptLbl.textContent = 'Select'; ptLbl.classList.add('text-slate-500'); ptLbl.classList.remove('text-slate-800'); }
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
            var modal = document.getElementById('create-modal');
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
                    ['ddMcTypeLabel', 'Select type', 'ddMcTypeHidden'],
                    ['ddMcCatLabel', 'Select category', 'ddMcCatHidden'],
                    ['ddMcTplLabel', 'Default', 'ddMcTplHidden'],
                    ['ddMcCreatorLabel', 'Select creator', 'ddMcCreatorHidden'],
                    ['ddMcDiscLabel', 'Select reason', 'ddMcDiscHidden'],
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
                'ddMcTypeWrapper', 'ddMcCatWrapper', 'ddMcTplWrapper', 'ddMcCreatorWrapper',
                'ddMcWeightUnitWrapper', 'ddMcCurrencyWrapper', 'ddMcDiscWrapper',
                'ddMcItemUnitWrapper', 'ddMcOutUnitWrapper'
            ].forEach(setupDropdown);

            // —— Modal Form Submission ————————————————————————————————————————
            document.getElementById('createProductionForm').addEventListener('submit', function (e) {
                var type = document.getElementById('ddMcTypeHidden') ? document.getElementById('ddMcTypeHidden').value : '';
                var cat = document.getElementById('ddMcCatHidden') ? document.getElementById('ddMcCatHidden').value : '';
                if (!type || !cat) {
                    e.preventDefault();
                    alert('Please select a production type and category before creating.');
                }
            });

            document.getElementById('create-save-draft').addEventListener('click', function () {
                var form = document.getElementById('createProductionForm');
                var input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'status';
                input.value = 'draft';
                form.appendChild(input);
                form.submit();
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
                                    '<td class="px-4 py-3 font-medium text-blue-600">' + r.sheet_number + '</td>' +
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
                    var fields = { sku: item.sku, description: item.desc, quantity: item.qty, weight: item.weight, weight_unit: item.unit, cost: item.cost };
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
                    var sku = (document.getElementById('item-input-sku') || {}).value || '';
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

                    itemsList.push({ key: itemIndex++, sku: sku.trim(), desc: desc.trim(), qty: qty, weight: weight, unit: unit, cost: cost });

                    // Clear input fields
                    ['item-input-sku', 'item-input-desc', 'item-input-qty', 'item-input-weight', 'item-input-cost'].forEach(function (id) {
                        var el = document.getElementById(id);
                        if (el) el.value = '';
                    });
                    document.getElementById('item-input-sku').focus();

                    renderItems();
                });
            }

            // ── Enter key in item inputs triggers Add ────────────────────────
            ['item-input-sku', 'item-input-desc', 'item-input-qty', 'item-input-weight', 'item-input-cost'].forEach(function (id) {
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
                ['item-input-sku', 'item-input-desc', 'item-input-qty', 'item-input-weight', 'item-input-cost'].forEach(function (id) {
                    var el = document.getElementById(id);
                    if (el) el.value = '';
                });
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

        });
    </script>
@endsection
