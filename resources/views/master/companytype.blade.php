@extends('layouts.app')

@section('title', 'Company Types - Master Data')

@section('content')
<div class="page-header page-header-light bg-white shadow-sm border-b border-slate-100">
    <div class="container-fluid">
        <div class="page-header-content py-3 text-center text-lg-left">
            <h1 class="page-header-title font-weight-light mb-0 text-slate-800 flex items-center gap-2 justify-center lg:justify-start">
                <div class="page-header-icon text-primary-600"><i data-feather="database"></i></div>
                <span class="font-bold tracking-tight text-xl">Company Types Master</span>
            </h1>
        </div>
    </div>
</div>



<div class="container-fluid mt-3 p-2 p-md-3">
    <div class="card shadow-sm border border-slate-200 rounded-lg overflow-hidden">
        <div class="card-body p-4 bg-white">
            <div class="row">
                
                {{-- Form Column --}}
                <div class="col-12 col-md-4 mb-4 mb-md-0 border-r border-slate-100 pr-md-4">
                    <h3 class="text-sm font-bold text-slate-700 mb-4 tracking-wide uppercase">Add / Edit Company Type</h3>
                    
                    <form action="{{ route('master.companytype.insertupdate') }}" method="post" autocomplete="off" id="typeForm">
                        @csrf
                        
                        {{-- Type ID --}}
                        <div class="form-group mb-3">
                            <label class="block text-xs font-bold text-slate-500 mb-1.5 uppercase">Type ID</label>
                            <input type="text" class="w-full px-3 py-2 text-sm border border-slate-200 rounded-md bg-slate-50 text-slate-700 focus:outline-none cursor-default font-mono" 
                                   id="displayID" value="{{ $nextId ?? 1 }}" readonly>
                        </div>

                        {{-- Name --}}
                        <div class="form-group mb-3">
                            <label class="block text-xs font-bold text-slate-500 mb-1.5 uppercase">Company Type Name*</label>
                            <input type="text" class="w-full px-3 py-2 text-sm border border-slate-200 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" 
                                   name="company_type" id="company_type" required placeholder="e.g. Supplier">
                        </div>
                        
                        {{-- Value Key & Sort Order (Hidden as requested) --}}
                        <input type="hidden" name="value" id="value" value="">
                        <input type="hidden" name="sort_order" id="sort_order" value="0">

                        
                        {{-- Action Buttons --}}
                        <div class="form-group mt-4 flex gap-2">
                            <button type="submit" id="submitBtn" class="flex-1 inline-flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold py-2 px-4 rounded-md shadow-sm transition-all">
                                <i class="far fa-save"></i> Save Type
                            </button>
                            <button type="button" id="resetBtn" class="px-3 border border-slate-200 rounded-md text-slate-500 hover:bg-slate-50 transition-colors">
                                Reset
                            </button>
                        </div>
                        
                        <input type="hidden" name="recordOption" id="recordOption" value="1">
                        <input type="hidden" name="recordID" id="recordID" value="">
                    </form>
                </div>
                
                {{-- Table Column --}}
                <div class="col-12 col-md-8 pl-md-4">
                    <h3 class="text-sm font-bold text-slate-700 mb-4 tracking-wide uppercase">All Company Types</h3>
                    
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-sm nowrap w-100" id="dataTable">
                            <thead class="bg-slate-50 text-slate-500 border-b border-slate-100">
                                <tr>
                                    <th class="py-2.5 px-3 text-xs font-bold uppercase tracking-wider">ID</th>
                                    <th class="py-2.5 px-3 text-xs font-bold uppercase tracking-wider">COMPANY TYPE</th>
                                    <th class="py-2.5 px-3 text-xs font-bold uppercase tracking-wider">VALUE KEY</th>
                                    <th class="py-2.5 px-3 text-xs font-bold uppercase tracking-wider text-center">SORT ORDER</th>
                                    <th class="py-2.5 px-3 text-xs font-bold uppercase tracking-wider text-center">STATUS</th>
                                    <th class="py-2.5 px-3 text-xs font-bold uppercase tracking-wider text-right">ACTIONS</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @forelse($types ?? [] as $type)
                                    <tr class="hover:bg-slate-50/50 transition-colors">
                                        <td class="py-3 px-3 text-sm text-slate-600">{{ $type->idtbl_company_type }}</td>
                                        <td class="py-3 px-3 text-sm font-medium text-slate-800">{{ $type->company_type }}</td>
                                        <td class="py-3 px-3 text-sm text-slate-600 font-mono">{{ $type->value }}</td>
                                        <td class="py-3 px-3 text-sm text-slate-600 text-center">{{ $type->sort_order }}</td>
                                        <td class="py-3 px-3 text-sm text-center">
                                            @if($type->status == 1)
                                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-700 border border-emerald-200">Active</span>
                                            @else
                                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-red-100 text-red-700 border border-red-200">Inactive</span>
                                            @endif
                                        </td>
                                        <td class="py-3 px-3 text-right">
                                            <div class="btn-group btn-group-sm">
                                                {{-- Edit Button --}}
                                                <button class="btn btn-outline-primary btn-sm btnEdit"
                                                        data-id="{{ $type->idtbl_company_type }}"
                                                        data-name="{{ $type->company_type }}"
                                                        data-value="{{ $type->value }}"
                                                        data-order="{{ $type->sort_order }}"
                                                        title="Edit Type">
                                                    <i class="fas fa-pen"></i>
                                                </button>
                                                
                                                {{-- Toggle Status Button --}}
                                                @if($type->status == 1)
                                                    <a href="{{ route('master.companytype.status', [$type->idtbl_company_type, $type->status]) }}" 
                                                       onclick="return confirm('Are you sure you want to deactivate this company type?')"
                                                       class="btn btn-outline-secondary btn-sm" title="Active – click to deactivate">
                                                        <i class="fas fa-toggle-on"></i>
                                                    </a>
                                                @else
                                                    <a href="{{ route('master.companytype.status', [$type->idtbl_company_type, $type->status]) }}" 
                                                       onclick="return confirm('Are you sure you want to activate this company type?')"
                                                       class="btn btn-outline-warning btn-sm" title="Inactive – click to activate">
                                                        <i class="fas fa-toggle-off"></i>
                                                    </a>
                                                @endif

                                                {{-- Delete Button --}}
                                                <button type="button" class="btn btn-outline-danger btn-sm btnDelete"
                                                        data-id="{{ $type->idtbl_company_type }}"
                                                        title="Delete Type">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="py-6 px-3 text-center text-sm text-slate-400 italic">No company types found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    $(document).ready(function() {
        $('#dataTable').DataTable({
            responsive: true,
            order: [[3, "asc"]], // Order by Sort Order
            pageLength: 10,
        });

        // Auto-generate value key from company type name
        $('#company_type').on('input', function() {
            var val = $(this).val();
            // Convert to lowercase, replace spaces & special chars with underscores
            var key = val.trim().toLowerCase()
                         .replace(/[^a-z0-9\s-]/g, '') // remove invalid chars
                         .replace(/[\s-]+/g, '_');    // replace space/hyphen with underscore
            $('#value').val(key);
        });

        // Edit button handler
        $('#dataTable').on('click', '.btnEdit', function() {
            var btn = $(this);
            $('#recordID').val(btn.data('id'));
            $('#displayID').val(btn.data('id'));
            $('#company_type').val(btn.data('name'));
            $('#value').val(btn.data('value'));
            $('#sort_order').val(btn.data('order'));
            $('#recordOption').val('2');
            $('#submitBtn').html('<i class="far fa-save"></i> Update Type').removeClass('bg-blue-600').addClass('bg-amber-600');
        });

        // Reset button handler
        $('#resetBtn').on('click', function() {
            $('#typeForm')[0].reset();
            $('#recordID').val('');
            $('#displayID').val('{{ $nextId ?? 1 }}');
            $('#recordOption').val('1');
            $('#submitBtn').html('<i class="far fa-save"></i> Save Type').removeClass('bg-amber-600').addClass('bg-blue-600');
        });

        // Delete button handler
        $('#dataTable').on('click', '.btnDelete', function() {
            var recordID = $(this).data('id');
            if (confirm('Are you sure you want to delete this company type?')) {
                var form = $('<form method="POST" action="{{ route("master.companytype.delete") }}"></form>');
                form.append('<input type="hidden" name="_token" value="{{ csrf_token() }}">');
                form.append('<input type="hidden" name="recordID" value="' + recordID + '">');
                $('body').append(form);
                form.submit();
            }
        });
    });
</script>
@endsection
