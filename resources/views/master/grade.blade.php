@extends('layouts.app')

@section('title', 'Grades - Master Data')

@section('content')
<div class="page-header page-header-light bg-white shadow">
    <div class="container-fluid">
        <div class="page-header-content py-3 text-center text-lg-left">
            <h1 class="page-header-title font-weight-light mb-0">
                <div class="page-header-icon"><i data-feather="database"></i></div>
                <span>Grades</span>
            </h1>
        </div>
    </div>
</div>

<div class="container-fluid mt-2 p-0 p-md-2">
    <div class="card shadow-sm">
        <div class="card-body p-2">
            <div class="row">
                <div class="col-12 col-md-4 mb-3">
                    <form action="{{ url('Master/Gradeinsertupdate') }}" method="post" autocomplete="off">
                        @csrf
                        <div class="form-group mb-2">
                            <label class="small font-weight-bold text-dark">Grade Type*</label>
                            <select class="form-control form-control-sm" name="grade_type_id" id="grade_type_id" required>
                                <option value="">Select Grade Type</option>
                                @foreach($gradeTypes as $type)
                                <option value="{{ $type->idtbl_grade_types }}">{{ $type->type_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mb-2">
                            <label class="small font-weight-bold text-dark">Grade Value*</label>
                            <input type="text" class="form-control form-control-sm" name="grade_value" id="grade_value" required placeholder="e.g. VVS2">
                        </div>
                        <div class="form-group mt-3 text-right">
                            <button type="submit" id="submitBtn" class="btn btn-primary btn-sm px-4 w-100"><i class="far fa-save"></i>&nbsp;Save Grade</button>
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
                                    <th>TYPE</th>
                                    <th>VALUE</th>
                                    <th class="text-right">ACTIONS</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($grades as $grade)
                                <tr>
                                    <td>{{ $grade->gradeType->type_name ?? '-' }}</td>
                                    <td>{{ $grade->grade_value }}</td>
                                    <td class="text-right">
                                        <div class="btn-group btn-group-sm">
                                            <button type="button" class="btn btn-outline-primary btn-sm btnEdit" data-id="{{ $grade->idtbl_grades }}" title="Edit"><i class="fas fa-pen"></i></button>
                                            <button type="button" class="btn btn-outline-danger btn-sm btnDelete" data-id="{{ $grade->idtbl_grades }}" title="Delete"><i class="fas fa-trash-alt"></i></button>
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
                url: '{{ url("Master/Gradeedit") }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    recordID: recordID
                },
                success: function(response) {
                    $('#grade_type_id').val(response.grade_type_id);
                    $('#grade_value').val(response.grade_value);
                    $('#recordID').val(response.idtbl_grades);
                    $('#recordOption').val('2');
                    $('#submitBtn').html('<i class="fas fa-sync"></i>&nbsp;Update Grade');
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
                let form = $('<form method="POST" action="{{ url("Master/Gradedelete") }}"></form>');
                form.append('<input type="hidden" name="_token" value="{{ csrf_token() }}">');
                form.append('<input type="hidden" name="recordID" value="' + recordID + '">');
                $('body').append(form);
                form.submit();
            }
        });

        // Reset form
        function resetForm() {
            $('#grade_type_id').val('');
            $('#grade_value').val('');
            $('#recordID').val('');
            $('#recordOption').val('1');
            $('#submitBtn').html('<i class="far fa-save"></i>&nbsp;Save Grade');
        }
    });
</script>
@endsection
