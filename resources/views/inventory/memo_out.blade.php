@extends('layouts.app')

@section('title', 'Memo Out - GemExhibit')

@section('content')
<div class="page-header page-header-light bg-white shadow-sm mb-4">
    <div class="container-fluid">
        <div class="page-header-content py-3">
            <h1 class="page-header-title font-weight-light mb-1">
                Memo out
            </h1>
        </div>
    </div>
</div>

<div class="container-fluid">
    <!-- Filter Section -->
    <div class="card shadow-sm mb-4">
        <div class="card-body bg-light">
            <div class="mb-3 font-weight-bold text-secondary">
                <i data-feather="filter" class="mr-1"></i> Filter by
            </div>
            
            <div class="row align-items-end">
                <div class="col-md-3 mb-2">
                    <label class="small font-weight-bold">Product Category:</label>
                    <select class="form-control form-control-sm">
                        <option>Nothing selected</option>
                    </select>
                </div>
                <div class="col-md-2 mb-2">
                    <label class="small font-weight-bold">Receiver Type:</label>
                    <select class="form-control form-control-sm">
                        <option>Select</option>
                    </select>
                </div>
                <div class="col-md-2 mb-2">
                    <label class="small font-weight-bold">Receiver:</label>
                    <select class="form-control form-control-sm">
                        <option>Select</option>
                    </select>
                </div>
                <div class="col-md-5 mb-2">
                    <label class="small font-weight-bold">Creation date range:</label>
                    <div class="d-flex">
                        <div class="input-group input-group-sm mr-2" style="flex: 1;">
                            <input type="date" class="form-control" placeholder="From">
                            <div class="input-group-prepend input-group-append">
                                <span class="input-group-text border-0 bg-transparent">-></span>
                            </div>
                            <input type="date" class="form-control" placeholder="To">
                        </div>
                        <button class="btn btn-light btn-sm mr-2 text-nowrap">Clear filter</button>
                        <button class="btn btn-primary btn-sm text-nowrap">Update results</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabs -->
    <ul class="nav nav-tabs mb-4" id="memoOutTabs" role="tablist">
        <li class="nav-item flex-fill text-center">
            <a class="nav-link active font-weight-bold py-3" id="memo-out-tab" data-toggle="tab" href="#memo-out" role="tab" aria-controls="memo-out" aria-selected="true">
                Memo out (0)
            </a>
        </li>
        <li class="nav-item flex-fill text-center">
            <a class="nav-link text-muted py-3" id="returned-history-tab" data-toggle="tab" href="#returned-history" role="tab" aria-controls="returned-history" aria-selected="false">
                Returned history (0)
            </a>
        </li>
    </ul>

    <div class="tab-content" id="memoOutTabsContent">
        <!-- Memo Out Tab -->
        <div class="tab-pane fade show active" id="memo-out" role="tabpanel" aria-labelledby="memo-out-tab">
            <div class="card shadow-sm mb-5">
                <div class="card-body pb-0">
                    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">
                        <button class="btn btn-outline-secondary btn-sm mb-2"><i data-feather="upload" class="mr-1"></i> Export view</button>
                        <div class="d-flex mb-2 align-items-center">
                            <div class="input-group input-group-sm mr-2" style="width: 250px;">
                                <input type="text" class="form-control" placeholder="search e.g sku, variety, weigh">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary" type="button"><i data-feather="search"></i></button>
                                </div>
                            </div>
                            <button class="btn btn-light btn-sm mr-2 px-2" title="Columns"><i data-feather="columns"></i></button>
                            <select class="form-control form-control-sm" style="width: auto;">
                                <option>Filtered by</option>
                            </select>
                        </div>
                    </div>

                    <div class="table-responsive border-top">
                        <table class="table table-hover table-sm text-nowrap mb-0 align-middle">
                            <thead class="bg-light">
                                <tr>
                                    <th class="text-center" style="width: 40px;"><input type="checkbox"></th>
                                    <th>SKU <i data-feather="chevron-down" style="width: 14px;"></i><i data-feather="chevron-up" style="width: 14px; margin-left: -8px;"></i></th>
                                    <th>Reference <i data-feather="chevron-down" style="width: 14px;"></i><i data-feather="chevron-up" style="width: 14px; margin-left: -8px;"></i></th>
                                    <th>Category <i data-feather="chevron-down" style="width: 14px;"></i><i data-feather="chevron-up" style="width: 14px; margin-left: -8px;"></i></th>
                                    <th>Variety <i data-feather="chevron-down" style="width: 14px;"></i><i data-feather="chevron-up" style="width: 14px; margin-left: -8px;"></i></th>
                                    <th class="text-right">Quantity <i data-feather="chevron-down" style="width: 14px;"></i><i data-feather="chevron-up" style="width: 14px; margin-left: -8px;"></i></th>
                                    <th class="text-right">Weight <i data-feather="chevron-down" style="width: 14px;"></i><i data-feather="chevron-up" style="width: 14px; margin-left: -8px;"></i></th>
                                    <th class="text-right">Total price <i data-feather="chevron-down" style="width: 14px;"></i><i data-feather="chevron-up" style="width: 14px; margin-left: -8px;"></i></th>
                                    <th>Memo # <i data-feather="chevron-down" style="width: 14px;"></i><i data-feather="chevron-up" style="width: 14px; margin-left: -8px;"></i></th>
                                    <th>Creation date <i data-feather="chevron-down" style="width: 14px;"></i><i data-feather="chevron-up" style="width: 14px; margin-left: -8px;"></i></th>
                                    <th>Due date <i data-feather="chevron-down" style="width: 14px;"></i><i data-feather="chevron-up" style="width: 14px; margin-left: -8px;"></i></th>
                                    <th>Customer name <i data-feather="chevron-down" style="width: 14px;"></i><i data-feather="chevron-up" style="width: 14px; margin-left: -8px;"></i></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="12" class="text-center py-4 text-muted">
                                        No data available in table
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <div class="card-footer bg-white d-flex justify-content-between align-items-center py-2">
                    <div class="d-flex align-items-center text-sm">
                        <span class="mr-2">Show</span>
                        <select class="custom-select custom-select-sm" style="width: auto;">
                            <option>50</option>
                            <option>100</option>
                        </select>
                        <span class="ml-2">Items per page</span>
                    </div>
                    <div class="text-sm text-muted">Showing 0 to 0 of 0 entries</div>
                    <div class="btn-group">
                        <button class="btn btn-outline-secondary btn-sm" disabled>Previous</button>
                        <button class="btn btn-outline-secondary btn-sm" disabled>Next</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Returned History Tab -->
        <div class="tab-pane fade" id="returned-history" role="tabpanel" aria-labelledby="returned-history-tab">
            <div class="card shadow-sm mb-5">
                <div class="card-body text-center py-5">
                    <p class="text-muted mb-0">No returned history found.</p>
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
