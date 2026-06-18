@extends('layouts.app')

@section('title', 'Certificate Labs - Master Data')

@section('content')
<div class="page-header page-header-light bg-white shadow">
    <div class="container-fluid">
        <div class="page-header-content py-3 text-center text-lg-left">
            <h1 class="page-header-title font-weight-light mb-0">
                <div class="page-header-icon"><i data-feather="database"></i></div>
                <span>Certificate Labs</span>
            </h1>
        </div>
    </div>
</div>

<div class="container-fluid mt-2 p-0 p-md-2">
    <div class="card shadow-sm">
        <div class="card-body p-2">
            <div class="row">
                <div class="col-12 col-md-4 mb-3">
                    <form action="{{ url('Master/CertificateLabinsertupdate') }}" method="post" autocomplete="off">
                        @csrf
                        <div class="form-group mb-2">
                            <label class="small font-weight-bold text-dark">Lab Name*</label>
                            <input type="text" class="form-control form-control-sm" name="lab_name" id="lab_name" required placeholder="e.g. GIA">
                        </div>
                        <div class="form-group mt-3 text-right">
                            <button type="submit" id="submitBtn" class="btn btn-primary btn-sm px-4 w-100"><i class="far fa-save"></i>&nbsp;Add</button>
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
                                    <th>LAB NAME</th>
                                    <th>STATUS</th>
                                    <th class="text-right">ACTIONS</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($labs as $lab)
                                <tr>
                                    <td>{{ str_pad($lab->idtbl_certificate_labs, 2, '0', STR_PAD_LEFT) }}</td>
                                    <td>{{ $lab->lab_name }}</td>
                                    <td>
                                        @if($lab->status == 1)
                                            <span class="badge badge-success font-weight-normal">Active</span>
                                        @else
                                            <span class="badge badge-secondary font-weight-normal">Inactive</span>
                                        @endif
                                    </td>
                                    <td class="text-right">
                                        <div class="btn-group btn-group-sm">
                                            <button type="button" class="btn btn-primary btn-sm btnEdit mr-1" 
                                                data-id="{{ $lab->idtbl_certificate_labs }}" 
                                                data-name="{{ $lab->lab_name }}" 
                                                title="Edit">
                                                <i class="fas fa-pen"></i>
                                            </button>
                                            @if($lab->status == 1)
                                            <button type="button" class="btn btn-success btn-sm mr-1 btnStatus" data-id="{{ $lab->idtbl_certificate_labs }}" title="Active - click to deactivate"><i class="fas fa-check"></i></button>
                                            @else
                                            <button type="button" class="btn btn-warning btn-sm mr-1 btnStatus" data-id="{{ $lab->idtbl_certificate_labs }}" title="Inactive - click to activate"><i class="fas fa-times"></i></button>
                                            @endif
                                            <button type="button" class="btn btn-danger btn-sm btnDelete" data-id="{{ $lab->idtbl_certificate_labs }}" title="Delete"><i class="fas fa-trash-alt"></i></button>
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
@endsection

@section('script')
<script>
    $(document).ready(function() {
        $('#dataTable').DataTable({
            responsive: true,
            order: [[0, "asc"]],
            columnDefs: [
                { targets: -1, orderable: false, searchable: false }
            ]
        });

        function resetForm() {
            $('#recordID').val('');
            $('#recordOption').val('1');
            $('#lab_name').val('');
            $('#submitBtn').html('<i class="far fa-save"></i>&nbsp;Add');
        }

        $('#resetBtn').on('click', function() {
            resetForm();
        });

        $(document).on('click', '.btnEdit', function() {
            var id = $(this).data('id');
            var name = $(this).data('name');
            
            $('#recordID').val(id);
            $('#recordOption').val('2');
            $('#lab_name').val(name);
            $('#submitBtn').html('<i class="fas fa-sync"></i>&nbsp;Update');
            $('html, body').animate({ scrollTop: 0 }, 'slow');
        });
        
        // Status toggle
        $(document).on('click', '.btnStatus', function() {
            var id = $(this).data('id');
            if (confirm('Are you sure you want to change the status of this record?')) {
                var form = $('<form method="POST" action="{{ url("Master/CertificateLabstatus") }}"></form>');
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
                var form = $('<form method="POST" action="{{ url("Master/CertificateLabdelete") }}"></form>');
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
