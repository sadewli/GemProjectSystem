<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
<<<<<<< HEAD
<<<<<<< Updated upstream
=======
=======
>>>>>>> d2c05ed855d9a42e15dcf1f216f9b3838959b3d1
use Illuminate\Support\Facades\Session;
use App\Models\ProductType;
use App\Models\SubCategory;
use App\Models\Variety;
use App\Models\Color;
use App\Models\ColorGrade;
use App\Models\Shape;
use App\Models\Cut;
use App\Models\Treatment;
use App\Models\Origin;
use App\Models\CuttingGrade;
use App\Models\ClarityGrade;
use App\Models\StorageLocation;
use App\Models\TrayBox;
use App\Models\Supplier;
use App\Models\Sku;
use App\Models\WeightUnit;
use App\Models\OwnershipType;
<<<<<<< HEAD
>>>>>>> Stashed changes
=======
>>>>>>> d2c05ed855d9a42e15dcf1f216f9b3838959b3d1

class InventoryController extends Controller
{
    // ─── MyInventory index ────────────────────────────────────────────────────
    public function myinventory()
    {
<<<<<<< HEAD
<<<<<<< Updated upstream
        return view('inventory.myinventory.myinventory');
=======
        $productTypes = ProductType::where('status', 1)->orderBy('name')->get();
        return view('inventory.myinventory.myinventory', compact('productTypes'));
>>>>>>> Stashed changes
=======
        $productTypes = ProductType::where('status', 1)->orderBy('name')->get();
        return view('inventory.myinventory.myinventory', compact('productTypes'));
>>>>>>> d2c05ed855d9a42e15dcf1f216f9b3838959b3d1
    }

    // ─── STEP 1 : Show product-type selection screen ─────────────────────────
    public function selectProductType()
    {
        if (!Session::get('loggedin')) return redirect('/');

        $productTypes = ProductType::where('status', 1)->orderBy('name')->get();

        return view('inventory.myinventory.select_product_type', compact('productTypes'));
    }

    // ─── STEP 2 : Store chosen product type in session, redirect to create ───
    public function storeProductTypeSession(Request $request)
    {
        if (!Session::get('loggedin')) return redirect('/');

        $request->validate([
            'product_type_id' => 'required|integer|exists:tbl_product_types,idtbl_product_types',
        ]);

        $productType = ProductType::with('sku')->findOrFail($request->product_type_id);

        session([
            'selected_product_type_id' => $productType->idtbl_product_types,
            'selected_sku_id'          => $productType->idtbl_skus,
            'selected_sku_name'        => $productType->skuname,
            'selected_product_name'    => $productType->name,
        ]);

        return redirect()->route('inventory.myinventory.create');
    }

    // ─── STEP 3 : Create product form with filtered dropdowns ────────────────
    public function create()
    {
        if (!Session::get('loggedin')) return redirect('/');

        $productTypeId = session('selected_product_type_id');

        if (!$productTypeId) {
            return redirect()->route('inventory.myinventory.select_type')
                ->with('error', 'Please select a product type first.');
        }

        // Filtered by selected product type
        $varieties      = Variety::where('status', 1)->where('idtbl_product_types', $productTypeId)->orderBy('name')->get();
        $subCategories  = SubCategory::where('status', 1)->where('idtbl_product_types', $productTypeId)->orderBy('sub_category_name')->get();
        $colors         = Color::where('status', 1)->where('idtbl_product_types', $productTypeId)->orderBy('color_name')->get();
        $colorGrades    = ColorGrade::where('status', 1)->where('idtbl_product_types', $productTypeId)->orderBy('grade_name')->get();
        $shapes         = Shape::where('status', 1)->where('idtbl_product_types', $productTypeId)->orderBy('name')->get();
        $cuts           = Cut::where('status', 1)->where('idtbl_product_types', $productTypeId)->orderBy('name')->get();
        $treatments     = Treatment::where('status', 1)->where('idtbl_product_types', $productTypeId)->orderBy('treatment_name')->get();
        $origins        = Origin::where('status', 1)->where('idtbl_product_types', $productTypeId)->orderBy('origin_name')->get();
        $cuttingGrades  = CuttingGrade::where('status', 1)->where('idtbl_product_types', $productTypeId)->orderBy('cuttinggradename')->get();
        $clarityGrades  = ClarityGrade::where('status', 1)->where('idtbl_product_types', $productTypeId)->orderBy('clarity_grade_name')->get();

        // Unfiltered (global)
        $storageLocations = StorageLocation::where('status', 1)->orderBy('location_name')->get();
        $trayBoxes        = TrayBox::where('status', 1)->orderBy('tray_box_number')->get();
        $suppliers        = Supplier::where('status', 1)->orderBy('supplier_name')->get();
        $weightUnits      = WeightUnit::where('status', 1)->orderBy('unit_name')->get();
        $ownershipTypes   = OwnershipType::where('status', 1)->orderBy('ownership_type_name')->get();

        return view('inventory.myinventory.create', compact(
            'varieties', 'subCategories', 'colors', 'colorGrades',
            'shapes', 'cuts', 'treatments', 'origins', 'cuttingGrades', 'clarityGrades',
            'storageLocations', 'trayBoxes', 'suppliers', 'weightUnits', 'ownershipTypes'
        ));
    }

