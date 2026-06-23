<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::orderBy('sort_order', 'asc')->get();

        $nextId = 1;
        if (\Schema::hasTable('tbl_role')) {
            $latest = \DB::table('tbl_role')->orderBy('idtbl_role', 'desc')->first();
            if ($latest) {
                $nextId = $latest->idtbl_role + 1;
            }
        }

        return view('master.role', compact('roles', 'nextId'));
    }

    public function insertupdate(Request $request)
    {
        $request->validate([
            'role_name' => 'required|max:100',
            'value' => 'required|max:100',
            'sort_order' => 'nullable|integer',
        ]);

        $recordID = $request->input('recordID');
        $recordOption = $request->input('recordOption'); // 1 = Add, 2 = Edit

        $data = [
            'role_name' => $request->input('role_name'),
            'value' => $request->input('value'),
            'sort_order' => $request->input('sort_order', 0) ?: 0,
        ];

        if ($recordOption == 1) {
            Role::create($data);
            $msg = json_encode(['type' => 'success', 'message' => 'Role added successfully.']);
        } else {
            Role::where('idtbl_role', $recordID)->update($data);
            $msg = json_encode(['type' => 'success', 'message' => 'Role updated successfully.']);
        }

        return redirect()->back()->with('msg', $msg);
    }

    public function status($id, $status)
    {
        $newStatus = ($status == 1) ? 0 : 1;
        Role::where('idtbl_role', $id)->update(['status' => $newStatus]);
        
        $msg = json_encode(['type' => 'success', 'message' => 'Status changed successfully.']);
        return redirect()->back()->with('msg', $msg);
    }

    public function delete(Request $request)
    {
        $recordID = $request->input('recordID');
        try {
            Role::where('idtbl_role', $recordID)->delete();
            $msg = json_encode(['type' => 'success', 'message' => 'Role deleted successfully.']);
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() === '23000') {
                $msg = json_encode(['type' => 'danger', 'message' => 'Cannot delete this Role because it is referenced by other records.']);
            } else {
                $msg = json_encode(['type' => 'danger', 'message' => 'Failed to delete record. Error: ' . $e->getMessage()]);
            }
        } catch (\Exception $e) {
            $msg = json_encode(['type' => 'danger', 'message' => 'Failed to delete record. Error: ' . $e->getMessage()]);
        }

        return redirect()->back()->with('msg', $msg);
    }
}
