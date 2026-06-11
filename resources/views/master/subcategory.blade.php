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
            <div class="row">
                <div class="col-12 col-md-4 mb-3">
                    <form action="{{ url('Master/Subcategoryinsertupdate') }}" method="post" autocomplete="off">
                        @csrf
                        <div class="form-group mb-2">
                            <label class="small font-weight-bold text-dark">Select Main Variety*</label>
                            <select class="form-control form-control-sm" name="variety_id" id="variety_id" required>
                                <option value="">Select Variety</option>
                                <option value="1">Sapphire</option>
                                <option value="2">Ruby</option>
                                <option value="3">Alexandrite</option>
                            </select>
                        </div>
                        <div class="form-group mb-2">
                            <label class="small font-weight-bold text-dark">Sub-Category Name*</label>
                            <input type="text" class="form-control form-control-sm" name="subcategory_name" id="subcategory_name" required>
                        </div>
                        <div class="form-group mt-3 text-right">
                            <button type="submit" id="submitBtn" class="btn btn-primary btn-sm px-4 w-100"><i class="far fa-save"></i>&nbsp;Add</button>
                        </div>
                        <input type="hidden" name="recordOption" id="recordOption" value="1">
                        <input type="hidden" name="recordID" id="recordID" value="">
                    </form>
                </div>
                <div class="col-12 col-md-8">
                    <div class="row mb-2">
                        <div class="col-md-6 offset-md-6">
                            <div class="input-group input-group-sm">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-white">Filter Variety:</span>
                                </div>
                                <select class="form-control" id="filter_variety">
                                    <option value="">All Varieties</option>
                                    <option value="Sapphire">Sapphire</option>
                                    <option value="Ruby">Ruby</option>
                                    <option value="Alexandrite">Alexandrite</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive pb-3">
                        <table class="table table-bordered table-striped table-sm nowrap w-100" id="dataTable">
                            <thead class="thead-light">
                                <tr>
                                    <th>MAIN VARIETY</th>
                                    <th>SUB-CATEGORY</th>
                                    <th class="text-right">ACTIONS</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Sapphire</td>
                                    <td>Natural</td>
                                    <td class="text-right">
                                        <div class="btn-group btn-group-sm">
                                            <button class="btn btn-primary btn-sm btnEdit mr-1"><i class="fas fa-pen"></i></button>
                                            <button class="btn btn-success btn-sm mr-1"><i class="fas fa-check"></i></button>
                                            <button class="btn btn-danger btn-sm btnDelete"><i class="fas fa-trash-alt"></i></button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Sapphire</td>
                                    <td>Synthetic</td>
                                    <td class="text-right">
                                        <div class="btn-group btn-group-sm">
                                            <button class="btn btn-primary btn-sm btnEdit mr-1"><i class="fas fa-pen"></i></button>
                                            <button class="btn btn-success btn-sm mr-1"><i class="fas fa-check"></i></button>
                                            <button class="btn btn-danger btn-sm btnDelete"><i class="fas fa-trash-alt"></i></button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Ruby</td>
                                    <td>Pigeon Blood</td>
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
        var table = $('#dataTable').DataTable({
            responsive: true,
            order: [[0, "asc"]],
        });

        $('#filter_variety').on('change', function () {
            table.columns(0).search(this.value).draw();
        });
    });
</script>
@endsection
