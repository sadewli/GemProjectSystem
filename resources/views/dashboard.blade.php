@extends('layouts.app')

@section('title', 'Dashboard - Ceylon Center Gem')

@section('style')
    <style>
        .dashboard-summary-card .card-body {
            min-height: 130px;
        }
        .dashboard-summary-card .icon-circle {
            width: 48px;
            height: 48px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            font-size: 18px;
        }
        .dashboard-hero {
            background: linear-gradient(135deg, rgba(14, 82, 160, 0.95), rgba(37, 121, 205, 0.92));
            color: #fff;
        }
        .dashboard-hero .btn-outline-light {
            border-color: rgba(255,255,255,0.35);
        }
    </style>
@endsection

@section('content')
    <div class="page-header page-header-light bg-white shadow-sm">
        <div class="container-fluid">
            <div class="page-header-content py-3">
                <h1 class="page-header-title font-weight-light d-flex align-items-center">
                    <div class="page-header-icon mr-2"><i class="fas fa-desktop"></i></div>
                    <span>Dashboard</span>
                </h1>
            </div>
        </div>
    </div>

    <div class="container-fluid mt-4">
        <div class="card dashboard-hero shadow-sm border-0 mb-4">
            <div class="card-body p-4">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h2 class="h4 text-white">Welcome back, {{ Session::get('name', 'User') }}!</h2>
                        <p class="text-white-50 mb-3">Here's a quick overview of your gem system. Use the shortcuts below to jump into inventory, GRN and master data.</p>
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
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <a href="{{ url('Master/Variety') }}" class="btn btn-outline-secondary btn-block">Manage Variety</a>
                    </div>
                    <div class="col-md-4 mb-3">
                        <a href="{{ url('Master/Color') }}" class="btn btn-outline-secondary btn-block">Manage Colors</a>
                    </div>
                    <div class="col-md-4 mb-3">
                        <a href="{{ url('Inventory/MyInventory') }}" class="btn btn-outline-secondary btn-block">Review Inventory</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
