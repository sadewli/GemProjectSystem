<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\SubCategory;
use App\Models\ProductType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class SubCategoryController extends Controller
{
    public function index()
    {
        if (!Session::get('loggedin')) return redirect('/');
        $menuaccess = (new \App\Models\Commeninfo())->Getmenuprivilege();
        
        $product_types = ProductType::where('status', 1)->orderBy('name')->get();
        $subcategories = SubCategory::with('productType')->get();
        
        return view('master.subcategory', compact('menuaccess', 'product_types', 'subcategories'));
    }

    public function insertupdate(Request $request)
    {
        $data = $request->validate([
            'recordOption' => 'required|in:1,2',
            'recordID' => 'nullable|integer',
            'sub_category_name' => 'required|string|max:100',
            'idtbl_product_types' => 'required|integer|exists:tbl_product_types,idtbl_product_types',
        ]);

        $normalizedName = trim($data['sub_category_name']);

        if ($data['recordOption'] == 1) {
            $exists = SubCategory::where('idtbl_product_types', $data['idtbl_product_types'])
                ->whereRaw('LOWER(sub_category_name) = ?', [strtolower($normalizedName)])
                ->exists();

            if ($exists) {
                Session::flash('msg', json_encode($this->makeActionResponse(false, 'Sub-Category already exists under this Product Type.', 'warning')));
                return back()->withInput();
            }

            SubCategory::create([
                'idtbl_product_types' => $data['idtbl_product_types'],
                'sub_category_name' => $normalizedName,
                'insertuser' => Session::get('userid'),
            ]);

            Session::flash('msg', json_encode($this->makeActionResponse(true, 'Record Added Successfully', 'success')));
            return redirect('Master/Subcategory');
        }

        $subcategory = SubCategory::find($data['recordID']);
        if (!$subcategory) {
            Session::flash('msg', json_encode($this->makeActionResponse(false, 'Record not found', 'danger')));
            return redirect('Master/Subcategory');
        }

        $subcategory->update([
            'sub_category_name' => $normalizedName,
            'idtbl_product_types' => $data['idtbl_product_types'],
            'updateuser' => Session::get('userid'),
            'updatedatetime' => now(),
        ]);

        Session::flash('msg', json_encode($this->makeActionResponse(true, 'Record Updated Successfully', 'primary')));
        return redirect('Master/Subcategory');
    }

    public function delete(Request $request)
    {
        $data = $request->validate([
            'recordID' => 'required|integer',
        ]);

        $subcategory = SubCategory::find($data['recordID']);
        if (!$subcategory) {
            Session::flash('msg', json_encode($this->makeActionResponse(false, 'Record not found', 'danger')));
            return redirect('Master/Subcategory');
        }

        $subcategory->update([
            'status' => 0,
            'updateuser' => Session::get('userid'),
            'updatedatetime' => now(),
        ]);

        Session::flash('msg', json_encode($this->makeActionResponse(true, 'Record Deleted Successfully', 'primary')));
        return redirect('Master/Subcategory');
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
