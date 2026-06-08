@extends('layouts.app')

@section('title', 'Storage Locations - Master Data')

@section('content')
<div class="page-header page-header-light bg-white shadow">
    <div class="container-fluid">
        <div class="page-header-content py-3 text-center text-lg-left">
            <h1 class="page-header-title font-weight-light mb-0">
                <div class="page-header-icon"><i data-feather="database"></i></div>
                <span>Storage Locations</span>
            </h1>
        </div>
    </div>
</div>

<div class="container-fluid mt-2">
    @include('layouts.master_data_nav_bar')
</div>

<div class="container-fluid mt-2 p-0 p-md-2">
    <div class="card shadow-sm">
        <div class="card-body p-3">
            <form action="{{ url('Master/Storagelocationinsertupdate') }}" method="post" autocomplete="off">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label class="small font-weight-bold text-dark">Location Name*</label>
                            <input type="text" class="form-control form-control-sm" name="location_name" id="location_name" required placeholder="Safe Box 01">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label class="small font-weight-bold text-dark">Short Code* (e.g. SF-01)</label>
                            <input type="text" class="form-control form-control-sm" name="short_code" id="short_code" required placeholder="SB01">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label class="small font-weight-bold text-dark">Branch/Office*</label>
                            <select class="form-control form-control-sm" name="branch_id" id="branch_id" required>
                                <option value="">Select Branch</option>
                                @forelse($branches as $branch)
                                    <option value="{{ $branch->idtbl_company_branch }}">{{ $branch->branch }}</option>
                                @empty
                                    <option disabled>No branches available</option>
                                @endforelse
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label class="small font-weight-bold text-dark">Contact Person</label>
                            <input type="text" class="form-control form-control-sm" name="contact_person" id="contact_person" placeholder="Manager Name">
                        </div>
                    </div>
                </div>
                <div class="form-group mt-2 text-right">
                    <button type="button" id="clearBtn" class="btn btn-secondary btn-sm px-4 mr-2"><i class="fas fa-redo"></i>&nbsp;Clear</button>
                    <button type="submit" id="submitBtn" class="btn btn-primary btn-sm px-5"><i class="far fa-save"></i>&nbsp;Save Location</button>
                </div>
                <input type="hidden" name="recordOption" id="recordOption" value="1">
                <input type="hidden" name="recordID" id="recordID" value="">
            </form>

            <hr class="my-4">

            <div class="table-responsive pb-3">
                <table class="table table-bordered table-striped table-sm nowrap w-100" id="dataTable">
                    <thead class="thead-light">
                        <tr>
                            <th>LOCATION</th>
                            <th>CODE</th>
                            <th>BRANCH</th>
                            <th>CONTACT</th>
                            <th class="text-right">ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody>
@forelse($locations as $index => $location)
    <tr>
        <td>{{ $index + 1 }}. {{ $location->location_name }}</td>
        <td>{{ $location->short_code }}</td>
        <td>
            @php
                $branch = $branches->firstWhere('idtbl_company_branch', $location->branch_id);
            @endphp
            {{ $branch ? $branch->branch : 'Unknown Branch' }}
        </td>
        <td>{{ $location->contact_person ?? '-' }}</td>
        <td class="text-right">
            <div class="btn-group btn-group-sm">
                <button class="btn btn-primary btn-sm btnEdit mr-1" data-id="{{ $location->id }}">
                    <i class="fas fa-pen"></i>
                </button>
                <button class="btn btn-danger btn-sm btnDelete" data-id="{{ $location->id }}">
                    <i class="fas fa-trash-alt"></i>
                </button>
            </div>
        </td>
    </tr>
@empty
    <tr><td colspan="5" class="text-center text-muted py-3">No storage locations found</td></tr>
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
    $(document).ready(function() {
        $('#dataTable').DataTable({
            responsive: true,
            order: [[0, "asc"]],
        });

        // Clear form button
        $('#clearBtn').on('click', function() {
            $('#location_name').val('');
            $('#short_code').val('');
            $('#branch_id').val('');
            $('#contact_person').val('');
            $('#recordOption').val(1);
            $('#recordID').val('');
            $('#submitBtn').html('<i class="far fa-save"></i>&nbsp;Save Location');
            $('html, body').animate({ scrollTop: 0 }, 'fast');
        });

        // Edit button click handler
        $(document).on('click', '.btnEdit', function() {
            const recordID = $(this).data('id');
            $.ajax({
                url: '{{ url("Master/Storagelocationedit") }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    recordID: recordID
                },
                success: function(data) {
                    $('#location_name').val(data.location_name);
                    $('#short_code').val(data.short_code);
                    $('#branch_id').val(data.branch_id);
                    $('#contact_person').val(data.contact_person);
                    $('#recordOption').val(2);
                    $('#recordID').val(data.id);
                    $('#submitBtn').html('<i class="fas fa-edit"></i>&nbsp;Update Location');
                    $('html, body').animate({ scrollTop: 0 }, 'fast');
                },
                error: function(xhr) {
                    alert('Error loading record');
                }
            });
        });

        // Delete button click handler
        $(document).on('click', '.btnDelete', function() {
            if (!confirm('Are you sure you want to delete this location?')) {
                return;
            }
            const recordID = $(this).data('id');
            const form = $('<form></form>').attr({
                method: 'POST',
                action: '{{ url("Master/Storagelocationdelete") }}'
            }).append(
                $('<input>').attr({ type: 'hidden', name: '_token', value: '{{ csrf_token() }}' }),
                $('<input>').attr({ type: 'hidden', name: 'recordID', value: recordID })
            );
            $(document.body).append(form);
            form.submit();
        });
    });
</script>
@endsection
