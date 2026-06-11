@extends('layouts.app')

@section('title', 'Sub-Categories - Master Data')

@section('content')
<div class="page-header page-header-light bg-white shadow">
    <div class="container-fluid">
        <div class="page-header-content py-3 text-center text-lg-left">
            <h1 class="page-header-title font-weight-light mb-0">
                <div class="page-header-icon"><i data-feather="database"></i></div>
                <span>Sub-Categories</span>
            </h1>
        </div>
    </div>
</div>

<div class="container-fluid mt-2 p-0 p-md-2">
    <div class="card shadow-sm">
        <div class="card-body p-2">
            <div class="row mb-3">
                <div class="col-12 text-right">
                    <button type="button" id="openSubcategoryModalBtn" class="btn btn-primary btn-sm px-4">
                        <i class="fas fa-plus mr-1"></i> Add Sub-Category
                    </button>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="table-responsive pb-3">
                        <table class="table table-bordered table-striped table-sm nowrap w-100" id="dataTable">
                            <thead class="thead-light">
                                <tr>
                                    <th>#</th>
                                    <th>SUB-CATEGORY NAME</th>
                                    <th>PRODUCT TYPE</th>
                                    <th>STATUS</th>
                                    <th class="text-right">ACTIONS</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($subcategories as $index => $subcategory)
                                <tr>
                                    <td>{{ sprintf('%02d', $index + 1) }}</td>
                                    <td>{{ $subcategory->sub_category_name }}</td>
                                    <td>{{ $subcategory->productType ? $subcategory->productType->name : 'N/A' }}</td>
                                    <td>
                                        @if($subcategory->status == 1)
                                            <span class="badge badge-success font-weight-normal">Active</span>
                                        @else
                                            <span class="badge badge-secondary font-weight-normal">Inactive</span>
                                        @endif
                                    </td>
                                    <td class="text-right">
                                        <div class="btn-group btn-group-sm">
                                            <button class="btn btn-info btn-sm btnView mr-1" data-id="{{ $subcategory->idtbl_sub_categories }}" data-name="{{ $subcategory->sub_category_name }}" data-category="{{ $subcategory->productType ? $subcategory->productType->name : 'N/A' }}"><i class="fas fa-eye"></i></button>
                                            <button class="btn btn-primary btn-sm btnEdit mr-1" data-id="{{ $subcategory->idtbl_sub_categories }}" data-name="{{ $subcategory->sub_category_name }}" data-category="{{ $subcategory->idtbl_product_types }}"><i class="fas fa-pen"></i></button>
                                            <button class="btn btn-danger btn-sm btnDelete" data-id="{{ $subcategory->idtbl_sub_categories }}"><i class="fas fa-trash-alt"></i></button>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Sub-Category Modal -->
<div id="subcategoryModal" class="position-fixed d-none align-items-center justify-content-center" style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.55); z-index: 1050;">
    <div class="bg-white rounded shadow-lg w-100" style="max-width: 680px;">
        <div class="d-flex justify-content-between align-items-center px-4 py-3 border-bottom">
            <h5 class="mb-0" id="modalTitle">Add New Sub-Category</h5>
            <button type="button" id="closeSubcategoryModalBtn" class="btn btn-sm btn-light">×</button>
        </div>
        <div class="px-4 py-4">
            <form id="subcategoryModalForm" action="{{ url('Master/Subcategoryinsertupdate') }}" method="post" autocomplete="off">
                @csrf
                <div class="form-group mb-2">
                    <label class="small font-weight-bold text-dark">Sub-Category Name*</label>
                    <input type="text" class="form-control form-control-sm" name="sub_category_name" id="subcategory_name_modal" required>
                </div>
                <div class="form-group mb-2">
                    <label class="small font-weight-bold text-dark">Product Type*</label>
                    <select class="form-control form-control-sm" name="idtbl_product_types" id="category_modal" required>
                        <option value="">Select</option>
                        @foreach($product_types as $type)
                            <option value="{{ $type->idtbl_product_types }}">{{ $type->name }}</option>
                        @endforeach
                    </select>
                </div>
                <input type="hidden" name="recordOption" id="recordOption_modal" value="1">
                <input type="hidden" name="recordID" id="recordID_modal" value="">
            </form>
        </div>
        <div class="d-flex justify-content-end px-4 py-3 border-top">
            <button type="button" id="cancelSubcategoryModalBtn" class="btn btn-light btn-sm mr-2">Cancel</button>
            <button type="submit" form="subcategoryModalForm" class="btn btn-primary btn-sm">Save</button>
        </div>
    </div>
</div>

