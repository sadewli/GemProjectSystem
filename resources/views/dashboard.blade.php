@extends('layouts.app')

@section('title', 'Dashboard - VYS International')

@section('content')
    <div class="page-header page-header-light bg-white shadow">
        <div class="container-fluid">
            <div class="page-header-content py-3">
                <h1 class="page-header-title font-weight-light">
                    <div class="page-header-icon"><i class="fas fa-desktop"></i></div>
                    <span>Dashboard</span>
                </h1>
            </div>
        </div>
    </div>
<<<<<<< Updated upstream
    <div class="container-fluid mt-2 p-0 p-2">
        <div class="card rounded-0">
            <div class="card-body p-2">
=======

    <div class="container-fluid mt-4">
        <div class="card dashboard-hero shadow-sm border-0 mb-4">
            <div class="card-body p-4">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h2 class="h4 text-white">Welcome back, {{ Session::get('name', 'User') }}!</h2>
                        <p class="text-white-50 mb-3">Here’s a quick overview of your gem system. Use the shortcuts below to jump into inventory, GRN and master data.</p>
                        <a href="{{ url('Inventory/MyInventory') }}" class="btn btn-outline-light btn-sm">View Inventory</a>
                    </div>
                    <div class="col-md-4 text-md-right mt-3 mt-md-0">
                        <i class="fas fa-gem fa-3x text-white-50"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6 col-xl-3 mb-3">
                <div class="card dashboard-summary-card shadow-sm h-100 border-0">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="icon-circle bg-primary text-white mr-3"><i class="fas fa-gem"></i></div>
                            <div>
                                <small class="text-muted">Total Stones</small>
                                <h3 class="mb-0">12,485</h3>
                            </div>
                        </div>
                        <p class="small text-muted mb-0">Updated moments ago.</p>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3 mb-3">
                <div class="card dashboard-summary-card shadow-sm h-100 border-0">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="icon-circle bg-success text-white mr-3"><i class="fas fa-boxes"></i></div>
                            <div>
                                <small class="text-muted">Inventory Items</small>
                                <h3 class="mb-0">3,820</h3>
                            </div>
                        </div>
                        <p class="small text-muted mb-0">Current stock levels across branches.</p>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-xl-3 mb-3">
                <div class="card dashboard-summary-card shadow-sm h-100 border-0">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="icon-circle bg-info text-white mr-3"><i class="fas fa-users"></i></div>
                            <div>
                                <small class="text-muted">Active Users</small>
                                <h3 class="mb-0">29</h3>
                            </div>
                        </div>
                        <p class="small text-muted mb-0">Users active in the last 24 hours.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-body">
                <h5 class="card-title">Quick Actions</h5>
>>>>>>> Stashed changes
                <div class="row">
                    <div class="col-mb-4 col-lg-4 col-xl-4">
                        <div class="row no-gutters h-100">
                            <div class="col">
                                <div class="card-body p-0 p-2 text-right">
                                    <div class="progress" style="height: 3px;">
                                        <div class="progress-bar bg-warning" role="progressbar" style="width: 100%;"
                                            aria-valuenow="" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<<<<<<< Updated upstream
    <!doctype html>
    <html>

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="/dist/main.css" rel="stylesheet">
    </head>



    </html>
@endsection
=======
@endsection
>>>>>>> Stashed changes
