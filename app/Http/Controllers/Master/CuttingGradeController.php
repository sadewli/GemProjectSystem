<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\CuttingGrade;
use App\Models\ProductType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CuttingGradeController extends Controller
{
    public function index()
    {
        if (!Session::get('loggedin')) return redirect('/');
        $menuaccess = (new \App\Models\Commeninfo())->Getmenuprivilege();
        $productTypes = ProductType::where('status', 1)->get();
        $cuttinggrades = CuttingGrade::with('productType')->orderBy('cuttinggradename')->get();
        return view('master.cuttinggrade', compact('menuaccess', 'cuttinggrades', 'productTypes'));
    }

    public function insertupdate(Request $request)
    {
        $data = $request->validate([
            'recordOption' => 'required|in:1,2',
            'recordID' => 'nullable|integer',
            'idtbl_product_types' => 'required|integer',
            'cuttinggradename' => 'required|string|max:50',
        ]);

        $normalizedName = trim($data['cuttinggradename']);

        if ($data['recordOption'] == 1) {
            $exists = CuttingGrade::where('idtbl_product_types', $data['idtbl_product_types'])
                ->whereRaw('LOWER(cuttinggradename) = ?', [strtolower($normalizedName)])
                ->exists();

            if ($exists) {
                Session::flash('msg', json_encode($this->makeActionResponse(false, 'This cutting grade already exists for the selected product type.', 'warning')));
                return back()->withInput();
            }

            CuttingGrade::create([
                'idtbl_product_types' => $data['idtbl_product_types'],
                'cuttinggradename' => $normalizedName,
                'insertuser' => Session::get('userid'),
            ]);

            Session::flash('msg', json_encode($this->makeActionResponse(true, 'Record Added Successfully', 'success')));
            return redirect('Master/CuttingGrade');
        }

        $cuttinggrade = CuttingGrade::find($data['recordID']);
        if (!$cuttinggrade) {
            Session::flash('msg', json_encode($this->makeActionResponse(false, 'Record not found', 'danger')));
            return redirect('Master/CuttingGrade');
        }

        $exists = CuttingGrade::where('idtbl_cuttinggrade', '!=', $data['recordID'])
            ->where('idtbl_product_types', $data['idtbl_product_types'])
            ->whereRaw('LOWER(cuttinggradename) = ?', [strtolower($normalizedName)])
            ->exists();

        if ($exists) {
            Session::flash('msg', json_encode($this->makeActionResponse(false, 'This cutting grade already exists for the selected product type.', 'warning')));
            return back()->withInput();
        }

        $cuttinggrade->update([
            'idtbl_product_types' => $data['idtbl_product_types'],
            'cuttinggradename' => $normalizedName,
            'updateuser' => Session::get('username') ?? Session::get('userid'),
        ]);

        Session::flash('msg', json_encode($this->makeActionResponse(true, 'Record Updated Successfully', 'primary')));
        return redirect('Master/CuttingGrade');
    }

    public function edit(Request $request)
    {
        $data = $request->validate([
            'recordID' => 'required|integer',
        ]);

        $cuttinggrade = CuttingGrade::find($data['recordID']);
        if (!$cuttinggrade) {
            return response()->json(['error' => 'Record not found'], 404);
        }

        return response()->json($cuttinggrade);
    }

    public function delete(Request $request)
    {
        $data = $request->validate([
            'recordID' => 'required|integer',
        ]);

        $cuttinggrade = CuttingGrade::find($data['recordID']);
        if (!$cuttinggrade) {
            Session::flash('msg', json_encode($this->makeActionResponse(false, 'Record not found', 'danger')));
            return back();
        }

        $cuttinggrade->delete();
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