<!-- View Sub-Category Modal -->
<div id="viewSubcategoryModal" class="position-fixed d-none align-items-center justify-content-center" style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.55); z-index: 1050;">
    <div class="bg-white rounded shadow-lg w-100" style="max-width: 500px;">
        <div class="d-flex justify-content-between align-items-center px-4 py-3 border-bottom">
            <h5 class="mb-0">View Sub-Category Details</h5>
            <button type="button" id="closeViewSubcategoryModalBtn" class="btn btn-sm btn-light">×</button>
        </div>
        <div class="px-4 py-4">
            <table class="table table-bordered mb-0">
                <tr>
                    <th class="bg-light w-50">Sub-Category Name</th>
                    <td id="view_subcategory_name"></td>
                </tr>
                <tr>
                    <th class="bg-light">Product Type</th>
                    <td id="view_product_type"></td>
                </tr>
            </table>
        </div>
        <div class="d-flex justify-content-end px-4 py-3 border-top">
            <button type="button" id="cancelViewSubcategoryModalBtn" class="btn btn-secondary btn-sm">Close</button>
        </div>
    </div>
</div>

@endsection

@section('script')
<script>
    $(document).ready(function() {
        $('#dataTable').DataTable({
            responsive: true,
            order: [[0, "asc"]],
        });

        const modal = document.getElementById('subcategoryModal');
        const openBtn = document.getElementById('openSubcategoryModalBtn');
        const closeBtn = document.getElementById('closeSubcategoryModalBtn');
        const cancelBtn = document.getElementById('cancelSubcategoryModalBtn');

        function toggleModal(show) {
            if (show) {
                modal.classList.remove('d-none');
                modal.classList.add('d-flex');
                document.body.style.overflow = 'hidden';
            } else {
                modal.classList.add('d-none');
                modal.classList.remove('d-flex');
                document.body.style.overflow = '';
            }
        }

        if (openBtn) {
            openBtn.addEventListener('click', function() {
                $('#modalTitle').text('Add New Sub-Category');
                $('#recordOption_modal').val(1);
                $('#recordID_modal').val('');
                $('#subcategory_name_modal').val('');
                $('#category_modal').val('');
                toggleModal(true);
            });
        }
        if (closeBtn) {
            closeBtn.addEventListener('click', () => toggleModal(false));
        }
        if (cancelBtn) {
            cancelBtn.addEventListener('click', () => toggleModal(false));
        }
        if (modal) {
            modal.addEventListener('click', function(event) {
                if (event.target === modal) {
                    toggleModal(false);
                }
            });
        }

        // Edit button click
        $('.btnEdit').on('click', function() {
            var id = $(this).data('id');
            var name = $(this).data('name');
            var category = $(this).data('category');

            $('#modalTitle').text('Edit Sub-Category');
            $('#recordOption_modal').val(2);
            $('#recordID_modal').val(id);
            $('#subcategory_name_modal').val(name);
            $('#category_modal').val(category);
            
            toggleModal(true);
        });

        // Delete button click
        $('.btnDelete').on('click', function() {
            if (!confirm('Are you sure you want to delete this sub-category?')) return;
            var id = $(this).data('id');
            var form = $('<form></form>').attr({ method: 'POST', action: '{{ url("Master/Subcategorydelete") }}' })
                .append($('<input>').attr({ type: 'hidden', name: '_token', value: '{{ csrf_token() }}' }))
                .append($('<input>').attr({ type: 'hidden', name: 'recordID', value: id }));
            $(document.body).append(form);
            form.submit();
        });

        // View logic
        const viewModal = document.getElementById('viewSubcategoryModal');
        const closeViewBtn = document.getElementById('closeViewSubcategoryModalBtn');
        const cancelViewBtn = document.getElementById('cancelViewSubcategoryModalBtn');

        function toggleViewModal(show) {
            if (show) {
                viewModal.classList.remove('d-none');
                viewModal.classList.add('d-flex');
                document.body.style.overflow = 'hidden';
            } else {
                viewModal.classList.add('d-none');
                viewModal.classList.remove('d-flex');
                document.body.style.overflow = '';
            }
        }

        if (closeViewBtn) closeViewBtn.addEventListener('click', () => toggleViewModal(false));
        if (cancelViewBtn) cancelViewBtn.addEventListener('click', () => toggleViewModal(false));
        if (viewModal) {
            viewModal.addEventListener('click', function(event) {
                if (event.target === viewModal) toggleViewModal(false);
            });
        }

        $('.btnView').on('click', function() {
            var name = $(this).data('name');
            var category = $(this).data('category');

            $('#view_subcategory_name').text(name);
            $('#view_product_type').text(category);
            
            toggleViewModal(true);
        });

        @if(Session::has('msg'))
            action('{!! Session::get("msg") !!}');
        @endif
    });
</script>
@endsection
