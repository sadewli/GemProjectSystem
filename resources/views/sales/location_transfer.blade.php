@extends('layouts.app')

@section('title', 'Location Transfer Overview - GemExhibit')

@section('content')
<div class="page-header page-header-light bg-white shadow-sm mb-4">
    <div class="container-fluid">
        <div class="page-header-content py-3 d-flex align-items-center justify-content-between flex-wrap">
            <div>
                <h1 class="page-header-title font-weight-light mb-1">Location transfer overview</h1>
                <div class="text-muted small">Last updated: 2026-04-28 12:57:20 (1 month ago)</div>
            </div>
            <div>
                <button class="btn btn-light btn-sm shadow-sm"><i data-feather="download" class="mr-1"></i> Excel Import</button>
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
                <span class="text-primary" style="cursor:pointer;"><i data-feather="dollar-sign" class="mr-1"></i> All currencies (i)</span>
            </div>
            <div class="row">
                <div class="col-md-3 mb-2">
                    <label class="small font-weight-bold">Requested by:</label>
                    <select class="form-control form-control-sm">
                        <option>Select employee</option>
                    </select>
                </div>
                <div class="col-md-2 mb-2">
                    <label class="small font-weight-bold">Transfer type:</label>
                    <select class="form-control form-control-sm">
                        <option>Select type</option>
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
                <div class="col-md-2 mb-2">
                    <label class="small font-weight-bold">Creator:</label>
                    <select class="form-control form-control-sm">
                        <option>Select</option>
                    </select>
                </div>
                <div class="col-md-1 mb-2 d-flex align-items-end">
                    <button class="btn btn-light btn-sm mr-1" title="Reset"><i data-feather="refresh-cw"></i></button>
                    <button class="btn btn-primary btn-sm">Apply</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Status Blocks -->
    <div class="row mb-4">
        <div class="col-md col-sm-4 col-6 mb-2">
            <div class="card shadow-sm h-100" style="border-left: 4px solid #007bff;">
                <div class="card-body p-2">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <span class="font-weight-bold text-primary small">All</span>
                        <input type="checkbox">
                    </div>
                    <div class="small text-muted mb-1" style="font-size: 11px;">items: 3</div>
                    <div class="font-weight-bold small">USD: $0.00</div>
                </div>
            </div>
        </div>
        <div class="col-md col-sm-4 col-6 mb-2">
            <div class="card shadow-sm h-100" style="border-left: 4px solid #ffc107;">
                <div class="card-body p-2">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <span class="font-weight-bold text-warning small">Draft</span>
                        <input type="checkbox" checked>
                    </div>
                    <div class="small text-muted mb-1" style="font-size: 11px;">items: 3</div>
                    <div class="font-weight-bold small">USD: $0.00</div>
                </div>
            </div>
        </div>
        <div class="col-md col-sm-4 col-6 mb-2">
            <div class="card shadow-sm h-100" style="border-left: 4px solid #17a2b8;">
                <div class="card-body p-2">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <span class="font-weight-bold text-info small">In transfer</span>
                        <input type="checkbox">
                    </div>
                    <div class="small text-muted mb-1" style="font-size: 11px;">items: 0</div>
                    <div class="font-weight-bold small">USD: $0.00</div>
                </div>
            </div>
        </div>
        <div class="col-md col-sm-4 col-6 mb-2">
            <div class="card shadow-sm h-100" style="border-left: 4px solid #28a745;">
                <div class="card-body p-2">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <span class="font-weight-bold text-success small">Transferred</span>
                        <input type="checkbox">
                    </div>
                    <div class="small text-muted mb-1" style="font-size: 11px;">items: 0</div>
                    <div class="font-weight-bold small">USD: $0.00</div>
                </div>
            </div>
        </div>
        <div class="col-md col-sm-4 col-6 mb-2">
            <div class="card shadow-sm h-100" style="border-left: 4px solid #dc3545;">
                <div class="card-body p-2">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <span class="font-weight-bold text-danger small">Deleted</span>
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
            <button type="button" class="btn btn-primary btn-sm" id="btnCreateTransfer" data-toggle="modal" data-target="#transferTypeModal">
                <i data-feather="plus" class="mr-1"></i> Create new transfer document
            </button>
        </div>
    </div>

    <!-- Data Table -->
    <div class="card shadow-sm mb-5">
        <div class="table-responsive">
            <table class="table table-hover table-sm text-nowrap mb-0 align-middle">
                <thead class="bg-light">
                    <tr>
                        <th>Transfer # <i data-feather="chevron-down" style="width: 14px;"></i></th>
                        <th>Requested by</th>
                        <th>Issue date</th>
                        <th>Expiry date <i data-feather="chevron-down" style="width: 14px;"></i></th>
                        <th>Status</th>
                        <th class="text-right">Quantity <i data-feather="chevron-down" style="width: 14px;"></i></th>
                        <th class="text-right">Weight</th>
                        <th class="text-right">Amount</th>
                        <th class="text-center">Sent <i data-feather="chevron-down" style="width: 14px;"></i></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><a href="{{ url('Sales/LocationTransfer/TR26042801') }}" class="font-weight-bold text-primary">TR26042801</a></td>
                        <td class="text-muted">--</td>
                        <td>April 28th, 2026</td>
                        <td>April 28th, 2026</td>
                        <td><span class="badge badge-warning font-weight-normal text-white">Draft</span></td>
                        <td class="text-right">0</td>
                        <td class="text-right">0.00 ct</td>
                        <td class="text-right">VEF0.00</td>
                        <td class="text-center">-</td>
                    </tr>
                    <tr>
                        <td><a href="{{ url('Sales/LocationTransfer/TR26042202') }}" class="font-weight-bold text-primary">TR26042202</a></td>
                        <td class="text-muted">--</td>
                        <td>April 22nd, 2026</td>
                        <td>April 22nd, 2026</td>
                        <td><span class="badge badge-warning font-weight-normal text-white">Draft</span></td>
                        <td class="text-right">0</td>
                        <td class="text-right">0.00 ct</td>
                        <td class="text-right">VEF0.00</td>
                        <td class="text-center">-</td>
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
            <div class="text-sm text-muted">Showing 1 to 2 of 2 entries</div>
            <div class="btn-group">
                <button class="btn btn-outline-secondary btn-sm" disabled>Previous</button>
                <button class="btn btn-primary btn-sm">1</button>
                <button class="btn btn-outline-secondary btn-sm" disabled>Next</button>
            </div>
        </div>
    </div>
