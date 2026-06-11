@extends('layouts.app')

@section('title', 'Colors - Master Data')

@section('content')
<div class="page-header page-header-light bg-white shadow">
    <div class="container-fluid">
        <div class="page-header-content py-3 text-center text-lg-left">
            <h1 class="page-header-title font-weight-light mb-0">
                <div class="page-header-icon"><i data-feather="database"></i></div>
                <span>Colors</span>
            </h1>
        </div>
    </div>
</div>

<div class="container-fluid mt-2 p-0 p-md-2">
    <div class="card shadow-sm">
        <div class="card-body p-2">
            <div class="row">
                <div class="col-12 col-md-4 mb-3">
                    <form action="{{ url('Master/Colorinsertupdate') }}" method="post" autocomplete="off">
                        @csrf
                        <div class="form-group mb-2">
                            <label class="small font-weight-bold text-dark">Color Name*</label>
                            <input type="text" class="form-control form-control-sm" name="color_name" id="color_name" required placeholder="e.g. Royal Blue">
                        </div>
                        <div class="form-group mb-2">
                            <label class="small font-weight-bold text-dark">Hex Code (Optional)</label>
                            <div class="input-group input-group-sm">
                                <input type="color" class="form-control form-control-sm" name="hex_code_picker" id="hex_code_picker" style="max-width: 40px; padding: 0.1rem;" value="#002366">
                                <input type="text" class="form-control form-control-sm" name="hex_code" id="hex_code" placeholder="#002366">
                            </div>
                        </div>
                        <div class="form-group mb-2">
                            <label class="small font-weight-bold text-dark">Product Type*</label>
                            <select class="form-control form-control-sm" name="idtbl_product_types" id="idtbl_product_types" required>
                                <option value="">Select Product Type</option>
                                @foreach($productTypes as $type)
                                <option value="{{ $type->idtbl_product_types }}">{{ $type->name }}</option>
                                @endforeach
                            </select>
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
                                    <th>PRODUCT TYPE</th>
                                    <th>COLOR NAME</th>
                                    <th>PREVIEW</th>
                                    <th>STATUS</th>
                                    <th class="text-right">ACTIONS</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($colors as $color)
                                <tr>
                                    <td>{{ str_pad($color->idtbl_colors, 2, '0', STR_PAD_LEFT) }}</td>
                                    <td>{{ $color->productType->name ?? '-' }}</td>
                                    <td>{{ $color->color_name }}</td>
                                    <td>
                                        @if($color->hex_code)
                                        <span style="display:inline-block; width:20px; height:20px; background-color:{{ $color->hex_code }}; border:1px solid #ccc; border-radius:3px;"></span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($color->status == 1)
                                            <span class="badge badge-success font-weight-normal">Active</span>
                                        @else
                                            <span class="badge badge-secondary font-weight-normal">Inactive</span>
                                        @endif
                                    </td>
                                    <td class="text-right">
                                        <div class="btn-group btn-group-sm">
                                            <button type="button" class="btn btn-primary btn-sm btnEdit mr-1" 
                                                data-id="{{ $color->idtbl_colors }}" 
                                                data-product-type="{{ $color->idtbl_product_types }}"
                                                data-name="{{ $color->color_name }}" 
                                                data-hex="{{ $color->hex_code }}"
                                                title="Edit">
                                                <i class="fas fa-pen"></i>
                                            </button>
                                            @if($color->status == 1)
                                            <button type="button" class="btn btn-success btn-sm mr-1 btnStatus" data-id="{{ $color->idtbl_colors }}" title="Active - click to deactivate"><i class="fas fa-check"></i></button>
                                            @else
                                            <button type="button" class="btn btn-warning btn-sm mr-1 btnStatus" data-id="{{ $color->idtbl_colors }}" title="Inactive - click to activate"><i class="fas fa-times"></i></button>
                                            @endif
                                            <button type="button" class="btn btn-danger btn-sm btnDelete" data-id="{{ $color->idtbl_colors }}" title="Delete"><i class="fas fa-trash-alt"></i></button>
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

        // Sync color picker with hex input
        $('#hex_code_picker').on('input', function() {
            $('#hex_code').val($(this).val());
        });
        $('#hex_code').on('input', function() {
            // Only update picker if valid hex
            var val = $(this).val();
            if (/^#[0-9A-F]{6}$/i.test(val)) {
                $('#hex_code_picker').val(val);
            }
        });

        function resetForm() {
            $('#recordID').val('');
            $('#recordOption').val('1');
            $('#color_name').val('');
            $('#hex_code').val('');
            $('#hex_code_picker').val('#002366');
            $('#idtbl_product_types').val('');
            $('#submitBtn').html('<i class="far fa-save"></i>&nbsp;Add');
        }

        $('#resetBtn').on('click', function() {
            resetForm();
        });

        $(document).on('click', '.btnEdit', function() {
            var id = $(this).data('id');
            var productType = $(this).data('product-type');
            var name = $(this).data('name');
            var hex = $(this).data('hex');
            
            $('#recordID').val(id);
            $('#recordOption').val('2');
            $('#idtbl_product_types').val(productType);
            $('#color_name').val(name);
            $('#hex_code').val(hex);
            if(hex && /^#[0-9A-F]{6}$/i.test(hex)) {
                $('#hex_code_picker').val(hex);
            } else {
                $('#hex_code_picker').val('#000000');
            }
            $('#submitBtn').html('<i class="fas fa-sync"></i>&nbsp;Update');
            $('html, body').animate({ scrollTop: 0 }, 'slow');
        });
        
        // Status toggle
        $(document).on('click', '.btnStatus', function() {
            var id = $(this).data('id');
            if (confirm('Are you sure you want to change the status of this record?')) {
                var form = $('<form method="POST" action="{{ url("Master/Colorstatus") }}"></form>');
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
                var form = $('<form method="POST" action="{{ url("Master/Colordelete") }}"></form>');
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
