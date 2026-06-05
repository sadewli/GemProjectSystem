<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MasterController extends Controller
{
    public function variety()
    {
        return view('master.variety');
    }

    public function subcategory()
    {
        return view('master.subcategory');
    }

    public function color()
    {
        return view('master.color');
    }

    public function color_category()
    {
        return view('master.color_category');
    }

    public function shape_cut()
    {
        return view('master.shape_cut');
    }

    public function grade()
    {
        return view('master.grade');
    }

    public function origin_treatment()
    {
        return view('master.origin_treatment');
    }

    public function storage_location()
    {
        return view('master.storage_location');
    }

    public function companytype()
    {
        $types = \App\Models\CompanyType::orderBy('sort_order', 'asc')->get();
        
        $nextId = 1;
        if (\Schema::hasTable('tbl_company_type')) {
            $latest = \DB::table('tbl_company_type')->orderBy('idtbl_company_type', 'desc')->first();
            if ($latest) {
                $nextId = $latest->idtbl_company_type + 1;
            }
        }

        return view('master.companytype', compact('types', 'nextId'));
    }


    public function companytype_insertupdate(Request $request)
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
            \App\Models\CompanyType::create($data);
            $msg = json_encode(['type' => 'success', 'message' => 'Company Type added successfully.']);
        } else {
            \App\Models\CompanyType::where('idtbl_company_type', $recordID)->update($data);
            $msg = json_encode(['type' => 'success', 'message' => 'Company Type updated successfully.']);
        }

        return redirect()->back()->with('msg', $msg);
    }

    public function companytype_status($id, $status)
    {
        $newStatus = ($status == 1) ? 0 : 1;
        \App\Models\CompanyType::where('idtbl_company_type', $id)->update(['status' => $newStatus]);
        
        $msg = json_encode(['type' => 'success', 'message' => 'Status changed successfully.']);
        return redirect()->back()->with('msg', $msg);
    }

    public function role()
    {
        $roles = \App\Models\Role::orderBy('sort_order', 'asc')->get();

        $nextId = 1;
        if (\Schema::hasTable('tbl_role')) {
            $latest = \DB::table('tbl_role')->orderBy('idtbl_role', 'desc')->first();
            if ($latest) {
                $nextId = $latest->idtbl_role + 1;
            }
        }

        return view('master.role', compact('roles', 'nextId'));
    }

    public function role_insertupdate(Request $request)
    {
        $request->validate([
            'role_name' => 'required|max:100',
            'value' => 'required|max:100',
            'sort_order' => 'nullable|integer',
        ]);

        $recordID = $request->input('recordID');
        $recordOption = $request->input('recordOption'); // 1 = Add, 2 = Edit

        $data = [
            'role_name' => $request->input('role_name'),
            'value' => $request->input('value'),
            'sort_order' => $request->input('sort_order', 0) ?: 0,
        ];

        if ($recordOption == 1) {
            \App\Models\Role::create($data);
            $msg = json_encode(['type' => 'success', 'message' => 'Role added successfully.']);
        } else {
            \App\Models\Role::where('idtbl_role', $recordID)->update($data);
            $msg = json_encode(['type' => 'success', 'message' => 'Role updated successfully.']);
        }

        return redirect()->back()->with('msg', $msg);
    }

    public function role_status($id, $status)
    {
        $newStatus = ($status == 1) ? 0 : 1;
        \App\Models\Role::where('idtbl_role', $id)->update(['status' => $newStatus]);
        
        $msg = json_encode(['type' => 'success', 'message' => 'Status changed successfully.']);
        return redirect()->back()->with('msg', $msg);
    }

    public function state()
    {
        $states = \App\Models\State::orderBy('sort_order', 'asc')->get();
        $countries = \App\Models\Country::active()->orderBy('sort_order', 'asc')->get();
        return view('master.state', compact('states', 'countries'));
    }

    public function state_insertupdate(Request $request)
    {
        $recordID = $request->input('recordID');
        $recordOption = $request->input('recordOption'); // 1 = Add, 2 = Edit

        if ($recordOption == 1) {
            $request->validate([
                'idtbl_state' => 'required|string|max:50|unique:tbl_state,idtbl_state',
                'idtbl_country' => 'nullable|string|max:50|exists:tbl_country,idtbl_country',
                'state_name' => 'required|max:100',
                'value' => 'required|max:100',
                'sort_order' => 'nullable|integer',
            ]);
        } else {
            $request->validate([
                'idtbl_country' => 'nullable|string|max:50|exists:tbl_country,idtbl_country',
                'state_name' => 'required|max:100',
                'value' => 'required|max:100',
                'sort_order' => 'nullable|integer',
            ]);
        }

        $data = [
            'idtbl_country' => $request->input('idtbl_country'),
            'state_name' => $request->input('state_name'),
            'value' => $request->input('value'),
            'sort_order' => $request->input('sort_order', 0) ?: 0,
        ];

        if ($recordOption == 1) {
            $data['idtbl_state'] = $request->input('idtbl_state');
            \App\Models\State::create($data);
            $msg = json_encode(['type' => 'success', 'message' => 'State added successfully.']);
        } else {
            \App\Models\State::where('idtbl_state', $recordID)->update($data);
            $msg = json_encode(['type' => 'success', 'message' => 'State updated successfully.']);
        }

        return redirect()->back()->with('msg', $msg);
    }

    public function state_status($id, $status)
    {
        $newStatus = ($status == 1) ? 0 : 1;
        \App\Models\State::where('idtbl_state', $id)->update(['status' => $newStatus]);
        
        $msg = json_encode(['type' => 'success', 'message' => 'Status changed successfully.']);
        return redirect()->back()->with('msg', $msg);
    }

    public function country()
    {
        $countries = \App\Models\Country::orderBy('sort_order', 'asc')->get();
        return view('master.country', compact('countries'));
    }

    public function country_insertupdate(Request $request)
    {
        $recordID = $request->input('recordID');
        $recordOption = $request->input('recordOption'); // 1 = Add, 2 = Edit

        if ($recordOption == 1) {
            $request->validate([
                'idtbl_country' => 'required|string|max:50|unique:tbl_country,idtbl_country',
                'country_name' => 'required|max:100',
                'value' => 'required|max:100',
                'sort_order' => 'nullable|integer',
            ]);
        } else {
            $request->validate([
                'country_name' => 'required|max:100',
                'value' => 'required|max:100',
                'sort_order' => 'nullable|integer',
            ]);
        }

        $data = [
            'country_name' => $request->input('country_name'),
            'value' => $request->input('value'),
            'sort_order' => $request->input('sort_order', 0) ?: 0,
        ];

        if ($recordOption == 1) {
            $data['idtbl_country'] = $request->input('idtbl_country');
            \App\Models\Country::create($data);
            $msg = json_encode(['type' => 'success', 'message' => 'Country added successfully.']);
        } else {
            \App\Models\Country::where('idtbl_country', $recordID)->update($data);
            $msg = json_encode(['type' => 'success', 'message' => 'Country updated successfully.']);
        }

        return redirect()->back()->with('msg', $msg);
    }

    public function country_status($id, $status)
    {
        $newStatus = ($status == 1) ? 0 : 1;
        \App\Models\Country::where('idtbl_country', $id)->update(['status' => $newStatus]);
        
        $msg = json_encode(['type' => 'success', 'message' => 'Status changed successfully.']);
        return redirect()->back()->with('msg', $msg);
    }
}

