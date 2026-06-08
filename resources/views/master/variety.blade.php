@extends('layouts.app')

@section('title', 'Varieties - Master Data')

@section('content')
<div class="page-header page-header-light bg-white shadow">
    <div class="container-fluid">
        <div class="page-header-content py-3 text-center text-lg-left">
            <h1 class="page-header-title font-weight-light mb-0">
                <div class="page-header-icon"><i data-feather="database"></i></div>
                <span>Varieties</span>
            </h1>
        </div>
    </div>
</div>

<div class="container-fluid mt-2">
    @include('layouts.master_data_nav_bar')
</div>

<div class="container-fluid mt-2 p-0 p-md-2">
    <div class="card shadow-sm">
        <div class="card-body p-2">
            <div class="row mb-3">
                <div class="col-12 text-right">
                    <button type="button" id="openVarietyModalBtn" class="btn btn-primary btn-sm px-4">
                        <i class="fas fa-plus mr-1"></i> Add Variety
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
                                    <th>NAME</th>
                                    <th>CATEGORY</th>
                                    <th class="text-right">ACTIONS</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($varieties as $index => $variety)
                                <tr>
                                    <td>{{ sprintf('%02d', $index + 1) }}</td>
                                    <td>{{ $variety->variety_name }}</td>
                                    <td>{{ $variety->gem_type_id == 1 ? 'Precious' : 'Semi-Precious' }}</td>
                                    <td class="text-right">
                                        <div class="btn-group btn-group-sm">
                                            <button class="btn btn-primary btn-sm btnEdit mr-1" data-id="{{ $variety->idtbl_varieties }}" data-name="{{ $variety->variety_name }}" data-category="{{ $variety->gem_type_id }}"><i class="fas fa-pen"></i></button>
                                            <button class="btn btn-success btn-sm mr-1"><i class="fas fa-check"></i></button>
                                            <button class="btn btn-danger btn-sm btnDelete"><i class="fas fa-trash-alt"></i></button>
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

<!-- Variety Modal -->
<div id="varietyModal" class="position-fixed d-none align-items-center justify-content-center" style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.55); z-index: 1050;">
    <div class="bg-white rounded shadow-lg w-100" style="max-width: 680px;">
        <div class="d-flex justify-content-between align-items-center px-4 py-3 border-bottom">
            <h5 class="mb-0">Add New Variety</h5>
            <button type="button" id="closeVarietyModalBtn" class="btn btn-sm btn-light">×</button>
        </div>
        <div class="px-4 py-4">
            <form id="varietyModalForm" action="{{ url('Master/Varietyinsertupdate') }}" method="post" autocomplete="off">
                @csrf
                <div class="form-group mb-2">
                    <label class="small font-weight-bold text-dark">Variety Name*</label>
                    <input type="text" class="form-control form-control-sm" name="variety_name" id="variety_name_modal" required>
                </div>
                <div class="form-group mb-2">
                    <label class="small font-weight-bold text-dark">Category*</label>
                    <select class="form-control form-control-sm" name="category" id="category_modal" required>
                        <option value="">Select</option>
                        <option value="1">Precious</option>
                        <option value="2">Semi-Precious</option>
                    </select>
                </div>
                <input type="hidden" name="recordOption" id="recordOption_modal" value="1">
                <input type="hidden" name="recordID" id="recordID_modal" value="">
            </form>
        </div>
        <div class="d-flex justify-content-end px-4 py-3 border-top">
            <button type="button" id="cancelVarietyModalBtn" class="btn btn-light btn-sm mr-2">Cancel</button>
            <button type="submit" form="varietyModalForm" class="btn btn-primary btn-sm">Save</button>
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

        const modal = document.getElementById('varietyModal');
        const openBtn = document.getElementById('openVarietyModalBtn');
        const closeBtn = document.getElementById('closeVarietyModalBtn');
        const cancelBtn = document.getElementById('cancelVarietyModalBtn');

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
            openBtn.addEventListener('click', () => toggleModal(true));
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

            $('#recordOption_modal').val(2);
            $('#recordID_modal').val(id);
            $('#variety_name_modal').val(name);
            $('#category_modal').val(category);
            
            toggleModal(true);
        });

        // Add variety button click (reset form)
        $('#openVarietyModalBtn').on('click', function() {
            $('#recordOption_modal').val(1);
            $('#recordID_modal').val('');
            $('#variety_name_modal').val('');
            $('#category_modal').val('');
            toggleModal(true);
        });
    });
</script>
@endsection
