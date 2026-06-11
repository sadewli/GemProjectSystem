<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Origin;
use App\Models\ProductType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class OriginController extends Controller
{
    public function index()
    {
        if (!Session::get('loggedin')) return redirect('/');
        $menuaccess = (new \App\Models\Commeninfo())->Getmenuprivilege();
        $productTypes = ProductType::where('status', 1)->get();
        $origins = Origin::with('productType')->orderBy('origin_name')->get();
        return view('master.origin', compact('menuaccess', 'origins', 'productTypes'));
    }

    public function insertupdate(Request $request)
    {
        $data = $request->validate([
            'recordOption' => 'required|in:1,2',
            'recordID' => 'nullable|integer',
            'idtbl_product_types' => 'required|integer',
            'origin_name' => 'required|string|max:100',
        ]);

        $normalizedName = trim($data['origin_name']);

        if ($data['recordOption'] == 1) {
            $exists = Origin::where('idtbl_product_types', $data['idtbl_product_types'])
                ->whereRaw('LOWER(origin_name) = ?', [strtolower($normalizedName)])
                ->exists();

            if ($exists) {
                Session::flash('msg', json_encode($this->makeActionResponse(false, 'This origin already exists for the selected product type.', 'warning')));
                return back()->withInput();
            }

            Origin::create([
                'idtbl_product_types' => $data['idtbl_product_types'],
                'origin_name' => $normalizedName,
                'insertuser' => Session::get('userid'),
            ]);

            Session::flash('msg', json_encode($this->makeActionResponse(true, 'Record Added Successfully', 'success')));
            return redirect('Master/Origin');
        }

        $origin = Origin::find($data['recordID']);
        if (!$origin) {
            Session::flash('msg', json_encode($this->makeActionResponse(false, 'Record not found', 'danger')));
            return redirect('Master/Origin');
        }

        $exists = Origin::where('idtbl_origins', '!=', $data['recordID'])
            ->where('idtbl_product_types', $data['idtbl_product_types'])
            ->whereRaw('LOWER(origin_name) = ?', [strtolower($normalizedName)])
            ->exists();

        if ($exists) {
            Session::flash('msg', json_encode($this->makeActionResponse(false, 'This origin already exists for the selected product type.', 'warning')));
            return back()->withInput();
        }

        $origin->update([
            'idtbl_product_types' => $data['idtbl_product_types'],
            'origin_name' => $normalizedName,
            'updateuser' => Session::get('username') ?? Session::get('userid'),
        ]);

        Session::flash('msg', json_encode($this->makeActionResponse(true, 'Record Updated Successfully', 'primary')));
        return redirect('Master/Origin');
    }

    public function edit(Request $request)
    {
        $data = $request->validate([
            'recordID' => 'required|integer',
        ]);

        $origin = Origin::find($data['recordID']);
        if (!$origin) {
            return response()->json(['error' => 'Record not found'], 404);
        }

        return response()->json($origin);
    }

    public function delete(Request $request)
    {
        $data = $request->validate([
            'recordID' => 'required|integer',
        ]);

        $origin = Origin::find($data['recordID']);
        if (!$origin) {
            Session::flash('msg', json_encode($this->makeActionResponse(false, 'Record not found', 'danger')));
            return back();
        }

        $origin->delete();
        Session::flash('msg', json_encode($this->makeActionResponse(true, 'Record Deleted Successfully', 'success')));
        return back();
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
}
