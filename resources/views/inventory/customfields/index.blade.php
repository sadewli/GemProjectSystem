@extends('layouts.app')

@section('title', 'Custom Fields')

@section('content')
<div class="px-6 py-4">
    <!-- Header -->
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-blue-600 mb-1">Custom fields</h1>
        <div class="flex items-center text-sm text-slate-500">
            <a href="#" class="hover:text-blue-600">Overview</a>
            <svg class="w-3 h-3 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            <span class="text-blue-600">Custom fields</span>
        </div>
    </div>

    <!-- Main Content -->
    <div class="bg-white rounded-lg shadow-sm border border-slate-200">
        <div class="p-6 border-b border-blue-600 border-t-4 border-t-blue-600 rounded-t-lg">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-lg font-medium text-blue-800">Add/remove custom fields</h2>
                <button type="button" onclick="openModal()" class="bg-[#2563eb] hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                    Create new
                </button>
            </div>
            
            <p class="text-slate-600 text-sm mb-6">
                Here you can set up custom fields that are unique to your different types of inventory. Custom fields allow you to upload any kind of information to your inventory that is not covered by our default settings.
            </p>

            @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded mb-6">
                {{ session('success') }}
            </div>
            @endif

            <!-- Table Controls -->
            <div class="flex justify-between items-center mb-4">
                <div class="relative w-64">
                    <input type="text" id="searchInput" onkeyup="filterTable()" placeholder="search" class="w-full pl-3 pr-10 py-2 border border-slate-300 rounded-md text-[13px] focus:outline-none focus:ring-1 focus:ring-blue-500">
                    <button type="button" class="absolute right-0 top-0 h-full px-3 bg-[#2563eb] hover:bg-blue-700 text-white rounded-r-md transition-colors" onclick="filterTable()">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </button>
                </div>
                <div class="flex items-center text-[13px] text-slate-600">
                    <span class="mr-2">Show</span>
                    <select class="border border-slate-300 rounded-md px-2 py-1 focus:outline-none focus:ring-1 focus:ring-blue-500">
                        <option>10</option>
                        <option>25</option>
                        <option>50</option>
                    </select>
                    <span class="ml-2">entries</span>
                </div>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse" id="customFieldsTable">
                    <thead>
                        <tr class="bg-slate-50 text-[13px] font-bold text-slate-900 border-b border-slate-200">
                            <th class="p-3">Name</th>
                            <th class="p-3">Type</th>
                            <th class="p-3">Option</th>
                            <th class="p-3">Description</th>
                            <th class="p-3">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($customFields as $field)
                        <tr class="border-b border-slate-100 text-[13px] text-slate-600 hover:bg-slate-50 cf-row">
                            <td class="p-3 cf-name">{{ $field->field_name }}</td>
                            <td class="p-3">{{ $field->field_type }}</td>
                            <td class="p-3">
                                @if($field->field_type === 'dropdown')
                                    {{ implode(', ', json_decode($field->field_options, true) ?: []) }}
                                @else
                                    --
                                @endif
                            </td>
                            <td class="p-3">{{ $field->field_description }}</td>
                            <td class="p-3">
                                <div class="flex items-center gap-1.5">
                                    <a href="#" class="p-1.5 bg-slate-100 hover:bg-blue-100 text-slate-500 hover:text-blue-600 rounded transition-colors" title="View">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    </a>
                                    <a href="#" class="p-1.5 bg-slate-100 hover:bg-orange-100 text-slate-500 hover:text-orange-600 rounded transition-colors" title="Edit">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </a>
                                    <form action="{{ route('customfields.destroy', $field->idtbl_custom_fields) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this custom field?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1.5 bg-slate-100 hover:bg-red-100 text-slate-500 hover:text-red-600 rounded transition-colors" title="Delete">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                        @if(count($customFields) == 0)
                        <tr>
                            <td colspan="5" class="p-4 text-center text-slate-500 text-sm">No custom fields found.</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>

            <!-- Pagination (Mock) -->
            <div class="flex justify-between items-center mt-4">
                <div class="text-sm text-slate-600">
                    Showing results 1 to {{ count($customFields) }} of {{ count($customFields) }} entries
                </div>
                <div class="flex">
                    <button class="px-3 py-1 border border-slate-300 rounded-l-md text-sm text-slate-400 bg-slate-50 cursor-not-allowed">Previous</button>
                    <button class="px-3 py-1 border-t border-b border-slate-300 text-sm bg-slate-200 text-slate-700">1</button>
                    <button class="px-3 py-1 border border-slate-300 rounded-r-md text-sm text-blue-600 hover:bg-slate-50">Next</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Create Modal -->
