<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\ProductType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ProductTypeController extends Controller
{
    public function index()
    {
        if (!Session::get('loggedin')) return redirect('/');
        $menuaccess = (new \App\Models\Commeninfo())->Getmenuprivilege();
        $product_types = ProductType::with('sku')->orderBy('name')->get();
        $skus = \App\Models\Sku::where('status', 1)->orderBy('sku_name')->get();
        return view('master.product_type', compact('menuaccess', 'product_types', 'skus'));
    }

    public function insertupdate(Request $request)
    {
        $data = $request->validate([
            'recordOption' => 'required|in:1,2',
            'recordID'     => 'nullable|integer',
            'idtbl_skus'   => 'required|integer|exists:tbl_skus,idtbl_skus',
            'name'         => 'required|string|max:100',
            'skuname'      => 'required|string|max:50',
        ]);

        $normalizedName    = trim($data['name']);
        $normalizedSkuname = trim($data['skuname']);

        if ($data['recordOption'] == 1) {
            $exists = ProductType::where('idtbl_skus', $data['idtbl_skus'])
                ->whereRaw('LOWER(name) = ?', [strtolower($normalizedName)])
                ->exists();

            if ($exists) {
                Session::flash('msg', json_encode($this->makeActionResponse(false, 'Product Type already exists for this SKU.', 'warning')));
                return back()->withInput();
            }

            ProductType::create([
                'idtbl_skus'     => (int) $data['idtbl_skus'],
                'name'           => $normalizedName,
                'skuname'        => $normalizedSkuname,
                'status'         => 1,
                'insertuser'     => Session::get('userid'),
                'insertdatetime' => now(),
            ]);

            Session::flash('msg', json_encode($this->makeActionResponse(true, 'Record Added Successfully', 'success')));
            return redirect('Master/ProductType');
        }

        $productType = ProductType::find($data['recordID']);
        if (!$productType) {
            Session::flash('msg', json_encode($this->makeActionResponse(false, 'Record not found', 'danger')));
            return redirect('Master/ProductType');
        }

        $exists = ProductType::where('idtbl_product_types', '!=', $data['recordID'])
            ->where('idtbl_skus', $data['idtbl_skus'])
            ->whereRaw('LOWER(name) = ?', [strtolower($normalizedName)])
            ->exists();

        if ($exists) {
            Session::flash('msg', json_encode($this->makeActionResponse(false, 'Product Type already exists for this SKU.', 'warning')));
            return back()->withInput();
        }

        $productType->update([
            'idtbl_skus' => (int) $data['idtbl_skus'],
            'name'       => $normalizedName,
            'skuname'    => $normalizedSkuname,
            'updateuser'     => Session::get('userid') ?? 'admin',
            'updatedatetime' => now(),
        ]);

        Session::flash('msg', json_encode($this->makeActionResponse(true, 'Record Updated Successfully', 'primary')));
        return redirect('Master/ProductType');
    }

    public function delete(Request $request)
    {
        $data = $request->validate([
            'recordID' => 'required|integer',
        ]);

        $productType = ProductType::find($data['recordID']);
        if (!$productType) {
            Session::flash('msg', json_encode($this->makeActionResponse(false, 'Record not found', 'danger')));
            return back();
        }

        $productType->delete();
        Session::flash('msg', json_encode($this->makeActionResponse(true, 'Product Type Deleted Successfully', 'success')));
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
