<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Sku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class SkuController extends Controller
{
    public function index()
    {
        if (!Session::get('loggedin')) return redirect('/');
        $menuaccess = (new \App\Models\Commeninfo())->GetmenupriVilege();
        $skus = Sku::orderBy('sku_name')->get();
        return view('master.sku', compact('menuaccess', 'skus'));
    }

    public function insertupdate(Request $request)
    {
        $data = $request->validate([
            'recordOption' => 'required|in:1,2',
            'recordID'     => 'nullable|integer',
            'sku_name'     => 'required|string|max:255',
        ]);

        $normalizedName = trim($data['sku_name']);

        if ($data['recordOption'] == 1) {
            $exists = Sku::whereRaw('LOWER(sku_name) = ?', [strtolower($normalizedName)])
                ->exists();

            if ($exists) {
                return redirect('Master/Sku?action=5')->withInput();
            }

            Sku::create([
                'sku_name'   => $normalizedName,
                'status'     => 1,
                'created_by' => Session::get('userid'),
            ]);

            return redirect('Master/Sku?action=4');
        }

        $sku = Sku::find($data['recordID']);
        if (!$sku) {
            return redirect('Master/Sku?action=5');
        }

        $exists = Sku::where('idtbl_skus', '!=', $data['recordID'])
            ->whereRaw('LOWER(sku_name) = ?', [strtolower($normalizedName)])
            ->exists();

        if ($exists) {
            return redirect('Master/Sku?action=5')->withInput();
        }

        $sku->update(['sku_name' => $normalizedName]);

        return redirect('Master/Sku?action=6');
    }

    public function edit(Request $request)
    {
        $data = $request->validate(['recordID' => 'required|integer']);
        $sku = Sku::find($data['recordID']);
        if (!$sku) return response()->json(['error' => 'Record not found'], 404);
        return response()->json($sku);
    }

    public function delete(Request $request)
    {
        $data = $request->validate(['recordID' => 'required|integer']);
        $sku = Sku::find($data['recordID']);
        if (!$sku) {
            return redirect('Master/Sku?action=5');
        }
        $sku->delete();
        return redirect('Master/Sku?action=3');
    }

    public function status(Request $request)
    {
        $data = $request->validate([
            'recordID' => 'required|integer',
            'status'   => 'required|in:0,1',
        ]);
        
        $sku = Sku::find($data['recordID']);
        if (!$sku) {
            return redirect('Master/Sku?action=5');
        }
        
        $sku->update(['status' => $data['status']]);
        
        // Use action 1 for activate, 2 for deactivate
        $action = $data['status'] == 1 ? 1 : 2;
        return redirect('Master/Sku?action=' . $action);
    }

    private function makeActionResponse(bool $success, string $message, string $class): array
    {
        return ['success' => $success, 'message' => $message, 'class' => $class];
    }
}
