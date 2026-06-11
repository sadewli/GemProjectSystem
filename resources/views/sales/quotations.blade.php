@extends('layouts.app')

@section('title', 'Quotation Overview - GemExhibit')

@section('content')
<div class="page-header page-header-light bg-white shadow-sm mb-4">
    <div class="container-fluid">
        <div class="page-header-content py-3 d-flex align-items-center justify-content-between flex-wrap">
            <div>
                <h1 class="page-header-title font-weight-light mb-1">
                    <span>Quotation overview</span>
                </h1>
                <div class="text-muted small">Last updated: 2026-04-22 16:21:35 (1 month ago)</div>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <!-- Filter Section -->
    <div class="card shadow-sm mb-4">
        <div class="card-body bg-light">
            <div class="d-flex justify-content-between mb-3">
                <span class="font-weight-bold text-secondary"><i data-feather="filter" class="mr-1"></i> Filter by</span>
            </div>
            
            <div class="row">
                <div class="col-md-3 mb-2">
                    <label class="small font-weight-bold">Company:</label>
                    <select class="form-control form-control-sm">
                        <option>Select</option>
                    </select>
                </div>
                <div class="col-md-4 mb-2">
                    <label class="small font-weight-bold">Date range:</label>
                    <div class="input-group input-group-sm">
                        <input type="date" class="form-control" value="2025-06-04">
                        <div class="input-group-prepend input-group-append">
                            <span class="input-group-text border-0 bg-transparent">-></span>
                        </div>
                        <input type="date" class="form-control" value="2026-06-04">
                    </div>
                </div>
                <div class="col-md-3 mb-2">
                    <label class="small font-weight-bold">Creator:</label>
                    <select class="form-control form-control-sm">
                        <option>All</option>
                    </select>
                </div>
                <div class="col-md-2 mb-2 d-flex align-items-end">
                    <button class="btn btn-light btn-sm mr-2" title="Reset"><i data-feather="refresh-cw"></i></button>
                    <button class="btn btn-primary btn-sm flex-grow-1">Apply</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Status Blocks -->
    <div class="row mb-4">
        <div class="col-md-2 col-sm-4 col-6 mb-2">
            <div class="card shadow-sm border-left-primary h-100">
                <div class="card-body p-2">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <span class="font-weight-bold text-primary small">All</span>
                        <input type="checkbox">
                    </div>
                    <div class="small text-muted mb-1" style="font-size: 11px;">items: 1</div>
                    <div class="font-weight-bold small">USD: $0.00</div>
                </div>
            </div>
        </div>
        <div class="col-md-2 col-sm-4 col-6 mb-2">
            <div class="card shadow-sm border-left-warning h-100" style="border-left: 4px solid #ffc107 !important;">
                <div class="card-body p-2 bg-warning" style="opacity: 0.1; position: absolute; top:0; left:0; right:0; bottom:0;"></div>
                <div class="card-body p-2 position-relative">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <span class="font-weight-bold text-warning small">Draft</span>
                        <input type="checkbox" checked>
                    </div>
                    <div class="small text-muted mb-1" style="font-size: 11px;">items: 1</div>
                    <div class="font-weight-bold small">USD: $0.00</div>
                </div>
            </div>
        </div>
        <div class="col-md-2 col-sm-4 col-6 mb-2">
            <div class="card shadow-sm border-left-info h-100">
                <div class="card-body p-2">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <span class="font-weight-bold text-info small">Sent</span>
                        <input type="checkbox">
                    </div>
                    <div class="small text-muted mb-1" style="font-size: 11px;">items: 0</div>
                    <div class="font-weight-bold small">USD: $0.00</div>
                </div>
            </div>
        </div>
        <div class="col-md-2 col-sm-4 col-6 mb-2">
            <div class="card shadow-sm border-left-success h-100">
                <div class="card-body p-2">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <span class="font-weight-bold text-success small">Accepted</span>
                        <input type="checkbox">
                    </div>
                    <div class="small text-muted mb-1" style="font-size: 11px;">items: 0</div>
                    <div class="font-weight-bold small">USD: $0.00</div>
                </div>
            </div>
        </div>
        <div class="col-md-2 col-sm-4 col-6 mb-2">
            <div class="card shadow-sm border-left-secondary h-100">
                <div class="card-body p-2">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <span class="font-weight-bold text-secondary small">Invoiced</span>
                        <input type="checkbox">
                    </div>
                    <div class="small text-muted mb-1" style="font-size: 11px;">items: 0</div>
                    <div class="font-weight-bold small">USD: $0.00</div>
                </div>
            </div>
        </div>
        <div class="col-md-2 col-sm-4 col-6 mb-2">
            <div class="card shadow-sm border-left-danger h-100">
                <div class="card-body p-2">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <span class="font-weight-bold text-danger small">Declined</span>
                        <input type="checkbox">
                    </div>
                    <div class="small text-muted mb-1" style="font-size: 11px;">items: 0</div>
                    <div class="font-weight-bold small">USD: $0.00</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Table Header Actions -->
    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">
        <button class="btn btn-outline-secondary btn-sm mb-2"><i data-feather="settings" class="mr-1"></i> Manage Columns</button>
        <div class="d-flex mb-2">
            <div class="input-group input-group-sm mr-2" style="width: 250px;">
                <input type="text" class="form-control" placeholder="search">
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="button"><i data-feather="search"></i></button>
                </div>
            </div>
            <a href="{{ url('Sales/Quotations/new') }}" class="btn btn-primary btn-sm"><i data-feather="plus" class="mr-1"></i> Create new quotation</a>
        </div>
    </div>

    <!-- Data Table -->
    <div class="card shadow-sm mb-5">
        <div class="table-responsive">
            <table class="table table-hover table-sm text-nowrap mb-0 align-middle">
                <thead class="bg-light">
                    <tr>
                        <th>Quotation # <i data-feather="chevron-down" style="width: 14px;"></i></th>
                        <th>Reference</th>
                        <th>Customer</th>
                        <th>Issue date</th>
                        <th>Expiry date <i data-feather="chevron-down" style="width: 14px;"></i></th>
                        <th>Quot status</th>
                        <th class="text-right">Quantity <i data-feather="chevron-down" style="width: 14px;"></i></th>
                        <th class="text-right">Weight</th>
                        <th class="text-right">Amount</th>
                        <th class="text-right">Exchange Rate <i data-feather="chevron-down" style="width: 14px;"></i></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><a href="{{ url('Sales/Quotations/QUO26042201') }}" class="font-weight-bold text-primary">QUO26042201</a></td>
                        <td class="text-muted">--</td>
                        <td class="text-muted">--</td>
                        <td>April 22nd, 2026</td>
                        <td class="text-muted">--</td>
                        <td><span class="badge badge-warning font-weight-normal text-white">Draft</span></td>
                        <td class="text-right">0</td>
                        <td class="text-right">0 ct</td>
                        <td class="text-right">VEF0.00</td>
                        <td class="text-right">1.00</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="card-footer bg-white border-top d-flex justify-content-between align-items-center py-2">
            <div class="d-flex align-items-center text-sm">
                <span class="mr-2">Show</span>
                <select class="custom-select custom-select-sm" style="width: auto;">
                    <option>25</option>
                    <option>50</option>
                    <option>100</option>
                </select>
                <span class="ml-2">entries</span>
            </div>
            <div class="text-sm text-muted">Showing 1 to 1 of 1 entries</div>
            <div class="btn-group">
                <button class="btn btn-outline-secondary btn-sm" disabled>Previous</button>
                <button class="btn btn-primary btn-sm">1</button>
                <button class="btn btn-outline-secondary btn-sm" disabled>Next</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            if (typeof feather !== 'undefined') {
                feather.replace();
            }
        });
    </script>
@endsection
