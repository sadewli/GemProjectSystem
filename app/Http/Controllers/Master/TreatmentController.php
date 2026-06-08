<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Treatment;
use App\Models\ProductType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class TreatmentController extends Controller
{
    public function index()
    {
        if (!Session::get('loggedin')) return redirect('/');
        $menuaccess = (new \App\Models\Commeninfo())->Getmenuprivilege();
        $productTypes = ProductType::where('status', 1)->get();
        $treatments = Treatment::with('productType')->orderBy('treatment_name')->get();
        return view('master.treatment', compact('menuaccess', 'treatments', 'productTypes'));
    }

    public function insertupdate(Request $request)
    {
        $data = $request->validate([
            'recordOption' => 'required|in:1,2',
            'recordID' => 'nullable|integer',
            'idtbl_product_types' => 'required|integer',
            'treatment_name' => 'required|string|max:100',
        ]);

        $normalizedName = trim($data['treatment_name']);

        if ($data['recordOption'] == 1) {
            $exists = Treatment::where('idtbl_product_types', $data['idtbl_product_types'])
                ->whereRaw('LOWER(treatment_name) = ?', [strtolower($normalizedName)])
                ->exists();

            if ($exists) {
                Session::flash('msg', json_encode($this->makeActionResponse(false, 'This treatment already exists for the selected product type.', 'warning')));
                return back()->withInput();
            }

            Treatment::create([
                'idtbl_product_types' => $data['idtbl_product_types'],
                'treatment_name' => $normalizedName,
                'insertuser' => Session::get('userid'),
            ]);

            Session::flash('msg', json_encode($this->makeActionResponse(true, 'Record Added Successfully', 'success')));
            return redirect('Master/Treatment');
        }

        $treatment = Treatment::find($data['recordID']);
        if (!$treatment) {
            Session::flash('msg', json_encode($this->makeActionResponse(false, 'Record not found', 'danger')));
            return redirect('Master/Treatment');
        }

        $exists = Treatment::where('idtbl_treatments', '!=', $data['recordID'])
            ->where('idtbl_product_types', $data['idtbl_product_types'])
            ->whereRaw('LOWER(treatment_name) = ?', [strtolower($normalizedName)])
            ->exists();

        if ($exists) {
            Session::flash('msg', json_encode($this->makeActionResponse(false, 'This treatment already exists for the selected product type.', 'warning')));
            return back()->withInput();
        }

        $treatment->update([
            'idtbl_product_types' => $data['idtbl_product_types'],
            'treatment_name' => $normalizedName,
            'updateuser' => Session::get('username') ?? Session::get('userid'),
        ]);

        Session::flash('msg', json_encode($this->makeActionResponse(true, 'Record Updated Successfully', 'primary')));
        return redirect('Master/Treatment');
    }

    public function edit(Request $request)
    {
        $data = $request->validate([
            'recordID' => 'required|integer',
        ]);

        $treatment = Treatment::find($data['recordID']);
        if (!$treatment) {
            return response()->json(['error' => 'Record not found'], 404);
        }

        return response()->json($treatment);
    }

    public function delete(Request $request)
    {
        $data = $request->validate([
            'recordID' => 'required|integer',
        ]);

        $treatment = Treatment::find($data['recordID']);
        if (!$treatment) {
            Session::flash('msg', json_encode($this->makeActionResponse(false, 'Record not found', 'danger')));
            return back();
        }

        $treatment->delete();
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