    // ─── Existing: show (full-page) ──────────────────────────────────────────
    public function show($id = null)
    {
<<<<<<< HEAD
<<<<<<< Updated upstream
        return view('inventory.myinventory.fullpage.fullpage.show');
=======
=======
>>>>>>> d2c05ed855d9a42e15dcf1f216f9b3838959b3d1
        $productTypes  = ProductType::where('status', 1)->get();
        $subCategories = SubCategory::where('status', 1)->get();
        $varieties     = Variety::where('status', 1)->get();
        $colors        = Color::where('status', 1)->get();
        $shapes        = Shape::where('status', 1)->get();
        $cuts          = Cut::where('status', 1)->get();
        $treatments    = Treatment::where('status', 1)->get();
        $origins       = Origin::where('status', 1)->get();
        $colorGrades   = ColorGrade::where('status', 1)->get();
        $cutGrades     = CuttingGrade::where('status', 1)->get();
        $clarityGrades = ClarityGrade::where('status', 1)->get();
        $storageLocations = StorageLocation::where('status', 1)->get();
        $trayBoxes     = TrayBox::where('status', 1)->get();
        $suppliers     = Supplier::where('status', 1)->get();
        $skus          = Sku::where('status', 1)->get();
        $weightUnits   = WeightUnit::where('status', 1)->get();
        $ownershipTypes = OwnershipType::where('status', 1)->get();

        return view('inventory.myinventory.fullpage.fullpage.show', compact(
            'productTypes', 'subCategories', 'varieties', 'colors', 'shapes', 'cuts',
            'treatments', 'origins', 'colorGrades', 'cutGrades', 'clarityGrades',
            'storageLocations', 'trayBoxes', 'suppliers', 'skus', 'weightUnits', 'ownershipTypes'
        ));
    }

    // ─── AJAX: Get next SKU number for a product type ────────────────────────
    public function nextSku($productTypeId)
    {
        $productType = ProductType::with('sku')->findOrFail($productTypeId);

        // skuname from tbl_product_types (e.g. "gm", "CPG") — shown in prefix dropdown AND used in SKU number
        $skuPrefix = $productType->skuname ?? strtoupper(substr($productType->name, 0, 3));

        // Count products with this type to generate sequential 2-digit number
        $count   = \App\Models\Inventory\Product::where('idtbl_product_types', $productTypeId)->count();
        $nextNum = str_pad($count + 1, 2, '0', STR_PAD_LEFT); // 01, 02, 03...

        return response()->json([
            'sku_label'  => $skuPrefix,             // Shown in prefix dropdown (e.g. "gm")
            'sku_prefix' => $skuPrefix,             // Hidden value
            'sku_number' => $skuPrefix . $nextNum,  // Full SKU (e.g. "gm01", "gm02")
        ]);
    }

    public function memoOut()
    {
        return view('inventory.memo_out');
<<<<<<< HEAD
>>>>>>> Stashed changes
=======
>>>>>>> d2c05ed855d9a42e15dcf1f216f9b3838959b3d1
    }

    public function store(Request $request)
    {
        $product = \App\Models\Inventory\Product::create([
            'idtbl_product_types' => $request->idtbl_product_types ?: 1,
            'idtbl_sub_categories' => $request->idtbl_sub_categories ?: null,
            'idtbl_varieties' => $request->idtbl_varieties ?: null,
            'idtbl_colors' => $request->idtbl_colors ?: null,
            'idtbl_shapes' => $request->idtbl_shapes ?: null,
            'idtbl_cuts' => $request->idtbl_cuts ?: null,
            'idtbl_treatments' => $request->idtbl_treatments ?: null,
            'idtbl_origins' => $request->idtbl_origins ?: null,
            'idtbl_color_grade' => $request->idtbl_color_grade ?: null,
            'idtbl_cuttinggrade' => $request->idtbl_cuttinggrade ?: null,
            'idtbl_clarity_grade' => $request->idtbl_clarity_grade ?: null,
            'idtbl_storage_locations' => $request->idtbl_storage_locations ?: null,
            'idtbl_tray_box' => $request->idtbl_tray_box ?: null,
            'idtbl_skus' => $request->idtbl_skus ?: 1,
            'sku_number' => $request->sku_number ?: 'DEFAULT-SKU',
            'length_mm' => $request->length_mm,
            'width_mm' => $request->width_mm,
            'height_mm' => $request->height_mm,
            'product_title' => $request->product_title,
            'product_description' => $request->product_description,
            'status' => 1,
        ]);

        if ($request->idtbl_suppliers || $request->supplier_stone_ref || $request->date_of_purchase || $request->idtbl_ownership_type) {
            \App\Models\Inventory\ProductPurchasing::create([
                'idtbl_products' => $product->idtbl_products,
                'idtbl_suppliers' => $request->idtbl_suppliers ?: null,
                'supplier_stone_ref' => $request->supplier_stone_ref,
                'date_of_purchase' => $request->date_of_purchase,
                'idtbl_ownership_type' => $request->idtbl_ownership_type ?: null,
                'status' => 1,
            ]);
        }

        if ($request->weight || $request->quantity || $request->cost_per_unit) {
            \App\Models\Inventory\ProductPricing::create([
                'idtbl_products' => $product->idtbl_products,
                'idtbl_weight_units' => $request->idtbl_weight_units ?: null,
                'weight' => $request->weight,
                'quantity' => $request->quantity,
                'cost_per_unit' => $request->cost_per_unit,
                'total_cost' => $request->total_cost,
                'my_cost_per_unit' => $request->my_cost_per_unit,
                'my_total_cost' => $request->my_total_cost,
                'wholesale_price_per_unit' => $request->wholesale_per_unit,
                'wholesale_total_price' => $request->wholesale_total,
                'retail_price_per_unit' => $request->retail_per_unit,
                'retail_total_price' => $request->retail_total,
                'matrix_price_per_unit' => $request->matrix_per_unit,
                'matrix_total_price' => $request->matrix_total,
                'status' => 1,
            ]);
        }

        return redirect()->route('inventory.myinventory.index')->with('success', 'Product saved successfully!');
    }
}
