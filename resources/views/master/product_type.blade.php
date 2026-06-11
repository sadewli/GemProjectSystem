@extends('layouts.app')

@section('title', 'Product Types - Master Data')

@section('content')
    <div class="page-header page-header-light bg-white shadow">
        <div class="container-fluid">
            <div class="page-header-content py-3 text-center text-lg-left">
                <h1 class="page-header-title font-weight-light mb-0">
                    <div class="page-header-icon"><i data-feather="database"></i></div>
                    <span>Product Types</span>
                </h1>
            </div>
        </div>
    </div>

    <div class="container-fluid mt-2 p-0 p-md-2">
        <div class="card shadow-sm">
            <div class="card-body p-2">
                <div class="row mb-3">
                    <div class="col-12 text-right">
                        <button type="button" id="openProductTypeModalBtn" class="btn btn-primary btn-sm px-4">
                            <i class="fas fa-plus mr-1"></i> Add Product Type
                        </button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="table-responsive pb-3">
                            <table class="table table-bordered table-striped table-sm nowrap w-100" id="dataTable">
                                <thead class="thead-light">
                                    <tr>
                                        <th>#</th>
                                        <th>SKU</th>
                                        <th>PRODUCT TYPE NAME</th>
                                        <th>SKU NAME</th>
                                        <th>STATUS</th>
                                        <th class="text-right">ACTIONS</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($product_types as $index => $type)
                                        <tr>
                                            <td>{{ sprintf('%02d', $index + 1) }}</td>
                                            <td>{{ $type->sku->sku_name ?? '-' }}</td>
                                            <td>{{ $type->name }}</td>
                                            <td>{{ $type->skuname }}</td>
                                            <td>
                                                @if($type->status == 1)
                                                    <span class="badge badge-success font-weight-normal">Active</span>
                                                @else
                                                    <span class="badge badge-secondary font-weight-normal">Inactive</span>
                                                @endif
                                            </td>
                                            <td class="text-right">
                                                <div class="btn-group btn-group-sm">
                                                    <button class="btn btn-primary btn-sm btnEdit mr-1"
                                                        data-id="{{ $type->idtbl_product_types }}"
                                                        data-skuid="{{ $type->idtbl_skus }}" data-name="{{ $type->name }}"
                                                        data-skuname="{{ $type->skuname }}">
                                                        <i class="fas fa-pen"></i>
                                                    </button>
                                                    <button class="btn btn-danger btn-sm btnDelete"
                                                        data-id="{{ $type->idtbl_product_types }}">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Product Type Modal -->
    <div id="productTypeModal" class="position-fixed d-none align-items-center justify-content-center"
        style="top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,0.55);z-index:1050;">
        <div class="bg-white rounded shadow-lg w-100" style="max-width:600px;">
            <div class="d-flex justify-content-between align-items-center px-4 py-3 border-bottom">
                <h5 class="mb-0" id="modalTitle">Add New Product Type</h5>
                <button type="button" id="closeProductTypeModalBtn" class="btn btn-sm btn-light">&times;</button>
            </div>
            <div class="px-4 py-4">
                <form id="productTypeModalForm" action="{{ url('Master/ProductTypeinsertupdate') }}" method="post"
                    autocomplete="off">
                    @csrf
                    <input type="hidden" name="recordOption" id="recordOption_modal" value="1">
                    <input type="hidden" name="recordID" id="recordID_modal" value="">

                    <div class="form-group mb-2">
                        <label class="small font-weight-bold text-dark">Product Type Name <span
                                class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-sm" name="name" id="name_modal" required
                            placeholder="e.g. Faceted">
                    </div>

                    <div class="form-group mb-2">
                        <label class="small font-weight-bold text-dark">SKU <span class="text-danger">*</span></label>
                        <select class="form-control form-control-sm" name="idtbl_skus" id="idtbl_skus_modal" required>
                            <option value="">-- Select SKU --</option>
                            @foreach($skus as $sku)
                                <option value="{{ $sku->idtbl_skus }}">{{ $sku->sku_name }}</option>
                            @endforeach
                        </select>
                    </div>



                    <div class="form-group mb-2">
                        <label class="small font-weight-bold text-dark">SKU Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-sm" name="skuname" id="skuname_modal" required
                            placeholder="e.g. RUBY" maxlength="50">
                    </div>
                </form>
            </div>
            <div class="d-flex justify-content-end px-4 py-3 border-top">
                <button type="button" id="cancelProductTypeModalBtn" class="btn btn-light btn-sm mr-2">Cancel</button>
                <button type="submit" form="productTypeModalForm" class="btn btn-primary btn-sm">Save</button>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <script>
        $(document).ready(function () {
            $('#dataTable').DataTable({
                responsive: true,
                order: [[0, "asc"]],
            });

            const modal = document.getElementById('productTypeModal');
            const openBtn = document.getElementById('openProductTypeModalBtn');
            const closeBtn = document.getElementById('closeProductTypeModalBtn');
            const cancelBtn = document.getElementById('cancelProductTypeModalBtn');

            function toggleModal(show) {
                if (show) {
                    modal.classList.remove('d-none');
                    modal.classList.add('d-flex');
                    document.body.style.overflow = 'hidden';
                } else {
                    modal.classList.add('d-none');
                    modal.classList.remove('d-flex');
                    document.body.style.overflow = '';
                }
            }

            if (openBtn) {
                openBtn.addEventListener('click', function () {
                    // reset form for Add
                    $('#recordOption_modal').val(1);
                    $('#recordID_modal').val('');
                    $('#idtbl_skus_modal').val('');
                    $('#name_modal').val('');
                    $('#skuname_modal').val('');
                    $('#modalTitle').text('Add New Product Type');
                    toggleModal(true);
                });
            }
            if (closeBtn) closeBtn.addEventListener('click', () => toggleModal(false));
            if (cancelBtn) cancelBtn.addEventListener('click', () => toggleModal(false));

            if (modal) {
                modal.addEventListener('click', function (e) {
                    if (e.target === modal) toggleModal(false);
                });
            }

            // Edit button
            $(document).on('click', '.btnEdit', function () {
                var id = $(this).data('id');
                var skuid = $(this).data('skuid');
                var name = $(this).data('name');
                var skuname = $(this).data('skuname');

                $('#recordOption_modal').val(2);
                $('#recordID_modal').val(id);
                $('#idtbl_skus_modal').val(skuid);
                $('#name_modal').val(name);
                $('#skuname_modal').val(skuname);
                $('#modalTitle').text('Edit Product Type');
                toggleModal(true);
            });

            // Delete button
            $(document).on('click', '.btnDelete', function () {
                if (!confirm('Are you sure you want to delete this product type?')) return;
                var id = $(this).data('id');
                var form = $('<form></form>').attr({ method: 'POST', action: '{{ url("Master/ProductTypeDelete") }}' })
                    .append($('<input>').attr({ type: 'hidden', name: '_token', value: '{{ csrf_token() }}' }))
                    .append($('<input>').attr({ type: 'hidden', name: 'recordID', value: id }));
                $(document.body).append(form);
                form.submit();
            });

            @if(Session::has('msg'))
                action('{!! Session::get("msg") !!}');
            @endif
        });
    </script>
@endsection