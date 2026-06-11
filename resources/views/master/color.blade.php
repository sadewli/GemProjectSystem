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
                            <label class="small font-weight-bold text-dark">Color Category*</label>
                            <select class="form-control form-control-sm" name="color_category" id="color_category" required>
                                <option value="">Select Category</option>
                                <option value="Primary/Basic">Primary/Basic</option>
                                <option value="Pastel">Pastel</option>
                                <option value="Neon">Neon</option>
                            </select>
                        </div>
                        <div class="form-group mt-3 text-right">
                            <button type="submit" id="submitBtn" class="btn btn-primary btn-sm px-4 w-100"><i class="far fa-save"></i>&nbsp;Add</button>
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
                                    <th>COLOR NAME</th>
                                    <th>PREVIEW</th>
                                    <th class="text-right">ACTIONS</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>01</td>
                                    <td>Blue</td>
                                    <td><span style="display:inline-block; width:20px; height:20px; background-color:#0000FF; border:1px solid #ccc; border-radius:3px;"></span></td>
                                    <td class="text-right">
                                        <div class="btn-group btn-group-sm">
                                            <button class="btn btn-primary btn-sm btnEdit mr-1"><i class="fas fa-pen"></i></button>
                                            <button class="btn btn-success btn-sm mr-1"><i class="fas fa-check"></i></button>
                                            <button class="btn btn-danger btn-sm btnDelete"><i class="fas fa-trash-alt"></i></button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>02</td>
                                    <td>Pink</td>
                                    <td><span style="display:inline-block; width:20px; height:20px; background-color:#FFC0CB; border:1px solid #ccc; border-radius:3px;"></span></td>
                                    <td class="text-right">
                                        <div class="btn-group btn-group-sm">
                                            <button class="btn btn-primary btn-sm btnEdit mr-1"><i class="fas fa-pen"></i></button>
                                            <button class="btn btn-success btn-sm mr-1"><i class="fas fa-check"></i></button>
                                            <button class="btn btn-danger btn-sm btnDelete"><i class="fas fa-trash-alt"></i></button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>03</td>
                                    <td>Yellow</td>
                                    <td><span style="display:inline-block; width:20px; height:20px; background-color:#FFFF00; border:1px solid #ccc; border-radius:3px;"></span></td>
                                    <td class="text-right">
                                        <div class="btn-group btn-group-sm">
                                            <button class="btn btn-primary btn-sm btnEdit mr-1"><i class="fas fa-pen"></i></button>
                                            <button class="btn btn-success btn-sm mr-1"><i class="fas fa-check"></i></button>
                                            <button class="btn btn-danger btn-sm btnDelete"><i class="fas fa-trash-alt"></i></button>
                                        </div>
                                    </td>
                                </tr>
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
    });
</script>
@endsection
