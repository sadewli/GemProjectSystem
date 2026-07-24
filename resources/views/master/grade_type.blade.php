@extends('layouts.app')

@section('title', 'Grade Types - Master Data')

@section('content')
<div class="page-header page-header-light bg-white shadow">
    <div class="container-fluid">
        <div class="page-header-content py-3 text-center text-lg-left">
            <h1 class="page-header-title font-weight-light mb-0">
                <div class="page-header-icon"><i data-feather="database"></i></div>
                <span>Grade Types</span>
            </h1>
        </div>
    </div>
</div>

<div class="container-fluid mt-2 p-0 p-md-2">
    <div class="card shadow-sm">
        <div class="card-body p-2">
            <div class="row">
                <div class="col-12 col-md-4 mb-3">
                    <form action="{{ url('Master/Gradetypeinsertupdate') }}" method="post" autocomplete="off">
                        @csrf
                        <div class="form-group mb-2">
                            <label class="small font-weight-bold text-dark">Type Name*</label>
                            <input type="text" class="form-control form-control-sm" name="type_name" id="type_name" required placeholder="e.g. Clarity Grade">
                        </div>
                        <div class="form-group mb-2">
                            <label class="small font-weight-bold text-dark">Description</label>
                            <textarea class="form-control form-control-sm" name="description" id="description" rows="3" placeholder="Optional description"></textarea>
                        </div>
                        <div class="form-group mt-3 text-right">
                            <button type="submit" id="submitBtn" class="btn btn-primary btn-sm px-4 w-100"><i class="far fa-save"></i>&nbsp;Save Type</button>
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
                                    <th>TYPE NAME</th>
                                    <th>DESCRIPTION</th>
                                    <th class="text-right">ACTIONS</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($gradeTypes as $gradeType)
                                <tr>
                                    <td>{{ $gradeType->type_name }}</td>
                                    <td>{{ $gradeType->description ?? '-' }}</td>
                                    <td class="text-right">
                                        <div class="btn-group btn-group-sm">
                                            <button type="button" class="btn btn-outline-primary btn-sm btnEdit" data-id="{{ $gradeType->idtbl_grade_types }}" title="Edit"><i class="fas fa-pen"></i></button>
                                            <button type="button" class="btn btn-outline-danger btn-sm btnDelete" data-id="{{ $gradeType->idtbl_grade_types }}" title="Delete"><i class="fas fa-trash-alt"></i></button>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="text-center text-muted py-3">No records found</td>
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
            order: [[0, "asc"]],
            columnDefs: [
                { targets: -1, orderable: false, searchable: false }
            ]
        });

        // Edit button click
        $(document).on('click', '.btnEdit', function() {
            let recordID = $(this).data('id');
            
            $.ajax({
                url: '{{ url("Master/Gradetypeedit") }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    recordID: recordID
                },
                success: function(response) {
                    $('#type_name').val(response.type_name);
                    $('#description').val(response.description);
                    $('#recordID').val(response.idtbl_grade_types);
                    $('#recordOption').val('2');
                    $('#submitBtn').html('<i class="fas fa-sync"></i>&nbsp;Update Type');
                    $('html, body').animate({ scrollTop: 0 }, 'slow');
                },
                error: function() {
                    alert('Error loading record');
                }
            });
        });

        // Delete button click
        $(document).on('click', '.btnDelete', function() {
            let recordID = $(this).data('id');
            
            if (confirm('Are you sure you want to delete this record?')) {
                let form = $('<form method="POST" action="{{ url("Master/Gradetypedelete") }}"></form>');
                form.append('<input type="hidden" name="_token" value="{{ csrf_token() }}">');
                form.append('<input type="hidden" name="recordID" value="' + recordID + '">');
                $('body').append(form);
                form.submit();
            }
        });

        // Reset form
        function resetForm() {
            $('#type_name').val('');
            $('#description').val('');
            $('#recordID').val('');
            $('#recordOption').val('1');
            $('#submitBtn').html('<i class="far fa-save"></i>&nbsp;Save Type');
        }
    });
</script>
@endsection
