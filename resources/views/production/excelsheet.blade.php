@extends('layouts.app')
@section('title', 'Excel / Spreadsheet Upload')
@section('content')
<script src="https://cdn.tailwindcss.com"></script>
<style>
.type-card{transition:all .18s ease;cursor:pointer;}
.type-card:hover{transform:translateY(-2px);box-shadow:0 6px 20px rgba(37,99,235,.13);}
</style>

<div class="p-6 min-h-screen bg-slate-50">

    {{-- HEADER --}}
    <div class="mb-5">
        <h1 class="text-2xl font-bold text-slate-800 mb-2">Excel / spreadsheet upload</h1>
        <nav class="flex items-center gap-1 text-[13px] text-slate-500">
            @foreach($breadcrumbs as $i => $bc)
                @if($i > 0)<span class="text-slate-400">›</span>@endif
                <a href="{{ $bc['url'] }}"
                   class="{{ $i === count($breadcrumbs)-1 ? 'text-blue-600 font-semibold' : 'hover:text-blue-600' }} transition-colors">
                    {{ $bc['label'] }}
                </a>
            @endforeach
        </nav>
    </div>

    <div class="flex gap-5 items-start">

        {{-- ===== MAIN CONTENT ===== --}}
        <div class="flex-1 bg-white rounded-md border border-slate-200 shadow-sm p-6">

            <h2 class="text-[15px] font-bold text-slate-800 mb-1">Import category</h2>
            <p class="text-sm text-slate-500 mb-1">Select upload type for new upload</p>
            <p class="text-xs text-slate-400 mb-6">
                Select the category of product you want to upload into your inventory.
                GC Software categorize products into the below categories:
            </p>

            {{-- Category sections --}}
            @foreach($categories as $cat)
            <div class="mb-7">
                <h3 class="text-[13px] font-bold text-slate-600 uppercase tracking-wider mb-3">{{ $cat['name'] }}</h3>
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                    @foreach($cat['types'] as $type)
                    <button type="button"
                        data-type="{{ $type['key'] }}"
                        data-category="{{ $cat['name'] }}"
                        class="type-card flex flex-col items-center justify-center gap-3 p-5 bg-white border border-slate-200 rounded-md text-center
                               {{ $type['key'] === 're_cutting_modal' ? 'open-recutting-modal' : 'open-module' }}">

                        {{-- Icon --}}
                        @if($type['icon'] === 'reassortment')
                        <div class="w-12 h-12 rounded-md bg-blue-50 flex items-center justify-center">
                            <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                            </svg>
                        </div>
                        @elseif($type['icon'] === 'recutting')
                        <div class="w-12 h-12 rounded-md bg-purple-50 flex items-center justify-center">
                            <svg class="w-6 h-6 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M14.121 14.121L19 19m-7-7l7-7m-7 7l-2.879 2.879M12 12L9.121 9.121m0 5.758a3 3 0 10-4.243 4.243 3 3 0 004.243-4.243zm0-5.758a3 3 0 10-4.243-4.243 3 3 0 004.243 4.243z"/>
                            </svg>
                        </div>
                        @elseif($type['icon'] === 'cutting')
                        <div class="w-12 h-12 rounded-md bg-amber-50 flex items-center justify-center">
                            <svg class="w-6 h-6 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M14.121 14.121L19 19m-7-7l7-7m-7 7l-2.879 2.879M12 12L9.121 9.121m0 5.758a3 3 0 10-4.243 4.243 3 3 0 004.243-4.243zm0-5.758a3 3 0 10-4.243-4.243 3 3 0 004.243 4.243z"/>
                            </svg>
                        </div>
                        @elseif($type['icon'] === 'transfer')
                        <div class="w-12 h-12 rounded-md bg-green-50 flex items-center justify-center">
                            <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
                            </svg>
                        </div>
                        @elseif($type['icon'] === 'treatment')
                        <div class="w-12 h-12 rounded-md bg-teal-50 flex items-center justify-center">
                            <svg class="w-6 h-6 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                            </svg>
                        </div>
                        @endif

                        <span class="text-[13px] font-semibold text-slate-700">{{ $type['label'] }}</span>
                    </button>
                    @endforeach
                </div>
            </div>
            @endforeach

            {{-- Back button --}}
            <div class="mt-4 pt-4 border-t border-slate-100">
                <a href="{{ route('production.excelsheetupload.index') }}"
                   class="inline-flex items-center gap-2 px-4 py-2 text-[13px] font-semibold text-slate-600 bg-white border border-slate-300 rounded-md hover:bg-slate-50 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Select import type
                </a>
            </div>
        </div>

        {{-- ===== RIGHT SIDEBAR ===== --}}
        <div class="w-72 flex-shrink-0 flex flex-col gap-4">

            {{-- Template info card --}}
            <div class="bg-white rounded-md border border-slate-200 shadow-sm p-5">
                <h3 class="text-[14px] font-bold text-slate-800 mb-1">Template information</h3>
                <p class="text-xs text-slate-400 mb-4 leading-relaxed">
                    Select an example template to start upload. Fill the template and upload back to the system to save time.
                </p>

                {{-- Single unified template select dropdown matching the mockup --}}
                <div class="mb-3 relative" id="tpl-wrapper-single">
                    <button type="button" id="tpl-btn-single"
                        class="w-full flex items-center justify-between pl-3 pr-8 py-2.5 text-sm bg-slate-100 border border-slate-200 rounded-md hover:border-blue-400 transition-colors">
                        <span id="tpl-lbl-single" class="text-slate-700 font-semibold">Gemstone</span>
                    </button>
                    <div class="absolute inset-y-0 right-3 flex items-center pointer-events-none">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </div>
                    <div id="tpl-panel-single" class="hidden absolute left-0 z-50 mt-1 w-full bg-white border border-slate-200 rounded-md shadow-lg overflow-y-auto max-h-[280px]">
                        @foreach($templates as $group => $items)
                        <div class="px-4 pt-3 pb-1 text-[11px] font-bold text-blue-600 uppercase tracking-wider bg-slate-50/60">{{ $group }}</div>
                        <ul class="pb-1">
                            @foreach($items as $item)
                            <li class="tpl-opt px-6 py-2 text-sm text-slate-700 cursor-pointer hover:bg-slate-50 hover:text-blue-600 transition-colors"
                                data-label="{{ $item }}">{{ $item }}</li>
                            @endforeach
                        </ul>
                        @endforeach
                    </div>
                </div>

                <button type="button" id="btn-download-tpl"
                    class="mt-2 w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 text-[13px] font-bold text-white bg-[#2563eb] rounded-md hover:bg-blue-700 shadow-sm transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                    </svg>
                    Download template
                </button>
            </div>

            {{-- Contact card --}}
            <div class="bg-white rounded-md border border-slate-200 shadow-sm p-5">
                <h3 class="text-[14px] font-bold text-slate-800 mb-1">Contact us</h3>
                <p class="text-xs text-slate-400 leading-relaxed mb-4">
                    Get in touch with our team for any inquiries, support, or feedback you may have.
                    Email us <span class="text-blue-500">cs@thegemexhibit.com</span> or reach out to us on
                    Whatsapp <span class="text-blue-500">+1 (786) 6332574</span>
                </p>
                <a href="mailto:cs@thegemexhibit.com"
                   class="inline-flex items-center gap-2 px-4 py-2 text-[13px] font-semibold text-white bg-slate-700 rounded-md hover:bg-slate-800 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    Email us
                </a>
            </div>

        </div>
    </div>
