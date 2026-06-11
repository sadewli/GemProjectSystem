<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\StorageLocation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class StorageLocationController extends Controller
{
    public function index()
    {
        if (!Session::get('loggedin')) return redirect('/');
        $menuaccess = (new \App\Models\Commeninfo())->Getmenuprivilege();
        $locations = StorageLocation::orderBy('branch_name')->orderBy('location_name')->get();
        return view('master.storage_location', compact('menuaccess', 'locations'));
    }

    public function insertupdate(Request $request)
    {
        $data = $request->validate([
            'recordOption'  => 'required|in:1,2',
            'recordID'      => 'nullable|integer',
            'branch_name'   => 'required|string|max:255',
            'location_name' => 'required|string|max:255',
            'short_code'    => 'required|string|max:50',
            'contact_person'=> 'nullable|string|max:255',
            'description'   => 'nullable|string',
            'address_line1' => 'nullable|string|max:255',
            'address_line2' => 'nullable|string|max:255',
            'address_line3' => 'nullable|string|max:255',
            'city'          => 'nullable|string|max:100',
            'country'       => 'nullable|string|max:100',
        ]);

        $normalizedName   = trim($data['location_name']);
        $normalizedBranch = trim($data['branch_name']);

        if ($data['recordOption'] == 1) {
            $exists = StorageLocation::whereRaw('LOWER(branch_name) = ?', [strtolower($normalizedBranch)])
                ->whereRaw('LOWER(location_name) = ?', [strtolower($normalizedName)])
                ->exists();

            if ($exists) {
                Session::flash('msg', json_encode($this->makeActionResponse(false, 'This location already exists for this branch.', 'warning')));
                return back()->withInput();
            }

            StorageLocation::create([
                'branch_name'   => $normalizedBranch,
                'location_name' => $normalizedName,
                'short_code'    => trim($data['short_code']),
                'contact_person'=> $data['contact_person'] ?? null,
                'description'   => $data['description'] ?? null,
                'address_line1' => $data['address_line1'] ?? null,
                'address_line2' => $data['address_line2'] ?? null,
                'address_line3' => $data['address_line3'] ?? null,
                'city'          => $data['city'] ?? null,
                'country'       => $data['country'] ?? null,
                'insertuser'    => Session::get('userid'),
            ]);

            Session::flash('msg', json_encode($this->makeActionResponse(true, 'Storage Location Added Successfully', 'success')));
            return redirect('Master/StorageLocation');
        }

        $location = StorageLocation::find($data['recordID']);
        if (!$location) {
            Session::flash('msg', json_encode($this->makeActionResponse(false, 'Record not found', 'danger')));
            return redirect('Master/StorageLocation');
        }

        $exists = StorageLocation::where('idtbl_storage_locations', '!=', $data['recordID'])
            ->whereRaw('LOWER(branch_name) = ?', [strtolower($normalizedBranch)])
            ->whereRaw('LOWER(location_name) = ?', [strtolower($normalizedName)])
            ->exists();

        if ($exists) {
            Session::flash('msg', json_encode($this->makeActionResponse(false, 'This location already exists for this branch.', 'warning')));
            return back()->withInput();
        }

        $location->update([
            'branch_name'   => $normalizedBranch,
            'location_name' => $normalizedName,
            'short_code'    => trim($data['short_code']),
            'contact_person'=> $data['contact_person'] ?? null,
            'description'   => $data['description'] ?? null,
            'address_line1' => $data['address_line1'] ?? null,
            'address_line2' => $data['address_line2'] ?? null,
            'address_line3' => $data['address_line3'] ?? null,
            'city'          => $data['city'] ?? null,
            'country'       => $data['country'] ?? null,
            'updateuser'    => Session::get('username') ?? Session::get('userid'),
        ]);

        Session::flash('msg', json_encode($this->makeActionResponse(true, 'Storage Location Updated Successfully', 'primary')));
        return redirect('Master/StorageLocation');
    }

    public function edit(Request $request)
    {
        $data = $request->validate(['recordID' => 'required|integer']);
        $location = StorageLocation::find($data['recordID']);
        if (!$location) {
            return response()->json(['error' => 'Record not found'], 404);
        }
        return response()->json($location);
    }

    public function delete(Request $request)
    {
        $data = $request->validate(['recordID' => 'required|integer']);
        $location = StorageLocation::find($data['recordID']);
        if ($location) {
            $location->delete();
            Session::flash('msg', json_encode($this->makeActionResponse(true, 'Location Deleted Successfully', 'success')));
        } else {
            Session::flash('msg', json_encode($this->makeActionResponse(false, 'Record not found', 'danger')));
        }
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
