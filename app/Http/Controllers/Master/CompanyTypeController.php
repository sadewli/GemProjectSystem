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
            'value' => 'nullable|max:100',
            'sort_order' => 'nullable|integer',
        ]);

        $recordID = $request->input('recordID');
        $recordOption = $request->input('recordOption'); // 1 = Add, 2 = Edit

        // Auto-generate value key from name if not provided
        $value = $request->input('value');
        if (empty($value)) {
            $value = strtolower(preg_replace('/[^a-z0-9]+/i', '_', trim($request->input('company_type'))));
        }

        $data = [
            'company_type' => $request->input('company_type'),
            'value' => $value,
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

    public function delete(Request $request)
    {
        $recordID = $request->input('recordID');
        try {
            CompanyType::where('idtbl_company_type', $recordID)->delete();
            $msg = json_encode(['type' => 'success', 'message' => 'Company Type deleted successfully.']);
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() === '23000') {
                $msg = json_encode(['type' => 'danger', 'message' => 'Cannot delete this Company Type because it is referenced by other records.']);
            } else {
                $msg = json_encode(['type' => 'danger', 'message' => 'Failed to delete record. Error: ' . $e->getMessage()]);
            }
        } catch (\Exception $e) {
            $msg = json_encode(['type' => 'danger', 'message' => 'Failed to delete record. Error: ' . $e->getMessage()]);
        }

        return redirect()->back()->with('msg', $msg);
    }
}
