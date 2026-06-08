@extends('layouts.app')

@section('title', 'Color Grades - Master Data')

@section('content')
<div class="page-header page-header-light bg-white shadow">
    <div class="container-fluid">
        <div class="page-header-content py-3 text-center text-lg-left">
            <h1 class="page-header-title font-weight-light mb-0">
                <div class="page-header-icon"><i data-feather="database"></i></div>
                <span>Color Grades</span>
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
            <div class="row">
                <div class="col-12 col-md-4 mb-3">
                    <form action="{{ url('Master/ColorGradeinsertupdate') }}" method="post" autocomplete="off" id="colorGradeForm">
                        @csrf
                        <div class="form-group mb-2">
                            <label class="small font-weight-bold text-dark">Product Type <span class="text-danger">*</span></label>
                            <select class="form-control form-control-sm" name="idtbl_product_types" id="idtbl_product_types" required>
                                <option value="">-- Select Product Type --</option>
                                @foreach($productTypes as $type)
                                <option value="{{ $type->idtbl_product_types }}">{{ $type->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mb-2">
                            <label class="small font-weight-bold text-dark">Grade Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-sm" name="grade_name" id="grade_name" required placeholder="e.g. AAA+">
                        </div>
                        <div class="form-group mt-3">
                            <button type="submit" id="submitBtn" class="btn btn-primary btn-sm px-4 w-100"><i class="far fa-save"></i>&nbsp;Save Grade</button>
                        </div>
                        <div class="text-right mt-1">
                            <button type="button" id="resetBtn" class="btn btn-light btn-sm btn-block"><i class="fas fa-redo-alt"></i>&nbsp;Reset</button>
                        </div>
                        <input type="hidden" name="recordOption" id="recordOption" value="1">
                        <input type="hidden" name="recordID" id="recordID" value="">
                    </form>
                </div>
                <div class="col-12 col-md-8">
                    <div class="table-responsive pb-3">
                        <table class="table table-bordered table-striped table-sm nowrap w-100" id="dataTable">
                            <thead class="thead-light">
                                <tr>
                                    <th>ID</th>
                                    <th>PRODUCT TYPE</th>
                                    <th>GRADE NAME</th>
                                    <th>STATUS</th>
                                    <th class="text-right">ACTIONS</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($colorGrades as $grade)
                                <tr>
                                    <td>{{ str_pad($grade->idtbl_color_grade, 2, '0', STR_PAD_LEFT) }}</td>
                                    <td>{{ $grade->productType->name ?? '-' }}</td>
                                    <td>{{ $grade->grade_name }}</td>
                                    <td>
                                        @if($grade->status == 1)
                                            <span class="badge badge-success font-weight-normal">Active</span>
                                        @else
                                            <span class="badge badge-secondary font-weight-normal">Inactive</span>
                                        @endif
                                    </td>
                                    <td class="text-right">
                                        <div class="btn-group btn-group-sm">
                                            <button type="button" class="btn btn-primary btn-sm btnEdit mr-1"
                                                data-id="{{ $grade->idtbl_color_grade }}"
                                                data-product-type="{{ $grade->idtbl_product_types }}"
                                                data-grade-name="{{ $grade->grade_name }}"
                                                title="Edit">
                                                <i class="fas fa-pen"></i>
                                            </button>
                                            @if($grade->status == 1)
                                            <button type="button" class="btn btn-success btn-sm mr-1 btnStatus" data-id="{{ $grade->idtbl_color_grade }}" title="Active – click to deactivate"><i class="fas fa-check"></i></button>
                                            @else
                                            <button type="button" class="btn btn-warning btn-sm mr-1 btnStatus" data-id="{{ $grade->idtbl_color_grade }}" title="Inactive – click to activate"><i class="fas fa-times"></i></button>
                                            @endif
                                            <button type="button" class="btn btn-danger btn-sm btnDelete" data-id="{{ $grade->idtbl_color_grade }}" title="Delete">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-3">No records found</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    let table;
    $(document).ready(function() {
        table = $('#dataTable').DataTable({
            responsive: true,
            order: [[0, 'asc']],
            columnDefs: [
                { targets: -1, orderable: false, searchable: false }
            ]
        });

        // Reset form helper
        function resetForm() {
            $('#recordID').val('');
            $('#recordOption').val('1');
            $('#grade_name').val('');
            $('#idtbl_product_types').val('');
            $('#submitBtn').html('<i class="far fa-save"></i>&nbsp;Save Grade');
        }

        // Reset button
        $('#resetBtn').on('click', function() {
            resetForm();
        });

        // Edit button
        $(document).on('click', '.btnEdit', function() {
            var id          = $(this).data('id');
            var productType = $(this).data('product-type');
            var gradeName   = $(this).data('grade-name');

            $('#recordID').val(id);
            $('#recordOption').val('2');
            $('#idtbl_product_types').val(productType);
            $('#grade_name').val(gradeName);
            $('#submitBtn').html('<i class="fas fa-sync"></i>&nbsp;Update Grade');
            $('html, body').animate({ scrollTop: 0 }, 'slow');
        });

        // Status toggle
        $(document).on('click', '.btnStatus', function() {
            var id = $(this).data('id');
            if (confirm('Are you sure you want to change the status of this record?')) {
                var form = $('<form method="POST" action="{{ url("Master/ColorGradestatus") }}"></form>');
                form.append('<input type="hidden" name="_token" value="{{ csrf_token() }}">');
                form.append('<input type="hidden" name="recordID" value="' + id + '">');
                $('body').append(form);
                form.submit();
            }
        });

        // Delete button
        $(document).on('click', '.btnDelete', function() {
            var id = $(this).data('id');
            if (confirm('Are you sure you want to delete this record?')) {
                var form = $('<form method="POST" action="{{ url("Master/ColorGradedelete") }}"></form>');
                form.append('<input type="hidden" name="_token" value="{{ csrf_token() }}">');
                form.append('<input type="hidden" name="recordID" value="' + id + '">');
                $('body').append(form);
                form.submit();
            }
        });

        @if(Session::has('msg'))
            action('{!! Session::get("msg") !!}');
        @endif
    });
</script>
@endsection
