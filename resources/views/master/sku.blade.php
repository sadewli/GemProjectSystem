@extends('layouts.app')

@section('title', 'SKU Management - GemExhibit')

@section('content')
<div class="page-header page-header-light bg-white shadow-sm mb-4">
    <div class="container-fluid">
        <div class="page-header-content py-3 d-flex align-items-center justify-content-between flex-wrap">
            <div>
                <h1 class="page-header-title font-weight-light mb-1">SKU Management</h1>
            </div>
            <div>
                <button class="btn btn-primary btn-sm shadow-sm" data-toggle="modal" data-target="#skuModal" onclick="resetForm()">
                    <i data-feather="plus" class="mr-1"></i> Create New SKU
                </button>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    @if(Session::has('msg'))
        <div class="alert alert-{{ json_decode(Session::get('msg'))->class }} alert-dismissible fade show" role="alert">
            {{ json_decode(Session::get('msg'))->message }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <div class="d-flex justify-content-end mb-3">
                <div class="input-group input-group-sm" style="width: 250px;">
                    <input type="text" class="form-control" id="searchInput" placeholder="search SKU name">
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="button"><i data-feather="search"></i></button>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover table-sm border align-middle text-center" id="skuTable">
                    <thead class="bg-light">
                        <tr>
                            <th style="width: 50px;">#</th>
                            <th class="text-left">SKU Name</th>
                            <th>Status</th>
                            <th>Insert Date/Time</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($skus as $index => $sku)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td class="text-left">{{ $sku->sku_name }}</td>
                            <td>
                                @if($sku->status == 1)
                                    <span class="badge badge-success font-weight-normal">Active</span>
                                @else
                                    <span class="badge badge-secondary font-weight-normal">Inactive</span>
                                @endif
                            </td>
                            <td>{{ \Carbon\Carbon::parse($sku->insertdatetime ?? $sku->created_at)->format('Y-m-d H:i:s') }}</td>
                            <td>
                                <button class="btn btn-sm btn-outline-info py-0 px-2" onclick="viewSku({{ $sku->idtbl_skus }})">View</button>
                                <button class="btn btn-sm btn-outline-primary py-0 px-2" onclick="editSku({{ $sku->idtbl_skus }})">Edit</button>
                                <button class="btn btn-sm btn-outline-warning py-0 px-2" onclick="statusSku({{ $sku->idtbl_skus }})">Status</button>
                                <button class="btn btn-sm btn-outline-danger py-0 px-2" onclick="deleteSku({{ $sku->idtbl_skus }})">Delete</button>
                            </td>
                        </tr>
                        @endforeach
                        @if($skus->isEmpty())
                        <tr>
                            <td colspan="5" class="text-muted py-3">No data available in table</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-between align-items-center mt-3">
                <div class="text-sm">
                    Show 
                    <select class="custom-select custom-select-sm d-inline-block" style="width: auto;">
                        <option>10</option>
                        <option>25</option>
                        <option>50</option>
                    </select> 
                    entries
                </div>
                <div class="text-sm text-muted">Showing 1 to {{ $skus->count() }} of {{ $skus->count() }} entries</div>
                <div class="btn-group">
                    <button class="btn btn-outline-secondary btn-sm" disabled>Previous</button>
                    <button class="btn btn-primary btn-sm">1</button>
                    <button class="btn btn-outline-secondary btn-sm" disabled>Next</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="skuModal" tabindex="-1" role="dialog" aria-labelledby="skuModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="{{ url('Master/Skuinsertupdate') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h5 class="modal-title font-weight-bold" id="skuModalLabel">Add / Edit SKU</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="recordOption" id="recordOption" value="1">
                    <input type="hidden" name="recordID" id="recordID" value="">
                    
                    <div class="form-group">
                        <label class="font-weight-bold">SKU Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="sku_name" id="sku_name" required placeholder="Enter SKU name">
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Delete Form -->
<form action="{{ url('Master/Skudelete') }}" method="POST" id="deleteForm" style="display: none;">
    @csrf
    <input type="hidden" name="recordID" id="deleteRecordID">
</form>

<!-- View Modal -->
<div class="modal fade" id="viewSkuModal" tabindex="-1" role="dialog" aria-labelledby="viewSkuModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h5 class="modal-title font-weight-bold" id="viewSkuModalLabel">View SKU Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-borderless table-sm mb-0">
                    <tbody>
                        <tr>
                            <td class="font-weight-bold" style="width: 150px;">SKU ID</td>
                            <td>: <span id="view_sku_id"></span></td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold">SKU Name</td>
                            <td>: <span id="view_sku_name"></span></td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold">Status</td>
                            <td>: <span id="view_sku_status"></span></td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold">Created By</td>
                            <td>: <span id="view_sku_creator"></span></td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold">Insert Date/Time</td>
                            <td>: <span id="view_sku_insert"></span></td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold">Last Updated</td>
                            <td>: <span id="view_sku_update"></span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Status Modal -->
<div class="modal fade" id="statusSkuModal" tabindex="-1" role="dialog" aria-labelledby="statusSkuModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="{{ url('Master/Skustatus') }}" method="POST" id="statusForm">
            @csrf
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h5 class="modal-title font-weight-bold" id="statusSkuModalLabel">Change SKU Status</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="recordID" id="statusRecordID" value="">
                    
                    <p>Are you sure you want to change the status of this SKU?</p>
                    <div class="mb-3">
                        <strong>SKU Name:</strong> <span id="status_sku_name"></span><br>
                        <strong>Current Status:</strong> <span id="status_sku_current"></span>
                    </div>
                    
                    <div class="form-group">
                        <label class="font-weight-bold">Change to:</label>
                        <div class="custom-control custom-radio mb-2">
                            <input type="radio" id="statusActive" name="status" class="custom-control-input" value="1">
                            <label class="custom-control-label" for="statusActive">Active</label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input type="radio" id="statusInactive" name="status" class="custom-control-input" value="0">
                            <label class="custom-control-label" for="statusInactive">Inactive</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Message Modal -->
<div class="modal fade" id="messageModal" tabindex="-1" role="dialog" aria-labelledby="messageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content text-center">
            <div class="modal-body py-4">
                <i id="messageModalIcon" class="fas fa-check-circle fa-4x mb-3 text-success"></i>
                <h5 class="modal-title font-weight-bold mb-2" id="messageModalTitle"></h5>
                <p class="mb-0" id="messageModalBody"></p>
            </div>
        </div>
    </div>
</div>


@endsection

@section('script')
    <script>
        $(document).ready(function() {
            if (typeof feather !== 'undefined') { feather.replace(); }
            
            if (typeof window.actionJSONData !== 'undefined' && window.actionJSONData !== '') {
                let actionData = window.actionJSONData;
                $('#messageModalTitle').text(actionData.title || (actionData.type === 'success' ? 'Success!' : 'Notice'));
                $('#messageModalBody').text(actionData.message);
                
                // Update icon based on type
                $('#messageModalIcon').attr('class', actionData.icon + ' fa-4x mb-3 text-' + actionData.type);
                
                $('#messageModal').modal('show');
                setTimeout(function() {
                    $('#messageModal').modal('hide');
                }, 2000);
            }
        });

        function resetForm() {
            $('#recordOption').val('1');
            $('#recordID').val('');
            $('#sku_name').val('');
            $('#skuModalLabel').text('Add SKU');
        }

        function editSku(id) {
            $.ajax({
                url: "{{ url('Master/Skuedit') }}",
                type: "POST",
                data: {
                    recordID: id,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    $('#recordOption').val('2');
                    $('#recordID').val(response.idtbl_skus);
                    $('#sku_name').val(response.sku_name);
                    $('#skuModalLabel').text('Edit SKU');
                    $('#skuModal').modal('show');
                },
                error: function() {
                    alert('Error retrieving data.');
                }
            });
        }
        
        function viewSku(id) {
            $.ajax({
                url: "{{ url('Master/Skuedit') }}",
                type: "POST",
                data: {
                    recordID: id,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    $('#view_sku_id').text(response.idtbl_skus);
                    $('#view_sku_name').text(response.sku_name);
                    
                    if (response.status == 1) {
                        $('#view_sku_status').html('<span class="badge badge-success">Active</span>');
                    } else {
                        $('#view_sku_status').html('<span class="badge badge-secondary">Inactive</span>');
                    }
                    
                    $('#view_sku_creator').text(response.created_by || 'Admin');
                    
                    let insertDate = response.insertdatetime ? response.insertdatetime : response.created_at;
                    let updateDate = response.updatedatetime ? response.updatedatetime : response.updated_at;
                    
                    $('#view_sku_insert').text(insertDate);
                    $('#view_sku_update').text(updateDate);
                    
                    $('#viewSkuModal').modal('show');
                },
                error: function() {
                    alert('Error retrieving data.');
                }
            });
        }
        
        function statusSku(id) {
            $.ajax({
                url: "{{ url('Master/Skuedit') }}",
                type: "POST",
                data: {
                    recordID: id,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    $('#statusRecordID').val(response.idtbl_skus);
                    $('#status_sku_name').text(response.sku_name);
                    
                    if (response.status == 1) {
                        $('#status_sku_current').html('<span class="badge badge-success">Active</span>');
                        $('#statusActive').prop('checked', true);
                    } else {
                        $('#status_sku_current').html('<span class="badge badge-secondary">Inactive</span>');
                        $('#statusInactive').prop('checked', true);
                    }
                    
                    $('#statusSkuModal').modal('show');
                },
                error: function() {
                    alert('Error retrieving data.');
                }
            });
        }

        function deleteSku(id) {
            if(confirm('Are you sure you want to delete this SKU?')) {
                $('#deleteRecordID').val(id);
                $('#deleteForm').submit();
            }
        }
    </script>
@endsection
