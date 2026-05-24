@extends('layouts.app')

@section('title', 'Stone Detail - CPG9')

@section('content')

<!-- Tailwind CSS for this page -->
<script src="https://cdn.tailwindcss.com"></script>

@section('style')
    @vite('resources/css/inventory/my_inventory/show.css')
@endsection

@section('script')
    @vite('resources/js/inventory/my_inventory/show.js')
@endsection

<div class="p-6 bg-[#f8fafc] min-h-screen font-sans">

    {{-- Top Header --}}
    <div class="bg-white rounded-xl border border-slate-200 p-4 mb-6 flex justify-between items-center shadow-sm">
        <div class="flex items-center gap-4">
            <a href="{{ route('inventory.myinventory.index') }}" class="w-9 h-9 flex items-center justify-center rounded-full bg-slate-50 border border-slate-200 hover:bg-slate-100 text-slate-400 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
            </a>
            <div>
                <h1 class="text-[17px] font-bold text-blue-700 leading-none mb-1">CPG9</h1>
                <div class="text-[11px] font-semibold text-amber-500">Draft</div>
            </div>
        </div>
        <button type="button" class="bg-[#2563eb] hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-[13px] font-medium flex items-center gap-2 transition-colors">
            Save and add new
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" /></svg>
        </button>
    </div>

    {{-- Tabs Navigation --}}
    <div class="bg-white rounded-xl border border-slate-200 px-2 flex gap-8 mb-6 shadow-sm overflow-x-auto">
        <a href="#overview" data-target="tab-overview" class="tab-link active border-b-[3px] border-[#2563eb] text-[#2563eb] font-bold py-3.5 px-4 text-[13px] flex items-center gap-2 whitespace-nowrap">
            Overview
        </a>
        <a href="#advance" data-target="tab-advance" class="tab-link border-b-[3px] border-transparent text-slate-500 hover:text-slate-700 font-semibold py-3.5 px-4 text-[13px] flex items-center gap-2 whitespace-nowrap">
            Advance Details
        </a>
        <a href="#media" data-target="tab-media" class="tab-link border-b-[3px] border-transparent text-slate-500 hover:text-slate-700 font-semibold py-3.5 px-4 text-[13px] flex items-center gap-2 whitespace-nowrap">
            Media & Docs
        </a>
        <a href="#memo" data-target="tab-memo" class="tab-link border-b-[3px] border-transparent text-slate-500 hover:text-slate-700 font-semibold py-3.5 px-4 text-[13px] flex items-center gap-2 whitespace-nowrap">
            Memo & Purchases
        </a>
        <a href="#history" data-target="tab-history" class="tab-link border-b-[3px] border-transparent text-slate-500 hover:text-slate-700 font-semibold py-3.5 px-4 text-[13px] flex items-center gap-2 whitespace-nowrap">
            History
        </a>
    </div>

    <div class="flex flex-col lg:flex-row gap-6 items-start">

        {{-- ================= LEFT COLUMN ================= --}}
        <div class="flex-1 w-full flex flex-col gap-6">
            @include('inventory.myinventory.fullpage.fullpage.partials._overview')
            @include('inventory.myinventory.fullpage.fullpage.partials._advance')
            @include('inventory.myinventory.fullpage.fullpage.partials._media')
            @include('inventory.myinventory.fullpage.fullpage.partials._memo')
            @include('inventory.myinventory.fullpage.fullpage.partials._history')
        </div>

        {{-- ================= RIGHT COLUMN (Sidebar) ================= --}}
        @include('inventory.myinventory.fullpage.fullpage.partials._sidebar')

    </div>
</div>
@endsection
