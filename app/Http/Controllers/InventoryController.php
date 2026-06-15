<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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

class InventoryController extends Controller
{
	// MyInventory index
	public function myinventory()
	{
		$productTypes = ProductType::where('status', 1)->orderBy('name')->get();
		$storageLocations = \App\Models\StorageLocation::where('status', 1)->orderBy('location_name')->get();
		$suppliers = \App\Models\Supplier::where('status', 1)->orderBy('supplier_name')->get();
		$ownershipTypes = \App\Models\OwnershipType::where('status', 1)->orderBy('ownership_type_name')->get();
		$treatments = \App\Models\Treatment::where('status', 1)->orderBy('treatment_name')->get();
		return view('inventory.myinventory.myinventory', compact('productTypes', 'storageLocations', 'suppliers', 'ownershipTypes', 'treatments'));
	}

	// Show product-type selection
	public function selectProductType()
	{
		if (!Session::get('loggedin')) return redirect('/');

		$productTypes = ProductType::where('status', 1)->orderBy('name')->get();
		return view('inventory.myinventory.select_product_type', compact('productTypes'));
	}

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

	public function create()
	{
		if (!Session::get('loggedin')) return redirect('/');

		$productTypeId = session('selected_product_type_id');
		if (!$productTypeId) {
			return redirect()->route('inventory.myinventory.select_type')
				->with('error', 'Please select a product type first.');
		}

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

	public function show($id = null)
	{
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

	public function nextSku($productTypeId)
	{
		// 1. Find the row in tbl_product_types matching the idtbl_product_types.
		$productType = \Illuminate\Support\Facades\DB::table('tbl_product_types')
			->where('idtbl_product_types', $productTypeId)
			->first();

		if (!$productType) {
			return response()->json(['error' => 'Product type not found'], 404);
		}

		// 2. Use the foreign key idtbl_skus to fetch the corresponding name from tbl_skus.
		$sku = \Illuminate\Support\Facades\DB::table('tbl_skus')
			->where('idtbl_skus', $productType->idtbl_skus)
			->first();

		$prefixName = $sku ? $sku->sku_name : 'Prefix';

		// 3. Calculate the next sequential number for the SKU based on how many products already exist with that prefix.
		// Assuming the products table is `tbl_products` and the SKU column is `sku_number`.
		// We count how many products have this product type to determine the next number.
		try {
			$count = \Illuminate\Support\Facades\DB::table('tbl_products')
				->where('idtbl_product_types', $productTypeId)
				->count();
		} catch (\Exception $e) {
			// Fallback to 0 if tbl_products does not exist yet
			$count = 0;
		}

		$nextNumber = str_pad($count + 1, 2, '0', STR_PAD_LEFT);

		// 4. Return a JSON response
		$skuCode = ($productType->skuname ?? '') . $nextNumber;

		return response()->json([
			'prefix_name' => $prefixName,
			'sku_code'    => $skuCode,
			'idtbl_skus'  => $productType->idtbl_skus
		]);
	}

	public function memoOut()
	{
		return view('inventory.memo_out');
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

		if ($request->hasAny(['color_distribution', 'size_length_from', 'size_length_to', 'size_width_from', 'size_width_to', 'color_grade_from', 'color_grade_to', 'clarity_grade_from', 'clarity_grade_to', 'tolerance_mm', 'allow_selection', 'cut_grade_from', 'cut_grade_to', 'barcode', 'traceability_no', 'rfid', 'direct_sales'])) {
            \Illuminate\Support\Facades\DB::table('tbl_product_advance_details')->insert([
                'idtbl_products' => $product->idtbl_products,
                'barcode' => $request->barcode,
                'traceability_no' => $request->traceability_no,
                'rfid' => $request->rfid,
                'color_distribution' => $request->color_distribution,
                'size_length_from' => $request->size_length_from,
                'size_length_to' => $request->size_length_to,
                'size_width_from' => $request->size_width_from,
                'size_width_to' => $request->size_width_to,
                'color_grade_from' => $request->color_grade_from,
                'color_grade_to' => $request->color_grade_to,
                'clarity_grade_from' => $request->clarity_grade_from,
                'clarity_grade_to' => $request->clarity_grade_to,
                'tolerance_mm' => $request->tolerance_mm,
                'allow_selection' => $request->allow_selection,
                'cut_grade_from' => $request->cut_grade_from,
                'cut_grade_to' => $request->cut_grade_to,
                'direct_sales' => $request->direct_sales ?: 0,
                'status' => 1,
            ]);
        }

		return redirect()->route('inventory.myinventory.index')->with('success', 'Product saved successfully!');
	}

	public function getDependentData($productTypeId)
	{
		$varieties = \App\Models\Variety::where('status', 1)->where('idtbl_product_types', $productTypeId)->orderBy('name')->get();
		$subCategories = \App\Models\SubCategory::where('status', 1)->where('idtbl_product_types', $productTypeId)->orderBy('sub_category_name')->get();
		$colors = \App\Models\Color::where('status', 1)->where('idtbl_product_types', $productTypeId)->orderBy('color_name')->get();
		$shapes = \App\Models\Shape::where('status', 1)->where('idtbl_product_types', $productTypeId)->orderBy('name')->get();
		$cuts = \App\Models\Cut::where('status', 1)->where('idtbl_product_types', $productTypeId)->orderBy('name')->get();
		$treatments = \App\Models\Treatment::where('status', 1)->where('idtbl_product_types', $productTypeId)->orderBy('treatment_name')->get();
		$origins = \App\Models\Origin::where('status', 1)->where('idtbl_product_types', $productTypeId)->orderBy('origin_name')->get();
		$colorGrades = \App\Models\ColorGrade::where('status', 1)->where('idtbl_product_types', $productTypeId)->orderBy('grade_name')->get();
		$cuttingGrades = \App\Models\CuttingGrade::where('status', 1)->where('idtbl_product_types', $productTypeId)->orderBy('cuttinggradename')->get();
		$clarityGrades = \App\Models\ClarityGrade::where('status', 1)->where('idtbl_product_types', $productTypeId)->orderBy('clarity_grade_name')->get();

		return response()->json([
			'varieties' => $varieties,
			'subCategories' => $subCategories,
			'colors' => $colors,
			'shapes' => $shapes,
			'cuts' => $cuts,
			'treatments' => $treatments,
			'origins' => $origins,
			'colorGrades' => $colorGrades,
			'cuttingGrades' => $cuttingGrades,
			'clarityGrades' => $clarityGrades
		]);
	}
}
