@extends('layouts.app')

@section('title', 'User Privilege - VYS International')

@section('content')
<div class="page-header page-header-light bg-white shadow">
    <div class="container-fluid">
        <div class="page-header-content py-3 text-center text-lg-left">
            <h1 class="page-header-title font-weight-light mb-0">
                <div class="page-header-icon"><i data-feather="shield"></i></div>
                <span>User Privilege</span>
            </h1>
        </div>
    </div>
</div>



<div class="container-fluid mt-2 p-0 p-md-2">
    <div class="card shadow-sm">
        <div class="card-body p-2">
            <div class="row">
                <div class="col-12 col-md-4 mb-3">
                    <form action="{{ url('User/Userprivilegeinsertupdate') }}" method="post" autocomplete="off">
                        @csrf
                        <div class="form-group mb-3">
                            <label class="small font-weight-bold">User</label>
                            <select class="form-control" name="userid" id="userid" required>
                                <option value="">Select</option>
                                @if(isset($useraccount))
                                    @foreach ($useraccount as $user)
                                        <option value="{{ $user->idtbl_user }}">{{ $user->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        
                        <div class="form-group mb-3">
                            <label class="small font-weight-bold">Access Menu</label>
                            <select class="form-control" name="menuid" id="menuid" required>
                                <option value="">Select</option>
                                @if(isset($menulist))
                                    @foreach ($menulist as $menu)
                                        <option value="{{ $menu->idtbl_menu_list }}">{{ $menu->menu_name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>

                        <div class="form-group mb-3">
                            <label class="small font-weight-bold mb-2">User Privilege</label>
                            
                            <div class="custom-control custom-checkbox mb-2">
                                <input type="checkbox" class="custom-control-input" id="can_add" name="can_add" value="1">
                                <label class="custom-control-label small font-weight-bold" style="padding-top: 3px;" for="can_add">Add Privilege</label>
                            </div>
                            
                            <div class="custom-control custom-checkbox mb-2">
                                <input type="checkbox" class="custom-control-input" id="can_edit" name="can_edit" value="1">
                                <label class="custom-control-label small font-weight-bold" style="padding-top: 3px;" for="can_edit">Edit Privilege</label>
                            </div>
                            
                            <div class="custom-control custom-checkbox mb-2">
                                <input type="checkbox" class="custom-control-input" id="can_statuschange" name="can_statuschange" value="1">
                                <label class="custom-control-label small font-weight-bold" style="padding-top: 3px;" for="can_statuschange">Status Privilege</label>
                            </div>
                            
                            <div class="custom-control custom-checkbox mb-3">
                                <input type="checkbox" class="custom-control-input" id="can_remove" name="can_remove" value="1">
                                <label class="custom-control-label small font-weight-bold" style="padding-top: 3px;" for="can_remove">Delete Privilege</label>
                            </div>
                        </div>

                        <div class="form-group mt-3">
                            <button type="submit" id="submitBtn" class="btn btn-primary w-100"><i class="far fa-save"></i>&nbsp;Add</button>
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
                                    <th>USER</th>
                                    <th>MENU</th>
                                    <th>ADD</th>
                                    <th>EDIT</th>
                                    <th>STATUS</th>
                                    <th>REMOVE</th>
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
        var statuscheck = '{{ $statuscheck ?? 1 }}';
        var deletecheck = '{{ $deletecheck ?? 1 }}';

        $('#dataTable').DataTable({
            destroy: true,
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: {
                url: "{{ url('scripts/userprivilegelist.php') }}",
                type: "POST",
                data: function(d) {
                    d.userID = '{{ session('userid') }}';
                    d._token = '{{ csrf_token() }}';
                }
            },
            order: [[0, "desc"]],
            columnDefs: [
                {
                    targets: [3, 4, 5, 6],
                    render: function(data, type, full) {
                        return data == 1 ? '<i class="text-success fas fa-check"></i>' : '<i class="text-danger fas fa-times"></i>';
                    }
                }
            ],
            columns: [
                { data: "idtbl_privilege" },
                { data: "name" },
                { data: "menu_name" },
                { data: "can_add" },
                { data: "can_edit" },
                { data: "can_statuschange" },
                { data: "can_remove" },
                {
                    targets: -1,
                    className: 'text-right',
                    data: null,
                    render: function(data, type, full) {
                        var button = '';
                        button += '<button class="btn btn-primary btn-sm btnEdit mr-1" id="' + full["idtbl_privilege"] + '"><i class="fas fa-pen"></i></button>';

                        if(full["status"] == 1){
                            button += '<a href="{{ url('User/Userprivilegestatus') }}/'+full["idtbl_privilege"]+'/2" onclick="return confirm(\'Are you sure you want to deactivate this?\')" target="_self" class="btn btn-warning btn-sm mr-1 ' + (statuscheck != 1 ? 'd-none' : '') + '"><i class="fas fa-times"></i></a>';
                        } else {
                            button += '<a href="{{ url('User/Userprivilegestatus') }}/'+full["idtbl_privilege"]+'/1" onclick="return confirm(\'Are you sure you want to activate this?\')" target="_self" class="btn btn-success btn-sm mr-1 ' + (statuscheck != 1 ? 'd-none' : '') + '"><i class="fas fa-check"></i></a>';
                        }
                        button += '<a href="{{ url('User/Userprivilegestatus') }}/'+full["idtbl_privilege"]+'/3" onclick="return confirm(\'Are you sure you want to remove this?\')" target="_self" class="btn btn-danger btn-sm ' + (deletecheck != 1 ? 'd-none' : '') + '"><i class="fas fa-trash-alt"></i></a>';

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
                url: '{{ url('User/Userprivilegeedit') }}',
                success: function(result) {
                    var obj = typeof result === 'string' ? JSON.parse(result) : result;
                    $('#recordID').val(obj.id);
                    $('#userid').val(obj.user).css('pointer-events', 'none').css('opacity', '0.6');
                    $('#menuid').val(obj.menu[0].menulistID).css('pointer-events', 'none').css('opacity', '0.6');
                    $('#can_add').prop('checked', obj.add == 1);
                    $('#can_edit').prop('checked', obj.edit == 1);
                    $('#can_statuschange').prop('checked', obj.statuschange == 1);
                    $('#can_remove').prop('checked', obj.remove == 1);
                    $('#recordOption').val('2');
                    $('#submitBtn').html('<i class="far fa-save"></i>&nbsp;Update');
                }
            });
        });
    });
</script>
@endsection
