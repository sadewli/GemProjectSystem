<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\GradeType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class GradeTypeController extends Controller
{
    public function index()
    {
        if (!Session::get('loggedin')) return redirect('/');
        $menuaccess = (new \App\Models\Commeninfo())->Getmenuprivilege();
        $gradeTypes = GradeType::orderBy('type_name')->get();
        return view('master.grade_type', compact('menuaccess', 'gradeTypes'));
    }

    public function insertupdate(Request $request)
    {
        $data = $request->validate([
            'recordOption' => 'required|in:1,2',
            'recordID' => 'nullable|integer',
            'type_name' => 'required|string|max:100',
            'description' => 'nullable|string',
        ]);

        $normalizedName = trim($data['type_name']);

        if ($data['recordOption'] == 1) {
            $exists = GradeType::whereRaw('LOWER(type_name) = ?', [strtolower($normalizedName)])
                ->exists();

            if ($exists) {
                Session::flash('msg', json_encode($this->makeActionResponse(false, 'Grade Type already exists.', 'warning')));
                return back()->withInput();
            }

            GradeType::create([
                'type_name' => $normalizedName,
                'description' => $data['description'] ?? null,
                'created_by' => Session::get('userid'),
            ]);

            Session::flash('msg', json_encode($this->makeActionResponse(true, 'Record Added Successfully', 'success')));
            return redirect('Master/GradeType');
        }

        $gradeType = GradeType::find($data['recordID']);
        if (!$gradeType) {
            Session::flash('msg', json_encode($this->makeActionResponse(false, 'Record not found', 'danger')));
            return redirect('Master/GradeType');
        }

        $exists = GradeType::where('idtbl_grade_types', '!=', $data['recordID'])
            ->whereRaw('LOWER(type_name) = ?', [strtolower($normalizedName)])
            ->exists();

        if ($exists) {
            Session::flash('msg', json_encode($this->makeActionResponse(false, 'Grade Type already exists.', 'warning')));
            return back()->withInput();
        }

        $gradeType->update([
            'type_name' => $normalizedName,
            'description' => $data['description'] ?? null,
        ]);

        Session::flash('msg', json_encode($this->makeActionResponse(true, 'Record Updated Successfully', 'primary')));
        return redirect('Master/GradeType');
    }

    public function edit(Request $request)
    {
        $data = $request->validate([
            'recordID' => 'required|integer',
        ]);

        $gradeType = GradeType::find($data['recordID']);
        if (!$gradeType) {
            return response()->json(['error' => 'Record not found'], 404);
        }

        return response()->json($gradeType);
    }

    public function delete(Request $request)
    {
        $data = $request->validate([
            'recordID' => 'required|integer',
        ]);

        $gradeType = GradeType::find($data['recordID']);
        if (!$gradeType) {
            Session::flash('msg', json_encode($this->makeActionResponse(false, 'Record not found', 'danger')));
            return back();
        }

        $gradeType->delete();
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