</div>

<!-- Select Transfer Type Modal -->
<div class="modal fade" id="transferTypeModal" tabindex="-1" role="dialog" aria-labelledby="transferTypeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 460px;">
        <div class="modal-content">
            <div class="modal-header border-bottom-0 pb-0">
                <button type="button" class="close ml-auto" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body px-5 py-4">
                <h5 class="text-center font-weight-bold mb-4">Select Transfer Type</h5>
                <div class="form-group">
                    <select class="form-control" id="transferTypeSelect">
                        <option value="">Select</option>
                        <option value="company_to_company">Company to company</option>
                        <option value="location_to_location">Location to Location</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer border-top-0 justify-content-center pb-4">
                <button type="button" class="btn btn-light px-4 mr-2" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary px-4" id="btnProceedTransfer">Proceed</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            if (typeof feather !== 'undefined') { feather.replace(); }

            $('#btnProceedTransfer').on('click', function() {
                var type = $('#transferTypeSelect').val();
                if (!type) {
                    alert('Please select a transfer type.');
                    return;
                }
                window.location.href = '{{ url("Sales/LocationTransfer/new") }}?type=' + type;
            });

            // Reset modal on close
            $('#transferTypeModal').on('hidden.bs.modal', function() {
                $('#transferTypeSelect').val('');
            });
        });
    </script>
@endsection
