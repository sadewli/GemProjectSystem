<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\CertificateLab;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CertificateLabController extends Controller
{
    public function index()
    {
        if (!Session::get('loggedin')) return redirect('/');
        $menuaccess = (new \App\Models\Commeninfo())->Getmenuprivilege();
        $labs = CertificateLab::orderBy('lab_name')->get();
        return view('master.certificate_lab', compact('labs', 'menuaccess'));
    }

    public function insertupdate(Request $request)
    {
        $data = $request->validate([
            'recordOption' => 'required|in:1,2',
            'recordID' => 'nullable|integer',
            'lab_name' => 'required|string|max:100',
        ]);

        $name = trim($data['lab_name']);

        if ($data['recordOption'] == 1) {
            $exists = CertificateLab::whereRaw('LOWER(lab_name) = ?', [strtolower($name)])->exists();
            if ($exists) {
                Session::flash('msg', json_encode($this->makeActionResponse(false, 'Certificate Lab already exists.', 'warning')));
                return back()->withInput();
            }

            CertificateLab::create([
                'lab_name' => $name,
                'insertuser' => Session::get('userid'),
                'status' => 1,
            ]);

            Session::flash('msg', json_encode($this->makeActionResponse(true, 'Record Added Successfully', 'success')));
            return redirect('Master/CertificateLab');
        }

        $lab = CertificateLab::find($data['recordID']);
        if (!$lab) {
            Session::flash('msg', json_encode($this->makeActionResponse(false, 'Record not found', 'danger')));
            return redirect('Master/CertificateLab');
        }

        $exists = CertificateLab::where('idtbl_certificate_labs', '!=', $data['recordID'])
            ->whereRaw('LOWER(lab_name) = ?', [strtolower($name)])
            ->exists();

        if ($exists) {
            Session::flash('msg', json_encode($this->makeActionResponse(false, 'Certificate Lab already exists.', 'warning')));
            return back()->withInput();
        }

        $lab->update([
            'lab_name' => $name,
            'updateuser' => Session::get('username'),
            'updatedatetime' => now(),
        ]);

        Session::flash('msg', json_encode($this->makeActionResponse(true, 'Record Updated Successfully', 'primary')));
        return redirect('Master/CertificateLab');
    }

    public function status(Request $request)
    {
        $id = $request->input('recordID');
        $lab = CertificateLab::find($id);
        if (!$lab) return redirect('Master/CertificateLab');
        $lab->status = ($lab->status == 1) ? 2 : 1;
        $lab->updateuser = Session::get('username');
        $lab->updatedatetime = now();
        $lab->save();
        Session::flash('msg', json_encode($this->makeActionResponse(true, 'Status Updated', 'info')));
        return redirect('Master/CertificateLab');
    }

    public function delete(Request $request)
    {
        $id = $request->input('recordID');
        $lab = CertificateLab::find($id);
        if ($lab) {
            $lab->status = 0;
            $lab->updateuser = Session::get('username');
            $lab->updatedatetime = now();
            $lab->save();
            Session::flash('msg', json_encode($this->makeActionResponse(true, 'Record Deleted', 'danger')));
        }
        return redirect('Master/CertificateLab');
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
