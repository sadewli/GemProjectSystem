<div id="tab-media" class="tab-content hidden flex-col gap-6">

    <div class="mb-8">
        <h2 class="text-2xl font-bold text-slate-800 mb-6">Visuals</h2>
        
        <div class="border-t border-slate-100 py-6">
            <h3 class="text-[15px] text-slate-800 font-medium mb-1">Photos</h3>
            <p class="text-[13px] text-slate-500 mb-4">Upload the image of products. Only JPG, PNG, & SVG format can be uploaded</p>
            <div class="w-[120px] h-[120px] bg-slate-50 border border-dashed border-slate-300 rounded-xl flex flex-col items-center justify-center cursor-pointer hover:bg-slate-100 transition-colors">
                <svg class="w-6 h-6 text-[#2563eb] mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                <span class="text-[12px] text-[#2563eb] font-medium">Upload</span>
            </div>
        </div>

        <div class="border-t border-slate-100 py-6">
            <h3 class="text-[15px] text-slate-800 font-medium mb-1">360° View</h3>
            <p class="text-[13px] text-slate-500 mb-4">Add the 360 view link or upload vision 360 HTML.</p>
            <div class="w-[120px] h-[120px] bg-slate-50 border border-dashed border-slate-300 rounded-xl flex flex-col items-center justify-center cursor-pointer hover:bg-slate-100 transition-colors">
                <svg class="w-6 h-6 text-[#2563eb] mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                <span class="text-[12px] text-[#2563eb] font-medium">Upload</span>
            </div>
        </div>

        <div class="border-t border-slate-100 py-6">
            <h3 class="text-[15px] text-slate-800 font-medium mb-1">Product Video</h3>
            <p class="text-[13px] text-slate-500 mb-4">Add the video of products. Add the Youtube/Vimeo link.</p>
            <div class="w-[120px] h-[120px] bg-slate-50 border border-dashed border-slate-300 rounded-xl flex flex-col items-center justify-center cursor-pointer hover:bg-slate-100 transition-colors">
                <svg class="w-6 h-6 text-[#2563eb] mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span class="text-[12px] text-[#2563eb] font-medium">Upload</span>
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
            <button type="button" onclick="openModal('certModal')" class="bg-slate-100 hover:bg-slate-200 text-slate-700 px-4 py-2.5 rounded-lg text-[14px] font-medium flex items-center gap-2 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Add New
            </button>
        </div>
        <div class="border-t border-slate-100 p-8 flex justify-center items-center py-12">
            <span class="text-[14px] text-slate-500">No Certificates found.</span>
        </div>
    </div>

    {{-- Documents Section --}}
    <div class="bg-white rounded-2xl shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] border border-slate-200">
        <div class="flex items-center justify-between p-6">
            <div>
                <h2 class="text-[18px] font-bold text-slate-800">Documents</h2>
                <p class="text-[14px] text-slate-500 mt-1">Add additional documents e.g "Importing shipping document".</p>
            </div>
            <button type="button" onclick="openModal('docModal')" class="bg-slate-100 hover:bg-slate-200 text-slate-700 px-4 py-2.5 rounded-lg text-[14px] font-medium flex items-center gap-2 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Add New
            </button>
        </div>
        <div class="border-t border-slate-100 p-8 flex justify-center items-center py-12">
            <span class="text-[14px] text-slate-500">No documents found.</span>
        </div>
    </div>

    {{-- Traceability info Section --}}
    <div class="bg-white rounded-2xl shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] border border-slate-200">
        <div class="flex items-center justify-between p-6">
            <div>
                <h2 class="text-[18px] font-bold text-slate-800">Traceability info</h2>
                <p class="text-[14px] text-slate-500 mt-1">Traceability information that can be attached to my gemstone(s)<br>e.g "Purchasing invoice from a mining company".</p>
            </div>
            <button type="button" onclick="openModal('traceModal')" class="bg-slate-100 hover:bg-slate-200 text-slate-700 px-4 py-2.5 rounded-lg text-[14px] font-medium flex items-center gap-2 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Add New
            </button>
        </div>
        <div class="border-t border-slate-100 p-8 flex justify-center items-center py-12">
            <span class="text-[14px] text-slate-500">No traceability documents found.</span>
        </div>
    </div>

    {{-- MODALS --}}

    {{-- Certificate Modal --}}
    <div id="certModal" class="fixed inset-0 z-[10000] hidden items-center justify-center bg-black/50 backdrop-blur-sm">
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-lg mx-4 overflow-hidden">
            <div class="flex justify-between items-center p-6 pb-2">
                <h3 class="text-[18px] font-bold text-slate-800">Add lab certificate</h3>
                <button type="button" onclick="closeModal('certModal')" class="text-slate-400 hover:text-slate-600 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            <div class="p-6 space-y-4">
                <div class="form-group !mb-0">
                    <label class="!text-[14px] !font-medium !text-slate-700 !mb-1">Certificate Lab*</label>
                    <div class="relative w-full custom-select-wrapper" id="certificateLabSelect">
                        <button type="button" class="form-control flex items-center pl-3 pr-8 text-left !bg-white">
                            <span class="truncate text-slate-800 selected-text">{{ $certificateLabs->first()->lab_name ?? 'Select' }}</span>
                        </button>
                        <input type="hidden" name="certificate_lab" id="certificate_lab_input" value="{{ $certificateLabs->first()->idtbl_certificate_labs ?? '' }}">
                        <div class="custom-dropdown-panel z-50">
                            @foreach($certificateLabs as $lab)
                                <div class="p-2 hover:bg-slate-50 cursor-pointer text-[13px] px-3 dd-item" data-id="{{ $lab->idtbl_certificate_labs }}">{{ $lab->lab_name }}</div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="form-group !mb-0">
                    <label class="!text-[14px] !font-medium !text-slate-700 !mb-1">Report number</label>
                    <input type="text" placeholder="e.g 10284528" class="form-control w-full px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:border-[#2563eb]">
                </div>
                <div class="form-group !mb-0">
                    <label class="!text-[14px] !font-medium !text-slate-700 !mb-1">Certificate URL</label>
                    <input type="text" placeholder="e.g. www.gemtrademanager.com" class="form-control w-full px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:border-[#2563eb]">
                </div>
                <div class="form-group !mb-0">
                    <label class="!text-[14px] !font-medium !text-slate-700 !mb-1">Choose certificate file</label>
                    <div class="flex items-center border border-slate-200 rounded-lg overflow-hidden bg-white">
                        <label class="px-4 py-2 bg-slate-100 border-r border-slate-200 text-slate-700 text-[14px] font-medium cursor-pointer hover:bg-slate-200 transition-colors">
                            Choose File
                            <input type="file" class="hidden">
                        </label>
                        <span class="px-3 text-slate-500 text-[14px]">No file chosen</span>
                    </div>
                </div>
            </div>
            <div class="p-6 pt-2 flex justify-end">
                <button type="button" class="bg-[#2563eb] hover:bg-blue-700 text-white px-5 py-2.5 rounded-lg text-[14px] font-medium flex items-center gap-2 transition-colors shadow-sm">
                    Submit
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                </button>
            </div>
        </div>
    </div>

    {{-- Document Modal --}}
    <div id="docModal" class="fixed inset-0 z-[10000] hidden items-center justify-center bg-black/50 backdrop-blur-sm">
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-lg mx-4 overflow-hidden">
            <div class="flex justify-between items-center p-6 pb-2">
                <h3 class="text-[18px] font-bold text-slate-800">Add document(s)</h3>
                <button type="button" onclick="closeModal('docModal')" class="text-slate-400 hover:text-slate-600 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            <div class="p-6 space-y-4">
                <div class="form-group !mb-0">
                    <label class="!text-[14px] !font-medium !text-slate-700 !mb-1">Title*</label>
                    <input type="text" placeholder="Add title here" class="form-control w-full px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:border-[#2563eb]">
                </div>
                <div class="form-group !mb-0">
                    <label class="!text-[14px] !font-medium !text-slate-700 !mb-1">Description</label>
                    <textarea placeholder="Add description here" class="form-control w-full px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:border-[#2563eb] min-h-[100px] resize-y"></textarea>
                </div>
                <div class="form-group !mb-0">
                    <label class="!text-[14px] !font-medium !text-slate-700 !mb-1">Note File (2MB Max)</label>
                    <div class="flex items-center border border-slate-200 rounded-lg overflow-hidden bg-white">
                        <label class="px-4 py-2 bg-slate-100 border-r border-slate-200 text-slate-700 text-[14px] font-medium cursor-pointer hover:bg-slate-200 transition-colors">
                            Choose File
                            <input type="file" class="hidden">
                        </label>
                        <span class="px-3 text-slate-500 text-[14px]">No file chosen</span>
                    </div>
                </div>
            </div>
            <div class="p-6 pt-2 flex justify-end">
                <button type="button" class="bg-[#2563eb] hover:bg-blue-700 text-white px-6 py-2.5 rounded-lg text-[14px] font-medium transition-colors shadow-sm">
                    Upload
                </button>
            </div>
        </div>
    </div>

    {{-- Traceability Modal --}}
    <div id="traceModal" class="fixed inset-0 z-[10000] hidden items-center justify-center bg-black/50 backdrop-blur-sm">
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-lg mx-4 overflow-hidden">
            <div class="flex justify-between items-center p-6 pb-2">
                <h3 class="text-[18px] font-bold text-slate-800">Add traceability info</h3>
                <button type="button" onclick="closeModal('traceModal')" class="text-slate-400 hover:text-slate-600 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            <div class="p-6 space-y-4">
                <div class="form-group !mb-0">
                    <label class="!text-[14px] !font-medium !text-slate-700 !mb-1">Title</label>
                    <input type="text" placeholder="e.g. mining information" class="form-control w-full px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:border-[#2563eb]">
                </div>
                <div class="form-group !mb-0">
                    <label class="!text-[14px] !font-medium !text-slate-700 !mb-1">Description</label>
                    <textarea class="form-control w-full px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:border-[#2563eb] min-h-[100px] resize-y"></textarea>
                </div>
                <div class="form-group !mb-0">
                    <label class="!text-[14px] !font-medium !text-slate-700 !mb-1">Traceability File (2MB Max)</label>
                    <div class="flex items-center border border-slate-200 rounded-lg overflow-hidden bg-white">
                        <label class="px-4 py-2 bg-slate-100 border-r border-slate-200 text-slate-700 text-[14px] font-medium cursor-pointer hover:bg-slate-200 transition-colors">
                            Choose File
                            <input type="file" class="hidden">
                        </label>
                        <span class="px-3 text-slate-500 text-[14px]">No file chosen</span>
                    </div>
                </div>
            </div>
            <div class="p-6 pt-2 flex justify-end">
                <button type="button" class="bg-[#2563eb] hover:bg-blue-700 text-white px-5 py-2.5 rounded-lg text-[14px] font-medium flex items-center gap-2 transition-colors shadow-sm">
                    Submit
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                </button>
            </div>
        </div>
    </div>

    <script>
        function openModal(modalId) {
            const modal = document.getElementById(modalId);
            if(modal) {
                modal.classList.remove('hidden');
                modal.classList.add('flex');
            }
        }

        function closeModal(modalId) {
            const modal = document.getElementById(modalId);
            if(modal) {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }
        }
        
        // Handle file inputs to show selected filename
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('input[type="file"]').forEach(input => {
                input.addEventListener('change', function(e) {
                    const fileName = e.target.files[0] ? e.target.files[0].name : 'No file chosen';
                    const fileNameSpan = e.target.closest('label').nextElementSibling;
                    if(fileNameSpan) {
                        fileNameSpan.textContent = fileName;
                        fileNameSpan.classList.remove('text-slate-500');
                        fileNameSpan.classList.add('text-slate-800');
                    }
                });
            });
        });
    </script>
</div>