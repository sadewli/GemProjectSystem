<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Variety;
use App\Models\ProductType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class VarietyController extends Controller
{
    public function index()
    {
        if (!Session::get('loggedin')) return redirect('/');
        $menuaccess = (new \App\Models\Commeninfo())->Getmenuprivilege();
        // Assuming there is no display_order in the new table according to schema provided, I'll order by name
        $varieties = Variety::with('productType')->where('status', '!=', 0)->orderBy('name')->get();
        $product_types = ProductType::where('status', 1)->orderBy('name')->get();
        return view('master.variety', compact('menuaccess', 'varieties', 'product_types'));
    }

    public function insertupdate(Request $request)
    {
        $data = $request->validate([
            'recordOption' => 'required|in:1,2',
            'recordID'     => 'nullable|integer',
            'variety_name' => 'required|string|max:100',
            'category'     => 'required|integer|exists:tbl_product_types,idtbl_product_types',
        ]);

        $normalizedName = trim($data['variety_name']);

        if ($data['recordOption'] == 1) {
            $exists = Variety::whereRaw('LOWER(name) = ?', [strtolower($normalizedName)])
                ->exists();

            if ($exists) {
                Session::flash('msg', json_encode($this->makeActionResponse(false, 'Variety already exists.', 'warning')));
                return back()->withInput();
            }

            Variety::create([
                'name'                => $normalizedName,
                'idtbl_product_types' => $data['category'],
                'status'              => 1,
                'insertuser'          => Session::get('userid'),
            ]);

            Session::flash('msg', json_encode($this->makeActionResponse(true, 'Record Added Successfully', 'success')));
            return redirect('Master/Variety');
        }

        $variety = Variety::find($data['recordID']);
        if (!$variety) {
            Session::flash('msg', json_encode($this->makeActionResponse(false, 'Record not found', 'danger')));
            return redirect('Master/Variety');
        }

        $variety->update([
            'name'                => $normalizedName,
            'idtbl_product_types' => $data['category'],
            'updateuser'          => Session::get('userid'),
        ]);

        Session::flash('msg', json_encode($this->makeActionResponse(true, 'Record Updated Successfully', 'primary')));
        return redirect('Master/Variety');
    }

    private function makeActionResponse(bool $success, string $message, string $class): array
    {
        return ['success' => $success, 'message' => $message, 'class' => $class];
    }
}
