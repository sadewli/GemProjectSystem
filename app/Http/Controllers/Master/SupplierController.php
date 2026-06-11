<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class SupplierController extends Controller
{
    public function index()
    {
        if (!Session::get('loggedin')) return redirect('/');
        $menuaccess = (new \App\Models\Commeninfo())->Getmenuprivilege();
        $suppliers = Supplier::orderBy('supplier_name')->get();

        return view('master.suppliers', compact('suppliers', 'menuaccess'));
    }

    public function insertupdate(Request $request)
    {
        $data = $request->validate([
            'recordOption' => 'required|in:1,2',
            'recordID' => 'nullable|integer',
            'supplier_name' => 'required|string|max:255',
            'contact_name' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:191',
            'phone' => 'nullable|string|max:50',
            'address' => 'nullable|string',
            'country' => 'nullable|string|max:100',
            'currency' => 'required|string|max:10',
            'status' => 'required|string|max:50',
        ]);

        $normalizedName = trim($data['supplier_name']);

        if ($data['recordOption'] == 1) {
            $exists = Supplier::whereRaw('LOWER(supplier_name) = ?', [strtolower($normalizedName)])
                ->exists();

            if ($exists) {
                Session::flash('msg', json_encode($this->makeActionResponse(false, 'Supplier already exists.', 'warning')));
                return back()->withInput();
            }

            Supplier::create([
                'supplier_name' => $normalizedName,
                'contact_name'  => $data['contact_name'] ?? null,
                'email'         => $data['email'] ?? null,
                'phone'         => $data['phone'] ?? null,
                'address'       => $data['address'] ?? null,
                'country'       => $data['country'] ?? null,
                'currency'      => $data['currency'],
                'status'        => $data['status'],
            ]);

            Session::flash('msg', json_encode($this->makeActionResponse(true, 'Record Added Successfully', 'success')));
            return redirect('Master/Suppliers');
        }

        $supplier = Supplier::find($data['recordID']);

        if (!$supplier) {
            Session::flash('msg', json_encode($this->makeActionResponse(false, 'Record not found', 'danger')));
            return redirect('Master/Suppliers');
        }

        $supplier->update([
            'supplier_name' => $normalizedName,
            'contact_name'  => $data['contact_name'] ?? null,
            'email'         => $data['email'] ?? null,
            'phone'         => $data['phone'] ?? null,
            'address'       => $data['address'] ?? null,
            'country'       => $data['country'] ?? null,
            'currency'      => $data['currency'],
            'status'        => $data['status'],
        ]);

        Session::flash('msg', json_encode($this->makeActionResponse(true, 'Record Updated Successfully', 'primary')));

        return redirect('Master/Suppliers');
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
