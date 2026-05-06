@extends('layouts.app')

@section('title', 'Shapes & Cutting - Master Data')

@section('content')
<div class="page-header page-header-light bg-white shadow">
    <div class="container-fluid">
        <div class="page-header-content py-3 text-center text-lg-left">
            <h1 class="page-header-title font-weight-light mb-0">
                <div class="page-header-icon"><i data-feather="database"></i></div>
                <span>Shapes / Cutting</span>
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
                    <form action="{{ url('Master/Shapecutinsertupdate') }}" method="post" autocomplete="off">
                        @csrf
                        <div class="form-group mb-2">
                            <label class="small font-weight-bold text-dark d-block">Type*</label>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="typeShape" name="type" class="custom-control-input" value="Shape" checked>
                                <label class="custom-control-label" for="typeShape">Shape</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="typeCutting" name="type" class="custom-control-input" value="Cutting">
                                <label class="custom-control-label" for="typeCutting">Cutting</label>
                            </div>
                        </div>
                        <div class="form-group mb-2">
                            <label class="small font-weight-bold text-dark">Name*</label>
                            <input type="text" class="form-control form-control-sm" name="name" id="name" required placeholder="e.g. Cushion">
                        </div>
                        <div class="form-group mt-3 text-right">
                            <button type="submit" id="submitBtn" class="btn btn-primary btn-sm px-4 w-100"><i class="far fa-save"></i>&nbsp;Save Entry</button>
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
                                    <th>CATEGORY</th>
                                    <th>NAME</th>
                                    <th class="text-right">ACTIONS</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Shape</td>
                                    <td>Oval</td>
                                    <td class="text-right">
                                        <div class="btn-group btn-group-sm">
                                            <button class="btn btn-primary btn-sm btnEdit mr-1"><i class="fas fa-pen"></i></button>
                                            <button class="btn btn-danger btn-sm btnDelete"><i class="fas fa-trash-alt"></i></button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Shape</td>
                                    <td>Round</td>
                                    <td class="text-right">
                                        <div class="btn-group btn-group-sm">
                                            <button class="btn btn-primary btn-sm btnEdit mr-1"><i class="fas fa-pen"></i></button>
                                            <button class="btn btn-danger btn-sm btnDelete"><i class="fas fa-trash-alt"></i></button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Cutting</td>
                                    <td>Faceted</td>
                                    <td class="text-right">
                                        <div class="btn-group btn-group-sm">
                                            <button class="btn btn-primary btn-sm btnEdit mr-1"><i class="fas fa-pen"></i></button>
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
