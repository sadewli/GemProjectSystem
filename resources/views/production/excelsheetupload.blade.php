@extends('layouts.app')

@section('title', 'Excel / Spreadsheet Upload')

@section('content')
    <div class="p-6 min-h-full">

        {{-- ===== PAGE HEADER ===== --}}
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-slate-800 mb-1">Excel / spreadsheet upload</h1>
            <nav class="flex items-center gap-1.5 text-sm text-slate-500">
                <a href="{{ route('production.excelsheetupload.index') }}" class="hover:text-primary-600 transition-colors">Excel upload</a>
                <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
                <a href="{{ route('production.excelsheet.index') }}" class="hover:text-primary-600 transition-colors">Import type</a>
                <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
                <span class="font-medium text-slate-700">Import category</span>
            </nav>
        </div>

        {{-- ===== TWO-COLUMN LAYOUT ===== --}}
        <div class="flex gap-6 items-start">

            {{-- ===== LEFT COLUMN ===== --}}
            <div class="flex-1 flex flex-col gap-6 min-w-0">

                {{-- ---- Import Type Card ---- --}}
                <div class="bg-white rounded-md shadow-sm border border-slate-100">
                    {{-- Blue top bar --}}
                    <div class="h-1.5 bg-gradient-to-r from-blue-600 to-blue-400 rounded-t-md"></div>

                    <div class="p-6">
                        <h2 class="text-base font-bold text-primary-600 mb-5">Import type</h2>

                        <h3 class="text-sm font-bold text-slate-700 mb-2">Select upload type</h3>
                        <p class="text-sm text-slate-500 mb-5 leading-relaxed">
                            Select an upload option to streamline the process of importing products.
                            You have the flexibility to either create new inventory, update existing
                            inventory, or perform both actions simultaneously.
                        </p>

                        {{-- Custom Upload Type Dropdown --}}
                        <div class="relative w-64" id="uploadTypeWrapper">
                            <input type="hidden" id="uploadTypeHidden" name="upload_type" value="">

                            <button type="button" id="uploadTypeBtn"
                                class="w-full flex items-center justify-between px-4 py-3 text-sm border border-slate-200 rounded-md bg-white hover:border-blue-400 focus:outline-none focus:ring-2 focus:ring-blue-500 cursor-pointer transition-all duration-150 shadow-sm">
                                <div class="flex items-center gap-2.5">
                                    <svg class="w-4 h-4 text-slate-400 flex-shrink-0" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                                    </svg>
                                    <span id="uploadTypeLabel" class="text-slate-400">Select upload type</span>
                                </div>
                                <svg id="uploadTypeChevron"
                                    class="w-4 h-4 text-slate-400 flex-shrink-0 transition-transform duration-200"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>

                            <div id="uploadTypePanel"
                                class="hidden absolute left-0 right-0 top-full mt-1.5 bg-white border border-slate-200 rounded-md shadow-xl z-50 overflow-hidden">
                                <ul class="py-2 px-2">
                                    <li class="upload-type-option flex items-center px-3 py-2.5 text-sm text-slate-700 hover:bg-blue-600 hover:text-white cursor-pointer rounded-md transition-colors duration-100"
                                        data-value="create" data-label="Create new companies">Create new companies</li>
                                    <li class="upload-type-option flex items-center px-3 py-2.5 text-sm text-slate-700 hover:bg-blue-600 hover:text-white cursor-pointer rounded-md transition-colors duration-100"
                                        data-value="update" data-label="Update existing companies">Update existing companies
                                    </li>
                                    <li class="upload-type-option flex items-center px-3 py-2.5 text-sm text-slate-700 hover:bg-blue-600 hover:text-white cursor-pointer rounded-md transition-colors duration-100"
                                        data-value="both" data-label="Create &amp; update companies">Create &amp; update
                                        companies</li>
                                </ul>
                            </div>
                        </div>
                        {{-- End Custom Upload Type Dropdown --}}

                        {{-- File upload area (hidden until type is selected) --}}
                        <div id="fileUploadArea" class="hidden mt-6">
                            <label class="block text-xs font-medium text-slate-600 mb-2">Upload file</label>
                            <div id="dropZone"
                                class="border-2 border-dashed border-slate-300 rounded-md p-8 text-center hover:border-blue-400 hover:bg-blue-50 transition-all duration-200 cursor-pointer">
                                <svg class="w-10 h-10 text-slate-300 mx-auto mb-3" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                </svg>
                                <p class="text-sm font-medium text-slate-600 mb-1">Drop your file here or
                                    <label for="fileInput"
                                        class="text-primary-600 hover:text-primary-700 cursor-pointer underline">browse</label>
                                </p>
                                <p class="text-xs text-slate-400">Supports .xlsx, .xls, .csv — Max 10MB</p>
                                <input type="file" id="fileInput" accept=".xlsx,.xls,.csv" class="hidden">
                            </div>

                            {{-- File selected preview --}}
                            <div id="filePreview"
                                class="hidden mt-3 flex items-center gap-3 p-3 bg-blue-50 border border-blue-200 rounded-md">
                                <svg class="w-8 h-8 text-green-600 flex-shrink-0" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                <div class="flex-1 min-w-0">
                                    <p id="fileNameText" class="text-sm font-medium text-slate-700 truncate"></p>
                                    <p id="fileSizeText" class="text-xs text-slate-500"></p>
                                </div>
                                <button type="button" id="removeFileBtn"
                                    class="text-slate-400 hover:text-red-500 transition-colors flex-shrink-0">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>

                            <div class="mt-4 flex justify-end">
                                <button type="button" id="uploadBtn"
                                    class="inline-flex items-center gap-2 bg-primary-600 hover:bg-primary-700 text-white text-sm font-semibold px-5 py-2.5 rounded-md shadow-sm transition-all duration-150 active:scale-95 disabled:opacity-50 disabled:cursor-not-allowed"
                                    disabled>
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                                    </svg>
                                    Upload File
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ---- Upload History Card ---- --}}
                <div class="bg-white rounded-md shadow-sm overflow-hidden border border-slate-100">
                    <div class="h-1.5 bg-gradient-to-r from-blue-600 to-blue-400 rounded-t-md"></div>

                    <div class="p-6">
                        <h2 class="text-base font-bold text-primary-600 mb-5">Upload history</h2>

                        {{-- Table controls --}}
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center gap-2">
                                <input type="text" id="historySearch" placeholder="search"
                                    class="w-44 px-3 py-2 text-sm border border-slate-200 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <button type="button"
                                    class="w-9 h-9 flex items-center justify-center bg-primary-600 hover:bg-primary-700 text-white rounded-md transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M21 21l-4.35-4.35M11 19a8 8 0 100-16 8 8 0 000 16z" />
                                    </svg>
                                </button>
                            </div>

                            <div class="flex items-center gap-2 text-sm text-slate-500">
                                <span>Show</span>
                                <div class="relative">
                                    <select id="historyPerPage"
                                        class="pl-2 pr-7 py-1.5 text-sm border border-slate-200 rounded-md bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 appearance-none cursor-pointer">
                                        <option value="5">5</option>
                                        <option value="10">10</option>
                                        <option value="25">25</option>
                                    </select>
                                    <div class="absolute inset-y-0 right-1.5 flex items-center pointer-events-none">
                                        <svg class="w-3 h-3 text-slate-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </div>
                                </div>
                                <span>entries</span>
                            </div>
                        </div>

                        {{-- Table --}}
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm">
                                <thead>
                                    <tr class="bg-slate-100">
                                        <th class="text-left px-4 py-3 font-semibold text-slate-600 rounded-l-md">Type</th>
                                        <th class="text-left px-4 py-3 font-semibold text-slate-600">File name</th>
                                        <th class="text-left px-4 py-3 font-semibold text-slate-600">Summary</th>
                                        <th class="text-left px-4 py-3 font-semibold text-slate-600">Date</th>
                                        <th class="text-left px-4 py-3 font-semibold text-slate-600 rounded-r-md">Action
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- Dynamic rows would go here --}}
                                    <tr>
                                        <td colspan="5" class="px-4 py-8 text-center text-sm text-slate-400">
                                            No data available in table
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        {{-- Table footer --}}
                        <div class="flex items-center justify-between mt-4 pt-4 border-t border-slate-100">
                            <div class="flex items-center gap-2 text-sm text-slate-500">
                                <span>Show</span>
                                <div class="relative">
                                    <select
                                        class="pl-2 pr-7 py-1.5 text-sm border border-slate-200 rounded-md bg-white focus:outline-none appearance-none cursor-pointer">
                                        <option value="5">5</option>
                                        <option value="10">10</option>
                                        <option value="25">25</option>
                                    </select>
                                    <div class="absolute inset-y-0 right-1.5 flex items-center pointer-events-none">
                                        <svg class="w-3 h-3 text-slate-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </div>
                                </div>
                                <span>entries</span>
                            </div>

                            <p class="text-sm text-slate-500">Showing 0 to 0 of 0 entries</p>

                            <div class="flex items-center gap-2">
                                <button class="px-3 py-1.5 text-sm text-slate-400 cursor-not-allowed">Previous</button>
                                <button class="px-3 py-1.5 text-sm text-slate-400 cursor-not-allowed">Next</button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            {{-- end left column --}}

            {{-- ===== RIGHT COLUMN ===== --}}
            <div class="w-80 flex-shrink-0 flex flex-col gap-6">

                {{-- ---- Download Template Card ---- --}}
                <div class="bg-white rounded-md shadow-sm border border-slate-100">
                    <div class="h-1.5 bg-gradient-to-r from-blue-600 to-blue-400 rounded-t-md"></div>

                    <div class="p-6">
                        <h2 class="text-base font-bold text-primary-600 mb-5">Download template</h2>

                        <div class="flex items-start gap-4 mb-5">
                            <div class="flex-1">
                                <p class="text-sm font-bold text-slate-700 mb-1.5">Template information</p>
                                <p class="text-sm text-slate-500 leading-relaxed">
                                    Select an example template to start upload. fill the template and
                                    upload back to the system to save time.
                                </p>
                            </div>
                            {{-- Spreadsheet thumbnail --}}
                            <div
                                class="w-20 h-16 flex-shrink-0 bg-slate-100 rounded-md border border-slate-200 overflow-hidden flex items-center justify-center">
                                <svg class="w-10 h-10 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M9 17V7m0 10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h2a2 2 0 012 2m0 10a2 2 0 002 2h2a2 2 0 002-2M9 7a2 2 0 012-2h2a2 2 0 012 2m0 10V7m0 10a2 2 0 002 2h2a2 2 0 002-2V7a2 2 0 00-2-2h-2a2 2 0 00-2 2" />
                                </svg>
                            </div>
                        </div>

                        {{-- ===== Custom Grouped Template Dropdown ===== --}}
                        <div class="relative" id="templateDropdownWrapper">

                            {{-- Hidden input --}}
                            <input type="hidden" id="templateHiddenInput" name="template" value="">

                            {{-- Trigger button --}}
                            <button type="button" id="templateDropdownBtn"
                                class="w-full flex items-center justify-between px-4 py-3 text-sm border border-slate-200 rounded-md bg-white hover:border-blue-400 focus:outline-none focus:ring-2 focus:ring-blue-500 cursor-pointer transition-all duration-150 shadow-sm">
                                <div class="flex items-center gap-2.5">
                                    <svg class="w-4 h-4 text-slate-400 flex-shrink-0" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                    </svg>
                                    <span id="templateDropdownLabel" class="text-slate-400">Select template</span>
                                </div>
                                <svg id="templateDropdownChevron"
                                    class="w-4 h-4 text-slate-400 flex-shrink-0 transition-transform duration-200"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>

                            {{-- Dropdown panel — floats below, does NOT push card content --}}
                            <div id="templateDropdownPanel"
                                class="hidden absolute left-0 right-0 top-full mt-1.5 bg-white border border-slate-200 rounded-md shadow-xl z-50 overflow-hidden">
                                @include('master.download_template')
                            </div>
                        </div>
                        {{-- End Custom Grouped Template Dropdown --}}

                        {{-- Download button (shown when template selected) --}}
                        <div id="downloadBtnWrapper" class="hidden mt-3">
                            <button type="button" id="downloadTemplateBtn"
                                class="w-full inline-flex items-center justify-center gap-2 border border-primary-600 text-primary-600 hover:bg-primary-50 text-sm font-semibold px-4 py-2.5 rounded-md transition-all duration-150">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                </svg>
                                Download template
                            </button>
                        </div>
                    </div>
                </div>

                {{-- ---- Support Card ---- --}}
                <div class="bg-white rounded-md shadow-sm overflow-hidden border border-slate-100">
                    <div class="h-1.5 bg-gradient-to-r from-blue-600 to-blue-400 rounded-t-md"></div>

                    <div class="p-6">
                        <h2 class="text-base font-bold text-primary-600 mb-5">Support</h2>

                        <p class="text-sm font-bold text-slate-700 mb-2">Contact us</p>
                        <p class="text-sm text-slate-500 leading-relaxed mb-5">
                            Get in touch with our team for any inquiries, support, or feedback you may have.
                            Email us
                            <a href="mailto:cs@thegemexhibit.com"
                                class="text-primary-600 hover:text-primary-700 font-medium">
                                cs@thegemexhibit.com
                            </a>
                            or reach out to us on Whatsapp
                            <a href="https://wa.me/17866332574" class="text-primary-600 hover:text-primary-700 font-medium">
                                +1 (786) 6332574
                            </a>
                        </p>

                        <a href="mailto:cs@thegemexhibit.com"
                            class="block w-full text-center px-4 py-2.5 text-sm font-medium text-slate-700 border border-slate-200 rounded-md bg-slate-50 hover:bg-slate-100 transition-colors">
                            Email us
                        </a>
                    </div>
                </div>

            </div>
            {{-- end right column --}}

        </div>

    </div>

    <script>
        (function () {

            // ── Generic dropdown factory ──────────────────────────────────────────────
            function makeDropdown(cfg) {
                // cfg: { btnId, panelId, labelId, chevronId, hiddenId, optionClass,
                //        onSelect(value, label) }
                const btn = document.getElementById(cfg.btnId);
                const panel = document.getElementById(cfg.panelId);
                const label = document.getElementById(cfg.labelId);
                const chevron = document.getElementById(cfg.chevronId);
                const hidden = document.getElementById(cfg.hiddenId);

                function open() {
                    // Close all other dropdowns first
                    document.querySelectorAll('[data-dropdown-panel]').forEach(function (p) {
                        if (p !== panel) {
                            p.classList.add('hidden');
                            const otherChevron = document.querySelector('[data-chevron-for="' + p.id + '"]');
                            if (otherChevron) otherChevron.style.transform = 'rotate(0deg)';
                            const otherBtn = document.querySelector('[data-btn-for="' + p.id + '"]');
                            if (otherBtn) otherBtn.classList.remove('border-blue-500', 'ring-2', 'ring-blue-500');
                        }
                    });
                    panel.classList.remove('hidden');
                    chevron.style.transform = 'rotate(180deg)';
                    btn.classList.add('border-blue-500', 'ring-2', 'ring-blue-500');
                }

                function close() {
                    panel.classList.add('hidden');
                    chevron.style.transform = 'rotate(0deg)';
                    btn.classList.remove('border-blue-500', 'ring-2', 'ring-blue-500');
                }

                // Tag elements for the generic close-all logic
                panel.setAttribute('data-dropdown-panel', '1');
                chevron.setAttribute('data-chevron-for', panel.id);
                btn.setAttribute('data-btn-for', panel.id);

                btn.addEventListener('click', function (e) {
                    e.stopPropagation();
                    panel.classList.contains('hidden') ? open() : close();
                });

                panel.addEventListener('click', function (e) {
                    const opt = e.target.closest('.' + cfg.optionClass);
                    if (!opt) return;

                    hidden.value = opt.dataset.value;
                    label.textContent = opt.dataset.label;
                    label.classList.remove('text-slate-400');
                    label.classList.add('text-slate-700');

                    // Highlight selected
                    panel.querySelectorAll('.' + cfg.optionClass).forEach(function (o) {
                        o.classList.remove('bg-blue-600', 'text-white');
                        o.classList.add('text-slate-700');
                    });
                    opt.classList.add('bg-blue-600', 'text-white');
                    opt.classList.remove('text-slate-700');

                    close();
                    if (cfg.onSelect) cfg.onSelect(opt.dataset.value, opt.dataset.label);
                });

                return { open, close };
            }

            // ── Upload Type Dropdown ──────────────────────────────────────────────────
            const fileUploadArea = document.getElementById('fileUploadArea');

            makeDropdown({
                btnId: 'uploadTypeBtn',
                panelId: 'uploadTypePanel',
                labelId: 'uploadTypeLabel',
                chevronId: 'uploadTypeChevron',
                hiddenId: 'uploadTypeHidden',
                optionClass: 'upload-type-option',
                onSelect: function (value) {
                    fileUploadArea.classList.toggle('hidden', !value);
                }
            });

            // ── Template Dropdown ─────────────────────────────────────────────────────
            const downloadBtnWrapper = document.getElementById('downloadBtnWrapper');

            makeDropdown({
                btnId: 'templateDropdownBtn',
                panelId: 'templateDropdownPanel',
                labelId: 'templateDropdownLabel',
                chevronId: 'templateDropdownChevron',
                hiddenId: 'templateHiddenInput',
                optionClass: 'template-option',
                onSelect: function () {
                    downloadBtnWrapper.classList.remove('hidden');
                }
            });

            // ── Close all dropdowns on outside click / Escape ─────────────────────────
            document.addEventListener('click', function () {
                document.querySelectorAll('[data-dropdown-panel]').forEach(function (p) {
                    p.classList.add('hidden');
                });
                document.querySelectorAll('[data-btn-for]').forEach(function (b) {
                    b.classList.remove('border-blue-500', 'ring-2', 'ring-blue-500');
                });
                document.querySelectorAll('[data-chevron-for]').forEach(function (c) {
                    c.style.transform = 'rotate(0deg)';
                });
            });

            document.addEventListener('keydown', function (e) {
                if (e.key === 'Escape') {
                    document.querySelectorAll('[data-dropdown-panel]').forEach(function (p) {
                        p.classList.add('hidden');
                    });
                    document.querySelectorAll('[data-btn-for]').forEach(function (b) {
                        b.classList.remove('border-blue-500', 'ring-2', 'ring-blue-500');
                    });
                    document.querySelectorAll('[data-chevron-for]').forEach(function (c) {
                        c.style.transform = 'rotate(0deg)';
                    });
                }
            });

            // ── File input handling ───────────────────────────────────────────────────
            const fileInput = document.getElementById('fileInput');
            const dropZone = document.getElementById('dropZone');
            const filePreview = document.getElementById('filePreview');
            const fileNameText = document.getElementById('fileNameText');
            const fileSizeText = document.getElementById('fileSizeText');
            const removeFileBtn = document.getElementById('removeFileBtn');
            const uploadBtn = document.getElementById('uploadBtn');

            function formatSize(bytes) {
                if (bytes < 1024) return bytes + ' B';
                if (bytes < 1048576) return (bytes / 1024).toFixed(1) + ' KB';
                return (bytes / 1048576).toFixed(1) + ' MB';
            }

            function showFile(file) {
                fileNameText.textContent = file.name;
                fileSizeText.textContent = formatSize(file.size);
                filePreview.classList.remove('hidden');
                dropZone.classList.add('hidden');
                uploadBtn.disabled = false;
            }

            function clearFile() {
                fileInput.value = '';
                filePreview.classList.add('hidden');
                dropZone.classList.remove('hidden');
                uploadBtn.disabled = true;
            }

            fileInput.addEventListener('change', function () {
                if (this.files[0]) showFile(this.files[0]);
            });

            removeFileBtn.addEventListener('click', clearFile);

            dropZone.addEventListener('dragover', function (e) {
                e.preventDefault();
                this.classList.add('border-blue-400', 'bg-blue-50');
            });
            dropZone.addEventListener('dragleave', function () {
                this.classList.remove('border-blue-400', 'bg-blue-50');
            });
            dropZone.addEventListener('drop', function (e) {
                e.preventDefault();
                this.classList.remove('border-blue-400', 'bg-blue-50');
                const file = e.dataTransfer.files[0];
                if (file) showFile(file);
            });

        })();
    </script>
@endsection