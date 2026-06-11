<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Cut;
use App\Models\ProductType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CutController extends Controller
{
    public function index()
    {
        if (!Session::get('loggedin')) return redirect('/');
        $menuaccess = (new \App\Models\Commeninfo())->Getmenuprivilege();
        $productTypes = ProductType::where('status', 1)->get();
        $cuts = Cut::with('productType')->orderBy('name')->get();
        return view('master.cut', compact('menuaccess', 'cuts', 'productTypes'));
    }

    public function insertupdate(Request $request)
    {
        $data = $request->validate([
            'recordOption' => 'required|in:1,2',
            'recordID' => 'nullable|integer',
            'idtbl_product_types' => 'required|integer',
            'name' => 'required|string|max:100',
        ]);

        $normalizedName = trim($data['name']);

        if ($data['recordOption'] == 1) {
            $exists = Cut::where('idtbl_product_types', $data['idtbl_product_types'])
                ->whereRaw('LOWER(name) = ?', [strtolower($normalizedName)])
                ->exists();

            if ($exists) {
                Session::flash('msg', json_encode($this->makeActionResponse(false, 'This cut already exists for the selected product type.', 'warning')));
                return back()->withInput();
            }

            Cut::create([
                'idtbl_product_types' => $data['idtbl_product_types'],
                'name' => $normalizedName,
                'insertuser' => Session::get('userid'),
            ]);

            Session::flash('msg', json_encode($this->makeActionResponse(true, 'Record Added Successfully', 'success')));
            return redirect('Master/Cut');
        }

        $cut = Cut::find($data['recordID']);
        if (!$cut) {
            Session::flash('msg', json_encode($this->makeActionResponse(false, 'Record not found', 'danger')));
            return redirect('Master/Cut');
        }

        $exists = Cut::where('idtbl_cuts', '!=', $data['recordID'])
            ->where('idtbl_product_types', $data['idtbl_product_types'])
            ->whereRaw('LOWER(name) = ?', [strtolower($normalizedName)])
            ->exists();

        if ($exists) {
            Session::flash('msg', json_encode($this->makeActionResponse(false, 'This cut already exists for the selected product type.', 'warning')));
            return back()->withInput();
        }

        $cut->update([
            'idtbl_product_types' => $data['idtbl_product_types'],
            'name' => $normalizedName,
            'updateuser' => Session::get('username') ?? Session::get('userid'),
        ]);

        Session::flash('msg', json_encode($this->makeActionResponse(true, 'Record Updated Successfully', 'primary')));
        return redirect('Master/Cut');
    }

    public function edit(Request $request)
    {
        $data = $request->validate([
            'recordID' => 'required|integer',
        ]);

        $cut = Cut::find($data['recordID']);
        if (!$cut) {
            return response()->json(['error' => 'Record not found'], 404);
        }

        return response()->json($cut);
    }

    public function delete(Request $request)
    {
        $data = $request->validate([
            'recordID' => 'required|integer',
        ]);

        $cut = Cut::find($data['recordID']);
        if (!$cut) {
            Session::flash('msg', json_encode($this->makeActionResponse(false, 'Record not found', 'danger')));
            return back();
        }

        $cut->delete();
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
