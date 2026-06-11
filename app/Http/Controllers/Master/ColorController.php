<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Color;
use App\Models\ProductType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ColorController extends Controller
{
    public function index()
    {
        if (!Session::get('loggedin')) return redirect('/');
        $menuaccess = (new \App\Models\Commeninfo())->Getmenuprivilege();
        $colors = Color::with('productType')->orderBy('idtbl_product_types')->orderBy('color_name')->get();
        $productTypes = ProductType::where('status', 1)->orderBy('name')->get();
        return view('master.color', compact('colors', 'productTypes', 'menuaccess'));
    }

    public function insertupdate(Request $request)
    {
        $data = $request->validate([
            'recordOption' => 'required|in:1,2',
            'recordID' => 'nullable|integer',
            'color_name' => 'required|string|max:50',
            'hex_code' => 'nullable|string|max:7',
            'idtbl_product_types' => 'required|integer|exists:tbl_product_types,idtbl_product_types',
        ]);

        $normalizedName = trim($data['color_name']);
        $typeId = (int) $data['idtbl_product_types'];

        if ($data['recordOption'] == 1) {
            $exists = Color::where('idtbl_product_types', $typeId)
                ->whereRaw('LOWER(color_name) = ?', [strtolower($normalizedName)])
                ->exists();

            if ($exists) {
                Session::flash('msg', json_encode($this->makeActionResponse(false, 'Color already exists for this product type.', 'warning')));
                return back()->withInput();
            }

            Color::create([
                'idtbl_product_types' => $typeId,
                'color_name' => $normalizedName,
                'hex_code' => $data['hex_code'],
                'insertuser' => Session::get('userid'),
                'status' => 1,
            ]);

            Session::flash('msg', json_encode($this->makeActionResponse(true, 'Record Added Successfully', 'success')));
            return redirect('Master/Color');
        }

        $color = Color::find($data['recordID']);
        if (!$color) {
            Session::flash('msg', json_encode($this->makeActionResponse(false, 'Record not found', 'danger')));
            return redirect('Master/Color');
        }

        $exists = Color::where('idtbl_colors', '!=', $data['recordID'])
            ->where('idtbl_product_types', $typeId)
            ->whereRaw('LOWER(color_name) = ?', [strtolower($normalizedName)])
            ->exists();

        if ($exists) {
            Session::flash('msg', json_encode($this->makeActionResponse(false, 'Color already exists for this product type.', 'warning')));
            return back()->withInput();
        }

        $color->update([
            'idtbl_product_types' => $typeId,
            'color_name' => $normalizedName,
            'hex_code' => $data['hex_code'],
            'updateuser' => Session::get('username'),
            'updatedatetime' => now(),
        ]);

        Session::flash('msg', json_encode($this->makeActionResponse(true, 'Record Updated Successfully', 'primary')));
        return redirect('Master/Color');
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
