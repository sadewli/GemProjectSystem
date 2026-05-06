<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserType;
use App\Models\MenuList;
use App\Models\Privilege;
use App\Models\Commeninfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;

class UserController extends Controller
{
    public function Useraccount()
    {
        $usertype = UserType::active()->get();
        $menuaccess = (new Commeninfo())->Getmenuprivilege();

        return view('useraccount', compact('usertype', 'menuaccess'));
    }

    public function Usertype()
    {
        $menuaccess = (new Commeninfo())->Getmenuprivilege();
        return view('usertype', compact('menuaccess'));
    }

    public function Userprivilege()
    {
        $useraccount = User::where('status', 1)
            ->when(Session::get('userid') != 1, function ($query) {
                return $query->where('idtbl_user', '>', 1);
            })
            ->get(['idtbl_user', 'name']);

        $menulist = MenuList::active()->get();
        $menuaccess = (new Commeninfo())->Getmenuprivilege();

        return view('userprivilege', compact('useraccount', 'menulist', 'menuaccess'));
    }

    protected function makeActionResponse($isSuccess, $message, $type)
    {
        return (object) [
            'icon' => $isSuccess ? 'fas fa-save' : 'fas fa-exclamation-circle',
            'title' => '',
            'message' => $message,
            'url' => '',
            'target' => '_self',
            'type' => $type,
        ];
    }

    public function Useraccountinsertupdate(Request $request)
    {
        $data = $request->validate([
            'recordOption' => 'required|in:1,2',
            'accountname' => 'required|string|max:255',
            'username' => 'required|string|max:255',
            'password' => $request->input('recordOption') == 1 ? 'required|string|min:4' : 'nullable|string|min:4',
            'usertype' => 'required|integer|exists:tbl_user_type,idtbl_user_type',
            'recordID' => 'nullable|integer',
        ]);

        if ($data['recordOption'] == 1) {
            $exists = User::where('username', $data['username'])
                ->where('status', '!=', 3)
                ->exists();

            if ($exists) {
                Session::flash('msg', json_encode($this->makeActionResponse(false, 'Username already exists!', 'warning')));
                return redirect('User/Useraccount');
            }

            User::create([
                'name' => $data['accountname'],
                'username' => $data['username'],
                'password' => md5($data['password']),
                'status' => 1,
                'insertdatetime' => now(),
                'tbl_user_type_idtbl_user_type' => $data['usertype'],
            ]);

            Session::flash('msg', json_encode($this->makeActionResponse(true, 'Record Added Successfully', 'success')));
        } else {
            $user = User::find($data['recordID']);
            if (!$user) {
                Session::flash('msg', json_encode($this->makeActionResponse(false, 'User not found', 'danger')));
                return redirect('User/Useraccount');
            }

            $exists = User::where('username', $data['username'])
                ->where('idtbl_user', '!=', $data['recordID'])
                ->where('status', '!=', 3)
                ->exists();

            if ($exists) {
                Session::flash('msg', json_encode($this->makeActionResponse(false, 'Username already exists!', 'warning')));
                return redirect('User/Useraccount');
            }

            $updateData = [
                'name' => $data['accountname'],
                'username' => $data['username'],
                'updateuser' => Session::get('userid'),
                'updatedatetime' => now(),
                'tbl_user_type_idtbl_user_type' => $data['usertype'],
            ];

            if (!empty($data['password'])) {
                $updateData['password'] = md5($data['password']);
            }

            $user->update($updateData);

            Session::flash('msg', json_encode($this->makeActionResponse(true, 'Record Updated Successfully', 'primary')));
        }

        return redirect('User/Useraccount');
    }

    public function Useraccountedit(Request $request)
    {
        $id = $request->input('recordID');
        $user = User::where('idtbl_user', $id)->where('status', 1)->first();
        if (!$user) {
            return response()->json(['error' => 'Not found'], 404);
        }

        return response()->json([
            'id' => $user->idtbl_user,
            'name' => $user->name,
            'username' => $user->username,
            'type' => $user->tbl_user_type_idtbl_user_type,
        ]);
    }

    public function Useraccountstatus($x, $y)
    {
        $user = User::find($x);
        if (!$user) {
            Session::flash('msg', json_encode($this->makeActionResponse(false, 'Record not found', 'danger')));
            return redirect('User/Useraccount');
        }

        $status_value = $y == 1 ? 1 : ($y == 2 ? 2 : 3);
        $user->update(['status' => $status_value, 'updateuser' => Session::get('userid'), 'updatedatetime' => now()]);

        $message = $y == 1 ? 'Record Activated Successfully' : ($y == 2 ? 'Record Deactivated Successfully' : 'Record Removed Successfully');
        Session::flash('msg', json_encode($this->makeActionResponse(true, $message, 'success')));

        return redirect('User/Useraccount');
    }

    public function Usertypeedit(Request $request)
    {
        $recordID = $request->input('recordID');
        $usertype = UserType::where('idtbl_user_type', $recordID)->where('status',1)->first();
        if (!$usertype) {
            return response()->json(['error' => 'Not found'],404);
        }

        return response()->json(['id' => $usertype->idtbl_user_type, 'type' => $usertype->usertype]);
    }

