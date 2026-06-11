<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\ClarityGrade;
use App\Models\ProductType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ClarityGradeController extends Controller
{
    public function index()
    {
        if (!Session::get('loggedin')) return redirect('/');
        $menuaccess = (new \App\Models\Commeninfo())->Getmenuprivilege();
        $productTypes = ProductType::where('status', 1)->get();
        $claritygrades = ClarityGrade::with('productType')->orderBy('clarity_grade_name')->get();
        return view('master.claritygrade', compact('menuaccess', 'claritygrades', 'productTypes'));
    }

    public function insertupdate(Request $request)
    {
        $data = $request->validate([
            'recordOption'       => 'required|in:1,2',
            'recordID'           => 'nullable|integer',
            'idtbl_product_types'=> 'required|integer',
            'clarity_grade_name' => 'required|string|max:100',
        ]);

        $normalizedName = trim($data['clarity_grade_name']);

        if ($data['recordOption'] == 1) {
            $exists = ClarityGrade::where('idtbl_product_types', $data['idtbl_product_types'])
                ->whereRaw('LOWER(clarity_grade_name) = ?', [strtolower($normalizedName)])
                ->exists();

            if ($exists) {
                Session::flash('msg', json_encode($this->makeActionResponse(false, 'This clarity grade already exists for the selected product type.', 'warning')));
                return back()->withInput();
            }

            ClarityGrade::create([
                'idtbl_product_types' => $data['idtbl_product_types'],
                'clarity_grade_name'  => $normalizedName,
                'insertuser'          => Session::get('userid'),
            ]);

            Session::flash('msg', json_encode($this->makeActionResponse(true, 'Record Added Successfully', 'success')));
            return redirect('Master/ClarityGrade');
        }

        $claritygrade = ClarityGrade::find($data['recordID']);
        if (!$claritygrade) {
            Session::flash('msg', json_encode($this->makeActionResponse(false, 'Record not found', 'danger')));
            return redirect('Master/ClarityGrade');
        }

        $exists = ClarityGrade::where('idtbl_clarity_grade', '!=', $data['recordID'])
            ->where('idtbl_product_types', $data['idtbl_product_types'])
            ->whereRaw('LOWER(clarity_grade_name) = ?', [strtolower($normalizedName)])
            ->exists();

        if ($exists) {
            Session::flash('msg', json_encode($this->makeActionResponse(false, 'This clarity grade already exists for the selected product type.', 'warning')));
            return back()->withInput();
        }

        $claritygrade->update([
            'idtbl_product_types' => $data['idtbl_product_types'],
            'clarity_grade_name'  => $normalizedName,
            'updateuser'          => Session::get('username') ?? Session::get('userid'),
        ]);

        Session::flash('msg', json_encode($this->makeActionResponse(true, 'Record Updated Successfully', 'primary')));
        return redirect('Master/ClarityGrade');
    }

    public function edit(Request $request)
    {
        $data = $request->validate(['recordID' => 'required|integer']);
        $claritygrade = ClarityGrade::find($data['recordID']);
        if (!$claritygrade) {
            return response()->json(['error' => 'Record not found'], 404);
        }
        return response()->json($claritygrade);
    }

    public function delete(Request $request)
    {
        $data = $request->validate(['recordID' => 'required|integer']);
        $claritygrade = ClarityGrade::find($data['recordID']);
        if (!$claritygrade) {
            Session::flash('msg', json_encode($this->makeActionResponse(false, 'Record not found', 'danger')));
            return back();
        }
        $claritygrade->delete();
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
