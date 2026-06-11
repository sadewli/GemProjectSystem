<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\ColorGrade;
use App\Models\ProductType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ColorGradeController extends Controller
{
    public function index()
    {
        if (!Session::get('loggedin')) return redirect('/');
        $menuaccess   = (new \App\Models\Commeninfo())->GetmenupriviLege();
        $colorGrades  = ColorGrade::with('productType')->orderBy('idtbl_product_types')->orderBy('grade_name')->get();
        $productTypes = ProductType::orderBy('name')->get();
        return view('master.color_grade', compact('menuaccess', 'colorGrades', 'productTypes'));
    }

    public function insertupdate(Request $request)
    {
        $data = $request->validate([
            'recordOption'        => 'required|in:1,2',
            'recordID'            => 'nullable|integer',
            'idtbl_product_types' => 'required|integer|exists:tbl_product_types,idtbl_product_types',
            'grade_name'          => 'required|string|max:50',
        ]);

        $normalizedName = trim($data['grade_name']);
        $typeId         = (int) $data['idtbl_product_types'];

        if ($data['recordOption'] == 1) {
            $exists = ColorGrade::where('idtbl_product_types', $typeId)
                ->whereRaw('LOWER(grade_name) = ?', [strtolower($normalizedName)])
                ->exists();

            if ($exists) {
                Session::flash('msg', json_encode($this->makeActionResponse(false, 'This color grade already exists for the selected product type.', 'warning')));
                return back()->withInput();
            }

            ColorGrade::create([
                'idtbl_product_types' => $typeId,
                'grade_name'          => $normalizedName,
                'insertuser'          => Session::get('userid'),
                'status'              => 1,
            ]);

            Session::flash('msg', json_encode($this->makeActionResponse(true, 'Record Added Successfully', 'success')));
            return redirect('Master/ColorGrade');
        }

        // UPDATE
        $grade = ColorGrade::find($data['recordID']);
        if (!$grade) {
            Session::flash('msg', json_encode($this->makeActionResponse(false, 'Record not found', 'danger')));
            return redirect('Master/ColorGrade');
        }

        $exists = ColorGrade::where('idtbl_color_grade', '!=', $data['recordID'])
            ->where('idtbl_product_types', $typeId)
            ->whereRaw('LOWER(grade_name) = ?', [strtolower($normalizedName)])
            ->exists();

        if ($exists) {
            Session::flash('msg', json_encode($this->makeActionResponse(false, 'This color grade already exists for the selected product type.', 'warning')));
            return back()->withInput();
        }

        $grade->update([
            'idtbl_product_types' => $typeId,
            'grade_name'          => $normalizedName,
            'updateuser'          => Session::get('username'),
            'updatedatetime'      => now(),
        ]);

        Session::flash('msg', json_encode($this->makeActionResponse(true, 'Record Updated Successfully', 'primary')));
        return redirect('Master/ColorGrade');
    }


    public function status(Request $request)
    {
        $data = $request->validate([
            'recordID' => 'required|integer',
        ]);

        $grade = ColorGrade::find($data['recordID']);
        if (!$grade) {
            Session::flash('msg', json_encode($this->makeActionResponse(false, 'Record not found', 'danger')));
            return back();
        }

        $grade->update([
            'status'        => $grade->status == 1 ? 2 : 1,
            'updateuser'    => Session::get('username'),
            'updatedatetime' => now(),
        ]);

        Session::flash('msg', json_encode($this->makeActionResponse(true, 'Status Updated Successfully', 'success')));
        return back();
    }

    public function delete(Request $request)
    {
        $data = $request->validate([
            'recordID' => 'required|integer',
        ]);

        $grade = ColorGrade::find($data['recordID']);
        if (!$grade) {
            Session::flash('msg', json_encode($this->makeActionResponse(false, 'Record not found', 'danger')));
            return back();
        }

        $grade->delete();
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
