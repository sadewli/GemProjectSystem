@extends('layouts.app')

@section('title', 'Clarity Grades - Master Data')

@section('content')
<div class="page-header page-header-light bg-white shadow">
    <div class="container-fluid">
        <div class="page-header-content py-3 text-center text-lg-left">
            <h1 class="page-header-title font-weight-light mb-0">
                <div class="page-header-icon"><i data-feather="database"></i></div>
                <span>Clarity Grades Master</span>
            </h1>
        </div>
    </div>
</div>

<div class="container-fluid mt-2 p-0 p-md-2">
    <div class="card shadow-sm">
        <div class="card-body p-2">
            <div class="row">
                <div class="col-12 col-md-4 mb-3">
                    <form action="{{ url('Master/ClarityGradeinsertupdate') }}" method="post" autocomplete="off">
                        @csrf
                        <div class="form-group mb-2">
                            <label class="small font-weight-bold text-dark">Product Type*</label>
                            <select class="form-control form-control-sm" name="idtbl_product_types" id="idtbl_product_types" required>
                                <option value="">Select Product Type</option>
                                @foreach($productTypes as $type)
                                <option value="{{ $type->idtbl_product_types }}">{{ $type->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mb-2">
                            <label class="small font-weight-bold text-dark">Clarity Grade Name*</label>
                            <input type="text" class="form-control form-control-sm" name="clarity_grade_name" id="clarity_grade_name" required placeholder="e.g. IF, VVS1, VS2">
                        </div>
                        <div class="form-group mt-3">
                            <button type="submit" id="submitBtn" class="btn btn-primary btn-sm w-100"><i class="far fa-save"></i>&nbsp;Save Entry</button>
                        </div>
                        <div class="mt-1">
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
                                    <th>PRODUCT TYPE</th>
                                    <th>CLARITY GRADE NAME</th>
                                    <th class="text-right">ACTIONS</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($claritygrades as $grade)
                                <tr>
                                    <td>{{ $grade->productType->name ?? '-' }}</td>
                                    <td>{{ $grade->clarity_grade_name }}</td>
                                    <td class="text-right">
                                        <div class="btn-group btn-group-sm">
                                            <button type="button" class="btn btn-outline-primary btn-sm btnEdit" data-id="{{ $grade->idtbl_clarity_grade }}" title="Edit"><i class="fas fa-pen"></i></button>
                                            <button type="button" class="btn btn-outline-danger btn-sm btnDelete" data-id="{{ $grade->idtbl_clarity_grade }}" title="Delete"><i class="fas fa-trash-alt"></i></button>
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
    $(document).ready(function() {
        $('#dataTable').DataTable({
            responsive: true,
            order: [[0, "asc"], [1, "asc"]],
            columnDefs: [{ targets: -1, orderable: false, searchable: false }]
        });

        $(document).on('click', '.btnEdit', function() {
            $.ajax({
                url: '{{ url("Master/ClarityGradeedit") }}',
                method: 'POST',
                data: { _token: '{{ csrf_token() }}', recordID: $(this).data('id') },
                success: function(response) {
                    $('#clarity_grade_name').val(response.clarity_grade_name);
                    $('#idtbl_product_types').val(response.idtbl_product_types);
                    $('#recordID').val(response.idtbl_clarity_grade);
                    $('#recordOption').val('2');
                    $('#submitBtn').html('<i class="fas fa-sync"></i>&nbsp;Update Entry');
                    $('html, body').animate({ scrollTop: 0 }, 'slow');
                },
                error: function() { alert('Error loading record'); }
            });
        });

        $(document).on('click', '.btnDelete', function() {
            if (!confirm('Are you sure you want to delete this record?')) return;
            let form = $('<form method="POST" action="{{ url("Master/ClarityGradedelete") }}"></form>');
            form.append('<input type="hidden" name="_token" value="{{ csrf_token() }}">');
            form.append('<input type="hidden" name="recordID" value="' + $(this).data('id') + '">');
            $('body').append(form);
            form.submit();
        });

        $('#resetBtn').on('click', function() {
            $('#clarity_grade_name').val('');
            $('#idtbl_product_types').val('');
            $('#recordID').val('');
            $('#recordOption').val('1');
            $('#submitBtn').html('<i class="far fa-save"></i>&nbsp;Save Entry');
        });

        @if(Session::has('msg'))
            action('{!! Session::get("msg") !!}');
        @endif
    });
</script>
@endsection
