@extends('layouts.app')

@section('title', 'User Type - VYS International')

@section('content')
<div class="page-header page-header-light bg-white shadow">
    <div class="container-fluid">
        <div class="page-header-content py-3 text-center text-lg-left">
            <h1 class="page-header-title font-weight-light mb-0">
                <div class="page-header-icon"><i data-feather="user-tag"></i></div>
                <span>User Type</span>
            </h1>
        </div>
    </div>
</div>

<div class="container-fluid mt-2">
    @include('layouts.system_users_nav_bar')
</div>

<div class="container-fluid mt-2 p-0 p-md-2">
    <div class="card shadow-sm">
        <div class="card-body p-2">
            <div class="row">
                <div class="col-12 col-md-4 mb-3">
                    <form action="{{ url('User/Usertypeinsertupdate') }}" method="post" autocomplete="off">
                        @csrf
                        <div class="form-group mb-1">
                            <label class="small font-weight-bold">User Type Name*</label>
                            <input type="text" class="form-control form-control-sm" name="usertype" id="usertype" required>
                        </div>
                        <div class="form-group mt-2 text-right">
                            <button type="submit" id="submitBtn" class="btn btn-primary btn-sm px-4 w-100 w-md-auto"><i class="far fa-save"></i>&nbsp;Add</button>
                        </div>
                        <input type="hidden" name="recordOption" id="recordOption" value="1">
                        <input type="hidden" name="recordID" id="recordID" value="">
                    </form>
                </div>
                <div class="col-12 col-md-8">
                    <div class="table-responsive pb-3">
                        <table class="table table-bordered table-striped table-sm nowrap w-100" id="dataTable">
                            <thead class="thead-light">
                                <tr>
                                    <th>#</th>
                                    <th>USER TYPE</th>
                                    <th class="text-right">ACTIONS</th>
                                </tr>
                            </thead>
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
        var addcheck = '{{ $addcheck ?? 1 }}';
        var editcheck = '{{ $editcheck ?? 1 }}';
        var statuscheck = '{{ $statuscheck ?? 1 }}';
        var deletecheck = '{{ $deletecheck ?? 1 }}';

        $('#dataTable').DataTable({
            destroy: true,
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: {
                url: "{{ url('scripts/usertypelist.php') }}",
                type: "POST",
                data: function(d) {
                    d.userID = '{{ session('userid') }}';
                }
            },
            order: [[0, "desc"]],
            columns: [
                { data: "idtbl_user_type" },
                { data: "usertype" },
                {
                    targets: -1,
                    className: 'text-right',
                    data: null,
                    render: function(data, type, full) {
                        var button = '';
                        button += '<button class="btn btn-primary btn-sm btnEdit mr-1 ' + (editcheck != 1 ? 'd-none' : '') + '" id="' + full['idtbl_user_type'] + '"><i class="fas fa-pen"></i></button>';

                        if(full['status'] == 1){
                            button += '<a href="{{ url('User/Usertypestatus') }}/'+full['idtbl_user_type']+'/2" onclick="return confirm(\'Are you sure you want to deactivate this?\')" target="_self" class="btn btn-warning btn-sm mr-1 ' + (statuscheck != 1 ? 'd-none' : '') + '"><i class="fas fa-times"></i></a>';
                        } else {
                            button += '<a href="{{ url('User/Usertypestatus') }}/'+full['idtbl_user_type']+'/1" onclick="return confirm(\'Are you sure you want to activate this?\')" target="_self" class="btn btn-success btn-sm mr-1 ' + (statuscheck != 1 ? 'd-none' : '') + '"><i class="fas fa-check"></i></a>';
                        }

                        button += '<a href="{{ url('User/Usertypestatus') }}/'+full['idtbl_user_type']+'/3" onclick="return confirm(\'Are you sure you want to remove this?\')" target="_self" class="btn btn-danger btn-sm ' + (deletecheck != 1 ? 'd-none' : '') + '"><i class="fas fa-trash-alt"></i></a>';

                        return '<div class="btn-group btn-group-sm">'+button+'</div>';
                    }
                }
            ],
            drawCallback: function(settings) {
                $('[data-toggle="tooltip"]').tooltip();
            }
        });

        $('#dataTable tbody').on('click', '.btnEdit', function() {
            if(!confirm("Are you sure, You want to Edit this?")) return;
            var id = $(this).attr('id');
            $.ajax({
                type: "POST",
                data: { recordID: id, _token: '{{ csrf_token() }}' },
                url: '{{ url('User/Usertypeedit') }}',
                success: function(result) {
                    var obj = typeof result === 'string' ? JSON.parse(result) : result;
                    $('#recordID').val(obj.id);
                    $('#usertype').val(obj.type);
                    $('#recordOption').val('2');
                    $('#submitBtn').html('<i class="far fa-save"></i>&nbsp;Update');
                }
            });
        });
    });
</script>
@endsection
