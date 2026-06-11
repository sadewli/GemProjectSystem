@extends('layouts.app')

@section('title', 'Customer Memo - GemExhibit')

@section('content')
<div class="page-header page-header-light bg-white shadow-sm mb-3">
    <div class="container-fluid">
        <div class="page-header-content py-3 d-flex align-items-center justify-content-between">
            <div>
                <h1 class="page-header-title font-weight-light mb-0 d-flex align-items-center">
                    <a href="{{ url('Sales/CustomerMemo') }}" class="btn btn-sm btn-icon btn-light mr-2"><i data-feather="arrow-left"></i></a>
                    <span>MEMO26060401</span>
                    <span class="badge badge-warning ml-2 font-weight-normal text-white" style="font-size: 12px;">Draft</span>
                </h1>
                <div class="text-muted small mt-1 ml-5 pl-2">Last updated: 04 Jun 2026 11:19:56 (1 second ago)</div>
            </div>
            <div>
                <button class="btn btn-light btn-sm shadow-sm mr-1"><i data-feather="printer" class="mr-1"></i> Print</button>
                <button class="btn btn-light btn-sm shadow-sm mr-1"><i data-feather="share" class="mr-1"></i> Share</button>
                <div class="btn-group mr-1">
                    <button class="btn btn-primary btn-sm px-3"><i data-feather="save" class="mr-1"></i> Save</button>
                    <button type="button" class="btn btn-primary btn-sm dropdown-toggle dropdown-toggle-split" data-toggle="dropdown"></button>
                </div>
                <button class="btn btn-light btn-sm shadow-sm"><i data-feather="more-horizontal"></i></button>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid mt-3">
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-3 form-group">
                    <label class="small font-weight-bold">Memo id:</label>
                    <input type="text" class="form-control form-control-sm" value="MEMO26060401">
                </div>
                <div class="col-md-3 form-group">
                    <label class="small font-weight-bold">Reference:</label>
                    <input type="text" class="form-control form-control-sm">
                </div>
                <div class="col-md-3 form-group">
                    <label class="small font-weight-bold">Issue date:</label>
                    <input type="date" class="form-control form-control-sm" value="2026-06-04">
                </div>
                <div class="col-md-3 form-group">
                    <label class="small font-weight-bold">Due date:</label>
                    <input type="date" class="form-control form-control-sm" placeholder="Suggested due date">
                </div>
            </div>
            <div class="row">
                <div class="col-md-3 form-group">
                    <label class="small font-weight-bold">From:</label>
                    <select class="form-control form-control-sm"><option>svtd</option></select>
                </div>
                <div class="col-md-3 form-group">
                    <label class="small font-weight-bold">To:</label>
                    <select class="form-control form-control-sm"><option>Select</option></select>
                </div>
                <div class="col-md-3 form-group">
                    <label class="small font-weight-bold">Auto-populate price from:</label>
                    <select class="form-control form-control-sm"><option>Matrix Price</option></select>
                </div>
                <div class="col-md-3 form-group">
                    <label class="small font-weight-bold">Currency:</label>
                    <select class="form-control form-control-sm"><option>Venezuela</option></select>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3 form-group mb-0">
                    <label class="small font-weight-bold">Exchange Rate:</label>
                    <div class="input-group input-group-sm">
                        <input type="number" class="form-control" value="1">
                        <div class="input-group-append">
                            <span class="input-group-text bg-white">B</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 form-group mb-0">
                    <label class="small font-weight-bold">Requested By:</label>
                    <select class="form-control form-control-sm"><option>Select</option></select>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabs -->
    <ul class="nav nav-tabs mb-4 border-bottom" id="memoTabs" role="tablist">
        <li class="nav-item">
            <a class="nav-link active font-weight-bold" style="border-top:3px solid #007bff; color:#007bff;" id="current-tab" data-toggle="tab" href="#current" role="tab">Current (0)</a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-muted" id="returned-tab" data-toggle="tab" href="#returned" role="tab">Returned & sold (0)</a>
        </li>
    </ul>

    <!-- Add items section -->
    <div class="card shadow-sm mb-4">
        <div class="card-body text-center py-5 bg-light">
            <h5 class="font-weight-bold">Add items to Memo</h5>
            <p class="text-muted small">This Memo currently does not have any items in it.<br>Please add items to this Memo.</p>
            <div class="mt-3">
                <button class="btn btn-outline-primary btn-sm mr-2"><i data-feather="maximize"></i> Scan / type to add</button>
                <button class="btn btn-outline-primary btn-sm mr-2"><i data-feather="plus"></i> Add from catalog</button>
                <button class="btn btn-outline-primary btn-sm"><i data-feather="plus-circle"></i> Add new item</button>
            </div>
        </div>
    </div>

    <!-- Terms, Notes, and Totals -->
    <div class="row mb-4">
        <div class="col-md-7">
            <div class="form-group">
                <label class="font-weight-bold small">Term & Conditions</label>
                <select class="form-control form-control-sm"><option>Select template</option></select>
            </div>
            <div class="form-group">
                <label class="font-weight-bold small">Note to customer</label>
                <textarea class="form-control" rows="4" placeholder="Add a note to your customer"></textarea>
                <div class="mt-2 text-right">
                    <button class="btn btn-outline-danger btn-sm">Clear</button>
                    <button class="btn btn-light btn-sm border">Save</button>
                </div>
            </div>
        </div>
        <div class="col-md-5">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-3 font-weight-bold">
                        <span>Subtotal:</span>
                        <span>VEF0.00</span>
                    </div>
                    <div class="form-group row no-gutters align-items-center mb-2">
                        <label class="col-sm-4 small font-weight-bold mb-0">Discount:</label>
                        <div class="col-sm-3 px-1"><input type="number" class="form-control form-control-sm"></div>
                        <div class="col-sm-2 px-1"><select class="form-control form-control-sm"><option>VEF</option></select></div>
                        <div class="col-sm-3 text-right">VEF0.00</div>
                    </div>
                    <div class="form-group row no-gutters align-items-center mb-2">
                        <label class="col-sm-4 small font-weight-bold mb-0">Shipping & handl.:</label>
                        <div class="col-sm-3 px-1"><input type="number" class="form-control form-control-sm"></div>
                        <div class="col-sm-2 px-1 text-muted small">VEF</div>
                        <div class="col-sm-3 text-right">VEF0.00</div>
                    </div>
                    <div class="form-group row no-gutters align-items-center mb-2">
                        <label class="col-sm-4 small font-weight-bold mb-0">Vat:</label>
                        <div class="col-sm-3 px-1"><input type="number" class="form-control form-control-sm"></div>
                        <div class="col-sm-2 px-1 text-muted small">%</div>
                        <div class="col-sm-3 text-right">VEF0.00</div>
                    </div>
                    <div class="form-group row no-gutters align-items-center mb-3">
                        <label class="col-sm-4 small font-weight-bold mb-0">Tax(es):</label>
                        <div class="col-sm-3 px-1"><input type="number" class="form-control form-control-sm"></div>
                        <div class="col-sm-2 px-1 text-muted small">%</div>
                        <div class="col-sm-3 text-right">VEF0.00</div>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between h5 text-primary mb-0 font-weight-bold">
                        <span>Total :</span>
                        <span>VEF0.00</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Product Summary -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-white font-weight-bold d-flex justify-content-between align-items-center">
            Product summary
            <i data-feather="chevron-down"></i>
        </div>
        <div class="card-body text-center py-4 bg-light">
            <h6 class="font-weight-bold">Empty document</h6>
            <p class="small text-muted mb-0">This Memo currently does not have any items in it. Please add<br>items to this Memo</p>
        </div>
    </div>

    <!-- Additional (Internal Information) -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-white font-weight-bold d-flex justify-content-between align-items-center">
            Additional (Internal Information)
            <i data-feather="chevron-down"></i>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-5 form-group">
                    <label class="small font-weight-bold">Internal note</label>
                    <textarea class="form-control" rows="3" placeholder="Add internal note"></textarea>
                    <div class="text-right mt-2">
                        <button class="btn btn-outline-danger btn-sm">Clear</button>
                        <button class="btn btn-light btn-sm border">Save</button>
                    </div>
                </div>
                <div class="col-md-3">
                    <label class="small font-weight-bold">Document</label>
                    <div class="border rounded p-3 text-center bg-light">
                        <button class="btn btn-white btn-sm shadow-sm">Upload file</button>
                        <p class="small text-muted mt-2 mb-0">Max file size 2 MB</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <label class="small font-weight-bold">Broker</label>
                    <select class="form-control form-control-sm mb-3"><option>None</option></select>
                    
                    <div class="row">
                        <div class="col-6">
                            <label class="small font-weight-bold text-muted">Broker fee:</label>
                            <div class="input-group input-group-sm">
                                <input type="number" class="form-control" value="0">
                                <div class="input-group-append">
                                    <span class="input-group-text bg-white">%</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <label class="small font-weight-bold text-muted">Broker total:</label>
                            <div class="mt-1">VEF0.00</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- History -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-white font-weight-bold d-flex justify-content-between align-items-center">
            History
            <i data-feather="chevron-down"></i>
        </div>
        <div class="card-body">
            <div class="d-flex justify-content-between mb-3 align-items-center">
                <span class="small text-muted">Created by Madushika sadamali on 4 Jun 2026 at 11:19 am.</span>
                <div class="d-flex">
                    <div class="input-group input-group-sm mr-2" style="width: 200px;">
                        <input type="text" class="form-control" placeholder="search">
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary" type="button"><i data-feather="search"></i></button>
                        </div>
                    </div>
                    <select class="form-control form-control-sm" style="width: auto;"><option>Show 10</option></select>
                </div>
            </div>
            
            <div class="table-responsive">
                <table class="table table-sm text-center mb-0 border">
                    <thead class="bg-light">
                        <tr>
                            <th>Date/Time <i data-feather="chevron-up" style="width: 14px;"></i></th>
                            <th>User</th>
                            <th>Role</th>
                            <th>Action</th>
                            <th>Detail</th>
                            <th>Action Type</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="6" class="py-4 text-muted small">This List has not had any changes made to it</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-between align-items-center mt-2">
                <div class="text-sm">
                    Show <select class="custom-select custom-select-sm" style="width: auto;"><option>10</option></select> Items per page
                </div>
                <div class="text-sm text-muted">Showing 0 to 0 of 0 entries</div>
                <div class="btn-group">
                    <button class="btn btn-outline-secondary btn-sm" disabled>Previous</button>
                    <button class="btn btn-outline-secondary btn-sm" disabled>Next</button>
                </div>
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
