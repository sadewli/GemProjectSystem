<?php

namespace App\Http\Controllers\crm;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CompanyType;
use App\Models\Role;
use App\Models\Country;
use App\Models\State;
use App\Models\PhoneCode;
use App\Models\User;
use App\Models\Crm\CreateContact;
use App\Models\Crm\CreateCompany;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class ContactsController extends Controller
{
    public function index(Request $request)
    {
        $companyTypes  = CompanyType::active()->orderBy('sort_order', 'asc')->get();
        $roles         = Role::active()->orderBy('sort_order', 'asc')->get();
        $countries     = Country::active()->orderBy('sort_order', 'asc')->get();
        $states        = State::active()->orderBy('sort_order', 'asc')->get();
        $phoneCodes    = PhoneCode::active()->orderBy('country_name', 'asc')->get();
        $owners        = User::active()->orderBy('name', 'asc')->get();
        $companies_list = CreateCompany::orderBy('name', 'asc')->get(['idtbl_create_company as id', 'name']);

        // Calculate next reference (P-101, P-102, …)
        $nextId    = 1;
        $latestRef = DB::table('tbl_create_contact')
            ->where('reference', 'like', 'P-%')
            ->orderByRaw('CAST(SUBSTRING(reference, 3) AS UNSIGNED) DESC')
            ->value('reference');
        if ($latestRef) {
            $num    = intval(substr($latestRef, 2));
            $nextId = ($num - 100) + 1;
        } else {
            $latest = DB::table('tbl_create_contact')->latest('idtbl_create_contact')->first();
            if ($latest) {
                $nextId = $latest->idtbl_create_contact + 1;
            }
        }
        $nextReference = 'P-' . (100 + $nextId);

        // Build query with filters
        $query = CreateContact::with(['owner', 'company']);

        if ($request->filled('company_type') && $request->company_type !== 'all') {
            $query->where(function ($q) use ($request) {
                $q->where('contact_type', $request->company_type)
                  ->orWhereHas('company', function ($q2) use ($request) {
                      $q2->where('company_type', $request->company_type);
                  });
            });
        }
        if ($request->filled('status')) {
            $query->where('status', $this->mapContactStatus($request->status));
        }
        if ($request->filled('owner')) {
            $query->where('owned_by', $request->owner);
        }
        if ($request->filled('company_id')) {
            $query->where('company_id', $request->company_id);
        }
        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('first_name', 'like', "%$s%")
                  ->orWhere('last_name',  'like', "%$s%")
                  ->orWhere('reference',  'like', "%$s%")
                  ->orWhere('email',      'like', "%$s%")
                  ->orWhere('phone',      'like', "%$s%");
            });
        }

        $perPage  = intval($request->input('per_page', 10));
        $contacts = $query->latest('idtbl_create_contact')->paginate($perPage);

        return view('crm.contacts', compact(
            'companyTypes', 'roles', 'countries', 'states',
            'phoneCodes', 'owners', 'companies_list', 'contacts', 'nextReference'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:150',
            'last_name'  => 'required|string|max:150',
            'email'      => 'nullable|email|max:255',
        ]);

        // Build reference
        $nextId    = 1;
        $latestRef = DB::table('tbl_create_contact')
            ->where('reference', 'like', 'P-%')
            ->orderByRaw('CAST(SUBSTRING(reference, 3) AS UNSIGNED) DESC')
            ->value('reference');
        if ($latestRef) {
            $num    = intval(substr($latestRef, 2));
            $nextId = ($num - 100) + 1;
        } else {
            $latest = DB::table('tbl_create_contact')->latest('idtbl_create_contact')->first();
            if ($latest) {
                $nextId = $latest->idtbl_create_contact + 1;
            }
        }
        $reference = 'P-' . (100 + $nextId);

        // Handle image upload
        $imagePath = null;
        if ($request->hasFile('profile_image')) {
            $file      = $request->file('profile_image');
            $fileName  = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/contacts'), $fileName);
            $imagePath = 'uploads/contacts/' . $fileName;
        }

        CreateContact::create([
            'first_name'    => $request->first_name,
            'last_name'     => $request->last_name,
            'reference'     => $reference,
            'contact_type'  => $request->contact_type,
            'email'         => $request->email,
            'phone_code'    => $request->phone_code,
            'phone'         => $request->phone,
            'owned_by'      => $request->owned_by ?: Session::get('userid'),
            'role'          => $request->role,
            'profile_image' => $imagePath,
            'address_line1' => $request->address_line1,
            'address_line2' => $request->address_line2,
            'address_line3' => $request->address_line3,
            'country'       => $request->country,
            'state'         => $request->state,
            'postal_code'   => $request->postal_code,
            'company_id'    => $request->company_id ?: null,
            'status'        => $this->mapContactStatus($request->status ?? 'active'),
        ]);

        Session::flash('success', 'Contact created successfully.');
        return redirect()->route('crm.contacts.index');
    }

    public function show($id)
    {
        $contact = CreateContact::findOrFail($id);
        return response()->json($contact);
    }

    public function update(Request $request, $id)
    {
        $contact = CreateContact::findOrFail($id);

        $request->validate([
            'first_name' => 'required|string|max:150',
            'last_name'  => 'required|string|max:150',
            'email'      => 'nullable|email|max:255',
        ]);

        $imagePath = $contact->profile_image;
        if ($request->hasFile('profile_image')) {
            if ($imagePath && File::exists(public_path($imagePath))) {
                File::delete(public_path($imagePath));
            }
            $file      = $request->file('profile_image');
            $fileName  = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/contacts'), $fileName);
            $imagePath = 'uploads/contacts/' . $fileName;
        }

        $contact->update([
            'first_name'    => $request->first_name,
            'last_name'     => $request->last_name,
            'contact_type'  => $request->contact_type,
            'email'         => $request->email,
            'phone_code'    => $request->phone_code,
            'phone'         => $request->phone,
            'owned_by'      => $request->owned_by ?: $contact->owned_by,
            'role'          => $request->role,
            'profile_image' => $imagePath,
            'address_line1' => $request->address_line1,
            'address_line2' => $request->address_line2,
            'address_line3' => $request->address_line3,
            'country'       => $request->country,
            'state'         => $request->state,
            'postal_code'   => $request->postal_code,
            'company_id'    => $request->company_id ?: null,
            'status'        => $this->mapContactStatus($request->status ?? $contact->status),
        ]);

        Session::flash('success', 'Contact updated successfully.');
        return redirect()->route('crm.contacts.index');
    }

    public function destroy($id)
    {
        $contact = CreateContact::findOrFail($id);

        // Soft-delete: mark status as 0 (Deleted), keep the row in DB
        $contact->status = 0;
        $contact->save();

        Session::flash('success', 'Contact marked as deleted.');
        return redirect()->route('crm.contacts.index');
    }


    /**
     * Map status string to tinyint: active=1, deleted/anything else=0
     */
    private function mapContactStatus($status): int
    {
        return ($status === 'active' || $status === 1 || $status === '1') ? 1 : 0;
    }
}
