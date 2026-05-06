@extends('layouts.app')
@section('content')
<div class="page-header page-header-light bg-white shadow">
    <div class="container-fluid">
        <div class="page-header-content py-3 text-center text-lg-left">
            <h1 class="page-header-title font-weight-light mb-0">
                <div class="page-header-icon"><i class="fa-light fa-box"></i></div>
                <span>Distributor GRN</span>
            </h1>
        </div>
    </div>
</div>

<div class="container-fluid mt-2 p-0 p-md-2">
    <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">GRN Records</h5>
            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#kt_modal_add"><i class="fas fa-plus"></i> Create GRN</button>
        </div>
        <div class="card-body p-2">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-sm nowrap w-100" id="areasTable">
                    <thead class="thead-light">
                        <tr>
                            <th>Date</th>
                            <th>GRN</th>
                            <th>Distributor</th>
                            <th>Invoice No</th>
                            <th>Dispatch No</th>
                            <th>Batch No</th>
                            <th class="text-right">Total</th>
                            <th class="text-right">VAT</th>
                            <th class="text-right">Nettotal</th>
                            <th class="text-center">Confirm Status</th>
                            <th class="text-center">Transfer Status</th>
                            <th class="text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Create GRN -->
<div class="modal fade" id="kt_modal_add" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold">Create GRN</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="createorderform" autocomplete="off">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group mb-2">
                                <label class="small font-weight-bold">GRN Number*</label>
                                <input type="text" id="grn_number" name="grn_number" class="form-control form-control-sm" value="{{ $grnNumber ?? '' }}" readonly>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group mb-2">
                                <label class="small font-weight-bold">GRN Date*</label>
                                <input type="date" id="grn_date" name="grn_date" class="form-control form-control-sm" value="{{ date('Y-m-d') }}" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group mb-2">
                                <label class="small font-weight-bold">Purchase Order*</label>
                                <select name="purchase_order_id" id="purchase_order_id" class="form-control form-control-sm" required>
                                    <option value="" selected>Select Purchase Order</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="form-group mb-2">
                                <label class="small font-weight-bold">Invoice Number*</label>
                                <input type="text" name="invoice_id" id="invoice_id" class="form-control form-control-sm" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-2">
                                <label class="small font-weight-bold">Delivery Number*</label>
                                <input type="text" name="delivery_id" id="delivery_id" class="form-control form-control-sm" required>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="unitprice" id="unitprice" value="">
                    <input type="hidden" name="selected_purchase_order_id" id="selected_purchase_order_id" value="">
                    <div class="table-responsive mb-3">
                        <table class="table table-bordered table-sm nowrap w-100" id="tableorder">
                            <thead class="thead-light">
                                <tr>
                                    <th>Product</th>
                                    <th class="d-none">ProductID</th>
                                    <th class="text-center">Unit Price</th>
                                    <th class="text-center">Sale Price</th>
                                    <th class="text-center">Retail Price</th>
                                    <th class="text-center" style="width: 100px;">Qty</th>
                                    <th class="d-none">HideTotal</th>
                                    <th class="text-right">Total</th>
                                </tr>
                            </thead>
                            <tbody id="tableBody">
                            </tbody>
                        </table>
                    </div>
                    <div class="row">
                        <div class="col-12 col-md-4 offset-md-8">
                            <table class="table table-sm table-borderless">
                                <tr>
                                    <td class="text-right font-weight-bold">Total :</td>
                                    <td class="text-right font-weight-bold" id="divtotal" style="width: 150px;">Rs. 0.00</td>
                                </tr>
                                <tr>
                                    <td class="text-right font-weight-bold">VAT % :</td>
                                    <td class="text-right font-weight-bold" id="divvat">Rs. 0.00</td>
                                </tr>
                                <tr>
                                    <td class="text-right font-weight-bold">Net Total :</td>
                                    <td class="text-right font-weight-bold" id="divnettotal">Rs. 0.00</td>
                                </tr>
                            </table>
                            <input type="hidden" id="hidetotalorder" value="0">
                            <input type="hidden" id="hidevatper" value="">
                            <input type="hidden" id="hidevatamount" value="0">
                            <input type="hidden" id="hidenettotal" value="0">
                        </div>
                    </div>
                    <div class="text-right mt-2">
                        <button type="button" id="btncreateorder" class="btn btn-primary btn-sm"><i class="fas fa-save"></i> Create GRN</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal View GRN -->
