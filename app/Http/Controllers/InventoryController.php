<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
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

		$auditLogs = \DB::table('tbl_audit_logs')
			->leftJoin('tbl_user', 'tbl_audit_logs.user_id', '=', 'tbl_user.idtbl_user')
			->where('tbl_audit_logs.entity_type', 'tbl_products')
			->select(
				'tbl_audit_logs.*',
				'tbl_user.name as user_name'
			)
			->orderBy('tbl_audit_logs.insertdatetime', 'desc')
			->get();

		return view('inventory.myinventory.myinventory', compact('productTypes', 'storageLocations', 'suppliers', 'ownershipTypes', 'treatments', 'auditLogs'));
	}

	// Show product-type selection – redirects to the modal-based index
	public function selectProductType()
	{
		if (!Session::get('loggedin'))
			return redirect('/');

		// Product type selection is now handled via modal on the index page
		return redirect()->route('inventory.myinventory.index');
	}

	public function storeProductTypeSession(Request $request)
	{
		if (!Session::get('loggedin'))
			return redirect('/');

		$request->validate([
			'product_type_id' => 'required|integer|exists:tbl_product_types,idtbl_product_types',
		]);

		$productType = ProductType::with('sku')->findOrFail($request->product_type_id);

		session([
			'selected_product_type_id' => $productType->idtbl_product_types,
			'selected_sku_id' => $productType->idtbl_skus,
			'selected_sku_name' => $productType->skuname,
			'selected_product_name' => $productType->name,
		]);

		return redirect()->route('inventory.myinventory.create');
	}

	public function create()
	{
		if (!Session::get('loggedin'))
			return redirect('/');

		// Creation is now handled via modal on the index page
		return redirect()->route('inventory.myinventory.index');
	}

	public function show($id = null)
	{
		$productTypes = ProductType::where('status', 1)->get();
		$subCategories = SubCategory::where('status', 1)->get();
		$varieties = Variety::where('status', 1)->get();
		$colors = Color::where('status', 1)->get();
		$shapes = Shape::where('status', 1)->get();
		$cuts = Cut::where('status', 1)->get();
		$treatments = Treatment::where('status', 1)->get();
		$origins = Origin::where('status', 1)->get();
		$colorGrades = ColorGrade::where('status', 1)->get();
		$cutGrades = CuttingGrade::where('status', 1)->get();
		$clarityGrades = ClarityGrade::where('status', 1)->get();
		$storageLocations = StorageLocation::where('status', 1)->get();
		$trayBoxes = TrayBox::where('status', 1)->get();
		$suppliers = Supplier::where('status', 1)->get();
		$skus = Sku::where('status', 1)->get();
		$weightUnits = WeightUnit::where('status', 1)->get();
		$ownershipTypes = OwnershipType::where('status', 1)->get();

		$auditLogs = [];
		if ($id) {
			$auditLogs = \DB::table('tbl_audit_logs')
				->leftJoin('tbl_user', 'tbl_audit_logs.user_id', '=', 'tbl_user.idtbl_user')
				->where('tbl_audit_logs.entity_type', 'tbl_products')
				->where('tbl_audit_logs.entity_id', $id)
				->select(
					'tbl_audit_logs.*',
					'tbl_user.name as user_name'
				)
				->orderBy('tbl_audit_logs.insertdatetime', 'desc')
				->get();
		}

		return view('inventory.myinventory.fullpage.fullpage.show', compact(
			'productTypes',
			'subCategories',
			'varieties',
			'colors',
			'shapes',
			'cuts',
			'treatments',
			'origins',
			'colorGrades',
			'cutGrades',
			'clarityGrades',
			'storageLocations',
			'trayBoxes',
			'suppliers',
			'skus',
			'weightUnits',
			'ownershipTypes',
			'auditLogs'
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
			'sku_code' => $skuCode,
			'idtbl_skus' => $productType->idtbl_skus
		]);
	}

	public function memoOut()
	{
		return view('inventory.memo_out');
	}

	private function intVal($value)
	{
		if (is_null($value) || $value === '' || $value === 'Unspecified' || $value === 'Prefix' || !is_numeric($value)) {
			return null;
		}
		return intval($value);
	}

	private function floatVal($value)
	{
		if (is_null($value) || $value === '' || !is_numeric($value)) {
			return null;
		}
		return floatval($value);
	}

	public function store(Request $request)
	{
		// Resolve weight unit string to ID
		$weightUnitId = null;
		$weightUnitStr = $request->idtbl_weight_units;
		if ($weightUnitStr) {
			if (is_numeric($weightUnitStr)) {
				$weightUnitId = intval($weightUnitStr);
			} else {
				$wu = \DB::table('tbl_weight_units')->where('unit_name', $weightUnitStr)->first();
				if ($wu) {
					$weightUnitId = $wu->idtbl_weight_units;
				} else {
					$weightUnitId = \DB::table('tbl_weight_units')->insertGetId([
						'unit_name' => $weightUnitStr,
						'status' => 1,
						'insertdatetime' => now(),
					]);
				}
			}
		}

		$dateOfPurchase = $request->date_of_purchase ?: null;
		if ($dateOfPurchase) {
			$timestamp = strtotime($dateOfPurchase);
			if ($timestamp) {
				$dateOfPurchase = date('Y-m-d', $timestamp);
			} else {
				$dateOfPurchase = null;
			}
		}

		$product = \App\Models\Inventory\Product::create([
			'idtbl_product_types' => $this->intVal($request->idtbl_product_types) ?: 1,
			'idtbl_sub_categories' => $this->intVal($request->idtbl_sub_categories),
			'idtbl_varieties' => $this->intVal($request->idtbl_varieties),
			'idtbl_colors' => $this->intVal($request->idtbl_colors),
			'idtbl_shapes' => $this->intVal($request->idtbl_shapes),
			'idtbl_cuts' => $this->intVal($request->idtbl_cuts),
			'idtbl_treatments' => $this->intVal($request->idtbl_treatments),
			'idtbl_origins' => $this->intVal($request->idtbl_origins),
			'idtbl_color_grade' => $this->intVal($request->idtbl_color_grade),
			'idtbl_cuttinggrade' => $this->intVal($request->idtbl_cuttinggrade),
			'idtbl_clarity_grade' => $this->intVal($request->idtbl_clarity_grade),
			'idtbl_storage_locations' => $this->intVal($request->idtbl_storage_locations),
			'idtbl_tray_box' => $this->intVal($request->idtbl_tray_box),
			'idtbl_ownership_type' => $this->intVal($request->idtbl_ownership_type),
			'idtbl_skus' => $this->intVal($request->idtbl_skus) ?: 1,
			'sku_number' => $request->sku_number ?: 'DEFAULT-SKU',
			'length_mm' => $this->floatVal($request->length_mm),
			'width_mm' => $this->floatVal($request->width_mm),
			'height_mm' => $this->floatVal($request->height_mm),
			'product_title' => $request->product_title,
			'product_description' => $request->product_description,
			'status' => 1,
		]);

		// Record in tbl_audit_logs
		try {
			\DB::table('tbl_audit_logs')->insert([
				'user_id' => Session::get('userid') ?: 1,
				'org_id' => Session::get('org_id') ?: 1,
				'action' => 'Created',
				'entity_type' => 'tbl_products',
				'entity_id' => $product->idtbl_products,
				'old_values' => null,
				'new_values' => json_encode([
					'sku_number' => $product->sku_number,
					'product_title' => $product->product_title,
					'length_mm' => $product->length_mm,
					'width_mm' => $product->width_mm,
					'height_mm' => $product->height_mm,
					'insertdatetime' => $product->insertdatetime ?? now()->toDateTimeString(),
				]),
				'ip_address' => $request->ip(),
				'user_agent' => $request->userAgent(),
				'insertdatetime' => now(),
			]);
		} catch (\Exception $e) {
			// Silently skip if there's any database audit log constraint issue
		}

		$productPurchasing = null;
		if ($request->idtbl_suppliers || $request->supplier_stone_ref || $dateOfPurchase || $request->idtbl_ownership_type) {
			$productPurchasing = \App\Models\Inventory\ProductPurchasing::create([
				'idtbl_products' => $product->idtbl_products,
				'idtbl_suppliers' => $this->intVal($request->idtbl_suppliers),
				'supplier_stone_ref' => $request->supplier_stone_ref,
				'date_of_purchase' => $dateOfPurchase,
				'idtbl_ownership_type' => $this->intVal($request->idtbl_ownership_type),
				'status' => 1,
			]);

			// If ownership type is Partner (3) or empty/not set, save partners master/details
			$ownershipType = $this->intVal($request->idtbl_ownership_type);
			if ($ownershipType === 3 || is_null($ownershipType)) {
				$partnerIds = $request->input('partner_ids', []);
				$ownerships = $request->input('ownership_percentages', []);
				$profits = $request->input('profit_percentages', []);
				$myCompanyId = $this->intVal($request->input('my_company_id')) ?: 1;
				$myOwnership = $this->floatVal($request->input('my_ownership_percentage')) ?? 100.0;
				$myProfit = $this->floatVal($request->input('my_profit_share_percentage')) ?? 100.0;

				$sumOtherOwnership = 0.0;
				$sumOtherProfits = 0.0;
				foreach ($ownerships as $o) {
					$sumOtherOwnership += $this->floatVal($o) ?? 0.0;
				}
				foreach ($profits as $p) {
					$sumOtherProfits += $this->floatVal($p) ?? 0.0;
				}

				$totalOwnership = $myOwnership + $sumOtherOwnership;
				$totalProfit = $myProfit + $sumOtherProfits;

				if (abs($totalOwnership - 100.0) > 0.01 || abs($totalProfit - 100.0) > 0.01) {
					return redirect()->back()->withInput()->with('error', 'Ownership and profit totals must equal 100%');
				}

				$partnerDetails = [];
				for ($i = 0; $i < count($partnerIds); $i++) {
					$pid = $partnerIds[$i] ?? null;
					if (is_null($pid) || $pid === '') {
						continue;
					}
					$own = isset($ownerships[$i]) ? $this->floatVal($ownerships[$i]) : 0.0;
					$prof = isset($profits[$i]) ? $this->floatVal($profits[$i]) : 0.0;
					$partnerDetails[] = [
						'input_partner' => $pid,
						'ownership_percentage' => $own,
						'profit_share_percentage' => $prof,
					];
				}

				DB::transaction(function () use ($productPurchasing, $myCompanyId, $myOwnership, $myProfit, $partnerDetails) {
					$masterId = DB::table('tbl_partners_master')->insertGetId([
						'idtbl_product_purchasing' => $productPurchasing->idtbl_product_purchasing ?? $productPurchasing->id,
						'idtbl_partners' => $myCompanyId,
						'ownership_percentage' => $myOwnership,
						'profit_share_percentage' => $myProfit,
						'status' => 1,
					]);

					foreach ($partnerDetails as $detail) {
						$pid = $detail['input_partner'];
						if (!is_numeric($pid)) {
							// Look up by name or create!
							$existingPartner = DB::table('tbl_partners')->where('partner_name', $pid)->first();
							if ($existingPartner) {
								$pid = $existingPartner->idtbl_partners;
							} else {
								$pid = DB::table('tbl_partners')->insertGetId([
									'partner_name' => $pid,
									'status' => 1,
									'insertdatetime' => now(),
								]);
							}
						}

						DB::table('tbl_partners_details')->insert([
							'idtbl_partners_master' => $masterId,
							'idtbl_partners' => $pid,
							'ownership_percentage' => $detail['ownership_percentage'],
							'profit_share_percentage' => $detail['profit_share_percentage'],
							'status' => 1,
						]);
					}
				});
			}
		}

		if ($request->weight || $request->quantity || $request->cost_per_unit) {
			$sellingUnit = ($request->pricing_unit === 'Quantity') ? 2 : 1;

			\App\Models\Inventory\ProductPricing::create([
				'idtbl_products' => $product->idtbl_products,
				'selling_unit' => $sellingUnit,
				'idtbl_weight_units' => $weightUnitId,
				'weight' => $this->floatVal($request->weight),
				'quantity' => $this->intVal($request->quantity),
				'cost_per_unit' => $this->floatVal($request->cost_per_unit),
				'total_cost' => $this->floatVal($request->total_cost),
				'my_cost_per_unit' => $this->floatVal($request->my_cost_per_unit),
				'my_total_cost' => $this->floatVal($request->my_total_cost),
				'wholesale_price_per_unit' => $this->floatVal($request->wholesale_per_unit),
				'wholesale_total_price' => $this->floatVal($request->wholesale_total),
				'retail_price_per_unit' => $this->floatVal($request->retail_per_unit),
				'retail_total_price' => $this->floatVal($request->retail_total),
				'matrix_price_per_unit' => $this->floatVal($request->matrix_per_unit),
				'matrix_total_price' => $this->floatVal($request->matrix_total),
				'status' => 1,
			]);
		}

		if ($request->hasAny(['color_distribution', 'size_length_from', 'size_length_to', 'size_width_from', 'size_width_to', 'color_grade_from', 'color_grade_to', 'clarity_grade_from', 'clarity_grade_to', 'tolerance_mm', 'allow_selection', 'cut_grade_from', 'cut_grade_to', 'barcode', 'traceability_no', 'rfid', 'direct_sales'])) {
			try {
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
			} catch (\Exception $e) {
				// Silently skip if tbl_product_advance_details does not exist yet
			}
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
