<div id="tab-media" class="tab-content hidden flex-col gap-6">

    <div class="mb-8">
        <h2 class="text-2xl font-bold text-slate-800 mb-6">Visuals</h2>
        
        <!-- Photos Section -->
        <div class="border-t border-slate-100 py-6">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h3 class="text-[15px] text-slate-800 font-medium mb-1">Photos</h3>
                    <p class="text-[13px] text-slate-500">Upload the image of products. Only JPG, PNG, & SVG format can be uploaded</p>
                </div>
                <button type="button" onclick="openModal('createPhotoTypeModal')" class="bg-slate-100 hover:bg-slate-200 text-slate-700 px-3 py-2 rounded-lg text-[12px] font-medium flex items-center gap-1 transition-colors whitespace-nowrap ml-4">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Create New
                </button>
            </div>
            
            <!-- Upload Box -->
            <div class="flex items-center gap-4 mb-4">
                <div class="w-[120px] h-[120px] bg-slate-50 border border-dashed border-slate-300 rounded-xl flex flex-col items-center justify-center cursor-pointer hover:bg-slate-100 transition-colors" onclick="document.getElementById('photoUpload').click()">
                    <svg class="w-6 h-6 text-[#2563eb] mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    <span class="text-[12px] text-[#2563eb] font-medium">Upload</span>
                </div>
                <input type="file" id="photoUpload" class="hidden" accept="image/jpeg,image/png,image/svg+xml" multiple>
                
                <!-- Photo Preview -->
                <div id="photoPreview" class="flex gap-2"></div>
            </div>
            
            <!-- Save Button -->
            <button type="button" onclick="savePhotos()" class="bg-[#2563eb] hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-[13px] font-medium transition-colors">
                Save Photos
            </button>
            
            <!-- Display Saved Photos -->
            <div id="savedPhotosContainer" class="mt-4 flex flex-wrap gap-3"></div>
        </div>

        <!-- 360° View Section -->
        <div class="border-t border-slate-100 py-6">
            <h3 class="text-[15px] text-slate-800 font-medium mb-1">360° View</h3>
            <p class="text-[13px] text-slate-500 mb-4">Add the 360 view link or upload vision 360 HTML file.</p>
            
            <!-- Upload Box -->
            <div class="flex items-center gap-4 mb-4">
                <div class="w-[120px] h-[120px] bg-slate-50 border border-dashed border-slate-300 rounded-xl flex flex-col items-center justify-center cursor-pointer hover:bg-slate-100 transition-colors" onclick="document.getElementById('view360Upload').click()">
                    <svg class="w-6 h-6 text-[#2563eb] mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                    <span class="text-[12px] text-[#2563eb] font-medium">Upload</span>
                </div>
                <input type="file" id="view360Upload" class="hidden" accept=".html,text/html,.zip,.rar">
                
                <!-- 360 View Preview -->
                <div id="view360Preview" class="flex gap-2"></div>
            </div>
            
            <!-- Save Button -->
            <button type="button" onclick="save360View()" class="bg-[#2563eb] hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-[13px] font-medium transition-colors">
                Save 360° View
            </button>
            
            <!-- Display Saved 360 Views -->
            <div id="saved360ViewContainer" class="mt-4"></div>
        </div>

        <!-- Product Video Section -->
        <div class="border-t border-slate-100 py-6">
            <h3 class="text-[15px] text-slate-800 font-medium mb-1">Product Video</h3>
            <p class="text-[13px] text-slate-500 mb-4">Add the video of products. Add the Youtube/Vimeo link.</p>
            
            <!-- Upload Box -->
            <div class="flex items-center gap-4 mb-4">
                <div class="w-[120px] h-[120px] bg-slate-50 border border-dashed border-slate-300 rounded-xl flex flex-col items-center justify-center cursor-pointer hover:bg-slate-100 transition-colors" onclick="document.getElementById('videoUpload').click()">
                    <svg class="w-6 h-6 text-[#2563eb] mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span class="text-[12px] text-[#2563eb] font-medium">Upload</span>
                </div>
                <input type="file" id="videoUpload" class="hidden" accept="video/mp4,video/webm,video/ogg">
                
                <!-- Video Preview -->
                <div id="videoPreview" class="flex gap-2"></div>
            </div>
            
            <!-- Save Button -->
            <button type="button" onclick="saveVideos()" class="bg-[#2563eb] hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-[13px] font-medium transition-colors">
                Save Video
            </button>
            
            <!-- Display Saved Videos -->
            <div id="savedVideosContainer" class="mt-4"></div>
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
                            <div class="border-t border-slate-200 p-2 hover:bg-slate-50 cursor-pointer text-[13px] px-3 text-[#2563eb] font-medium flex items-center gap-1" onclick="openModal('createCertLabModal')">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                Create New
                            </div>
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

    {{-- Create Certificate Lab Modal --}}
    <div id="createCertLabModal" class="fixed inset-0 z-[10000] hidden items-center justify-center bg-black/50 backdrop-blur-sm">
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-sm mx-4 overflow-hidden">
            <div class="flex justify-between items-center p-6 pb-2">
                <h3 class="text-[18px] font-bold text-slate-800">Create new value</h3>
                <button type="button" onclick="closeModal('createCertLabModal')" class="text-slate-400 hover:text-slate-600 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            <div class="p-6 space-y-4">
                <div class="form-group !mb-0">
                    <label class="!text-[14px] !font-medium !text-slate-700 !mb-2">Lab Name*</label>
                    <input type="text" id="newCertLabName" placeholder="Enter lab name (e.g., GRS, GIA, Lotus)" class="form-control w-full px-4 py-2.5 border border-slate-200 rounded-lg focus:outline-none focus:border-[#2563eb] focus:ring-2 focus:ring-blue-100">
                </div>
            </div>
            <div class="p-6 pt-2 flex justify-end gap-2">
                <button type="button" onclick="closeModal('createCertLabModal')" class="px-4 py-2 border border-slate-200 text-slate-700 rounded-lg text-[14px] font-medium hover:bg-slate-50 transition-colors">
                    Cancel
                </button>
                <button type="button" onclick="createNewCertLab()" class="bg-[#2563eb] hover:bg-blue-700 text-white px-5 py-2.5 rounded-lg text-[14px] font-medium flex items-center gap-2 transition-colors shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Create new
                </button>
            </div>
        </div>
    </div>

    {{-- Create Photo Type Modal --}}
    <div id="createPhotoTypeModal" class="fixed inset-0 z-[10000] hidden items-center justify-center bg-black/50 backdrop-blur-sm">
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-sm mx-4 overflow-hidden">
            <div class="flex justify-between items-center p-6 pb-2">
                <h3 class="text-[18px] font-bold text-slate-800">Create new value</h3>
                <button type="button" onclick="closeModal('createPhotoTypeModal')" class="text-slate-400 hover:text-slate-600 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            <div class="p-6 space-y-4">
                <div class="form-group !mb-0">
                    <label class="!text-[14px] !font-medium !text-slate-700 !mb-2">Photo Type*</label>
                    <input type="text" id="newPhotoTypeName" placeholder="Enter photo type name" class="form-control w-full px-4 py-2.5 border border-slate-200 rounded-lg focus:outline-none focus:border-[#2563eb] focus:ring-2 focus:ring-blue-100">
                </div>
            </div>
            <div class="p-6 pt-2 flex justify-end gap-2">
                <button type="button" onclick="closeModal('createPhotoTypeModal')" class="px-4 py-2 border border-slate-200 text-slate-700 rounded-lg text-[14px] font-medium hover:bg-slate-50 transition-colors">
                    Cancel
                </button>
                <button type="button" onclick="createNewPhotoType()" class="bg-[#2563eb] hover:bg-blue-700 text-white px-5 py-2.5 rounded-lg text-[14px] font-medium flex items-center gap-2 transition-colors shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Create new
                </button>
            </div>
        </div>
    </div>

    <script>
        // Photo Upload Event Listener
        document.getElementById('photoUpload')?.addEventListener('change', function(e) {
            displayPhotoPreview(e.target.files);
        });

        // Video Upload Event Listener
        document.getElementById('videoUpload')?.addEventListener('change', function(e) {
            displayVideoPreview(e.target.files);
        });

        // 360° View Upload Event Listener
        document.getElementById('view360Upload')?.addEventListener('change', function(e) {
            display360ViewPreview(e.target.files);
        });

        // Display Photo Preview
        function displayPhotoPreview(files) {
            const previewContainer = document.getElementById('photoPreview');
            previewContainer.innerHTML = '';
            
            Array.from(files).forEach((file, index) => {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.className = 'w-[100px] h-[100px] rounded-lg object-cover border border-slate-200';
                    img.title = file.name;
                    previewContainer.appendChild(img);
                };
                reader.readAsDataURL(file);
            });
        }

        // Display Video Preview
        function displayVideoPreview(files) {
            const previewContainer = document.getElementById('videoPreview');
            previewContainer.innerHTML = '';
            
            if(files.length > 0) {
                const file = files[0];
                const reader = new FileReader();
                reader.onload = function(e) {
                    const video = document.createElement('video');
                    video.src = e.target.result;
                    video.className = 'w-[100px] h-[100px] rounded-lg object-cover border border-slate-200';
                    video.controls = true;
                    video.style.backgroundColor = '#f1f5f9';
                    previewContainer.appendChild(video);
                };
                reader.readAsDataURL(file);
            }
        }

        // Display 360° View Preview
        function display360ViewPreview(files) {
            const previewContainer = document.getElementById('view360Preview');
            previewContainer.innerHTML = '';
            
            if(files.length > 0) {
                const file = files[0];
                const previewBox = document.createElement('div');
                previewBox.className = 'w-[100px] h-[100px] rounded-lg border border-slate-200 bg-slate-50 flex flex-col items-center justify-center text-center p-2';
                
                // Create icon for file type
                let icon = '📁';
                if(file.name.endsWith('.html')) icon = '🌐';
                else if(file.name.endsWith('.zip') || file.name.endsWith('.rar')) icon = '📦';
                
                previewBox.innerHTML = `
                    <div class="text-2xl">${icon}</div>
                    <div class="text-[11px] text-slate-600 font-medium mt-1 truncate w-full">${file.name.substring(0, 15)}</div>
                    <div class="text-[10px] text-slate-500">${(file.size / 1024).toFixed(0)}KB</div>
                `;
                previewBox.title = file.name;
                previewContainer.appendChild(previewBox);
            }
        }

        // Save Photos
        function savePhotos() {
            const photoInput = document.getElementById('photoUpload');
            const files = photoInput.files;

            if(files.length === 0) {
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
                if(data.success) {
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

            if(files.length === 0) {
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
                if(data.success) {
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

            if(files.length === 0) {
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
                if(data.success) {
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

        // Display Saved Photos
        function displaySavedPhotos(photos) {
            const container = document.getElementById('savedPhotosContainer');
            
            photos.forEach(photoUrl => {
                const wrapper = document.createElement('div');
                wrapper.className = 'relative group';
                wrapper.innerHTML = `
                    <img src="${photoUrl}" class="w-[100px] h-[100px] rounded-lg object-cover border border-slate-200 cursor-pointer hover:shadow-lg transition-shadow" onclick="viewImage('${photoUrl}')">
                    <button type="button" onclick="deletePhoto('${photoUrl}')" class="absolute -top-2 -right-2 bg-red-500 hover:bg-red-600 text-white rounded-full w-6 h-6 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity text-xs font-bold">×</button>
                `;
                container.appendChild(wrapper);
            });
        }

        // Display Saved Video
        function displaySavedVideo(videoUrl) {
            const container = document.getElementById('savedVideosContainer');
            container.innerHTML = `
                <div class="relative group">
                    <video src="${videoUrl}" class="w-full max-w-md rounded-lg border border-slate-200 cursor-pointer" controls></video>
                    <button type="button" onclick="deleteVideo('${videoUrl}')" class="absolute -top-2 -right-2 bg-red-500 hover:bg-red-600 text-white rounded-full w-6 h-6 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity text-xs font-bold">×</button>
                </div>
            `;
        }

        // View full image
        function viewImage(photoUrl) {
            const modal = document.createElement('div');
            modal.className = 'fixed inset-0 z-[50000] flex items-center justify-center bg-black/70 cursor-pointer';
            modal.onclick = () => modal.remove();
            modal.innerHTML = `<img src="${photoUrl}" class="max-w-4xl max-h-[90vh] object-contain rounded-lg">`;
            document.body.appendChild(modal);
        }

        // Delete Photo
        function deletePhoto(photoUrl) {
            if(confirm('Are you sure you want to delete this photo?')) {
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
                    if(data.success) {
                        document.querySelector(`img[src="${photoUrl}"]`).closest('.relative').remove();
                        alert('Photo deleted successfully!');
                    } else {
                        alert('Failed to delete photo');
                    }
                })
                .catch(error => console.error('Error:', error));
            }
        }

        // Delete Video
        function deleteVideo(videoUrl) {
            if(confirm('Are you sure you want to delete this video?')) {
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
                    if(data.success) {
                        document.getElementById('savedVideosContainer').innerHTML = '';
                        alert('Video deleted successfully!');
                    } else {
                        alert('Failed to delete video');
                    }
                })
                .catch(error => console.error('Error:', error));
            }
        }

        // Display Saved 360° View
        function display360ViewSaved(view360Url, fileName) {
            const container = document.getElementById('saved360ViewContainer');
            
            const wrapper = document.createElement('div');
            wrapper.className = 'flex items-center gap-4 p-4 bg-slate-50 rounded-lg border border-slate-200 relative group';
            
            let icon = '📁';
            if(fileName.endsWith('.html')) icon = '🌐';
            else if(fileName.endsWith('.zip') || fileName.endsWith('.rar')) icon = '📦';
            
            wrapper.innerHTML = `
                <div class="text-3xl">${icon}</div>
                <div class="flex-1 min-w-0">
                    <div class="text-[14px] font-medium text-slate-800 truncate">${fileName}</div>
                    <div class="text-[12px] text-slate-500">360° View File</div>
                </div>
                <div class="flex gap-2">
                    <button type="button" onclick="window.open('${view360Url}', '_blank')" class="px-3 py-1.5 bg-[#2563eb] hover:bg-blue-700 text-white rounded-lg text-[12px] font-medium transition-colors">
                        View
                    </button>
                    <button type="button" onclick="delete360View('${view360Url}')" class="px-3 py-1.5 bg-red-500 hover:bg-red-600 text-white rounded-lg text-[12px] font-medium transition-colors">
                        Delete
                    </button>
                </div>
            `;
            
            container.appendChild(wrapper);
        }

        // Delete 360° View
        function delete360View(view360Url) {
            if(confirm('Are you sure you want to delete this 360° view?')) {
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
                    if(data.success) {
                        document.getElementById('saved360ViewContainer').innerHTML = '';
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

        // Create New Certificate Lab
        function createNewCertLab() {
            const labName = document.getElementById('newCertLabName').value.trim();
            
            if(!labName) {
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
                if(data.success) {
                    alert('Certificate lab created successfully!');
                    
                    // Add to dropdown
                    const dropdown = document.querySelector('.custom-dropdown-panel');
                    if(dropdown) {
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
            
            if(!photoTypeName) {
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
                if(data.success) {
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