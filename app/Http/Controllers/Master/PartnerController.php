<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Partner;
use Carbon\Carbon;

class PartnerController extends Controller
{
    public function index()
    {
        $partners = Partner::where('status', '!=', 0)->get();
        return view('master.partners', compact('partners'));
    }

    public function insertupdate(Request $request)
    {
        $request->validate([
            'partner_name' => 'required|string|max:255',
            'email' => 'nullable|email|max:191',
        ]);

        $recordOption = $request->input('recordOption');
        $recordID = $request->input('recordID');

        if ($recordOption == 1) { // Insert
            $partner = new Partner();
            $partner->partner_name = $request->input('partner_name');
            $partner->contact_name = $request->input('contact_name');
            $partner->email = $request->input('email');
            $partner->phone = $request->input('phone');
            $partner->address = $request->input('address');
            $partner->country = $request->input('country');
            $partner->currency = $request->input('currency');
            $partner->status = $request->input('status', 1);
            $partner->insertuser = session('userid', 1); // Assuming 1 as default if no session
            $partner->insertdatetime = Carbon::now();
            $partner->save();

            return redirect()->back()->with('success', 'Partner added successfully.');
        } elseif ($recordOption == 2) { // Update
            $partner = Partner::find($recordID);
            if ($partner) {
                $partner->partner_name = $request->input('partner_name');
                $partner->contact_name = $request->input('contact_name');
                $partner->email = $request->input('email');
                $partner->phone = $request->input('phone');
                $partner->address = $request->input('address');
                $partner->country = $request->input('country');
                $partner->currency = $request->input('currency');
                $partner->status = $request->input('status', 1);
                $partner->updateuser = session('userid', 1);
                $partner->updatedatetime = Carbon::now();
                $partner->save();

                return redirect()->back()->with('success', 'Partner updated successfully.');
            }
            return redirect()->back()->with('error', 'Partner not found.');
        }

        return redirect()->back()->with('error', 'Invalid action.');
    }
}