    public function Usertypeinsertupdate(Request $request)
    {
        $data = $request->validate([
            'recordOption' => 'required|in:1,2',
            'usertype' => 'required|string|max:255',
            'recordID' => 'nullable|integer',
        ]);

        if ($data['recordOption']==1) {
            $exists = UserType::whereRaw('LOWER(usertype)=?', [strtolower($data['usertype'])])->where('status','!=',3)->exists();
            if ($exists) {
                Session::flash('msg', json_encode($this->makeActionResponse(false, 'User type already exists!', 'warning')));
                return redirect('User/Usertype');
            }

            UserType::create(['usertype' => $data['usertype'], 'status' => 1, 'insertdatetime'=>now()]);
            Session::flash('msg', json_encode($this->makeActionResponse(true, 'Record Added Successfully', 'success')));
        } else {
            $usertype = UserType::find($data['recordID']);
            if (!$usertype) {
                Session::flash('msg', json_encode($this->makeActionResponse(false, 'Record not found', 'danger')));
                return redirect('User/Usertype');
            }
            $exists = UserType::whereRaw('LOWER(usertype)=?', [strtolower($data['usertype'])])->where('idtbl_user_type','!=', $data['recordID'])->where('status','!=',3)->exists();
            if ($exists) {
                Session::flash('msg', json_encode($this->makeActionResponse(false, 'User type already exists!', 'warning')));
                return redirect('User/Usertype');
            }
            $usertype->update(['usertype' => $data['usertype'], 'updatedatetime'=>now()]);
            Session::flash('msg', json_encode($this->makeActionResponse(true, 'Record Updated Successfully', 'primary')));
        }

        return redirect('User/Usertype');
    }

    public function Usertypestatus($x, $y)
    {
        $usertype = UserType::find($x);
        if (!$usertype) {
            Session::flash('msg', json_encode($this->makeActionResponse(false, 'Record not found', 'danger')));
            return redirect('User/Usertype');
        }

        $status_value = $y == 1 ? 1 : ($y == 2 ? 2 : 3);
        $usertype->update(['status' => $status_value, 'updatedatetime'=>now()]);

        $message = $y == 1 ? 'Record Activated Successfully' : ($y == 2 ? 'Record Deactivated Successfully' : 'Record Removed Successfully');
        Session::flash('msg', json_encode($this->makeActionResponse(true, $message, 'success')));

        return redirect('User/Usertype');
    }

    public function Userprivilegeinsertupdate(Request $request)
    {
        $data = $request->validate([
            'recordOption' => 'required|in:1,2',
            'userlist' => 'required|integer|exists:tbl_user,idtbl_user',
            'menulist' => 'required|array',
            'menulist.*' => 'integer|exists:tbl_menu_list,idtbl_menu_list',
            'addcheck' => 'nullable',
            'editcheck' => 'nullable',
            'statuscheck' => 'nullable',
            'removecheck' => 'nullable',
            'recordID' => 'nullable|integer',
        ]);

        $addcheck = $request->has('addcheck') ? 1 : 0;
        $editcheck = $request->has('editcheck') ? 1 : 0;
        $statuscheck = $request->has('statuscheck') ? 1 : 0;
        $removecheck = $request->has('removecheck') ? 1 : 0;

        if ($data['recordOption']==1) {
            foreach ($data['menulist'] as $menu_id) {
                Privilege::create([
                    'can_add' => $addcheck,
                    'can_edit' => $editcheck,
                    'can_statuschange' => $statuscheck,
                    'can_remove' => $removecheck,
                    'access_status' => 1,
                    'status' => 1,
                    'insertdatetime' => now(),
                    'tbl_user_idtbl_user' => $data['userlist'],
                    'tbl_menu_list_idtbl_menu_list' => $menu_id,
                ]);
            }
            Session::flash('msg', json_encode($this->makeActionResponse(true, 'Record Added Successfully', 'success')));
        } else {
            $privilege = Privilege::find($data['recordID']);
            if (!$privilege) {
                Session::flash('msg', json_encode($this->makeActionResponse(false, 'Record not found', 'danger')));
                return redirect('User/Userprivilege');
            }

            $privilege->update([
                'can_add' => $addcheck,
                'can_edit' => $editcheck,
                'can_statuschange' => $statuscheck,
                'can_remove' => $removecheck,
                'access_status' => 1,
                'updateuser' => Session::get('userid'),
                'updatedatetime' => now(),
                'tbl_user_idtbl_user' => $data['userlist'],
                'tbl_menu_list_idtbl_menu_list' => $data['menulist'][0],
            ]);
            Session::flash('msg', json_encode($this->makeActionResponse(true, 'Record Updated Successfully', 'primary')));
        }

        return redirect('User/Userprivilege');
    }

    public function Userprivilegeedit(Request $request)
    {
        $recordID = $request->input('recordID');
        $privilege = Privilege::where('idtbl_privilege', $recordID)->where('status',1)->first();
        if (!$privilege) {
            return response()->json(['error' => 'Not found'], 404);
        }

        return response()->json([
            'id' => $privilege->idtbl_privilege,
            'add' => $privilege->can_add,
            'edit' => $privilege->can_edit,
            'statuschange' => $privilege->can_statuschange,
            'remove' => $privilege->can_remove,
            'user' => $privilege->tbl_user_idtbl_user,
            'menu' => [ ['menulistID' => $privilege->tbl_menu_list_idtbl_menu_list] ],
        ]);
    }

    public function Userprivilegestatus($x, $y)
    {
        $privilege = Privilege::find($x);
        if (!$privilege) {
            Session::flash('msg', json_encode($this->makeActionResponse(false, 'Record not found', 'danger')));
            return redirect('User/Userprivilege');
        }

        $status_value = $y == 1 ? 1 : ($y == 2 ? 2 : 3);
        $privilege->update(['status'=>$status_value, 'updateuser'=>Session::get('userid'), 'updatedatetime'=>now()]);

        $message = $y == 1 ? 'Record Activated Successfully' : ($y == 2 ? 'Record Deactivated Successfully' : 'Record Removed Successfully');
        Session::flash('msg', json_encode($this->makeActionResponse(true, $message, 'success')));

        return redirect('User/Userprivilege');
    }
}