</div>

{{-- ===== RE-CUTTING MODAL ===== --}}
<div id="recutting-modal" class="fixed inset-0 z-50 hidden flex items-center justify-center">
    <div class="absolute inset-0 bg-slate-900/40 backdrop-blur-sm" id="recutting-backdrop"></div>
    <div id="recutting-modal-content"
         class="relative bg-white rounded-md shadow-2xl w-full max-w-md z-10 transform scale-95 opacity-0 transition-all duration-200">
        {{-- Header --}}
        <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100">
            <h3 class="text-[16px] font-bold text-slate-800">Select re-cutting type</h3>
            <button type="button" id="recutting-close"
                class="text-slate-400 hover:text-slate-600 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        {{-- Body --}}
        <div class="px-6 py-5 flex flex-col gap-4">
            {{-- Template --}}
            <div class="relative" id="rc-tpl-wrapper">
                <label class="block text-xs font-bold text-slate-700 mb-1.5">Template</label>
                <button type="button" id="rc-tpl-btn"
                    class="w-full flex items-center justify-between pl-3 pr-8 py-2.5 text-sm bg-slate-100 border border-slate-200 rounded-md hover:border-blue-400 transition-colors">
                    <span id="rc-tpl-lbl" class="text-slate-400">Select template</span>
                </button>
                <div class="absolute inset-y-0 right-3 top-6 flex items-center pointer-events-none" style="top:auto;bottom:0;height:42px;">
                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </div>
                <div id="rc-tpl-panel" class="hidden absolute left-0 z-50 mt-1 w-full bg-white border border-slate-200 rounded-md shadow-lg overflow-hidden" style="top:100%;">
                    <ul class="py-1">
                        <li class="rc-tpl-opt px-4 py-2.5 text-sm text-slate-700 cursor-pointer hover:bg-slate-50" data-label="Gemstone">Gemstone</li>
                        <li class="rc-tpl-opt px-4 py-2.5 text-sm text-slate-700 cursor-pointer hover:bg-slate-50" data-label="Diamond">Diamond</li>
                        <li class="rc-tpl-opt px-4 py-2.5 text-sm text-slate-700 cursor-pointer hover:bg-slate-50" data-label="Rough &amp; Specimen">Rough &amp; Specimen</li>
                    </ul>
                </div>
            </div>
            {{-- Production Category --}}
            <div class="relative" id="rc-cat-wrapper">
                <label class="block text-xs font-bold text-slate-700 mb-1.5">Production category</label>
                <button type="button" id="rc-cat-btn"
                    class="w-full flex items-center justify-between pl-3 pr-8 py-2.5 text-sm bg-slate-100 border border-slate-200 rounded-md hover:border-blue-400 transition-colors">
                    <span id="rc-cat-lbl" class="text-slate-400">Select category</span>
                </button>
                <div class="absolute inset-y-0 right-3 flex items-center pointer-events-none" style="top:auto;bottom:0;height:42px;margin-top:auto;">
                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </div>
                <div id="rc-cat-panel" class="hidden absolute left-0 z-50 mt-1 w-full bg-white border border-slate-200 rounded-md shadow-lg overflow-hidden" style="top:100%;">
                    <ul class="py-1">
                        <li class="rc-cat-opt px-4 py-2.5 text-sm text-slate-700 cursor-pointer hover:bg-slate-50" data-label="Gemstones">Gemstones</li>
                        <li class="rc-cat-opt px-4 py-2.5 text-sm text-slate-700 cursor-pointer hover:bg-slate-50" data-label="Diamonds">Diamonds</li>
                        <li class="rc-cat-opt px-4 py-2.5 text-sm text-slate-700 cursor-pointer hover:bg-slate-50" data-label="Rough and Specimen">Rough and Specimen</li>
                    </ul>
                </div>
            </div>
        </div>
        {{-- Footer --}}
        <div class="px-6 pb-5 flex items-center gap-3">
            <button type="button" id="recutting-cancel"
                class="px-5 py-2 text-sm font-semibold text-red-500 bg-white border border-red-400 rounded-md hover:bg-red-50 transition-colors">
                Cancel
            </button>
            <button type="button" id="recutting-import"
                class="px-6 py-2 text-sm font-bold text-white bg-[#2563eb] rounded-md hover:bg-blue-700 shadow-sm transition-colors">
                Import
            </button>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {

    // ── Sidebar template dropdown single selector ───────────────────
    const tplBtn   = document.getElementById('tpl-btn-single');
    const tplPanel = document.getElementById('tpl-panel-single');
    const tplLbl   = document.getElementById('tpl-lbl-single');

    function closeAllTpl() {
        if (tplPanel) tplPanel.classList.add('hidden');
    }

    if (tplBtn && tplPanel) {
        tplBtn.addEventListener('click', e => {
            e.stopPropagation();
            const wasHidden = tplPanel.classList.contains('hidden');
            closeAllTpl();
            if (wasHidden) tplPanel.classList.remove('hidden');
        });
        tplPanel.addEventListener('click', e => e.stopPropagation());
    }

    document.querySelectorAll('.tpl-opt').forEach(opt => {
        opt.addEventListener('click', function () {
            if (tplLbl) {
                tplLbl.textContent = this.dataset.label;
                tplLbl.classList.remove('text-slate-400');
                tplLbl.classList.add('text-slate-700');
            }
            closeAllTpl();
        });
    });

    document.addEventListener('click', closeAllTpl);

    // ── Modal dropdowns ────────────────────────────────────────────
    const modalDrops = [
        { btn: 'rc-tpl-btn', panel: 'rc-tpl-panel', opts: '.rc-tpl-opt', lbl: 'rc-tpl-lbl' },
        { btn: 'rc-cat-btn', panel: 'rc-cat-panel', opts: '.rc-cat-opt', lbl: 'rc-cat-lbl' },
    ];

    function closeModalDrops() {
        modalDrops.forEach(d => {
            const p = document.getElementById(d.panel);
            if (p) p.classList.add('hidden');
        });
    }

    modalDrops.forEach(d => {
        const btn   = document.getElementById(d.btn);
        const panel = document.getElementById(d.panel);
        if (!btn || !panel) return;

        btn.addEventListener('click', e => {
            e.stopPropagation();
            const wasHidden = panel.classList.contains('hidden');
            closeModalDrops();
            if (wasHidden) panel.classList.remove('hidden');
        });
        panel.addEventListener('click', e => e.stopPropagation());

        document.querySelectorAll(d.opts).forEach(opt => {
            opt.addEventListener('click', function () {
                const lbl = document.getElementById(d.lbl);
                lbl.textContent = this.dataset.label;
                lbl.classList.remove('text-slate-400');
                lbl.classList.add('text-slate-700');
                closeModalDrops();
            });
        });
    });

    // ── Re-cutting Modal open/close ────────────────────────────────
    const modal        = document.getElementById('recutting-modal');
    const modalContent = document.getElementById('recutting-modal-content');
    const backdrop     = document.getElementById('recutting-backdrop');

    function openModal() {
        modal.classList.remove('hidden');
        setTimeout(() => {
            modalContent.classList.remove('scale-95', 'opacity-0');
            modalContent.classList.add('scale-100', 'opacity-100');
        }, 10);
    }

    function closeModal() {
        modalContent.classList.remove('scale-100', 'opacity-100');
        modalContent.classList.add('scale-95', 'opacity-0');
        setTimeout(() => modal.classList.add('hidden'), 200);
        // reset labels
        ['rc-tpl-lbl','rc-cat-lbl'].forEach(id => {
            const el = document.getElementById(id);
            el.textContent = id === 'rc-tpl-lbl' ? 'Select template' : 'Select category';
            el.classList.add('text-slate-400');
            el.classList.remove('text-slate-700');
        });
    }

    document.querySelectorAll('.open-recutting-modal').forEach(btn => {
        btn.addEventListener('click', openModal);
    });

    [document.getElementById('recutting-close'),
     document.getElementById('recutting-cancel'),
     backdrop
    ].forEach(el => { if (el) el.addEventListener('click', closeModal); });

    document.getElementById('recutting-import').addEventListener('click', () => {
        alert('Import — coming soon.');
        closeModal();
    });

    // Prevent modal content clicks from closing
    modalContent.addEventListener('click', e => e.stopPropagation());

    // ── Module type cards (non-recutting) ─────────────────────────
    document.querySelectorAll('.open-module').forEach(btn => {
        btn.addEventListener('click', function () {
            const type = this.dataset.type;
            const cat  = this.dataset.category;
            alert('Import: ' + cat + ' → ' + type + '\n(Coming soon)');
        });
    });

    // ── Download template ──────────────────────────────────────────
    document.getElementById('btn-download-tpl').addEventListener('click', () => {
        alert('Download template — coming soon.');
    });

});
</script>
@endsection
