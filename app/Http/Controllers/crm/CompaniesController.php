<?php

namespace App\Http\Controllers\crm;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CompanyType;
use App\Models\Role;
use App\Models\State;
use App\Models\Country;
use App\Models\PhoneCode;
use App\Models\User;
use App\Models\Crm\CreateCompany;
use App\Models\Crm\CreateContact;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class CompaniesController extends Controller
{
    public function index(Request $request)
    {
        $companyTypes = CompanyType::active()->orderBy('sort_order', 'asc')->get();
        $roles = Role::active()->orderBy('sort_order', 'asc')->get();
        $states = State::active()->orderBy('sort_order', 'asc')->get();
        $countries = Country::active()->orderBy('sort_order', 'asc')->get();
        $phoneCodes = PhoneCode::active()->orderBy('country_name', 'asc')->get();
        $owners = User::active()->orderBy('name', 'asc')->get();

        // Calculate nextReference dynamically
        $nextId = 1;
        if (Schema::hasTable('tbl_create_company')) {
            $latestRef = DB::table('tbl_create_company')
                ->where('reference', 'like', 'Comp-%')
                ->orderByRaw('CAST(SUBSTRING(reference, 6) AS UNSIGNED) DESC')
                ->value('reference');
            if ($latestRef) {
                $num = intval(substr($latestRef, 5));
                $nextId = ($num - 100) + 1;
            } else {
                $latestCompany = DB::table('tbl_create_company')->latest('idtbl_create_company')->first();
                if ($latestCompany) {
                    $nextId = $latestCompany->idtbl_create_company + 1;
                }
            }
        }
        $nextReference = 'Comp-' . (100 + $nextId);

        // Fetch companies with filters
        $query = CreateCompany::with(['owner', 'contacts']);

        if ($request->filled('company_type') && $request->company_type !== 'all') {
            $query->where('company_type', $request->company_type);
        }

        if ($request->filled('status')) {
            $query->where('status', $this->mapCompanyStatus($request->status));
        }

        if ($request->filled('owner')) {
            $query->where('owner_id', $request->owner);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('reference', 'like', '%' . $search . '%')
                  ->orWhere('email', 'like', '%' . $search . '%')
                  ->orWhere('website', 'like', '%' . $search . '%')
                  ->orWhere('phone', 'like', '%' . $search . '%');
            });
        }

        $perPage = intval($request->input('per_page', 10));
        $companies = $query->latest('idtbl_create_company')->paginate($perPage);

        return view('crm.companies', compact(
            'companyTypes', 
            'nextReference', 
            'roles', 
            'states', 
            'countries', 
            'phoneCodes', 
            'owners', 
            'companies'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
        ]);

        // Recalculate reference to prevent race conditions
        $nextId = 1;
        $latestRef = DB::table('tbl_create_company')
            ->where('reference', 'like', 'Comp-%')
            ->orderByRaw('CAST(SUBSTRING(reference, 6) AS UNSIGNED) DESC')
            ->value('reference');
        if ($latestRef) {
            $num = intval(substr($latestRef, 5));
            $nextId = ($num - 100) + 1;
        } else {
            $latestCompany = DB::table('tbl_create_company')->latest('idtbl_create_company')->first();
            if ($latestCompany) {
                $nextId = $latestCompany->idtbl_create_company + 1;
            }
        }
        $reference = 'Comp-' . (100 + $nextId);

        $imagePath = null;
        if ($request->hasFile('profile_image')) {
            $file = $request->file('profile_image');
            $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/companies'), $fileName);
            $imagePath = 'uploads/companies/' . $fileName;
        }

        $company = CreateCompany::create([
            'name' => $request->name,
            'reference' => $reference,
            'company_type' => $request->company_type,
            'email' => $request->email,
            'phone_code' => $request->phone_code,
            'phone' => $request->phone,
            'profile_image' => $imagePath,
            'website' => $request->website,
            'status' => $this->mapCompanyStatus($request->status ?? 'active'),
            'owner_id' => Session::get('userid'),
            'attention' => $request->attention,
            'address_line1' => $request->address_line1,
            'address_line2' => $request->address_line2,
            'address_line3' => $request->address_line3,
            'country' => $request->country,
            'state' => $request->state,
            'postal_code' => $request->postal_code,
            'use_delivery_address' => $request->has('use_delivery_address') ? 1 : 0,
            'del_attention' => $request->del_attention,
            'del_address_line1' => $request->del_address_line1,
            'del_address_line2' => $request->del_address_line2,
            'del_address_line3' => $request->del_address_line3,
            'del_country' => $request->del_country,
            'del_state' => $request->del_state,
            'del_postal_code' => $request->del_postal_code,
        ]);

        // Save contacts
        $newContactCount = 0;
        if ($request->has('contacts') && is_array($request->contacts)) {
            foreach ($request->contacts as $contactData) {
                if (!empty($contactData['first_name']) || !empty($contactData['last_name']) || !empty($contactData['email'])) {
                    CreateContact::create([
                        'company_id' => $company->idtbl_create_company,
                        'reference' => $this->nextContactReference($newContactCount++),
                        'first_name' => $contactData['first_name'] ?? null,
                        'last_name' => $contactData['last_name'] ?? null,
                        'email' => $contactData['email'] ?? null,
                        'role' => $contactData['role'] ?? null,
                        'is_primary' => isset($contactData['primary']) ? 1 : 0,
                        'status' => 1, // 1 = Active
                    ]);
                }
            }
        }

        Session::flash('success', 'Company created successfully.');

        if ($request->has('add_another')) {
            return redirect()->route('crm.companies.index', ['open_modal' => 1]);
        }

        return redirect()->route('crm.companies.index');
    }

    public function show($id)
    {
        $company = CreateCompany::with('contacts')->findOrFail($id);
        return response()->json($company);
    }

    public function update(Request $request, $id)
    {
        $company = CreateCompany::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
        ]);

        $imagePath = $company->profile_image;
        if ($request->hasFile('profile_image')) {
            // Delete old image
            if ($imagePath && File::exists(public_path($imagePath))) {
                File::delete(public_path($imagePath));
            }
            $file = $request->file('profile_image');
            $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/companies'), $fileName);
            $imagePath = 'uploads/companies/' . $fileName;
        }

        $company->update([
            'name' => $request->name,
            'company_type' => $request->company_type,
            'email' => $request->email,
            'phone_code' => $request->phone_code,
            'phone' => $request->phone,
            'profile_image' => $imagePath,
            'website' => $request->website,
            'status' => $this->mapCompanyStatus($request->status ?? $company->status),
            'attention' => $request->attention,
            'address_line1' => $request->address_line1,
            'address_line2' => $request->address_line2,
            'address_line3' => $request->address_line3,
            'country' => $request->country,
            'state' => $request->state,
            'postal_code' => $request->postal_code,
            'use_delivery_address' => $request->has('use_delivery_address') ? 1 : 0,
            'del_attention' => $request->del_attention,
            'del_address_line1' => $request->del_address_line1,
            'del_address_line2' => $request->del_address_line2,
            'del_address_line3' => $request->del_address_line3,
            'del_country' => $request->del_country,
            'del_state' => $request->del_state,
            'del_postal_code' => $request->del_postal_code,
        ]);

        // Sync contacts: Update existing or create new ones
        $newContactCount = 0;
        if ($request->has('contacts') && is_array($request->contacts)) {
            foreach ($request->contacts as $contactData) {
                if (!empty($contactData['first_name']) || !empty($contactData['last_name']) || !empty($contactData['email'])) {
                    $hasId = !empty($contactData['id']);

                    if ($hasId) {
                        $contact = CreateContact::where('company_id', $company->idtbl_create_company)
                            ->where('idtbl_create_contact', $contactData['id'])
                            ->first();
                        if ($contact) {
                            $contact->update([
                                'first_name' => $contactData['first_name'] ?? null,
                                'last_name' => $contactData['last_name'] ?? null,
                                'email' => $contactData['email'] ?? null,
                                'role' => $contactData['role'] ?? null,
                                'is_primary' => isset($contactData['primary']) ? 1 : 0,
                            ]);
                            continue;
                        }
                    }

                    // Create new contact if no ID matching this company is found
                    CreateContact::create([
                        'company_id' => $company->idtbl_create_company,
                        'reference' => $this->nextContactReference($newContactCount++),
                        'first_name' => $contactData['first_name'] ?? null,
                        'last_name' => $contactData['last_name'] ?? null,
                        'email' => $contactData['email'] ?? null,
                        'role' => $contactData['role'] ?? null,
                        'is_primary' => isset($contactData['primary']) ? 1 : 0,
                        'status' => 1, // 1 = Active
                    ]);
                }
            }
        }

        Session::flash('success', 'Company updated successfully.');
        return redirect()->route('crm.companies.index');
    }

    public function destroy($id)
    {
        $company = CreateCompany::findOrFail($id);

        // Soft-delete: just mark status as 0 (Deleted), keep the row in DB
        $company->status = 0;
        $company->save();

        // Also soft-delete all contacts associated with this company
        $company->contacts()->update(['status' => 0]);

        Session::flash('success', 'Company and all associated contacts marked as deleted.');
        return redirect()->route('crm.companies.index');
    }


    /**
     * Generate the next P-1xx format contact reference.
     */
    private function nextContactReference($offset = 0)
    {
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
        return 'P-' . (100 + $nextId + $offset);
    }
    /**
     * Map status string to tinyint: active=1, deleted/anything else=0
     */
    private function mapCompanyStatus($status): int
    {
        return ($status === 'active' || $status === 1 || $status === '1') ? 1 : 0;
    }
}
