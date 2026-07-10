<div id="tab-media" class="tab-content hidden flex-col gap-6">

    <div class="mb-8">
        <h2 class="text-2xl font-bold text-slate-800 mb-6">Visuals</h2>

        <!-- ===================== Photos Section ===================== -->
        <div class="bg-white rounded-2xl shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] border border-slate-200 mb-4">
            <div class="flex items-center justify-between p-6">
                <div>
                    <h2 class="text-[18px] font-bold text-slate-800">Photos</h2>
                    <p class="text-[14px] text-slate-500 mt-1">Upload the image of products. Only JPG, PNG, & SVG format
                        can be uploaded.</p>
                </div>
                <button type="button" onclick="document.getElementById('photoUpload').click()"
                    class="bg-slate-100 hover:bg-slate-200 text-slate-700 px-4 py-2.5 rounded-lg text-[14px] font-medium flex items-center gap-2 transition-colors shrink-0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Add New
                </button>
            </div>
            <input type="file" id="photoUpload" class="hidden" accept="image/jpeg,image/png,image/svg+xml" multiple>
            <!-- Table -->
            <div class="border-t border-slate-100" id="savedPhotosContainer">
                <!-- Column Headers -->
                <div class="grid grid-cols-[72px_1fr_120px_104px] px-6 py-2.5 bg-slate-50 border-b border-slate-100">
                    <span class="text-[12px] font-semibold text-slate-400 uppercase tracking-wide">Preview</span>
                    <span class="text-[12px] font-semibold text-slate-400 uppercase tracking-wide">File Name</span>
                    <span class="text-[12px] font-semibold text-slate-400 uppercase tracking-wide">Size</span>
                    <span
                        class="text-[12px] font-semibold text-slate-400 uppercase tracking-wide text-right">Actions</span>
                </div>
                <div id="photoRowsBody">
                    <div class="flex items-center justify-center py-10 text-[14px] text-slate-500" id="photoEmptyState">
                        No photos found.
                    </div>
                </div>
            </div>
            <!-- Pending upload preview -->
            <div id="photoPendingSection" class="hidden px-6 pb-4 pt-3 border-t border-slate-100">
                <div class="flex items-center gap-3 flex-wrap mb-3" id="photoPreview"></div>
                <button type="button" onclick="savePhotos()"
                    class="bg-[#2563eb] hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-[13px] font-medium transition-colors">
                    Save Photos
                </button>
            </div>
        </div>

        <!-- ===================== 360° View Section ===================== -->
        <div class="bg-white rounded-2xl shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] border border-slate-200 mb-4">
            <div class="flex items-center justify-between p-6">
                <div>
                    <h2 class="text-[18px] font-bold text-slate-800">360° View</h2>
                    <p class="text-[14px] text-slate-500 mt-1">Add the 360° view link or upload a vision 360 HTML file.
                    </p>
                </div>
                <button type="button" onclick="document.getElementById('view360Upload').click()"
                    class="bg-slate-100 hover:bg-slate-200 text-slate-700 px-4 py-2.5 rounded-lg text-[14px] font-medium flex items-center gap-2 transition-colors shrink-0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Add New
                </button>
            </div>
            <input type="file" id="view360Upload" class="hidden" accept=".html,text/html,.zip,.rar">
            <!-- Table -->
            <div class="border-t border-slate-100">
                <div class="grid grid-cols-[56px_1fr_120px_104px] px-6 py-2.5 bg-slate-50 border-b border-slate-100">
                    <span class="text-[12px] font-semibold text-slate-400 uppercase tracking-wide">Icon</span>
                    <span class="text-[12px] font-semibold text-slate-400 uppercase tracking-wide">File Name</span>
                    <span class="text-[12px] font-semibold text-slate-400 uppercase tracking-wide">Type</span>
                    <span
                        class="text-[12px] font-semibold text-slate-400 uppercase tracking-wide text-right">Actions</span>
                </div>
                <div id="view360RowsBody">
                    <div class="flex items-center justify-center py-10 text-[14px] text-slate-500"
                        id="view360EmptyState">
                        No 360° view found.
                    </div>
                </div>
            </div>
            <div id="saved360ViewContainer" class="hidden"></div>
            <!-- Pending upload preview -->
            <div id="view360PendingSection" class="hidden px-6 pb-4 pt-3 border-t border-slate-100">
                <div class="flex items-center gap-3 flex-wrap mb-3" id="view360Preview"></div>
                <button type="button" onclick="save360View()"
                    class="bg-[#2563eb] hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-[13px] font-medium transition-colors">
                    Save 360° View
                </button>
            </div>
        </div>

        <!-- ===================== Product Video Section ===================== -->
        <div class="bg-white rounded-2xl shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] border border-slate-200 mb-8">
            <div class="flex items-center justify-between p-6">
                <div>
                    <h2 class="text-[18px] font-bold text-slate-800">Product Video</h2>
                    <p class="text-[14px] text-slate-500 mt-1">Add the video of products. Upload MP4/WebM or add a
                        YouTube/Vimeo link.</p>
                </div>
                <button type="button" onclick="document.getElementById('videoUpload').click()"
                    class="bg-slate-100 hover:bg-slate-200 text-slate-700 px-4 py-2.5 rounded-lg text-[14px] font-medium flex items-center gap-2 transition-colors shrink-0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Add New
                </button>
            </div>
            <input type="file" id="videoUpload" class="hidden" accept="video/mp4,video/webm,video/ogg">
            <!-- Table -->
            <div class="border-t border-slate-100">
                <div class="grid grid-cols-[72px_1fr_120px_104px] px-6 py-2.5 bg-slate-50 border-b border-slate-100">
                    <span class="text-[12px] font-semibold text-slate-400 uppercase tracking-wide">Preview</span>
                    <span class="text-[12px] font-semibold text-slate-400 uppercase tracking-wide">File Name</span>
                    <span class="text-[12px] font-semibold text-slate-400 uppercase tracking-wide">Size</span>
                    <span
                        class="text-[12px] font-semibold text-slate-400 uppercase tracking-wide text-right">Actions</span>
                </div>
                <div id="videoRowsBody">
                    <div class="flex items-center justify-center py-10 text-[14px] text-slate-500" id="videoEmptyState">
                        No video found.
                    </div>
                </div>
            </div>
            <div id="savedVideosContainer" class="hidden"></div>
            <!-- Pending upload preview -->
            <div id="videoPendingSection" class="hidden px-6 pb-4 pt-3 border-t border-slate-100">
                <div class="flex items-center gap-3 flex-wrap mb-3" id="videoPreview"></div>
                <button type="button" onclick="saveVideos()"
                    class="bg-[#2563eb] hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-[13px] font-medium transition-colors">
                    Save Video
                </button>
            </div>
        </div>
    </div>



    {{-- Certificates Section --}}
    <div class="bg-white rounded-2xl shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] border border-slate-200">
        <div class="flex items-center justify-between p-6">
            <div>
                <h2 class="text-[18px] font-bold text-slate-800">Certificates</h2>
                <p class="text-[14px] text-slate-500 mt-1">Lab certificate of my gemstone(s) e.g "GRS, GIA, Lotus".</p>
            </div>
            <button type="button" onclick="openModal('certModal')"
                class="bg-slate-100 hover:bg-slate-200 text-slate-700 px-4 py-2.5 rounded-lg text-[14px] font-medium flex items-center gap-2 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Add New
            </button>
        </div>
        <div class="border-t border-slate-100">
            <div id="certContainer" class="divide-y divide-slate-100">
                <div id="certEmptyState" class="p-8 flex justify-center items-center py-12">
                    <span class="text-[14px] text-slate-500">No Certificates found.</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Documents Section --}}
    <div class="bg-white rounded-2xl shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] border border-slate-200">
        <div class="flex items-center justify-between p-6">
            <div>
                <h2 class="text-[18px] font-bold text-slate-800">Documents</h2>
                <p class="text-[14px] text-slate-500 mt-1">Add additional documents e.g "Importing shipping document".
                </p>
            </div>
            <button type="button" onclick="openModal('docModal')"
                class="bg-slate-100 hover:bg-slate-200 text-slate-700 px-4 py-2.5 rounded-lg text-[14px] font-medium flex items-center gap-2 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Add New
            </button>
        </div>
        <div class="border-t border-slate-100">
            <div id="docContainer" class="divide-y divide-slate-100">
                <div id="docEmptyState" class="p-8 flex justify-center items-center py-12">
                    <span class="text-[14px] text-slate-500">No documents found.</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Traceability info Section --}}
    <div class="bg-white rounded-2xl shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] border border-slate-200">
        <div class="flex items-center justify-between p-6">
            <div>
                <h2 class="text-[18px] font-bold text-slate-800">Traceability info</h2>
                <p class="text-[14px] text-slate-500 mt-1">Traceability information that can be attached to my
                    gemstone(s)<br>e.g "Purchasing invoice from a mining company".</p>
            </div>
            <button type="button" onclick="openModal('traceModal')"
                class="bg-slate-100 hover:bg-slate-200 text-slate-700 px-4 py-2.5 rounded-lg text-[14px] font-medium flex items-center gap-2 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Add New
            </button>
        </div>
        <div class="border-t border-slate-100">
            <div id="traceContainer" class="divide-y divide-slate-100">
                <div id="traceEmptyState" class="p-8 flex justify-center items-center py-12">
                    <span class="text-[14px] text-slate-500">No traceability documents found.</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Wizard Navigation --}}
    <div class="flex justify-between items-center mt-6 pt-4 border-t border-slate-200">
        <button type="button" class="btn-prev bg-white border border-slate-300 hover:bg-slate-50 text-slate-700 px-6 py-2.5 rounded-lg text-[13px] font-medium flex items-center gap-2 transition-colors shadow-sm" data-prev="tab-pricing">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            Previous
        </button>
        <button type="button" class="btn-save bg-[#2563eb] hover:bg-blue-700 text-white px-8 py-2.5 rounded-lg text-[13px] font-medium flex items-center gap-2 transition-colors shadow-sm" onclick="document.getElementById('productForm').submit();">
            Save
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
        </button>
    </div>

    {{-- MODALS --}}

    {{-- Certificate Modal --}}
    <div id="certModal" class="fixed inset-0 z-[10000] hidden items-center justify-center bg-black/50 backdrop-blur-sm">
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-lg mx-4 overflow-hidden">
            <div class="flex justify-between items-center p-6 pb-2">
                <h3 class="text-[18px] font-bold text-slate-800">Add lab certificate</h3>
                <button type="button" onclick="closeModal('certModal')"
                    class="text-slate-400 hover:text-slate-600 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>
            <div class="p-6 space-y-4">
                <div class="form-group !mb-0">
                    <label class="!text-[14px] !font-medium !text-slate-700 !mb-1">Certificate Lab*</label>
                    <div class="relative w-full custom-select-wrapper" id="certificateLabSelect">
                        <button type="button" class="form-control flex items-center pl-3 pr-8 text-left !bg-white">
                            <span
                                class="truncate text-slate-800 selected-text">{{ $certificateLabs->first()->lab_name ?? 'Select' }}</span>
                        </button>
                        <input type="hidden" name="certificate_lab" id="certificate_lab_input"
                            value="{{ $certificateLabs->first()->idtbl_certificate_labs ?? '' }}">
                        <div class="custom-dropdown-panel z-50">
                            @foreach($certificateLabs as $lab)
                                <div class="p-2 hover:bg-slate-50 cursor-pointer text-[13px] px-3 dd-item"
                                    data-id="{{ $lab->idtbl_certificate_labs }}">{{ $lab->lab_name }}</div>
                            @endforeach
                            <div class="border-t border-slate-200 p-2 hover:bg-slate-50 cursor-pointer text-[13px] px-3 text-[#2563eb] font-medium flex items-center gap-1"
                                onclick="openModal('createCertLabModal')">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v16m8-8H4"></path>
                                </svg>
                                Create New
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group !mb-0">
                    <label class="!text-[14px] !font-medium !text-slate-700 !mb-1">Report number</label>
                    <input type="text" id="cert_report_number" placeholder="e.g 10284528"
                        class="form-control w-full px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:border-[#2563eb]">
                </div>
                <div class="form-group !mb-0">
                    <label class="!text-[14px] !font-medium !text-slate-700 !mb-1">Certificate URL</label>
                    <input type="text" id="cert_url" placeholder="e.g. www.gemtrademanager.com"
                        class="form-control w-full px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:border-[#2563eb]">
                </div>
                <div class="form-group !mb-0">
                    <label class="!text-[14px] !font-medium !text-slate-700 !mb-1">Choose certificate file</label>
                    <div class="flex items-center border border-slate-200 rounded-lg overflow-hidden bg-white">
                        <label
                            class="px-4 py-2 bg-slate-100 border-r border-slate-200 text-slate-700 text-[14px] font-medium cursor-pointer hover:bg-slate-200 transition-colors">
                            Choose File
                            <input type="file" id="cert_file" class="hidden">
                        </label>
                        <span class="px-3 text-slate-500 text-[14px]">No file chosen</span>
                    </div>
                </div>
            </div>
            <div class="p-6 pt-2 flex justify-end">
                <button type="button" onclick="saveCertificate(event)"
                    class="bg-[#2563eb] hover:bg-blue-700 text-white px-5 py-2.5 rounded-lg text-[14px] font-medium flex items-center gap-2 transition-colors shadow-sm">
                    Submit
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    {{-- Document Modal --}}
    <div id="docModal" class="fixed inset-0 z-[10000] hidden items-center justify-center bg-black/50 backdrop-blur-sm">
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-lg mx-4 overflow-hidden">
            <div class="flex justify-between items-center p-6 pb-2">
                <h3 class="text-[18px] font-bold text-slate-800">Add document(s)</h3>
                <button type="button" onclick="closeModal('docModal')"
                    class="text-slate-400 hover:text-slate-600 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>
            <div class="p-6 space-y-4">
                <div class="form-group !mb-0">
                    <label class="!text-[14px] !font-medium !text-slate-700 !mb-1">Title*</label>
                    <input type="text" id="doc_title" placeholder="Add title here"
                        class="form-control w-full px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:border-[#2563eb]">
                </div>
                <div class="form-group !mb-0">
                    <label class="!text-[14px] !font-medium !text-slate-700 !mb-1">Description</label>
                    <textarea id="doc_description" placeholder="Add description here"
                        class="form-control w-full px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:border-[#2563eb] min-h-[100px] resize-y"></textarea>
                </div>
                <div class="form-group !mb-0">
                    <label class="!text-[14px] !font-medium !text-slate-700 !mb-1">Note File (2MB Max)</label>
                    <div class="flex items-center border border-slate-200 rounded-lg overflow-hidden bg-white">
                        <label
                            class="px-4 py-2 bg-slate-100 border-r border-slate-200 text-slate-700 text-[14px] font-medium cursor-pointer hover:bg-slate-200 transition-colors">
                            Choose File
                            <input type="file" id="doc_file" class="hidden">
                        </label>
                        <span class="px-3 text-slate-500 text-[14px]">No file chosen</span>
                    </div>
                </div>
            </div>
            <div class="p-6 pt-2 flex justify-end">
                <button type="button" onclick="saveDocument(event)"
                    class="bg-[#2563eb] hover:bg-blue-700 text-white px-6 py-2.5 rounded-lg text-[14px] font-medium transition-colors shadow-sm">
                    Upload
                </button>
            </div>
        </div>
    </div>

    {{-- Traceability Modal --}}
    <div id="traceModal"
        class="fixed inset-0 z-[10000] hidden items-center justify-center bg-black/50 backdrop-blur-sm">
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-lg mx-4 overflow-hidden">
            <div class="flex justify-between items-center p-6 pb-2">
                <h3 class="text-[18px] font-bold text-slate-800">Add traceability info</h3>
                <button type="button" onclick="closeModal('traceModal')"
                    class="text-slate-400 hover:text-slate-600 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>
            <div class="p-6 space-y-4">
                <div class="form-group !mb-0">
                    <label class="!text-[14px] !font-medium !text-slate-700 !mb-1">Title</label>
                    <input type="text" id="trace_title" placeholder="e.g. mining information"
                        class="form-control w-full px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:border-[#2563eb]">
                </div>
                <div class="form-group !mb-0">
                    <label class="!text-[14px] !font-medium !text-slate-700 !mb-1">Description</label>
                    <textarea id="trace_description"
                        class="form-control w-full px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:border-[#2563eb] min-h-[100px] resize-y"></textarea>
                </div>
                <div class="form-group !mb-0">
                    <label class="!text-[14px] !font-medium !text-slate-700 !mb-1">Traceability File (2MB Max)</label>
                    <div class="flex items-center border border-slate-200 rounded-lg overflow-hidden bg-white">
                        <label
                            class="px-4 py-2 bg-slate-100 border-r border-slate-200 text-slate-700 text-[14px] font-medium cursor-pointer hover:bg-slate-200 transition-colors">
                            Choose File
                            <input type="file" id="trace_file" class="hidden">
                        </label>
                        <span class="px-3 text-slate-500 text-[14px]">No file chosen</span>
                    </div>
                </div>
            </div>
            <div class="p-6 pt-2 flex justify-end">
                <button type="button" onclick="saveTraceability(event)"
                    class="bg-[#2563eb] hover:bg-blue-700 text-white px-5 py-2.5 rounded-lg text-[14px] font-medium flex items-center gap-2 transition-colors shadow-sm">
                    Submit
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    {{-- Create Certificate Lab Modal --}}
    <div id="createCertLabModal"
        class="fixed inset-0 z-[10000] hidden items-center justify-center bg-black/50 backdrop-blur-sm">
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-sm mx-4 overflow-hidden">
            <div class="flex justify-between items-center p-6 pb-2">
                <h3 class="text-[18px] font-bold text-slate-800">Create new value</h3>
                <button type="button" onclick="closeModal('createCertLabModal')"
                    class="text-slate-400 hover:text-slate-600 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>
            <div class="p-6 space-y-4">
                <div class="form-group !mb-0">
                    <label class="!text-[14px] !font-medium !text-slate-700 !mb-2">Lab Name*</label>
                    <input type="text" id="newCertLabName" placeholder="Enter lab name (e.g., GRS, GIA, Lotus)"
                        class="form-control w-full px-4 py-2.5 border border-slate-200 rounded-lg focus:outline-none focus:border-[#2563eb] focus:ring-2 focus:ring-blue-100">
                </div>
            </div>
            <div class="p-6 pt-2 flex justify-end gap-2">
                <button type="button" onclick="closeModal('createCertLabModal')"
                    class="px-4 py-2 border border-slate-200 text-slate-700 rounded-lg text-[14px] font-medium hover:bg-slate-50 transition-colors">
                    Cancel
                </button>
                <button type="button" onclick="createNewCertLab()"
                    class="bg-[#2563eb] hover:bg-blue-700 text-white px-5 py-2.5 rounded-lg text-[14px] font-medium flex items-center gap-2 transition-colors shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Create new
                </button>
            </div>
        </div>
    </div>

    {{-- Create Photo Type Modal --}}
    <div id="createPhotoTypeModal"
        class="fixed inset-0 z-[10000] hidden items-center justify-center bg-black/50 backdrop-blur-sm">
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-sm mx-4 overflow-hidden">
            <div class="flex justify-between items-center p-6 pb-2">
                <h3 class="text-[18px] font-bold text-slate-800">Create new value</h3>
                <button type="button" onclick="closeModal('createPhotoTypeModal')"
                    class="text-slate-400 hover:text-slate-600 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>
            <div class="p-6 space-y-4">
                <div class="form-group !mb-0">
                    <label class="!text-[14px] !font-medium !text-slate-700 !mb-2">Photo Type*</label>
                    <input type="text" id="newPhotoTypeName" placeholder="Enter photo type name"
                        class="form-control w-full px-4 py-2.5 border border-slate-200 rounded-lg focus:outline-none focus:border-[#2563eb] focus:ring-2 focus:ring-blue-100">
                </div>
            </div>
            <div class="p-6 pt-2 flex justify-end gap-2">
                <button type="button" onclick="closeModal('createPhotoTypeModal')"
                    class="px-4 py-2 border border-slate-200 text-slate-700 rounded-lg text-[14px] font-medium hover:bg-slate-50 transition-colors">
                    Cancel
                </button>
                <button type="button" onclick="createNewPhotoType()"
                    class="bg-[#2563eb] hover:bg-blue-700 text-white px-5 py-2.5 rounded-lg text-[14px] font-medium flex items-center gap-2 transition-colors shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Create new
                </button>
            </div>
        </div>
    </div>

    <script>
        // Photo Upload Event Listener
        document.getElementById('photoUpload')?.addEventListener('change', function (e) {
            if (e.target.files.length > 0) {
                displayPhotoPreview(e.target.files);
                document.getElementById('photoPendingSection').classList.remove('hidden');
            }
        });

        // Video Upload Event Listener
        document.getElementById('videoUpload')?.addEventListener('change', function (e) {
            if (e.target.files.length > 0) {
                displayVideoPreview(e.target.files);
                document.getElementById('videoPendingSection').classList.remove('hidden');
            }
        });

        // 360° View Upload Event Listener
        document.getElementById('view360Upload')?.addEventListener('change', function (e) {
            if (e.target.files.length > 0) {
                display360ViewPreview(e.target.files);
                document.getElementById('view360PendingSection').classList.remove('hidden');
            }
        });

        // Display Photo Preview (pending thumbnails)
        function displayPhotoPreview(files) {
            const previewContainer = document.getElementById('photoPreview');
            previewContainer.innerHTML = '';
            Array.from(files).forEach((file) => {
                const reader = new FileReader();
                reader.onload = function (e) {
                    const wrap = document.createElement('div');
                    wrap.className = 'relative group';
                    wrap.innerHTML = `<img src="${e.target.result}" class="w-16 h-16 rounded-lg object-cover border border-slate-200 shadow-sm" title="${file.name}">
                        <div class="absolute bottom-0 left-0 right-0 bg-black/50 text-white text-[9px] rounded-b-lg px-1 py-0.5 truncate">${file.name}</div>`;
                    previewContainer.appendChild(wrap);
                };
                reader.readAsDataURL(file);
            });
        }

        // Display Video Preview (pending)
        function displayVideoPreview(files) {
            const previewContainer = document.getElementById('videoPreview');
            previewContainer.innerHTML = '';
            if (files.length > 0) {
                const file = files[0];
                const reader = new FileReader();
                reader.onload = function (e) {
                    const wrap = document.createElement('div');
                    wrap.className = 'relative';
                    wrap.innerHTML = `<video src="${e.target.result}" class="w-24 h-16 rounded-lg object-cover border border-slate-200 shadow-sm" style="background:#f1f5f9"></video>
                        <div class="text-[10px] text-slate-500 truncate max-w-[96px] mt-1">${file.name}</div>`;
                    previewContainer.appendChild(wrap);
                };
                reader.readAsDataURL(file);
            }
        }

        // Display 360° View Preview (pending)
        function display360ViewPreview(files) {
            const previewContainer = document.getElementById('view360Preview');
            previewContainer.innerHTML = '';
            if (files.length > 0) {
                const file = files[0];
                let icon = '📁';
                if (file.name.endsWith('.html')) icon = '🌐';
                else if (file.name.endsWith('.zip') || file.name.endsWith('.rar')) icon = '📦';
                const wrap = document.createElement('div');
                wrap.className = 'flex items-center gap-3 px-4 py-2.5 bg-slate-50 rounded-lg border border-slate-200';
                wrap.innerHTML = `<span class="text-2xl">${icon}</span>
                    <div><div class="text-[13px] font-medium text-slate-700 truncate max-w-[200px]">${file.name}</div>
                    <div class="text-[11px] text-slate-400">${(file.size / 1024).toFixed(1)} KB</div></div>`;
                previewContainer.appendChild(wrap);
            }
        }

        // Save Photos
        function savePhotos() {
            const photoInput = document.getElementById('photoUpload');
            const files = photoInput.files;

            if (files.length === 0) {
                alert('Please select at least one photo to upload.');
                return;
            }

            const formData = new FormData();
            Array.from(files).forEach(file => {
                formData.append('photos[]', file);
            });

            // Show loading indicator
            const saveBtn = event.target;
            const originalText = saveBtn.textContent;
            saveBtn.textContent = 'Uploading...';
            saveBtn.disabled = true;

            fetch('/api/upload-photos', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                }
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Photos uploaded successfully!');
                        displaySavedPhotos(data.photos);
                        photoInput.value = '';
                        document.getElementById('photoPreview').innerHTML = '';
                    } else {
                        alert('Error: ' + (data.message || 'Failed to upload photos'));
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error uploading photos');
                })
                .finally(() => {
                    saveBtn.textContent = originalText;
                    saveBtn.disabled = false;
                });
        }

        // Save Videos
        function saveVideos() {
            const videoInput = document.getElementById('videoUpload');
            const files = videoInput.files;

            if (files.length === 0) {
                alert('Please select a video to upload.');
                return;
            }

            const formData = new FormData();
            formData.append('video', files[0]);

            // Show loading indicator
            const saveBtn = event.target;
            const originalText = saveBtn.textContent;
            saveBtn.textContent = 'Uploading...';
            saveBtn.disabled = true;

            fetch('/api/upload-video', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                }
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Video uploaded successfully!');
                        displaySavedVideo(data.video);
                        videoInput.value = '';
                        document.getElementById('videoPreview').innerHTML = '';
                    } else {
                        alert('Error: ' + (data.message || 'Failed to upload video'));
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error uploading video');
                })
                .finally(() => {
                    saveBtn.textContent = originalText;
                    saveBtn.disabled = false;
                });
        }

        // Save 360° View File
        function save360View() {
            const view360Input = document.getElementById('view360Upload');
            const files = view360Input.files;

            if (files.length === 0) {
                alert('Please select a 360° view file to upload.');
                return;
            }

            const formData = new FormData();
            formData.append('view360', files[0]);

            // Show loading indicator
            const saveBtn = event.target;
            const originalText = saveBtn.textContent;
            saveBtn.textContent = 'Uploading...';
            saveBtn.disabled = true;

            fetch('/api/upload-360view', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                }
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('360° view uploaded successfully!');
                        display360ViewSaved(data.view360_url, data.file_name);
                        view360Input.value = '';
                        document.getElementById('view360Preview').innerHTML = '';
                    } else {
                        alert('Error: ' + (data.message || 'Failed to upload 360° view'));
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error uploading 360° view');
                })
                .finally(() => {
                    saveBtn.textContent = originalText;
                    saveBtn.disabled = false;
                });
        }

        // Display Saved Photos (table row format)
        function displaySavedPhotos(photos) {
            const body = document.getElementById('photoRowsBody');
            const emptyState = document.getElementById('photoEmptyState');
            if (emptyState) emptyState.remove();

            photos.forEach((photo, idx) => {
                const photoUrl = typeof photo === 'string' ? photo : photo.url;
                const fileName = typeof photo === 'object' && photo.name ? photo.name : photoUrl.split('/').pop();
                const fileSize = typeof photo === 'object' && photo.size ? (photo.size / 1024).toFixed(1) + ' KB' : '—';

                const row = document.createElement('div');
                row.className = 'grid grid-cols-[56px_1fr_120px_100px] items-center px-4 py-3 border-b border-slate-100 hover:bg-slate-50 transition-colors last:border-b-0';
                row.dataset.photoUrl = photoUrl;
                row.innerHTML = `
                    <div>
                        <img src="${photoUrl}" class="w-10 h-10 rounded-lg object-cover border border-slate-200 cursor-pointer hover:shadow-md transition-shadow" onclick="viewImage('${photoUrl}')" title="View">
                    </div>
                    <div class="text-[13px] text-slate-700 font-medium truncate pr-3">${fileName}</div>
                    <div class="text-[12px] text-slate-400">${fileSize}</div>
                    <div class="flex justify-end gap-2">
                        <button type="button" onclick="viewImage('${photoUrl}')" class="p-1.5 rounded-lg text-slate-500 hover:text-[#2563eb] hover:bg-blue-50 transition-colors" title="View">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        </button>
                        <button type="button" onclick="deletePhoto('${photoUrl}', this)" class="p-1.5 rounded-lg text-slate-500 hover:text-red-500 hover:bg-red-50 transition-colors" title="Delete">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        </button>
                    </div>
                `;
                body.appendChild(row);
            });
        }

        // Display Saved Video (table row format)
        function displaySavedVideo(videoUrl, fileName, fileSize) {
            const body = document.getElementById('videoRowsBody');
            const emptyState = document.getElementById('videoEmptyState');
            if (emptyState) emptyState.remove();

            fileName = fileName || videoUrl.split('/').pop();
            fileSize = fileSize ? (fileSize / 1024).toFixed(1) + ' KB' : '—';

            const row = document.createElement('div');
            row.className = 'grid grid-cols-[72px_1fr_120px_100px] items-center px-4 py-3 border-b border-slate-100 hover:bg-slate-50 transition-colors last:border-b-0';
            row.innerHTML = `
                <div>
                    <div class="w-14 h-10 rounded-lg border border-slate-200 bg-slate-100 flex items-center justify-center">
                        <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664zM21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                </div>
                <div class="text-[13px] text-slate-700 font-medium truncate pr-3">${fileName}</div>
                <div class="text-[12px] text-slate-400">${fileSize}</div>
                <div class="flex justify-end gap-2">
                    <button type="button" onclick="window.open('${videoUrl}', '_blank')" class="p-1.5 rounded-lg text-slate-500 hover:text-[#2563eb] hover:bg-blue-50 transition-colors" title="View">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664zM21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </button>
                    <button type="button" onclick="deleteVideo('${videoUrl}', this)" class="p-1.5 rounded-lg text-slate-500 hover:text-red-500 hover:bg-red-50 transition-colors" title="Delete">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                    </button>
                </div>
            `;
            body.appendChild(row);
        }

        // View full image
        function viewImage(photoUrl) {
            const modal = document.createElement('div');
            modal.className = 'fixed inset-0 flex items-center justify-center cursor-pointer';
            modal.style.zIndex = '50000';
            modal.style.backgroundColor = 'rgba(0, 0, 0, 0.7)';
            modal.onclick = () => modal.remove();
            modal.innerHTML = `<img src="${photoUrl}" class="max-w-4xl max-h-[90vh] object-contain rounded-lg shadow-2xl">`;
            document.body.appendChild(modal);
        }

        // Delete Photo
        function deletePhoto(photoUrl, btn) {
            if (confirm('Are you sure you want to delete this photo?')) {
                fetch('/api/delete-photo', {
                    method: 'DELETE',
                    body: JSON.stringify({ photo_url: photoUrl }),
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                    }
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            btn.closest('.grid').remove();
                            alert('Photo deleted successfully!');
                        } else {
                            alert('Failed to delete photo');
                        }
                    })
                    .catch(error => console.error('Error:', error));
            }
        }

        // Delete Video
        function deleteVideo(videoUrl, btn) {
            if (confirm('Are you sure you want to delete this video?')) {
                fetch('/api/delete-video', {
                    method: 'DELETE',
                    body: JSON.stringify({ video_url: videoUrl }),
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                    }
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            btn.closest('.grid').remove();
                            alert('Video deleted successfully!');
                        } else {
                            alert('Failed to delete video');
                        }
                    })
                    .catch(error => console.error('Error:', error));
            }
        }

        // Display Saved 360° View (table row format)
        function display360ViewSaved(view360Url, fileName, fileSize) {
            const body = document.getElementById('view360RowsBody');
            const emptyState = document.getElementById('view360EmptyState');
            if (emptyState) emptyState.remove();

            let iconEmoji = '📁';
            let iconLabel = 'File';
            if (fileName.endsWith('.html')) { iconEmoji = '🌐'; iconLabel = 'HTML'; }
            else if (fileName.endsWith('.zip')) { iconEmoji = '📦'; iconLabel = 'ZIP'; }
            else if (fileName.endsWith('.rar')) { iconEmoji = '📦'; iconLabel = 'RAR'; }

            fileSize = fileSize ? (fileSize / 1024).toFixed(1) + ' KB' : '—';

            const row = document.createElement('div');
            row.className = 'grid grid-cols-[56px_1fr_120px_100px] items-center px-4 py-3 border-b border-slate-100 hover:bg-slate-50 transition-colors last:border-b-0';
            row.innerHTML = `
                <div class="w-10 h-10 rounded-lg bg-slate-100 border border-slate-200 flex items-center justify-center text-xl">${iconEmoji}</div>
                <div class="text-[13px] text-slate-700 font-medium truncate pr-3">${fileName}</div>
                <div class="text-[12px] text-slate-400">${iconLabel}</div>
                <div class="flex justify-end gap-2">
                    <button type="button" onclick="window.open('${view360Url}', '_blank')" class="p-1.5 rounded-lg text-slate-500 hover:text-[#2563eb] hover:bg-blue-50 transition-colors" title="View">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                    </button>
                    <button type="button" onclick="delete360View('${view360Url}', this)" class="p-1.5 rounded-lg text-slate-500 hover:text-red-500 hover:bg-red-50 transition-colors" title="Delete">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                    </button>
                </div>
            `;
            body.appendChild(row);
        }

        // Delete 360° View
        function delete360View(view360Url, btn) {
            if (confirm('Are you sure you want to delete this 360° view?')) {
                fetch('/api/delete-360view', {
                    method: 'DELETE',
                    body: JSON.stringify({ view360_url: view360Url }),
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                    }
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            btn.closest('.grid').remove();
                            alert('360° view deleted successfully!');
                        } else {
                            alert('Failed to delete 360° view');
                        }
                    })
                    .catch(error => console.error('Error:', error));
            }
        }

        function openModal(modalId) {
            const modal = document.getElementById(modalId);
            if (modal) {
                modal.classList.remove('hidden');
                modal.classList.add('flex');
            }
        }

        function closeModal(modalId) {
            const modal = document.getElementById(modalId);
            if (modal) {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }
        }

        // Create New Certificate Lab
        function createNewCertLab() {
            const labName = document.getElementById('newCertLabName').value.trim();

            if (!labName) {
                alert('Please enter a lab name');
                return;
            }

            const btn = event.target;
            const originalText = btn.textContent;
            btn.textContent = 'Creating...';
            btn.disabled = true;

            fetch('/api/create-certificate-lab', {
                method: 'POST',
                body: JSON.stringify({ lab_name: labName }),
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                }
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Certificate lab created successfully!');

                        // Add to dropdown
                        const dropdown = document.querySelector('.custom-dropdown-panel');
                        if (dropdown) {
                            const newOption = document.createElement('div');
                            newOption.className = 'p-2 hover:bg-slate-50 cursor-pointer text-[13px] px-3 dd-item';
                            newOption.dataset.id = data.lab_id;
                            newOption.textContent = labName;
                            dropdown.insertBefore(newOption, dropdown.querySelector('.border-t'));

                            // Set as selected
                            document.querySelector('.selected-text').textContent = labName;
                            document.getElementById('certificate_lab_input').value = data.lab_id;
                        }

                        closeModal('createCertLabModal');
                        document.getElementById('newCertLabName').value = '';
                    } else {
                        alert('Error: ' + (data.message || 'Failed to create certificate lab'));
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error creating certificate lab');
                })
                .finally(() => {
                    btn.textContent = originalText;
                    btn.disabled = false;
                });
        }

        // Create New Photo Type
        function createNewPhotoType() {
            const photoTypeName = document.getElementById('newPhotoTypeName').value.trim();

            if (!photoTypeName) {
                alert('Please enter a photo type name');
                return;
            }

            const btn = event.target;
            const originalText = btn.textContent;
            btn.textContent = 'Creating...';
            btn.disabled = true;

            fetch('/api/create-photo-type', {
                method: 'POST',
                body: JSON.stringify({ photo_type_name: photoTypeName }),
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                }
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Photo type created successfully!');
                        closeModal('createPhotoTypeModal');
                        document.getElementById('newPhotoTypeName').value = '';
                    } else {
                        alert('Error: ' + (data.message || 'Failed to create photo type'));
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error creating photo type');
                })
                .finally(() => {
                    btn.textContent = originalText;
                    btn.disabled = false;
                });
        }

        // Handle file inputs to show selected filename
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('input[type="file"]').forEach(input => {
                input.addEventListener('change', function (e) {
                    const fileName = e.target.files[0] ? e.target.files[0].name : 'No file chosen';
                    const fileNameSpan = e.target.closest('label').nextElementSibling;
                    if (fileNameSpan) {
                        fileNameSpan.textContent = fileName;
                        fileNameSpan.classList.remove('text-slate-500');
                        fileNameSpan.classList.add('text-slate-800');
                    }
                });
            });
        });

        // Save Certificate
        function saveCertificate(event) {
            const labInput = document.getElementById('certificate_lab_input').value;
            const labText = document.querySelector('#certificateLabSelect .selected-text').innerText;
            const reportInput = document.getElementById('cert_report_number').value.trim();
            const urlInput = document.getElementById('cert_url').value.trim();
            const fileInput = document.getElementById('cert_file').files;

            const formData = new FormData();
            formData.append('certificate_lab', labInput);
            formData.append('certificate_lab_name', labText);
            formData.append('report_number', reportInput);
            formData.append('certificate_url', urlInput);
            if (fileInput.length > 0) {
                formData.append('file', fileInput[0]);
            }
            
            const btn = event.target.closest('button');
            const originalText = btn.innerHTML;
            btn.textContent = 'Saving...';
            btn.disabled = true;

            fetch('/api/upload-certificate', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                }
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    alert('Certificate uploaded successfully!');
                    displaySavedCertificate(data.data);
                    closeModal('certModal');
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error uploading certificate');
            })
            .finally(() => {
                btn.innerHTML = originalText;
                btn.disabled = false;
            });
        }

        function displaySavedCertificate(cert) {
            const container = document.getElementById('certContainer');
            const emptyState = document.getElementById('certEmptyState');
            if (emptyState) emptyState.remove();

            const row = document.createElement('div');
            row.className = 'grid grid-cols-[1fr_120px] sm:grid-cols-[1fr_200px_1fr_120px] items-center px-6 py-4 hover:bg-slate-50 transition-colors gap-4';
            row.innerHTML = `
                <div>
                    <div class="text-[14px] font-medium text-slate-800">${cert.lab}</div>
                    <div class="text-[12px] text-slate-500 mt-0.5">Report: ${cert.report_number || 'N/A'}</div>
                </div>
                <div class="text-[13px] text-slate-600 truncate">${cert.url || '-'}</div>
                <div class="text-[13px] text-slate-600 truncate">${cert.file_path ? cert.file_path.split('/').pop() : 'No file'}</div>
                <div class="flex justify-end gap-2">
                    ${cert.file_path ? `<button type="button" onclick="window.open('${cert.file_path}', '_blank')" class="p-1.5 rounded-lg text-slate-500 hover:text-[#2563eb] hover:bg-blue-50 transition-colors" title="View File"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg></button>` : ''}
                </div>
            `;
            container.appendChild(row);
        }

        // Save Document
        function saveDocument(event) {
            const titleInput = document.getElementById('doc_title').value.trim();
            const descInput = document.getElementById('doc_description').value.trim();
            const fileInput = document.getElementById('doc_file').files;

            if (!titleInput) {
                alert('Please enter a title');
                return;
            }

            const formData = new FormData();
            formData.append('title', titleInput);
            formData.append('description', descInput);
            if (fileInput.length > 0) {
                formData.append('file', fileInput[0]);
            }
            
            const btn = event.target.closest('button');
            const originalText = btn.innerHTML;
            btn.textContent = 'Saving...';
            btn.disabled = true;

            fetch('/api/upload-document', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                }
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    alert('Document uploaded successfully!');
                    displaySavedDocument(data.data);
                    closeModal('docModal');
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error uploading document');
            })
            .finally(() => {
                btn.innerHTML = originalText;
                btn.disabled = false;
            });
        }

        function displaySavedDocument(doc) {
            const container = document.getElementById('docContainer');
            const emptyState = document.getElementById('docEmptyState');
            if (emptyState) emptyState.remove();

            const row = document.createElement('div');
            row.className = 'flex items-center justify-between px-6 py-4 hover:bg-slate-50 transition-colors gap-4';
            row.innerHTML = `
                <div class="flex-1 min-w-0">
                    <div class="text-[14px] font-medium text-slate-800 truncate">${doc.title}</div>
                    <div class="text-[12px] text-slate-500 mt-0.5 line-clamp-1">${doc.description || ''}</div>
                </div>
                <div class="flex justify-end gap-2 shrink-0">
                    ${doc.file_path ? `<button type="button" onclick="window.open('${doc.file_path}', '_blank')" class="p-1.5 rounded-lg text-slate-500 hover:text-[#2563eb] hover:bg-blue-50 transition-colors" title="View File"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg></button>` : ''}
                </div>
            `;
            container.appendChild(row);
        }

        // Save Traceability
        function saveTraceability(event) {
            const titleInput = document.getElementById('trace_title').value.trim();
            const descInput = document.getElementById('trace_description').value.trim();
            const fileInput = document.getElementById('trace_file').files;

            const formData = new FormData();
            formData.append('title', titleInput);
            formData.append('description', descInput);
            if (fileInput.length > 0) {
                formData.append('file', fileInput[0]);
            }
            
            const btn = event.target.closest('button');
            const originalText = btn.innerHTML;
            btn.textContent = 'Saving...';
            btn.disabled = true;

            fetch('/api/upload-traceability', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                }
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    alert('Traceability uploaded successfully!');
                    displaySavedTraceability(data.data);
                    closeModal('traceModal');
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error uploading traceability document');
            })
            .finally(() => {
                btn.innerHTML = originalText;
                btn.disabled = false;
            });
        }

        function displaySavedTraceability(doc) {
            const container = document.getElementById('traceContainer');
            const emptyState = document.getElementById('traceEmptyState');
            if (emptyState) emptyState.remove();

            const row = document.createElement('div');
            row.className = 'flex items-center justify-between px-6 py-4 hover:bg-slate-50 transition-colors gap-4';
            row.innerHTML = `
                <div class="flex-1 min-w-0">
                    <div class="text-[14px] font-medium text-slate-800 truncate">${doc.title || 'Traceability Document'}</div>
                    <div class="text-[12px] text-slate-500 mt-0.5 line-clamp-1">${doc.description || ''}</div>
                </div>
                <div class="flex justify-end gap-2 shrink-0">
                    ${doc.file_path ? `<button type="button" onclick="window.open('${doc.file_path}', '_blank')" class="p-1.5 rounded-lg text-slate-500 hover:text-[#2563eb] hover:bg-blue-50 transition-colors" title="View File"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg></button>` : ''}
                </div>
            `;
            container.appendChild(row);
        }
    </script>
</div>