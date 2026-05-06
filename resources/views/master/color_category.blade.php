@extends('layouts.app')

@section('title', 'Color Categories - Master Data')

@section('content')
<div class="page-header page-header-light bg-white shadow">
    <div class="container-fluid">
        <div class="page-header-content py-3 text-center text-lg-left">
            <h1 class="page-header-title font-weight-light mb-0">
                <div class="page-header-icon"><i data-feather="database"></i></div>
                <span>Color Categories</span>
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
                    <form action="{{ url('Master/Colorcategoryinsertupdate') }}" method="post" autocomplete="off">
                        @csrf
                        <div class="form-group mb-2">
                            <label class="small font-weight-bold text-dark">Color Category Name*</label>
                            <input type="text" class="form-control form-control-sm" name="category_name" id="category_name" required placeholder="e.g. Primary/Basic">
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
                                    <th>CATEGORY NAME</th>
                                    <th class="text-right">ACTIONS</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>01</td>
                                    <td>Primary/Basic</td>
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
                                    <td>Pastel</td>
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
    });
</script>
@endsection
