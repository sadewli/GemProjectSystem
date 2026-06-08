<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Shape;
use App\Models\ProductType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ShapeController extends Controller
{
    public function index()
    {
        if (!Session::get('loggedin')) return redirect('/');
        $menuaccess = (new \App\Models\Commeninfo())->Getmenuprivilege();
        $productTypes = ProductType::where('status', 1)->get();
        $shapes = Shape::with('productType')->orderBy('name')->get();
        return view('master.shape', compact('menuaccess', 'shapes', 'productTypes'));
    }

    public function insertupdate(Request $request)
    {
        $data = $request->validate([
            'recordOption' => 'required|in:1,2',
            'recordID' => 'nullable|integer',
            'idtbl_product_types' => 'required|integer',
            'name' => 'required|string|max:100',
        ]);

        $normalizedName = trim($data['name']);

        if ($data['recordOption'] == 1) {
            $exists = Shape::where('idtbl_product_types', $data['idtbl_product_types'])
                ->whereRaw('LOWER(name) = ?', [strtolower($normalizedName)])
                ->exists();

            if ($exists) {
                Session::flash('msg', json_encode($this->makeActionResponse(false, 'This shape already exists for the selected product type.', 'warning')));
                return back()->withInput();
            }

            Shape::create([
                'idtbl_product_types' => $data['idtbl_product_types'],
                'name' => $normalizedName,
                'insertuser' => Session::get('userid'),
            ]);

            Session::flash('msg', json_encode($this->makeActionResponse(true, 'Record Added Successfully', 'success')));
            return redirect('Master/Shape');
        }

        $shape = Shape::find($data['recordID']);
        if (!$shape) {
            Session::flash('msg', json_encode($this->makeActionResponse(false, 'Record not found', 'danger')));
            return redirect('Master/Shape');
        }

        $exists = Shape::where('idtbl_shapes', '!=', $data['recordID'])
            ->where('idtbl_product_types', $data['idtbl_product_types'])
            ->whereRaw('LOWER(name) = ?', [strtolower($normalizedName)])
            ->exists();

        if ($exists) {
            Session::flash('msg', json_encode($this->makeActionResponse(false, 'This shape already exists for the selected product type.', 'warning')));
            return back()->withInput();
        }

        $shape->update([
            'idtbl_product_types' => $data['idtbl_product_types'],
            'name' => $normalizedName,
            'updateuser' => Session::get('username') ?? Session::get('userid'),
        ]);

        Session::flash('msg', json_encode($this->makeActionResponse(true, 'Record Updated Successfully', 'primary')));
        return redirect('Master/Shape');
    }

    public function edit(Request $request)
    {
        $data = $request->validate([
            'recordID' => 'required|integer',
        ]);

        $shape = Shape::find($data['recordID']);
        if (!$shape) {
            return response()->json(['error' => 'Record not found'], 404);
        }

        return response()->json($shape);
    }

    public function delete(Request $request)
    {
        $data = $request->validate([
            'recordID' => 'required|integer',
        ]);

        $shape = Shape::find($data['recordID']);
        if (!$shape) {
            Session::flash('msg', json_encode($this->makeActionResponse(false, 'Record not found', 'danger')));
            return back();
        }

        $shape->delete();
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
