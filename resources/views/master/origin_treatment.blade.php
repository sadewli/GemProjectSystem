@extends('layouts.app')

@section('title', 'Origin & Treatment - Master Data')

@section('content')
<div class="page-header page-header-light bg-white shadow">
    <div class="container-fluid">
        <div class="page-header-content py-3 text-center text-lg-left">
            <h1 class="page-header-title font-weight-light mb-0">
                <div class="page-header-icon"><i data-feather="database"></i></div>
                <span>Origin & Treatment</span>
            </h1>
        </div>
    </div>
</div>

<div class="container-fluid mt-2">
    @include('layouts.master_data_nav_bar')
</div>

<div class="container-fluid mt-2 p-0 p-md-2">
    <div class="row">
        <!-- Origin Section -->
        <div class="col-12 col-md-6 mb-3">
            <div class="card shadow-sm h-100">
                <div class="card-body p-3">
                    <h6 class="font-weight-bold text-dark mb-3">Manage Origins</h6>
                    <form action="{{ url('Master/Origininsertupdate') }}" method="post" autocomplete="off" class="mb-4">
                        @csrf
                        <div class="form-group mb-2">
                            <label class="small font-weight-bold">Origin Name*</label>
                            <div class="input-group input-group-sm">
                                <input type="text" class="form-control" name="origin_name" id="origin_name" required placeholder="Madagascar">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="submit">Add</button>
                                </div>
                            </div>
                        </div>
                    </form>
                    
                    <label class="small font-weight-bold text-dark">Current Origins:</label>
                    <div class="list-group list-group-flush border-top">
                        <div class="list-group-item d-flex justify-content-between align-items-center px-0 py-2">
                            <span>1. Sri Lanka</span>
                            <div class="btn-group btn-group-sm">
                                <button class="btn btn-link text-primary p-0 mr-2"><i class="fas fa-pen"></i></button>
                                <button class="btn btn-link text-danger p-0"><i class="fas fa-trash-alt"></i></button>
                            </div>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center px-0 py-2">
                            <span>2. Madagascar</span>
                            <div class="btn-group btn-group-sm">
                                <button class="btn btn-link text-primary p-0 mr-2"><i class="fas fa-pen"></i></button>
                                <button class="btn btn-link text-danger p-0"><i class="fas fa-trash-alt"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Treatment Section -->
        <div class="col-12 col-md-6 mb-3">
            <div class="card shadow-sm h-100">
                <div class="card-body p-3">
                    <h6 class="font-weight-bold text-dark mb-3">Manage Treatments</h6>
                    <form action="{{ url('Master/Treatmentinsertupdate') }}" method="post" autocomplete="off" class="mb-4">
                        @csrf
                        <div class="form-group mb-2">
                            <label class="small font-weight-bold">Treatment Name*</label>
                            <div class="input-group input-group-sm">
                                <input type="text" class="form-control" name="treatment_name" id="treatment_name" required placeholder="Heated">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="submit">Add</button>
                                </div>
                            </div>
                        </div>
                    </form>

                    <label class="small font-weight-bold text-dark">Current Treatments:</label>
                    <div class="list-group list-group-flush border-top">
                        <div class="list-group-item d-flex justify-content-between align-items-center px-0 py-2">
                            <span>1. Unheated</span>
                            <div class="btn-group btn-group-sm">
                                <button class="btn btn-link text-primary p-0 mr-2"><i class="fas fa-pen"></i></button>
                                <button class="btn btn-link text-danger p-0"><i class="fas fa-trash-alt"></i></button>
                            </div>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center px-0 py-2">
                            <span>2. Heated (Normal)</span>
                            <div class="btn-group btn-group-sm">
                                <button class="btn btn-link text-primary p-0 mr-2"><i class="fas fa-pen"></i></button>
                                <button class="btn btn-link text-danger p-0"><i class="fas fa-trash-alt"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
