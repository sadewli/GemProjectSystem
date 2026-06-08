<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\CompanyType;
use Illuminate\Http\Request;

class CompanyTypeController extends Controller
{
    public function index()
    {
        $types = CompanyType::orderBy('sort_order', 'asc')->get();
        
        $nextId = 1;
        if (\Schema::hasTable('tbl_company_type')) {
            $latest = \DB::table('tbl_company_type')->orderBy('idtbl_company_type', 'desc')->first();
            if ($latest) {
                $nextId = $latest->idtbl_company_type + 1;
            }
        }

        return view('master.companytype', compact('types', 'nextId'));
    }

    public function insertupdate(Request $request)
    {
        $request->validate([
            'company_type' => 'required|max:100',
            'value' => 'required|max:100',
            'sort_order' => 'nullable|integer',
        ]);

        $recordID = $request->input('recordID');
        $recordOption = $request->input('recordOption'); // 1 = Add, 2 = Edit

        $data = [
            'company_type' => $request->input('company_type'),
            'value' => $request->input('value'),
            'sort_order' => $request->input('sort_order', 0) ?: 0,
        ];

        if ($recordOption == 1) {
            CompanyType::create($data);
            $msg = json_encode(['type' => 'success', 'message' => 'Company Type added successfully.']);
        } else {
            CompanyType::where('idtbl_company_type', $recordID)->update($data);
            $msg = json_encode(['type' => 'success', 'message' => 'Company Type updated successfully.']);
        }

        return redirect()->back()->with('msg', $msg);
    }

    public function status($id, $status)
    {
        $newStatus = ($status == 1) ? 0 : 1;
        CompanyType::where('idtbl_company_type', $id)->update(['status' => $newStatus]);
        
        $msg = json_encode(['type' => 'success', 'message' => 'Status changed successfully.']);
        return redirect()->back()->with('msg', $msg);
    }
}
