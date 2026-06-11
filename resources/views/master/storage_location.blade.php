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
                                <option value="1">Main Office</option>
                                <option value="2">Branch 01</option>
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
                        <tr>
                            <td>Safe Box 01</td>
                            <td>SB01</td>
                            <td>Main Office</td>
                            <td>Manager Name</td>
                            <td class="text-right">
                                <div class="btn-group btn-group-sm">
                                    <button class="btn btn-primary btn-sm btnEdit mr-1"><i class="fas fa-pen"></i></button>
                                    <button class="btn btn-danger btn-sm btnDelete"><i class="fas fa-trash-alt"></i></button>
                                </div>
                            </td>
                        </tr>
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
    });
</script>
@endsection
