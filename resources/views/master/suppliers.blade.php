@extends('layouts.app')

@section('title', 'Suppliers - Master Data')

@section('content')
<div class="page-header page-header-light bg-white shadow">
    <div class="container-fluid">
        <div class="page-header-content py-3 text-center text-lg-left">
            <h1 class="page-header-title font-weight-light mb-0">
                <div class="page-header-icon"><i data-feather="truck"></i></div>
                <span>Suppliers</span>
            </h1>
        </div>
    </div>
</div>

<div class="container-fluid mt-2 p-0 p-md-2">
    <div class="card shadow-sm mb-3">
        <div class="card-body p-3">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
                <div>
                    <h5 class="mb-0">Add Supplier</h5>
                    <p class="text-muted small mb-0">Create supplier master records for your current organization.</p>
                </div>
            </div>

            <form action="{{ url('Master/Suppliersinsertupdate') }}" method="post" autocomplete="off">
                @csrf
                <input type="hidden" name="org_id" value="{{ session('company_id', 0) }}">
                <input type="hidden" name="recordOption" value="1">
                <input type="hidden" name="recordID" value="">

                <div class="row">
                    <div class="col-md-6 form-group">
                        <label class="small font-weight-bold text-dark">Supplier Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-sm @error('supplier_name') is-invalid @enderror" name="supplier_name" value="{{ old('supplier_name') }}" required>
                        @error('supplier_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 form-group">
                        <label class="small font-weight-bold text-dark">Contact Name</label>
                        <input type="text" class="form-control form-control-sm @error('contact_name') is-invalid @enderror" name="contact_name" value="{{ old('contact_name') }}">
                        @error('contact_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 form-group">
                        <label class="small font-weight-bold text-dark">Email</label>
                        <input type="email" class="form-control form-control-sm @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 form-group">
                        <label class="small font-weight-bold text-dark">Phone</label>
                        <input type="text" class="form-control form-control-sm @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}">
                        @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 form-group">
                        <label class="small font-weight-bold text-dark">Country</label>
                        <input type="text" class="form-control form-control-sm @error('country') is-invalid @enderror" name="country" value="{{ old('country') }}">
                        @error('country')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-3 form-group">
                        <label class="small font-weight-bold text-dark">Currency</label>
                        <select class="form-control form-control-sm @error('currency') is-invalid @enderror" name="currency">
                            <option value="USD" {{ old('currency', 'USD') === 'USD' ? 'selected' : '' }}>USD</option>
                            <option value="LKR" {{ old('currency') === 'LKR' ? 'selected' : '' }}>LKR</option>
                            <option value="EUR" {{ old('currency') === 'EUR' ? 'selected' : '' }}>EUR</option>
                        </select>
                        @error('currency')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-3 form-group">
                        <label class="small font-weight-bold text-dark">Status</label>
                        <select class="form-control form-control-sm @error('status') is-invalid @enderror" name="status">
                            <option value="1" {{ old('status', '1') == '1' ? 'selected' : '' }}>Active</option>
                            <option value="2" {{ old('status') == '2' ? 'selected' : '' }}>Inactive</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-12 form-group">
                        <label class="small font-weight-bold text-dark">Address</label>
                        <textarea class="form-control form-control-sm @error('address') is-invalid @enderror" name="address" rows="3">{{ old('address') }}</textarea>
                        @error('address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="text-right mt-2">
                    <button type="submit" class="btn btn-primary btn-sm px-4">
                        <i class="fas fa-save mr-1"></i> Save Supplier
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body p-3">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <h5 class="mb-0">Saved Suppliers</h5>
                    <p class="text-muted small mb-0">Current supplier list for this organization.</p>
                </div>
            </div>

            <div class="table-responsive pb-2">
                <table class="table table-bordered table-striped table-sm nowrap w-100" id="supplierDataTable">
                    <thead class="thead-light">
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Contact</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Country</th>
                            <th>Currency</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($suppliers as $index => $supplier)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $supplier->supplier_name }}</td>
                                <td>{{ $supplier->contact_name ?? '-' }}</td>
                                <td>{{ $supplier->email ?? '-' }}</td>
                                <td>{{ $supplier->phone ?? '-' }}</td>
                                <td>{{ $supplier->country ?? '-' }}</td>
                                <td>{{ $supplier->currency }}</td>
                                <td>
                                    @if($supplier->status == 1)
                                        <span class="badge badge-success">Active</span>
                                    @elseif($supplier->status == 2)
                                        <span class="badge badge-warning">Inactive</span>
                                    @else
                                        <span class="badge badge-danger">Deleted</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted">No suppliers saved yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    $(document).ready(function () {
        if ($.fn.DataTable.isDataTable('#supplierDataTable')) {
            $('#supplierDataTable').DataTable().destroy();
        }
        $('#supplierDataTable').DataTable({
            responsive: true,
            order: [[0, 'asc']],
        });
    });
</script>
@endsection
