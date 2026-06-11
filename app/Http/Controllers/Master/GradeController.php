<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Grade;
use App\Models\GradeType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class GradeController extends Controller
{
    public function index()
    {
        if (!Session::get('loggedin')) return redirect('/');
        $menuaccess = (new \App\Models\Commeninfo())->Getmenuprivilege();
        $grades = Grade::with('gradeType')->orderBy('grade_type_id')->orderBy('grade_value')->get();
        $gradeTypes = GradeType::orderBy('type_name')->get();
        return view('master.grade', compact('menuaccess', 'grades', 'gradeTypes'));
    }

    public function insertupdate(Request $request)
    {
        $data = $request->validate([
            'recordOption' => 'required|in:1,2',
            'recordID' => 'nullable|integer',
            'grade_type_id' => 'required|integer|exists:tbl_grade_types,idtbl_grade_types',
            'grade_value' => 'required|string|max:100',
        ]);

        $normalizedValue = trim($data['grade_value']);

        if ($data['recordOption'] == 1) {
            $exists = Grade::where('grade_type_id', (int) $data['grade_type_id'])
                ->whereRaw('LOWER(grade_value) = ?', [strtolower($normalizedValue)])
                ->exists();

            if ($exists) {
                Session::flash('msg', json_encode($this->makeActionResponse(false, 'This grade already exists.', 'warning')));
                return back()->withInput();
            }

            Grade::create([
                'grade_type_id' => (int) $data['grade_type_id'],
                'grade_value' => $normalizedValue,
                'created_by' => Session::get('userid'),
            ]);

            Session::flash('msg', json_encode($this->makeActionResponse(true, 'Record Added Successfully', 'success')));
            return redirect('Master/Grade');
        }

        $grade = Grade::find($data['recordID']);
        if (!$grade) {
            Session::flash('msg', json_encode($this->makeActionResponse(false, 'Record not found', 'danger')));
            return redirect('Master/Grade');
        }

        $exists = Grade::where('idtbl_grades', '!=', $data['recordID'])
            ->where('grade_type_id', (int) $data['grade_type_id'])
            ->whereRaw('LOWER(grade_value) = ?', [strtolower($normalizedValue)])
            ->exists();

        if ($exists) {
            Session::flash('msg', json_encode($this->makeActionResponse(false, 'This grade already exists.', 'warning')));
            return back()->withInput();
        }

        $grade->update([
            'grade_type_id' => (int) $data['grade_type_id'],
            'grade_value' => $normalizedValue,
        ]);

        Session::flash('msg', json_encode($this->makeActionResponse(true, 'Record Updated Successfully', 'primary')));
        return redirect('Master/Grade');
    }

    public function edit(Request $request)
    {
        $data = $request->validate([
            'recordID' => 'required|integer',
        ]);

        $grade = Grade::find($data['recordID']);
        if (!$grade) {
            return response()->json(['error' => 'Record not found'], 404);
        }

        return response()->json($grade);
    }

    public function delete(Request $request)
    {
        $data = $request->validate([
            'recordID' => 'required|integer',
        ]);

        $grade = Grade::find($data['recordID']);
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
            'icon' => $isSuccess ? 'fas fa-save' : 'fas fa-exclamation-circle',
            'title' => '',
            'message' => $message,
            'url' => '',
            'target' => '_self',
            'type' => $type,
        ];
    }
}
