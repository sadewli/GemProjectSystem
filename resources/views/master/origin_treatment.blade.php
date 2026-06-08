@extends('layouts.app')

@section('title', 'Origin & Treatment - Master Data')

@section('content')
<div class="page-header page-header-light bg-white shadow">
    <div class="container-fluid">
        <div class="page-header-content py-3 text-center text-lg-left">
            <h1 class="page-header-title font-weight-light mb-0">
                <div class="page-header-icon"><i data-feather="database"></i></div>
                <span>Origin & Treatment</span>
            </h1>
        </div>
    </div>
</div>

<div class="container-fluid mt-2">
    @include('layouts.master_data_nav_bar')
</div>

<div class="container-fluid mt-2 p-0 p-md-2">
    <div class="row">
        <!-- Origin Section -->
        <div class="col-12 col-md-6 mb-3">
            <div class="card shadow-sm h-100">
                <div class="card-body p-3">
                    <h6 class="font-weight-bold text-dark mb-3">Manage Origins</h6>
                    <form id="originForm" action="{{ url('Master/Origininsertupdate') }}" method="post" autocomplete="off" class="mb-4">
                        @csrf
                        <div class="form-group mb-2">
                            <label class="small font-weight-bold">Origin Name*</label>
                            <div class="input-group input-group-sm">
                                <input type="text" class="form-control" name="origin_name" id="origin_name" required placeholder="Madagascar">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="submit" id="originSubmitBtn">Add</button>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="recordOption" id="originRecordOption" value="1">
                        <input type="hidden" name="recordID" id="originRecordID" value="">
                    </form>
                    
                    <label class="small font-weight-bold text-dark">Current Origins:</label>
                    <div class="list-group list-group-flush border-top" id="originList">
                        @forelse($origins as $index => $origin)
                        <div class="list-group-item d-flex justify-content-between align-items-center px-0 py-2" data-id="{{ $origin->idtbl_origins }}">
                            <span>{{ $index + 1 }}. {{ $origin->origin_name }}</span>
                            <div class="btn-group btn-group-sm">
                                <button class="btn btn-link text-primary p-0 mr-2 btnOriginEdit" data-id="{{ $origin->idtbl_origins }}"><i class="fas fa-pen"></i></button>
                                <button class="btn btn-link text-danger p-0 btnOriginDelete" data-id="{{ $origin->idtbl_origins }}"><i class="fas fa-trash-alt"></i></button>
                            </div>
                        </div>
                        @empty
                        <div class="text-center text-muted py-3">No origins found</div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <!-- Treatment Section -->
        <div class="col-12 col-md-6 mb-3">
            <div class="card shadow-sm h-100">
                <div class="card-body p-3">
                    <h6 class="font-weight-bold text-dark mb-3">Manage Treatments</h6>
                    <form id="treatmentForm" action="{{ url('Master/Treatmentinsertupdate') }}" method="post" autocomplete="off" class="mb-4">
                        @csrf
                        <div class="form-group mb-2">
                            <label class="small font-weight-bold">Treatment Name*</label>
                            <div class="input-group input-group-sm">
                                <input type="text" class="form-control" name="treatment_name" id="treatment_name" required placeholder="Heated">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="submit" id="treatmentSubmitBtn">Add</button>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="recordOption" id="treatmentRecordOption" value="1">
                        <input type="hidden" name="recordID" id="treatmentRecordID" value="">
                    </form>

                    <label class="small font-weight-bold text-dark">Current Treatments:</label>
                    <div class="list-group list-group-flush border-top" id="treatmentList">
                        @forelse($treatments as $index => $treatment)
                        <div class="list-group-item d-flex justify-content-between align-items-center px-0 py-2" data-id="{{ $treatment->idtbl_treatments }}">
                            <span>{{ $index + 1 }}. {{ $treatment->treatment_name }}</span>
                            <div class="btn-group btn-group-sm">
                                <button class="btn btn-link text-primary p-0 mr-2 btnTreatmentEdit" data-id="{{ $treatment->idtbl_treatments }}"><i class="fas fa-pen"></i></button>
                                <button class="btn btn-link text-danger p-0 btnTreatmentDelete" data-id="{{ $treatment->idtbl_treatments }}"><i class="fas fa-trash-alt"></i></button>
                            </div>
                        </div>
                        @empty
                        <div class="text-center text-muted py-3">No treatments found</div>
                        @endforelse
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
        // ----- Origin -----
        // Submit (Create/Update) Origin via AJAX
        $('#originForm').on('submit', function(e){
            e.preventDefault();
            const formData = $(this).serialize();
            $.ajax({
                url: '{{ url("Master/Origininsertupdate") }}',
                method: 'POST',
                data: formData,
                success: function(){ location.reload(); },
                error: function(xhr){
                    const errors = xhr.responseJSON?.errors ?? {};
                    let msg = 'Failed to save Origin.';
                    for(const key in errors){ msg += `\n${key}: ${errors[key].join(', ')}`; }
                    alert(msg);
                }
            });
        });

        // ----- Treatment -----
        // Submit (Create/Update) Treatment via AJAX
        $('#treatmentForm').on('submit', function(e){
            e.preventDefault();
            const formData = $(this).serialize();
            $.ajax({
                url: '{{ url("Master/Treatmentinsertupdate") }}',
                method: 'POST',
                data: formData,
                success: function(){ location.reload(); },
                error: function(xhr){
                    const errors = xhr.responseJSON?.errors ?? {};
                    let msg = 'Failed to save Treatment.';
                    for(const key in errors){ msg += `\n${key}: ${errors[key].join(', ')}`; }
                    alert(msg);
                }
            });
        });

        // Origin Edit
        $(document).on('click', '.btnOriginEdit', function() {
            let recordID = $(this).data('id');
            
            $.ajax({
                url: '{{ url("Master/Originedit") }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    recordID: recordID
                },
                success: function(response) {
                    $('#origin_name').val(response.origin_name);
                    $('#originRecordID').val(response.idtbl_origins);
                    $('#originRecordOption').val('2');
                    $('#originSubmitBtn').text('Update');
                },
                error: function() {
                    alert('Error loading record');
                }
            });
        });

        // Origin Delete
        $(document).on('click', '.btnOriginDelete', function() {
            let recordID = $(this).data('id');
            
            if (confirm('Are you sure you want to delete this origin?')) {
                let form = $('<form method="POST" action="{{ url("Master/Origindelete") }}"></form>');
                form.append('<input type="hidden" name="_token" value="{{ csrf_token() }}">');
                form.append('<input type="hidden" name="recordID" value="' + recordID + '">');
                $('body').append(form);
                form.submit();
            }
        });

        // Treatment Edit
        $(document).on('click', '.btnTreatmentEdit', function() {
            let recordID = $(this).data('id');
            
            $.ajax({
                url: '{{ url("Master/Treatmentedit") }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    recordID: recordID
                },
                success: function(response) {
                    $('#treatment_name').val(response.treatment_name);
                    $('#treatmentRecordID').val(response.idtbl_treatments);
                    $('#treatmentRecordOption').val('2');
                    $('#treatmentSubmitBtn').text('Update');
                },
                error: function() {
                    alert('Error loading record');
                }
            });
        });

        // Treatment Delete
        $(document).on('click', '.btnTreatmentDelete', function() {
            let recordID = $(this).data('id');
            
            if (confirm('Are you sure you want to delete this treatment?')) {
                let form = $('<form method="POST" action="{{ url("Master/Treatmentdelete") }}"></form>');
                form.append('<input type="hidden" name="_token" value="{{ csrf_token() }}">');
                form.append('<input type="hidden" name="recordID" value="' + recordID + '">');
                $('body').append(form);
                form.submit();
            }
        });
    });
</script>
@endsection
