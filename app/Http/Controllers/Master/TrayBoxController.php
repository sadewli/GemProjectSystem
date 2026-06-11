<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\TrayBox;
use App\Models\StorageLocation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class TrayBoxController extends Controller
{
    public function index()
    {
        if (!Session::get('loggedin')) return redirect('/');
        $menuaccess = (new \App\Models\Commeninfo())->Getmenuprivilege();
        $storageLocations = StorageLocation::orderBy('branch_name')->orderBy('location_name')->get();
        $trayboxes = TrayBox::with('storageLocation')->orderBy('tray_box_number')->get();
        return view('master.traybox', compact('menuaccess', 'trayboxes', 'storageLocations'));
    }

    public function insertupdate(Request $request)
    {
        $data = $request->validate([
            'recordOption'            => 'required|in:1,2',
            'recordID'                => 'nullable|integer',
            'idtbl_storage_locations' => 'required|integer',
            'tray_box_number'         => 'required|string|max:50',
            'description'             => 'nullable|string|max:255',
        ]);

        $normalizedNumber = trim($data['tray_box_number']);

        if ($data['recordOption'] == 1) {
            $exists = TrayBox::where('idtbl_storage_locations', $data['idtbl_storage_locations'])
                ->whereRaw('LOWER(tray_box_number) = ?', [strtolower($normalizedNumber)])
                ->exists();

            if ($exists) {
                Session::flash('msg', json_encode($this->makeActionResponse(false, 'This tray/box number already exists in the selected storage location.', 'warning')));
                return back()->withInput();
            }

            TrayBox::create([
                'idtbl_storage_locations' => $data['idtbl_storage_locations'],
                'tray_box_number'         => $normalizedNumber,
                'description'             => $data['description'] ?? null,
                'insertuser'              => Session::get('userid'),
            ]);

            Session::flash('msg', json_encode($this->makeActionResponse(true, 'Record Added Successfully', 'success')));
            return redirect('Master/TrayBox');
        }

        $traybox = TrayBox::find($data['recordID']);
        if (!$traybox) {
            Session::flash('msg', json_encode($this->makeActionResponse(false, 'Record not found', 'danger')));
            return redirect('Master/TrayBox');
        }

        $exists = TrayBox::where('idtbl_tray_box', '!=', $data['recordID'])
            ->where('idtbl_storage_locations', $data['idtbl_storage_locations'])
            ->whereRaw('LOWER(tray_box_number) = ?', [strtolower($normalizedNumber)])
            ->exists();

        if ($exists) {
            Session::flash('msg', json_encode($this->makeActionResponse(false, 'This tray/box number already exists in the selected storage location.', 'warning')));
            return back()->withInput();
        }

        $traybox->update([
            'idtbl_storage_locations' => $data['idtbl_storage_locations'],
            'tray_box_number'         => $normalizedNumber,
            'description'             => $data['description'] ?? null,
            'updateuser'              => Session::get('username') ?? Session::get('userid'),
        ]);

        Session::flash('msg', json_encode($this->makeActionResponse(true, 'Record Updated Successfully', 'primary')));
        return redirect('Master/TrayBox');
    }

    public function edit(Request $request)
    {
        $data = $request->validate(['recordID' => 'required|integer']);
        $traybox = TrayBox::find($data['recordID']);
        if (!$traybox) {
            return response()->json(['error' => 'Record not found'], 404);
        }
        return response()->json($traybox);
    }

    public function delete(Request $request)
    {
        $data = $request->validate(['recordID' => 'required|integer']);
        $traybox = TrayBox::find($data['recordID']);
        if (!$traybox) {
            Session::flash('msg', json_encode($this->makeActionResponse(false, 'Record not found', 'danger')));
            return back();
        }
        $traybox->delete();
        Session::flash('msg', json_encode($this->makeActionResponse(true, 'Record Deleted Successfully', 'success')));
        return back();
    }

    protected function makeActionResponse($isSuccess, $message, $type)
    {
        return (object) [
            'icon'    => $isSuccess ? 'fas fa-save' : 'fas fa-exclamation-circle',
            'title'   => '',
            'message' => $message,
            'url'     => '',
            'target'  => '_self',
            'type'    => $type,
        ];
    }
}