<div id="createModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; z-index: 9999; background-color: rgba(15, 23, 42, 0.4); align-items: center; justify-content: center;">
    <div class="bg-white rounded-xl shadow-xl w-full mx-4" style="max-width: 480px; max-height: 90vh; display: flex; flex-direction: column;">
        <form action="{{ route('customfields.store') }}" method="POST" style="display: flex; flex-direction: column; height: 100%;">
            @csrf
            <!-- Hidden Product Type (Default to 1) -->
            <input type="hidden" name="idtbl_product_types" value="1">
            
            <!-- Modal Header -->
            <div class="flex justify-between items-center px-6 py-5">
                <h3 class="text-[17px] font-bold text-slate-900">Create new custom field</h3>
                <button type="button" onclick="closeModal()" class="text-slate-400 hover:text-slate-600 focus:outline-none">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            
            <!-- Modal Body -->
            <div class="px-6 pb-2 space-y-4 overflow-y-auto" style="flex: 1;">
                <div>
                    <label class="block text-[13px] text-slate-700 mb-1">Field Name:</label>
                    <input type="text" name="field_name" placeholder="Enter Field Name (Required)" class="w-full border border-slate-300 rounded-md px-3 py-2 text-[13px] focus:outline-none focus:ring-1 focus:ring-blue-500" required>
                </div>

                <div>
                    <label class="block text-[13px] text-slate-700 mb-1">Field Description:</label>
                    <textarea name="field_description" rows="3" class="w-full border border-slate-300 rounded-md px-3 py-2 text-[13px] focus:outline-none focus:ring-1 focus:ring-blue-500 resize-y"></textarea>
                </div>

                <div>
                    <label class="block text-[13px] text-slate-700 mb-1">Field Type:</label>
                    <select name="field_type" id="fieldTypeSelect" class="w-full border border-slate-300 rounded-md px-3 py-2 text-[13px] focus:outline-none focus:ring-1 focus:ring-blue-500 bg-white" onchange="toggleOptions()">
                        <option value="text">Text</option>
                        <option value="textarea">Textarea</option>
                        <option value="number">Number</option>
                        <option value="dropdown">Dropdown</option>
                        <option value="checkbox">Checkbox</option>
                        <option value="date">Date</option>
                        <option value="url">URL</option>
                    </select>
                </div>

                <div id="optionsContainer" class="hidden">
                    <div class="space-y-2" id="optionsList">
                        <div class="relative flex items-center option-row">
                            <input type="text" name="options[]" placeholder="Option Label (Required)" class="w-full border border-slate-300 rounded-md pl-3 pr-10 py-2 text-[13px] focus:outline-none focus:ring-1 focus:ring-blue-500">
                            <button type="button" class="absolute right-3 text-black hover:text-red-600 focus:outline-none" onclick="this.parentElement.remove()">
                                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor"><path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/></svg>
                            </button>
                        </div>
                    </div>
                    
                    <div class="flex justify-end gap-2 mt-3">
                        <button type="button" class="text-white rounded w-[22px] h-[22px] flex items-center justify-center focus:outline-none" style="background-color: #e03131;" onclick="if(document.querySelectorAll('.option-row').length > 1) { document.querySelectorAll('.option-row')[document.querySelectorAll('.option-row').length-1].remove(); }">
                            <span class="text-[16px] font-bold leading-none select-none" style="margin-top: -2px;">&minus;</span>
                        </button>
                        <button type="button" class="text-white rounded w-[22px] h-[22px] flex items-center justify-center focus:outline-none" style="background-color: #2b8a3e;" onclick="addOption()">
                            <span class="text-[16px] font-bold leading-none select-none" style="margin-top: -1px;">+</span>
                        </button>
                    </div>
                </div>

                <div class="flex items-center gap-2 mt-4 pt-1">
                    <input type="checkbox" name="is_required" value="1" class="w-3.5 h-3.5 text-blue-600 rounded border-slate-300 focus:ring-0">
                    <label class="text-[13px] text-slate-700">Required Field</label>
                </div>
            </div>
            
            <!-- Modal Footer -->
            <div class="flex justify-end gap-3 px-6 py-5">
                <button type="button" onclick="closeModal()" class="px-5 py-2 bg-white border border-[#ef4444] text-[#ef4444] hover:bg-red-50 rounded-md text-[13px] font-medium transition-colors">Close</button>
                <button type="submit" class="px-5 py-2 bg-[#2563eb] hover:bg-blue-700 text-white rounded-md text-[13px] font-medium transition-colors">Save</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openModal() {
        document.getElementById('createModal').style.display = 'flex';
    }

    function closeModal() {
        document.getElementById('createModal').style.display = 'none';
    }

    function toggleOptions() {
        const type = document.getElementById('fieldTypeSelect').value;
        const container = document.getElementById('optionsContainer');
        if (type === 'dropdown') {
            container.classList.remove('hidden');
        } else {
            container.classList.add('hidden');
        }
    }

    function addOption() {
        const template = `
            <div class="relative flex items-center option-row">
                <input type="text" name="options[]" placeholder="Option Label (Required)" class="w-full border border-slate-300 rounded-md pl-3 pr-10 py-2 text-[13px] focus:outline-none focus:ring-1 focus:ring-blue-500">
                <button type="button" class="absolute right-3 text-black hover:text-red-600 focus:outline-none" onclick="this.parentElement.remove()">
                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor"><path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/></svg>
                </button>
            </div>
        `;
        document.getElementById('optionsList').insertAdjacentHTML('beforeend', template);
    }
    function filterTable() {
        const input = document.getElementById('searchInput');
        const filter = input.value.toLowerCase();
        const table = document.getElementById('customFieldsTable');
        const rows = table.getElementsByClassName('cf-row');
        
        let visibleCount = 0;
        for (let i = 0; i < rows.length; i++) {
            const nameCell = rows[i].getElementsByClassName('cf-name')[0];
            if (nameCell) {
                const textValue = nameCell.textContent || nameCell.innerText;
                if (textValue.toLowerCase().indexOf(filter) > -1) {
                    rows[i].style.display = "";
                    visibleCount++;
                } else {
                    rows[i].style.display = "none";
                }
            }
        }
    }
</script>
@endsection
