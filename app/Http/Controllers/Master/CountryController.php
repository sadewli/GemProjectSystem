<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Country;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    public function index()
    {
        $countries = Country::orderBy('sort_order', 'asc')->get();
        return view('master.country', compact('countries'));
    }

    public function insertupdate(Request $request)
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
            Country::create($data);
            $msg = json_encode(['type' => 'success', 'message' => 'Country added successfully.']);
        } else {
            Country::where('idtbl_country', $recordID)->update($data);
            $msg = json_encode(['type' => 'success', 'message' => 'Country updated successfully.']);
        }

        return redirect()->back()->with('msg', $msg);
    }

    public function status($id, $status)
    {
        $newStatus = ($status == 1) ? 0 : 1;
        Country::where('idtbl_country', $id)->update(['status' => $newStatus]);
        
        $msg = json_encode(['type' => 'success', 'message' => 'Status changed successfully.']);
        return redirect()->back()->with('msg', $msg);
    }
}
