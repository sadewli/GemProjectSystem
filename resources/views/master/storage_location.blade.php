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
                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <label class="small font-weight-bold text-dark">Branch Name*</label>
                            <input type="text" class="form-control form-control-sm" name="branch_name" id="branch_name" required placeholder="e.g. Head Office">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <label class="small font-weight-bold text-dark">Location Name*</label>
                            <input type="text" class="form-control form-control-sm" name="location_name" id="location_name" required placeholder="e.g. Safe Box 01">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <label class="small font-weight-bold text-dark">Short Code* (e.g. SB-01)</label>
                            <input type="text" class="form-control form-control-sm" name="short_code" id="short_code" required placeholder="SB01">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <label class="small font-weight-bold text-dark">Contact Person</label>
                            <input type="text" class="form-control form-control-sm" name="contact_person" id="contact_person" placeholder="Manager Name">
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group mb-3">
                            <label class="small font-weight-bold text-dark">Description</label>
                            <input type="text" class="form-control form-control-sm" name="description" id="description" placeholder="Optional description">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <label class="small font-weight-bold text-dark">Address Line 1</label>
                            <input type="text" class="form-control form-control-sm" name="address_line1" id="address_line1" placeholder="Street / Building">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <label class="small font-weight-bold text-dark">Address Line 2</label>
                            <input type="text" class="form-control form-control-sm" name="address_line2" id="address_line2" placeholder="Area / District">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <label class="small font-weight-bold text-dark">Address Line 3</label>
                            <input type="text" class="form-control form-control-sm" name="address_line3" id="address_line3" placeholder="Province / Region">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <label class="small font-weight-bold text-dark">City</label>
                            <input type="text" class="form-control form-control-sm" name="city" id="city" placeholder="e.g. Colombo">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <label class="small font-weight-bold text-dark">Country</label>
                            <input type="text" class="form-control form-control-sm" name="country" id="country" placeholder="e.g. Sri Lanka">
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
                            <th>BRANCH</th>
                            <th>LOCATION</th>
                            <th>CODE</th>
                            <th>CONTACT</th>
                            <th>CITY</th>
                            <th>COUNTRY</th>
                            <th class="text-right">ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($locations as $location)
                        <tr>
                            <td>{{ $location->branch_name }}</td>
                            <td>{{ $location->location_name }}</td>
                            <td>{{ $location->short_code }}</td>
                            <td>{{ $location->contact_person ?? '-' }}</td>
                            <td>{{ $location->city ?? '-' }}</td>
                            <td>{{ $location->country ?? '-' }}</td>
                            <td class="text-right">
                                <div class="btn-group btn-group-sm">
                                    <button class="btn btn-primary btn-sm btnEdit mr-1" data-id="{{ $location->idtbl_storage_locations }}">
                                        <i class="fas fa-pen"></i>
                                    </button>
                                    <button class="btn btn-danger btn-sm btnDelete" data-id="{{ $location->idtbl_storage_locations }}">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="7" class="text-center text-muted py-3">No storage locations found</td></tr>
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
            order: [[0, "asc"], [1, "asc"]],
            columnDefs: [{ targets: -1, orderable: false, searchable: false }]
        });

        function resetForm() {
            $('#branch_name, #location_name, #short_code, #contact_person, #description').val('');
            $('#address_line1, #address_line2, #address_line3, #city, #country').val('');
            $('#recordOption').val(1);
            $('#recordID').val('');
            $('#submitBtn').html('<i class="far fa-save"></i>&nbsp;Save Location');
            $('html, body').animate({ scrollTop: 0 }, 'fast');
        }

        $('#clearBtn').on('click', function() { resetForm(); });

        $(document).on('click', '.btnEdit', function() {
            $.ajax({
                url: '{{ url("Master/Storagelocationedit") }}',
                method: 'POST',
                data: { _token: '{{ csrf_token() }}', recordID: $(this).data('id') },
                success: function(data) {
                    $('#branch_name').val(data.branch_name);
                    $('#location_name').val(data.location_name);
                    $('#short_code').val(data.short_code);
                    $('#contact_person').val(data.contact_person);
                    $('#description').val(data.description);
                    $('#address_line1').val(data.address_line1);
                    $('#address_line2').val(data.address_line2);
                    $('#address_line3').val(data.address_line3);
                    $('#city').val(data.city);
                    $('#country').val(data.country);
                    $('#recordOption').val(2);
                    $('#recordID').val(data.idtbl_storage_locations);
                    $('#submitBtn').html('<i class="fas fa-edit"></i>&nbsp;Update Location');
                    $('html, body').animate({ scrollTop: 0 }, 'fast');
                },
                error: function() { alert('Error loading record'); }
            });
        });

        $(document).on('click', '.btnDelete', function() {
            if (!confirm('Are you sure you want to delete this location?')) return;
            const form = $('<form></form>').attr({
                method: 'POST',
                action: '{{ url("Master/Storagelocationdelete") }}'
            }).append(
                $('<input>').attr({ type: 'hidden', name: '_token', value: '{{ csrf_token() }}' }),
                $('<input>').attr({ type: 'hidden', name: 'recordID', value: $(this).data('id') })
            );
            $(document.body).append(form);
            form.submit();
        });

        @if(Session::has('msg'))
            action('{!! Session::get("msg") !!}');
        @endif
    });
</script>
@endsection