<div class="modal fade" id="kt_modal_show" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold" id="exampleModalLabel">GRN Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-sm nowrap w-100">
                        <thead class="thead-light">
                            <tr>
                                <th>Product</th>
                                <th class="text-center">Unit Price</th>
                                <th class="text-center">Qty</th>
                                <th class="text-right">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function () {
    var table = $('#areasTable').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        ajax: "{{ route('distributor.grn.list') }}",
        columns: [
            { data: 'date', name: 'date', searchable: true },
            { data: 'grn_no', name: 'grn_no', searchable: true },
            { data: 'distributor.name', name: 'distributor.name', searchable: true },
            { data: 'invoicenum', name: 'invoicenum', searchable: true },
            { data: 'dispatchnum', name: 'dispatchnum', searchable: true },
            { data: 'batchno', name: 'batchno', searchable: true },
            { 
                data: 'total', 
                name: 'total',
                className: 'text-end',
                render: $.fn.dataTable.render.number(',', '.', 2),
                searchable: false
            },
            { 
                data: 'vatamount', 
                name: 'vatamount',
                className: 'text-end',
                render: $.fn.dataTable.render.number(',', '.', 2),
                searchable: false
            },
            { 
                data: 'nettotal', 
                name: 'nettotal',
                className: 'text-end',
                render: $.fn.dataTable.render.number(',', '.', 2),
                searchable: false
            },
            {
                data: null,
                name: 'confirm_status',
                className: 'text-center',
                orderable: false,
                searchable: false,
                render: function(data, type, row) {
                    if (row.confirm_status == 1) {
                        return '<span class="badge badge-success">Confirmed</span>';
                    } else {
                        return '<span class="badge badge-warning">Pending</span>';
                    }
                }
            },
            {
                data: null,
                name: 'transfer_status',
                className: 'text-center',
                orderable: false,
                searchable: false,
                render: function(data, type, row) {
                    if (row.transfer_status == 1) {
                        return '<span class="badge badge-primary">Transferred</span>';
                    } else {
                        return '<span class="badge badge-secondary">Pending</span>';
                    }
                }
            },
            {
                data: null,
                name: 'actions',
                className: 'text-end',
                orderable: false,
                searchable: false,
                render: function(data, type, row) {
                    let actions = `<div class="btn-group btn-group-sm">`;
                    
                    actions += `
                        <button class="btn btn-info btn-sm viewgrn" data-id="${row.idtbl_grn}" title="View">
                            <i class="fas fa-eye"></i>
                        </button>`;
                    
                    if (row.confirm_status == 0) {
                        actions += `
                            <button class="btn btn-success btn-sm confirmGRN" data-id="${row.idtbl_grn}" title="Confirm">
                                <i class="fas fa-check"></i>
                            </button>`;
                    }
                    
                    if (row.confirm_status == 1 && row.transfer_status == 0) {
                        actions += `
                            <button class="btn btn-primary btn-sm transferStock" data-id="${row.idtbl_grn}" title="Transfer Stock">
                                <i class="fas fa-truck"></i>
                            </button>`;
                    }
                    
                    actions += `
                            <button class="btn btn-secondary btn-sm printGRN" data-id="${row.idtbl_grn}" title="Print PDF">
                                <i class="fas fa-print"></i>
                            </button>
                            <button class="btn btn-danger btn-sm deletegrn" data-id="${row.idtbl_grn}" title="Delete">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </div>`;
                    
                    return actions;
                }
            }
        ],
        order: [[0, 'desc']],
        dom: "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6 d-flex justify-content-end'Bf>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
        buttons: [
            {
                extend: 'print',
                text: '<i class="fas fa-print"></i> Print',
                className: 'btn btn-light btn-sm ml-2'
            },
            {
                extend: 'csv',
                text: '<i class="fas fa-file-csv"></i> CSV',
                className: 'btn btn-light btn-sm ml-2'
            }
        ],
        drawCallback: function () {
            // KTMenu.createInstances();
        }
    });

    $("input[data-kt-customer-table-filter='search']").on('keyup change', function () {
        table.search(this.value).draw();
    });

    let grnItems = [];

    // Initialize Select2 for Purchase Order
    $('#purchase_order_id').select2({
        placeholder: 'Select Purchase Order',
        width: '100%',
        dropdownParent: $('#kt_modal_add'),
        ajax: {
            url: "{{ route('distributor.grn.getconfirmedpo') }}",
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    q: params.term,
                    page: params.page
                };
            },
            processResults: function (data) {
                return {
                    results: data.results,
                    pagination: data.pagination
                };
            },
            cache: true
        }
    });

    // Load PO items when PO is selected
    $('#purchase_order_id').on('change', function() {
        const poId = $(this).val();
        
        if (!poId) {
            grnItems = [];
            renderGRNTable();
            calculateTotals();
            return;
        }

        $('#selected_purchase_order_id').val(poId);

        $.ajax({
            url: "{{ route('distributor.grn.getpodetails') }}",
            type: 'GET',
            data: { po_id: poId },
            success: function(response) {
                if (response.success) {
                    const po = response.po;
                    
                    // Set VAT percentage
                    $('#hidevatper').val(po.vatpre || 0);
                    
                    // Map PO items to GRN items
                    grnItems = response.items.map(item => ({
                        product_id: item.product_id,
                        product_name: item.product_name,
                        unit_price: parseFloat(item.unitprice),
                        sale_price: parseFloat(item.saleprice),
                        retail_price: parseFloat(item.retailprice),
                        quantity: parseInt(item.qty),
                        total: parseFloat(item.total)
                    }));
                    
                    renderGRNTable();
                    calculateTotals();
                }
            },
            error: function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Failed to load purchase order details'
                });
            }
        });
    });

    // Render GRN Table
    function renderGRNTable() {
        const tbody = $('#tableBody');
        tbody.empty();

        grnItems.forEach((item, index) => {
            const row = `
                <tr>
                    <td>${item.product_name}</td>
                    <td class="d-none">${item.product_id}</td>
                    <td class="text-center">
                        <input type="number" class="form-control form-control-sm text-end" 
                               value="${item.unit_price.toFixed(2)}" disabled>
                    </td>
                    <td class="text-center">
                        <input type="number" class="form-control form-control-sm text-end" 
                               value="${item.sale_price.toFixed(2)}" disabled>
                    </td>
                    <td class="text-center">
                        <input type="number" class="form-control form-control-sm text-end" 
                               value="${item.retail_price.toFixed(2)}" disabled>
                    </td>
                    <td class="text-center">
                        <input type="number" class="form-control form-control-sm text-center grn-quantity" 
                               data-index="${index}" value="${item.quantity}" min="1">
                    </td>
                    <td class="d-none">
                        <input type="hidden" class="item-total" value="${item.total}">
                    </td>
                    <td class="text-end">
                        <span class="fw-bold total-display">Rs. ${item.total.toFixed(2)}</span>
                    </td>
                </tr>
            `;
            tbody.append(row);
        });
    }

    // Update quantity
    $(document).on('input', '.grn-quantity', function() {
        const index = $(this).data('index');
        const quantity = parseInt($(this).val()) || 1;
        
        grnItems[index].quantity = quantity;
        grnItems[index].total = grnItems[index].unit_price * quantity;
        
        $(this).closest('tr').find('.total-display').text('Rs. ' + grnItems[index].total.toFixed(2));
        $(this).closest('tr').find('.item-total').val(grnItems[index].total);
        
        calculateTotals();
    });

    // Calculate totals
    function calculateTotals() {
        let total = 0;
        
        grnItems.forEach(item => {
            total += item.total;
        });

        const vatPercentage = parseFloat($('#hidevatper').val()) || 0;
        const vatAmount = (total * vatPercentage) / 100;
        const netTotal = total + vatAmount;

        $('#hidetotalorder').val(total.toFixed(2));
        $('#divtotal').text('Rs. ' + total.toFixed(2));
        
        $('#hidevatamount').val(vatAmount.toFixed(2));
        $('#divvat').text('Rs. ' + vatAmount.toFixed(2));
        
        $('#hidenettotal').val(netTotal.toFixed(2));
        $('#divnettotal').text('Rs. ' + netTotal.toFixed(2));
    }

    // Create GRN
    $('#btncreateorder').click(function(e) {
        e.preventDefault();

        const grnDate = $('#grn_date').val();
        const poId = $('#purchase_order_id').val();
        const invoiceNum = $('#invoice_id').val();
        const deliveryNum = $('#delivery_id').val();

        if (!grnDate) {
            Swal.fire({
                icon: 'warning',
                title: 'Warning',
                text: 'Please select GRN date'
            });
            return;
        }

        if (!poId) {
            Swal.fire({
                icon: 'warning',
                title: 'Warning',
                text: 'Please select purchase order'
            });
            return;
        }

        if (!invoiceNum) {
            Swal.fire({
                icon: 'warning',
                title: 'Warning',
                text: 'Please enter invoice number'
            });
            return;
        }

        if (!deliveryNum) {
            Swal.fire({
                icon: 'warning',
                title: 'Warning',
                text: 'Please enter delivery number'
            });
            return;
        }

        if (grnItems.length === 0) {
            Swal.fire({
                icon: 'warning',
                title: 'Warning',
                text: 'No items to create GRN'
            });
            return;
        }

        const grnData = {
            _token: '{{ csrf_token() }}',
            grn_date: grnDate,
            po_id: poId,
            invoice_num: invoiceNum,
            delivery_num: deliveryNum,
            items: grnItems,
            total: $('#hidetotalorder').val(),
            vat_amount: $('#hidevatamount').val(),
            net_total: $('#hidenettotal').val()
        };

        $.ajax({
            url: "{{ route('distributor.grn.store') }}",
            type: 'POST',
            data: grnData,
            beforeSend: function() {
                $('#btncreateorder').prop('disabled', true)
                    .html('<span class="spinner-border spinner-border-sm me-2"></span>Processing...');
            },
            success: function(response) {
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: response.message
                    }).then(() => {
                        $('#kt_modal_add').modal('hide');
                        table.ajax.reload();
                        resetForm();
                    });
                }
            },
            error: function(xhr) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: xhr.responseJSON?.message || 'Failed to create GRN'
                });
            },
            complete: function() {
                $('#btncreateorder').prop('disabled', false)
                    .html('<span class="svg-icon svg-icon-2 me-2"><i class="fas fa-save"></i></span>Create GRN');
            }
        });
    });

    // View GRN
    $(document).on('click', '.viewgrn', function(e) {
        e.preventDefault();
        const grnId = $(this).data('id');

        $.ajax({
            url: "{{ route('distributor.grn.view') }}",
            type: 'GET',
            data: { id: grnId },
            success: function(response) {
                if (response.success) {
                    const grn = response.grn;
                    const items = response.items;
                    
                    let itemsHtml = '';
                    items.forEach(item => {
                        itemsHtml += `
                            <tr>
                                <td>${item.product_name}</td>
                                <td class="text-center">Rs. ${parseFloat(item.unitprice).toFixed(2)}</td>
                                <td class="text-center">${item.qty}</td>
                                <td class="text-end">Rs. ${parseFloat(item.total).toFixed(2)}</td>
                            </tr>
                        `;
                    });

                    itemsHtml += `
            <tr class="fw-bold border-top">
                <td colspan="3" class="text-end">Total</td>
                <td class="text-end">Rs. ${grn.nettotal.toFixed(2)}</td>
            </tr>
        `;

                    $('#kt_modal_show .modal-title').text(`GRN Details - ${grn.grn_no}`);
                    $('#kt_modal_show tbody').html(itemsHtml);
                    $('#kt_modal_show').modal('show');
                }
            }
        });
    });

    // Confirm GRN
    $(document).on('click', '.confirmGRN', function(e) {
        e.preventDefault();
        const grnId = $(this).data('id');
        
        Swal.fire({
            title: 'Are you sure?',
            text: "Do you want to confirm this GRN?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, confirm it!'
        }).then((result) => {
            if (result.isConfirmed) {
                updateGRNStatus(grnId, 'confirm');
            }
        });
    });

    // Transfer Stock
    $(document).on('click', '.transferStock', function(e) {
        e.preventDefault();
        const grnId = $(this).data('id');
        
        Swal.fire({
            title: 'Transfer Stock?',
            text: "This will transfer all items to distributor stock. Continue?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, transfer stock!'
        }).then((result) => {
            if (result.isConfirmed) {
                transferStockToDistributor(grnId);
            }
        });
    });

    // Transfer Stock Function
    function transferStockToDistributor(grnId) {
        $.ajax({
            url: "{{ route('distributor.grn.transferstock') }}",
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                grn_id: grnId
            },
            beforeSend: function() {
                Swal.fire({
                    title: 'Processing...',
                    text: 'Transferring stock to distributor',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
            },
            success: function(response) {
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: response.message
                    });
                    table.ajax.reload();
                }
            },
            error: function(xhr) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: xhr.responseJSON?.message || 'Failed to transfer stock'
                });
            }
        });
    }

    // Delete GRN
    $(document).on('click', '.deletegrn', function(e) {
        e.preventDefault();
        const grnId = $(this).data('id');
        
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ route('distributor.grn.delete') }}",
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        id: grnId
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire('Deleted!', response.message, 'success');
                            table.ajax.reload();
                        }
                    },
                    error: function() {
                        Swal.fire('Error!', 'Cannot delete GRN. Stock has already been transferred.', 'error');
                    }
                });
            }
        });
    });

    // Print GRN
    $(document).on('click', '.printGRN', function(e) {
        e.preventDefault();
        const grnId = $(this).data('id');
        const printUrl = "{{ url('distributor/grn/print') }}/" + grnId;
        window.open(printUrl, '_blank');
    });

    // Update GRN status
    function updateGRNStatus(grnId, action) {
        $.ajax({
            url: "{{ route('distributor.grn.updatestatus') }}",
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                id: grnId,
                action: action
            },
            success: function(response) {
                if (response.success) {
                    Swal.fire('Success!', response.message, 'success');
                    table.ajax.reload();
                }
            },
            error: function() {
                Swal.fire('Error!', 'Failed to update GRN status', 'error');
            }
        });
    }

    // Reset form
    function resetForm() {
        $('#createorderform')[0].reset();
        $('#purchase_order_id').val(null).trigger('change');
        $('#selected_purchase_order_id').val('');
        $('#hidevatper').val('');
        grnItems = [];
        renderGRNTable();
        calculateTotals();
    }

    // Reset form when modal is closed
    $('#kt_modal_add').on('hidden.bs.modal', function() {
        resetForm();
    });
});
</script>
    
@endsection