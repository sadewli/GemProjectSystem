<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\State;
use App\Models\Country;
use Illuminate\Http\Request;

class StateController extends Controller
{
    public function index()
    {
        $states = State::orderBy('sort_order', 'asc')->get();
        $countries = Country::active()->orderBy('sort_order', 'asc')->get();
        return view('master.state', compact('states', 'countries'));
    }

    public function insertupdate(Request $request)
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
            State::create($data);
            $msg = json_encode(['type' => 'success', 'message' => 'State added successfully.']);
        } else {
            State::where('idtbl_state', $recordID)->update($data);
            $msg = json_encode(['type' => 'success', 'message' => 'State updated successfully.']);
        }

        return redirect()->back()->with('msg', $msg);
    }

    public function status($id, $status)
    {
        $newStatus = ($status == 1) ? 0 : 1;
        State::where('idtbl_state', $id)->update(['status' => $newStatus]);
        
        $msg = json_encode(['type' => 'success', 'message' => 'Status changed successfully.']);
        return redirect()->back()->with('msg', $msg);
    }
}
