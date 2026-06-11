@extends('layouts.app')

@section('title', 'Shapes - Master Data')

@section('content')
<div class="page-header page-header-light bg-white shadow">
    <div class="container-fluid">
        <div class="page-header-content py-3 text-center text-lg-left">
            <h1 class="page-header-title font-weight-light mb-0">
                <div class="page-header-icon"><i data-feather="database"></i></div>
                <span>Shapes Master</span>
            </h1>
        </div>
    </div>
</div>

<div class="container-fluid mt-2 p-0 p-md-2">
    <div class="card shadow-sm">
        <div class="card-body p-2">
            <div class="row">
                <div class="col-12 col-md-4 mb-3">
                    <form action="{{ url('Master/Shapeinsertupdate') }}" method="post" autocomplete="off">
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
                            <label class="small font-weight-bold text-dark">Name*</label>
                            <input type="text" class="form-control form-control-sm" name="name" id="name" required placeholder="e.g. Cushion">
                        </div>
                        <div class="form-group mt-3 text-right">
                            <button type="submit" id="submitBtn" class="btn btn-primary btn-sm px-4 w-100"><i class="far fa-save"></i>&nbsp;Save Entry</button>
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
                                    <th>PRODUCT TYPE</th>
                                    <th>SHAPE NAME</th>
                                    <th class="text-right">ACTIONS</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($shapes as $shape)
                                <tr>
                                    <td>{{ $shape->productType->name ?? '-' }}</td>
                                    <td>{{ $shape->name }}</td>
                                    <td class="text-right">
                                        <div class="btn-group btn-group-sm">
                                            <button type="button" class="btn btn-primary btn-sm btnEdit mr-1" data-id="{{ $shape->idtbl_shapes }}"><i class="fas fa-pen"></i></button>
                                            <button type="button" class="btn btn-danger btn-sm btnDelete" data-id="{{ $shape->idtbl_shapes }}"><i class="fas fa-trash-alt"></i></button>
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
            order: [[0, "asc"], [1, "asc"]],
            columnDefs: [
                { targets: -1, orderable: false, searchable: false }
            ]
        });

        // Edit button click
        $(document).on('click', '.btnEdit', function() {
            let recordID = $(this).data('id');
            
            $.ajax({
                url: '{{ url("Master/Shapeedit") }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    recordID: recordID
                },
                success: function(response) {
                    $('#name').val(response.name);
                    $('#idtbl_product_types').val(response.idtbl_product_types);
                    $('#recordID').val(response.idtbl_shapes);
                    $('#recordOption').val('2');
                    $('#submitBtn').html('<i class="fas fa-sync"></i>&nbsp;Update Entry');
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
                let form = $('<form method="POST" action="{{ url("Master/Shapedelete") }}"></form>');
                form.append('<input type="hidden" name="_token" value="{{ csrf_token() }}">');
                form.append('<input type="hidden" name="recordID" value="' + recordID + '">');
                $('body').append(form);
                form.submit();
            }
        });

        // Reset form
        function resetForm() {
            $('#name').val('');
            $('#idtbl_product_types').val('');
            $('#recordID').val('');
            $('#recordOption').val('1');
            $('#submitBtn').html('<i class="far fa-save"></i>&nbsp;Save Entry');
        }

        $('#resetBtn').on('click', function() {
            resetForm();
        });

        @if(Session::has('msg'))
            action('{!! Session::get("msg") !!}');
        @endif
    });
</script>
@endsection
