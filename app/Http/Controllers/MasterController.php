<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use App\Models\Color;
use App\Models\ColorCategory;
use App\Models\Variety;
use App\Models\SubCategory;
use App\Models\ProductType;
use App\Models\Shape;
use App\Models\Grade;
use App\Models\GradeType;
use App\Models\Origin;
use App\Models\Treatment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class MasterController extends Controller
{
    public function product_type()
    {
        if (!Session::get('loggedin')) return redirect('/');
        $menuaccess = (new \App\Models\Commeninfo())->Getmenuprivilege();
        $product_types = ProductType::orderBy('type_name')->get();
        return view('master.product_type', compact('menuaccess', 'product_types'));
    }

    public function variety()
    {
        if (!Session::get('loggedin')) return redirect('/');
        $menuaccess = (new \App\Models\Commeninfo())->Getmenuprivilege();
        $varieties = Variety::orderBy('display_order')->get();
        return view('master.variety', compact('menuaccess', 'varieties'));
    }

    public function subcategory()
    {
        if (!Session::get('loggedin')) return redirect('/');
        $menuaccess = (new \App\Models\Commeninfo())->Getmenuprivilege();
        $varieties = Variety::where('status', 1)->orderBy('variety_name')->get();
        $subcategories = SubCategory::with('variety')->orderBy('display_order')->get();
        return view('master.subcategory', compact('menuaccess', 'varieties', 'subcategories'));
    }

    public function color()
    {
        if (!Session::get('loggedin')) return redirect('/');
        $menuaccess = (new \App\Models\Commeninfo())->Getmenuprivilege();
        $colors = Color::orderBy('display_order')->get();
        $categories = ColorCategory::where('status', 1)->orderBy('category_name')->get();
        return view('master.color', compact('colors', 'categories', 'menuaccess'));
    }

    public function color_category()
    {
        if (!Session::get('loggedin')) return redirect('/');
        $menuaccess = (new \App\Models\Commeninfo())->Getmenuprivilege();
        $categories = ColorCategory::orderBy('display_order')->get();
        return view('master.color_category', compact('categories', 'menuaccess'));
    }

    public function shape_cut()
    {
        if (!Session::get('loggedin')) return redirect('/');
        $menuaccess = (new \App\Models\Commeninfo())->Getmenuprivilege();
        $shapes = Shape::orderBy('type')->orderBy('name')->get();
        return view('master.shape_cut', compact('menuaccess', 'shapes'));
    }

    public function gradetype()
    {
        if (!Session::get('loggedin')) return redirect('/');
        $menuaccess = (new \App\Models\Commeninfo())->Getmenuprivilege();
        $gradeTypes = GradeType::orderBy('type_name')->get();
        return view('master.grade_type', compact('menuaccess', 'gradeTypes'));
    }

    public function gradetypeinsertupdate(Request $request)
    {
        $orgId = Session::get('company_id') ?: 1;

        $data = $request->validate([
            'recordOption' => 'required|in:1,2',
            'recordID' => 'nullable|integer',
            'type_name' => 'required|string|max:100',
            'description' => 'nullable|string',
        ]);

        $normalizedName = trim($data['type_name']);

        if ($data['recordOption'] == 1) {
            $exists = GradeType::where('org_id', (int) $orgId)
                ->whereRaw('LOWER(type_name) = ?', [strtolower($normalizedName)])
                ->exists();

            if ($exists) {
                Session::flash('msg', json_encode($this->makeActionResponse(false, 'Grade Type already exists.', 'warning')));
                return back()->withInput();
            }

            GradeType::create([
                'org_id' => (int) $orgId,
                'type_name' => $normalizedName,
                'description' => $data['description'] ?? null,
                'created_by' => Session::get('userid'),
            ]);

            Session::flash('msg', json_encode($this->makeActionResponse(true, 'Record Added Successfully', 'success')));
            return redirect('Master/GradeType');
        }

        $gradeType = GradeType::find($data['recordID']);
        if (!$gradeType) {
            Session::flash('msg', json_encode($this->makeActionResponse(false, 'Record not found', 'danger')));
            return redirect('Master/GradeType');
        }

        $exists = GradeType::where('idtbl_grade_types', '!=', $data['recordID'])
            ->where('org_id', (int) $orgId)
            ->whereRaw('LOWER(type_name) = ?', [strtolower($normalizedName)])
            ->exists();

        if ($exists) {
            Session::flash('msg', json_encode($this->makeActionResponse(false, 'Grade Type already exists.', 'warning')));
            return back()->withInput();
        }

        $gradeType->update([
            'type_name' => $normalizedName,
            'description' => $data['description'] ?? null,
        ]);

        Session::flash('msg', json_encode($this->makeActionResponse(true, 'Record Updated Successfully', 'primary')));
        return redirect('Master/GradeType');
    }

    public function gradetypeedit(Request $request)
    {
        $data = $request->validate([
            'recordID' => 'required|integer',
        ]);

        $gradeType = GradeType::find($data['recordID']);
        if (!$gradeType) {
            return response()->json(['error' => 'Record not found'], 404);
        }

        return response()->json($gradeType);
    }

    public function gradetypedelete(Request $request)
    {
        $data = $request->validate([
            'recordID' => 'required|integer',
        ]);

        $gradeType = GradeType::find($data['recordID']);
        if (!$gradeType) {
            Session::flash('msg', json_encode($this->makeActionResponse(false, 'Record not found', 'danger')));
            return back();
        }

        $gradeType->delete();
        Session::flash('msg', json_encode($this->makeActionResponse(true, 'Record Deleted Successfully', 'success')));
        return back();
    }

    public function grade()
    {
        if (!Session::get('loggedin')) return redirect('/');
        $menuaccess = (new \App\Models\Commeninfo())->Getmenuprivilege();
        $grades = Grade::with('gradeType')->orderBy('grade_type_id')->orderBy('grade_value')->get();
        $gradeTypes = GradeType::where('org_id', Session::get('company_id') ?: 1)->orderBy('type_name')->get();
        return view('master.grade', compact('menuaccess', 'grades', 'gradeTypes'));
    }

    public function gradeinsertupdate(Request $request)
    {
        $orgId = Session::get('company_id') ?: 1;

        $data = $request->validate([
            'recordOption' => 'required|in:1,2',
            'recordID' => 'nullable|integer',
            'grade_type_id' => 'required|integer|exists:tbl_grade_types,idtbl_grade_types',
            'grade_value' => 'required|string|max:100',
        ]);

        $normalizedValue = trim($data['grade_value']);

        if ($data['recordOption'] == 1) {
            $exists = Grade::where('org_id', (int) $orgId)
                ->where('grade_type_id', (int) $data['grade_type_id'])
                ->whereRaw('LOWER(grade_value) = ?', [strtolower($normalizedValue)])
                ->exists();

            if ($exists) {
                Session::flash('msg', json_encode($this->makeActionResponse(false, 'This grade already exists.', 'warning')));
                return back()->withInput();
            }

            Grade::create([
                'org_id' => (int) $orgId,
                'grade_type_id' => (int) $data['grade_type_id'],
                'grade_value' => $normalizedValue,
                'created_by' => Session::get('userid'),
            ]);

            Session::flash('msg', json_encode($this->makeActionResponse(true, 'Record Added Successfully', 'success')));
            return redirect('Master/Grade');
        }

        $grade = Grade::find($data['recordID']);
        if (!$grade) {
            Session::flash('msg', json_encode($this->makeActionResponse(false, 'Record not found', 'danger')));
            return redirect('Master/Grade');
        }

        $exists = Grade::where('idtbl_grades', '!=', $data['recordID'])
            ->where('org_id', (int) $orgId)
            ->where('grade_type_id', (int) $data['grade_type_id'])
            ->whereRaw('LOWER(grade_value) = ?', [strtolower($normalizedValue)])
            ->exists();

        if ($exists) {
            Session::flash('msg', json_encode($this->makeActionResponse(false, 'This grade already exists.', 'warning')));
            return back()->withInput();
        }

        $grade->update([
            'grade_type_id' => (int) $data['grade_type_id'],
            'grade_value' => $normalizedValue,
        ]);

        Session::flash('msg', json_encode($this->makeActionResponse(true, 'Record Updated Successfully', 'primary')));
        return redirect('Master/Grade');
    }

    public function gradeedit(Request $request)
    {
        $data = $request->validate([
            'recordID' => 'required|integer',
        ]);

        $grade = Grade::find($data['recordID']);
        if (!$grade) {
            return response()->json(['error' => 'Record not found'], 404);
        }

        return response()->json($grade);
    }

    public function gradedelete(Request $request)
    {
        $data = $request->validate([
            'recordID' => 'required|integer',
        ]);

        $grade = Grade::find($data['recordID']);
        if (!$grade) {
            Session::flash('msg', json_encode($this->makeActionResponse(false, 'Record not found', 'danger')));
            return back();
        }

        $grade->delete();
        Session::flash('msg', json_encode($this->makeActionResponse(true, 'Record Deleted Successfully', 'success')));
        return back();
    }

    public function origin_treatment()
    {
        if (!Session::get('loggedin')) return redirect('/');
        $menuaccess = (new \App\Models\Commeninfo())->Getmenuprivilege();
        $origins = Origin::orderBy('origin_name')->get();
        $treatments = Treatment::orderBy('treatment_name')->get();
        return view('master.origin_treatment', compact('menuaccess', 'origins', 'treatments'));
    }

    public function origininsertupdate(Request $request)
    {
        $orgId = Session::get('company_id') ?: 1;

        $data = $request->validate([
            'recordOption' => 'required|in:1,2',
            'recordID' => 'nullable|integer',
            'origin_name' => 'required|string|max:100',
        ]);

        $normalizedName = trim($data['origin_name']);

        if ($data['recordOption'] == 1) {
            $exists = Origin::where('org_id', (int) $orgId)
                ->whereRaw('LOWER(origin_name) = ?', [strtolower($normalizedName)])
                ->exists();

            if ($exists) {
                Session::flash('msg', json_encode($this->makeActionResponse(false, 'Origin already exists.', 'warning')));
                return back()->withInput();
            }

            Origin::create([
                'org_id' => (int) $orgId,
                'origin_name' => $normalizedName,
                'created_by' => Session::get('userid'),
            ]);

            Session::flash('msg', json_encode($this->makeActionResponse(true, 'Origin Added Successfully', 'success')));
            return back();
        }

        $origin = Origin::find($data['recordID']);
        if (!$origin) {
            Session::flash('msg', json_encode($this->makeActionResponse(false, 'Record not found', 'danger')));
            return back();
        }

        $exists = Origin::where('idtbl_origins', '!=', $data['recordID'])
            ->where('org_id', (int) $orgId)
            ->whereRaw('LOWER(origin_name) = ?', [strtolower($normalizedName)])
            ->exists();

        if ($exists) {
            Session::flash('msg', json_encode($this->makeActionResponse(false, 'Origin already exists.', 'warning')));
            return back()->withInput();
        }

        $origin->update([
            'origin_name' => $normalizedName,
        ]);

        Session::flash('msg', json_encode($this->makeActionResponse(true, 'Origin Updated Successfully', 'primary')));
        return back();
    }

    public function originedit(Request $request)
    {
        $data = $request->validate([
            'recordID' => 'required|integer',
        ]);

        $origin = Origin::find($data['recordID']);
        if (!$origin) {
            return response()->json(['error' => 'Record not found'], 404);
        }

        return response()->json($origin);
    }

    public function origindelete(Request $request)
    {
        $data = $request->validate([
            'recordID' => 'required|integer',
        ]);

        $origin = Origin::find($data['recordID']);
        if (!$origin) {
            Session::flash('msg', json_encode($this->makeActionResponse(false, 'Record not found', 'danger')));
            return back();
        }

        $origin->delete();
        Session::flash('msg', json_encode($this->makeActionResponse(true, 'Origin Deleted Successfully', 'success')));
        return back();
    }

    public function treatmentinsertupdate(Request $request)
    {
        $orgId = Session::get('company_id') ?: 1;

        $data = $request->validate([
            'recordOption' => 'required|in:1,2',
            'recordID' => 'nullable|integer',
            'treatment_name' => 'required|string|max:100',
        ]);

        $normalizedName = trim($data['treatment_name']);

        if ($data['recordOption'] == 1) {
            $exists = Treatment::where('org_id', (int) $orgId)
                ->whereRaw('LOWER(treatment_name) = ?', [strtolower($normalizedName)])
                ->exists();

            if ($exists) {
                Session::flash('msg', json_encode($this->makeActionResponse(false, 'Treatment already exists.', 'warning')));
                return back()->withInput();
            }

            Treatment::create([
                'org_id' => (int) $orgId,
                'treatment_name' => $normalizedName,
                'created_by' => Session::get('userid'),
            ]);

            Session::flash('msg', json_encode($this->makeActionResponse(true, 'Treatment Added Successfully', 'success')));
            return back();
        }

        $treatment = Treatment::find($data['recordID']);
        if (!$treatment) {
            Session::flash('msg', json_encode($this->makeActionResponse(false, 'Record not found', 'danger')));
            return back();
        }

        $exists = Treatment::where('idtbl_treatments', '!=', $data['recordID'])
            ->where('org_id', (int) $orgId)
            ->whereRaw('LOWER(treatment_name) = ?', [strtolower($normalizedName)])
            ->exists();

        if ($exists) {
            Session::flash('msg', json_encode($this->makeActionResponse(false, 'Treatment already exists.', 'warning')));
            return back()->withInput();
        }

        $treatment->update([
            'treatment_name' => $normalizedName,
        ]);

        Session::flash('msg', json_encode($this->makeActionResponse(true, 'Treatment Updated Successfully', 'primary')));
        return back();
    }

    public function treatmentedit(Request $request)
    {
        $data = $request->validate([
            'recordID' => 'required|integer',
        ]);

        $treatment = Treatment::find($data['recordID']);
        if (!$treatment) {
            return response()->json(['error' => 'Record not found'], 404);
        }

        return response()->json($treatment);
    }

    public function treatmentdelete(Request $request)
    {
        $data = $request->validate([
            'recordID' => 'required|integer',
        ]);

        $treatment = Treatment::find($data['recordID']);
        if (!$treatment) {
            Session::flash('msg', json_encode($this->makeActionResponse(false, 'Record not found', 'danger')));
            return back();
        }

        $treatment->delete();
        Session::flash('msg', json_encode($this->makeActionResponse(true, 'Treatment Deleted Successfully', 'success')));
        return back();
    }

    // Storage Location CRUD
    public function storage_location()
    {
        if (!Session::get('loggedin')) return redirect('/');
        $menuaccess = (new \App\Models\Commeninfo())->Getmenuprivilege();
        $locations = \App\Models\StorageLocation::orderBy('location_name')->get();
        $branches = \App\Models\CompanyBranch::where('status', 1)->orderBy('branch')->get();
        return view('master.storage_location', compact('menuaccess', 'locations', 'branches'));
    }

    // Insert/Update method for Storage Location
    public function storagelocationinsertupdate(Request $request)
    {
        $orgId = Session::get('company_id') ?: 1;

        $data = $request->validate([
            'recordOption' => 'required|in:1,2',
            'recordID' => 'nullable|integer',
            'location_name' => 'required|string|max:255',
            'short_code' => 'required|string|max:50',
            'branch_id' => 'required|integer',
            'contact_person' => 'nullable|string|max:255',
        ]);

        $normalizedName = trim($data['location_name']);
        $normalizedCode = trim($data['short_code']);

        // Insert new record
        if ($data['recordOption'] == 1) {
            // Check for duplicate location name
            $exists = \App\Models\StorageLocation::where('org_id', (int) $orgId)
                ->where('branch_id', (int) $data['branch_id'])
                ->whereRaw('LOWER(location_name) = ?', [strtolower($normalizedName)])
                ->exists();

            if ($exists) {
                Session::flash('msg', json_encode($this->makeActionResponse(false, 'This location already exists in this branch.', 'warning')));
                return back()->withInput();
            }

            \App\Models\StorageLocation::create([
                'org_id' => (int) $orgId,
                'location_name' => $normalizedName,
                'short_code' => $normalizedCode,
                'branch_id' => (int) $data['branch_id'],
                'contact_person' => $data['contact_person'] ?? null,
            ]);

            Session::flash('msg', json_encode($this->makeActionResponse(true, 'Storage Location Added Successfully', 'success')));
            return redirect('Master/StorageLocation');
        }

        // Update existing record
        $location = \App\Models\StorageLocation::find($data['recordID']);
        if (!$location) {
            Session::flash('msg', json_encode($this->makeActionResponse(false, 'Record not found', 'danger')));
            return redirect('Master/StorageLocation');
        }

        // Check for duplicate (excluding current record)
        $exists = \App\Models\StorageLocation::where('id', '!=', $data['recordID'])
            ->where('org_id', (int) $orgId)
            ->where('branch_id', (int) $data['branch_id'])
            ->whereRaw('LOWER(location_name) = ?', [strtolower($normalizedName)])
            ->exists();

        if ($exists) {
            Session::flash('msg', json_encode($this->makeActionResponse(false, 'This location already exists in this branch.', 'warning')));
            return back()->withInput();
        }

        $location->update([
            'location_name' => $normalizedName,
            'short_code' => $normalizedCode,
            'branch_id' => (int) $data['branch_id'],
            'contact_person' => $data['contact_person'] ?? null,
        ]);

        Session::flash('msg', json_encode($this->makeActionResponse(true, 'Storage Location Updated Successfully', 'primary')));
        return redirect('Master/StorageLocation');
    }

// New edit method for Storage Location – returns JSON
public function storagelocationedit(Request $request)
{
    $data = $request->validate([
        'recordID' => 'required|integer',
    ]);
    $location = \App\Models\StorageLocation::find($data['recordID']);
    if (!$location) {
        return response()->json(['error' => 'Record not found'], 404);
    }
    return response()->json($location);
}

// New delete method for Storage Location – deletes and redirects back
public function storagelocationdelete(Request $request)
{
    $data = $request->validate([
        'recordID' => 'required|integer',
    ]);
    $location = \App\Models\StorageLocation::find($data['recordID']);
    if ($location) {
        $location->delete();
        Session::flash('msg', json_encode($this->makeActionResponse(true, 'Location Deleted Successfully', 'success')));
    } else {
        Session::flash('msg', json_encode($this->makeActionResponse(false, 'Record not found', 'danger')));
    }
    return back();
}

    public function suppliers()
    {
        if (!Session::get('loggedin')) return redirect('/');
        $menuaccess = (new \App\Models\Commeninfo())->Getmenuprivilege();
        $suppliers = Supplier::orderBy('name')->get();

        return view('master.suppliers', compact('suppliers', 'menuaccess'));
    }

    public function suppliersinsertupdate(Request $request)
    {
        $orgId = Session::get('company_id');

        $data = $request->validate([
            'recordOption' => 'required|in:1,2',
            'recordID' => 'nullable|integer',
            'org_id' => 'required|integer|min:1',
            'name' => 'required|string|max:255',
            'contact_name' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:191',
            'phone' => 'nullable|string|max:50',
            'address' => 'nullable|string',
            'country' => 'nullable|string|max:100',
            'currency' => 'required|string|max:10',
            'status' => 'required|string|max:50',
        ]);

        if (!empty($orgId) && (int) $data['org_id'] !== (int) $orgId) {
            Session::flash('msg', json_encode($this->makeActionResponse(false, 'Organization mismatch detected.', 'warning')));
            return back()->withInput();
        }

        $normalizedName = trim($data['name']);

        if ($data['recordOption'] == 1) {
            $exists = Supplier::where('org_id', (int) $data['org_id'])
                ->whereRaw('LOWER(name) = ?', [strtolower($normalizedName)])
                ->exists();

            if ($exists) {
                Session::flash('msg', json_encode($this->makeActionResponse(false, 'Supplier already exists for this organization.', 'warning')));
                return back()->withInput();
            }

            Supplier::create([
                'org_id' => (int) $data['org_id'],
                'name' => $normalizedName,
                'contact_name' => $data['contact_name'] ?? null,
                'email' => $data['email'] ?? null,
                'phone' => $data['phone'] ?? null,
                'address' => $data['address'] ?? null,
                'country' => $data['country'] ?? null,
                'currency' => $data['currency'],
                'status' => $data['status'],
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
            'name' => $normalizedName,
            'contact_name' => $data['contact_name'] ?? null,
            'email' => $data['email'] ?? null,
            'phone' => $data['phone'] ?? null,
            'address' => $data['address'] ?? null,
            'country' => $data['country'] ?? null,
            'currency' => $data['currency'],
            'status' => $data['status'],
        ]);

        Session::flash('msg', json_encode($this->makeActionResponse(true, 'Record Updated Successfully', 'primary')));

        return redirect('Master/Suppliers');
    }

    public function colorinsertupdate(Request $request)
    {
        $orgId = Session::get('company_id') ?: 1;

        $data = $request->validate([
            'recordOption' => 'required|in:1,2',
            'recordID' => 'nullable|integer',
            'color_name' => 'required|string|max:50',
            'hex_code' => 'nullable|string|max:7',
            'color_category' => 'required|integer', // This comes from the view as category id
        ]);

        $normalizedName = trim($data['color_name']);

        if ($data['recordOption'] == 1) {
            $exists = Color::where('org_id', (int) $orgId)
                ->whereRaw('LOWER(color_name) = ?', [strtolower($normalizedName)])
                ->exists();

            if ($exists) {
                Session::flash('msg', json_encode($this->makeActionResponse(false, 'Color already exists.', 'warning')));
                return back()->withInput();
            }

            Color::create([
                'org_id' => (int) $orgId,
                'color_name' => $normalizedName,
                'hex_code' => $data['hex_code'],
                'created_by' => Session::get('userid'),
                // 'color_category' logic could be implemented if it's supposed to map to tbl_colors, 
                // wait, the table tbl_colors doesn't have a category_id based on the user's script. 
                // Let's re-verify the tbl_colors schema.
            ]);

            Session::flash('msg', json_encode($this->makeActionResponse(true, 'Record Added Successfully', 'success')));
            return redirect('Master/Color');
        }

        $color = Color::find($data['recordID']);
        if (!$color) {
            Session::flash('msg', json_encode($this->makeActionResponse(false, 'Record not found', 'danger')));
            return redirect('Master/Color');
        }

        $color->update([
            'color_name' => $normalizedName,
            'hex_code' => $data['hex_code'],
        ]);

        Session::flash('msg', json_encode($this->makeActionResponse(true, 'Record Updated Successfully', 'primary')));
        return redirect('Master/Color');
    }

    public function colorcategoryinsertupdate(Request $request)
    {
        $orgId = Session::get('company_id') ?: 1;

        $data = $request->validate([
            'recordOption' => 'required|in:1,2',
            'recordID' => 'nullable|integer',
            'category_name' => 'required|string|max:50',
        ]);

        $normalizedName = trim($data['category_name']);

        if ($data['recordOption'] == 1) {
            $exists = ColorCategory::where('org_id', (int) $orgId)
                ->whereRaw('LOWER(category_name) = ?', [strtolower($normalizedName)])
                ->exists();

            if ($exists) {
                Session::flash('msg', json_encode($this->makeActionResponse(false, 'Category already exists.', 'warning')));
                return back()->withInput();
            }

            ColorCategory::create([
                'org_id' => (int) $orgId,
                'category_name' => $normalizedName,
                'created_by' => Session::get('userid'),
            ]);

            Session::flash('msg', json_encode($this->makeActionResponse(true, 'Record Added Successfully', 'success')));
            return redirect('Master/ColorCategory');
        }

        $category = ColorCategory::find($data['recordID']);
        if (!$category) {
            Session::flash('msg', json_encode($this->makeActionResponse(false, 'Record not found', 'danger')));
            return redirect('Master/ColorCategory');
        }

        $category->update([
            'category_name' => $normalizedName,
        ]);

        Session::flash('msg', json_encode($this->makeActionResponse(true, 'Record Updated Successfully', 'primary')));
        return redirect('Master/ColorCategory');
    }

    public function varietyinsertupdate(Request $request)
    {
        $orgId = Session::get('company_id') ?: 1;

        $data = $request->validate([
            'recordOption' => 'required|in:1,2',
            'recordID' => 'nullable|integer',
            'variety_name' => 'required|string|max:100',
            'category' => 'required|integer', // gem_type_id
        ]);

        $normalizedName = trim($data['variety_name']);

        if ($data['recordOption'] == 1) {
            $exists = Variety::where('org_id', (int) $orgId)
                ->whereRaw('LOWER(variety_name) = ?', [strtolower($normalizedName)])
                ->exists();

            if ($exists) {
                Session::flash('msg', json_encode($this->makeActionResponse(false, 'Variety already exists.', 'warning')));
                return back()->withInput();
            }

            Variety::create([
                'org_id' => (int) $orgId,
                'variety_name' => $normalizedName,
                'gem_type_id' => $data['category'],
                'created_by' => Session::get('userid'),
            ]);

            Session::flash('msg', json_encode($this->makeActionResponse(true, 'Record Added Successfully', 'success')));
            return redirect('Master/Variety');
        }

        $variety = Variety::find($data['recordID']);
        if (!$variety) {
            Session::flash('msg', json_encode($this->makeActionResponse(false, 'Record not found', 'danger')));
            return redirect('Master/Variety');
        }

        $variety->update([
            'variety_name' => $normalizedName,
            'gem_type_id' => $data['category'],
        ]);

        Session::flash('msg', json_encode($this->makeActionResponse(true, 'Record Updated Successfully', 'primary')));
        return redirect('Master/Variety');
    }

    public function subcategoryinsertupdate(Request $request)
    {
        $orgId = Session::get('company_id') ?: 1;

        $data = $request->validate([
            'recordOption' => 'required|in:1,2',
            'recordID' => 'nullable|integer',
            'subcategory_name' => 'required|string|max:100',
            'variety_id' => 'required|integer|exists:tbl_varieties,idtbl_varieties',
        ]);

        $normalizedName = trim($data['subcategory_name']);

        if ($data['recordOption'] == 1) {
            $exists = SubCategory::where('org_id', (int) $orgId)
                ->where('variety_id', $data['variety_id'])
                ->whereRaw('LOWER(subcategory_name) = ?', [strtolower($normalizedName)])
                ->exists();

            if ($exists) {
                Session::flash('msg', json_encode($this->makeActionResponse(false, 'Sub-Category already exists under this Variety.', 'warning')));
                return back()->withInput();
            }

            SubCategory::create([
                'org_id' => (int) $orgId,
                'variety_id' => $data['variety_id'],
                'subcategory_name' => $normalizedName,
                'created_by' => Session::get('userid'),
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
            'subcategory_name' => $normalizedName,
            'variety_id' => $data['variety_id'],
        ]);

        Session::flash('msg', json_encode($this->makeActionResponse(true, 'Record Updated Successfully', 'primary')));
        return redirect('Master/Subcategory');
    }

    public function producttypeinsertupdate(Request $request)
    {
        $data = $request->validate([
            'recordOption' => 'required|in:1,2',
            'recordID' => 'nullable|integer',
            'type_name' => 'required|string|max:100',
            'prefix' => 'required|string|max:10',
        ]);

        $normalizedName = trim($data['type_name']);
        $normalizedPrefix = trim($data['prefix']);

        if ($data['recordOption'] == 1) {
            $exists = ProductType::whereRaw('LOWER(type_name) = ?', [strtolower($normalizedName)])
                ->orWhereRaw('LOWER(prefix) = ?', [strtolower($normalizedPrefix)])
                ->exists();

            if ($exists) {
                Session::flash('msg', json_encode($this->makeActionResponse(false, 'Product Type name or prefix already exists.', 'warning')));
                return back()->withInput();
            }

            ProductType::create([
                'type_name' => $normalizedName,
                'prefix' => $normalizedPrefix,
            ]);

            Session::flash('msg', json_encode($this->makeActionResponse(true, 'Record Added Successfully', 'success')));
            return redirect('Master/ProductType');
        }

        $productType = ProductType::find($data['recordID']);
        if (!$productType) {
            Session::flash('msg', json_encode($this->makeActionResponse(false, 'Record not found', 'danger')));
            return redirect('Master/ProductType');
        }

        $exists = ProductType::where('id', '!=', $data['recordID'])
            ->where(function ($query) use ($normalizedName, $normalizedPrefix) {
                $query->whereRaw('LOWER(type_name) = ?', [strtolower($normalizedName)])
                      ->orWhereRaw('LOWER(prefix) = ?', [strtolower($normalizedPrefix)]);
            })
            ->exists();

        if ($exists) {
            Session::flash('msg', json_encode($this->makeActionResponse(false, 'Product Type name or prefix already exists.', 'warning')));
            return back()->withInput();
        }

        $productType->update([
            'type_name' => $normalizedName,
            'prefix' => $normalizedPrefix,
        ]);

        Session::flash('msg', json_encode($this->makeActionResponse(true, 'Record Updated Successfully', 'primary')));
        return redirect('Master/ProductType');
    }

    public function productypedelete(Request $request)
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

    public function shapecutinsertupdate(Request $request)
    {
        $orgId = Session::get('company_id') ?: 1;

        $data = $request->validate([
            'recordOption' => 'required|in:1,2',
            'recordID' => 'nullable|integer',
            'type' => 'required|in:Shape,Cutting',
            'name' => 'required|string|max:100',
        ]);

        $normalizedName = trim($data['name']);

        if ($data['recordOption'] == 1) {
            $exists = \App\Models\Shape::where('org_id', (int) $orgId)
                ->where('type', $data['type'])
                ->whereRaw('LOWER(name) = ?', [strtolower($normalizedName)])
                ->exists();

            if ($exists) {
                Session::flash('msg', json_encode($this->makeActionResponse(false, 'This ' . strtolower($data['type']) . ' already exists.', 'warning')));
                return back()->withInput();
            }

            \App\Models\Shape::create([
                'org_id' => (int) $orgId,
                'type' => $data['type'],
                'name' => $normalizedName,
                'created_by' => Session::get('userid'),
            ]);

            Session::flash('msg', json_encode($this->makeActionResponse(true, 'Record Added Successfully', 'success')));
            return redirect('Master/ShapeCut');
        }

        $shape = \App\Models\Shape::find($data['recordID']);
        if (!$shape) {
            Session::flash('msg', json_encode($this->makeActionResponse(false, 'Record not found', 'danger')));
            return redirect('Master/ShapeCut');
        }

        $exists = \App\Models\Shape::where('idtbl_shapes', '!=', $data['recordID'])
            ->where('org_id', (int) $orgId)
            ->where('type', $data['type'])
            ->whereRaw('LOWER(name) = ?', [strtolower($normalizedName)])
            ->exists();

        if ($exists) {
            Session::flash('msg', json_encode($this->makeActionResponse(false, 'This ' . strtolower($data['type']) . ' already exists.', 'warning')));
            return back()->withInput();
        }

        $shape->update([
            'type' => $data['type'],
            'name' => $normalizedName,
        ]);

        Session::flash('msg', json_encode($this->makeActionResponse(true, 'Record Updated Successfully', 'primary')));
        return redirect('Master/ShapeCut');
    }

    public function shapecutedit(Request $request)
    {
        $data = $request->validate([
            'recordID' => 'required|integer',
        ]);

        $shape = \App\Models\Shape::find($data['recordID']);
        if (!$shape) {
            return response()->json(['error' => 'Record not found'], 404);
        }

        return response()->json($shape);
    }

    public function shapecutdelete(Request $request)
    {
        $data = $request->validate([
            'recordID' => 'required|integer',
        ]);

        $shape = \App\Models\Shape::find($data['recordID']);
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

