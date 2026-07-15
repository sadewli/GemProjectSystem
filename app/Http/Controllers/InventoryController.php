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
use App\Models\Inventory\TrackSkuid;
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
			->where('tbl_audit_logs.status', 1)
			->select(
				'tbl_audit_logs.*',
				'tbl_user.name as user_name'
			)
			->orderBy('tbl_audit_logs.insertdatetime', 'desc')
			->get();

		$partners = \App\Models\Partner::where('status', 1)->orderBy('partner_name')->get();

		$certificateLabs = \App\Models\CertificateLab::where('status', 1)->orderBy('lab_name')->get();
		return view('inventory.myinventory.myinventory', compact('productTypes', 'storageLocations', 'suppliers', 'ownershipTypes', 'treatments', 'auditLogs', 'partners', 'certificateLabs'));
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
		$partners = \App\Models\Partner::where('status', 1)->orderBy('partner_name')->get();
		$certificateLabs = \App\Models\CertificateLab::where('status', 1)->orderBy('lab_name')->get();

		$auditLogs = [];
		$product = null;
		$productCustomFields = [];
		$productTypeId = session('selected_product_type_id') ?: 1;

		if ($id) {
			$product = \App\Models\Inventory\Product::where('idtbl_products', $id)->first();
			if ($product) {
				$productTypeId = $product->idtbl_product_types ?: 1;
				$product->pricing = \DB::table('tbl_product_pricing')->where('idtbl_products', $id)->first();
				$product->purchasing = \DB::table('tbl_product_purchasing')->where('idtbl_products', $id)->first();
				$product->advance = \DB::table('tbl_product_advance_details')->where('idtbl_products', $id)->first();

				// Fetch Media
				$product->photos = \DB::table('tbl_product_media_details')
					->join('tbl_product_media_master', 'tbl_product_media_details.idtbl_product_media_master', '=', 'tbl_product_media_master.idtbl_product_media_master')
					->join('tbl_media_types', 'tbl_product_media_master.idtbl_media_types', '=', 'tbl_media_types.idtbl_media_types')
					->where('tbl_product_media_master.idtbl_products', $id)
					->where('tbl_media_types.type_name', 'photo')
					->where('tbl_product_media_details.status', 1)
					->pluck('tbl_product_media_details.file_path')
					->toArray();

				$product->video = \DB::table('tbl_product_media_details')
					->join('tbl_product_media_master', 'tbl_product_media_details.idtbl_product_media_master', '=', 'tbl_product_media_master.idtbl_product_media_master')
					->join('tbl_media_types', 'tbl_product_media_master.idtbl_media_types', '=', 'tbl_media_types.idtbl_media_types')
					->where('tbl_product_media_master.idtbl_products', $id)
					->where('tbl_media_types.type_name', 'video')
					->where('tbl_product_media_details.status', 1)
					->value('tbl_product_media_details.file_path');

				$product->view360 = \DB::table('tbl_product_media_details')
					->join('tbl_product_media_master', 'tbl_product_media_details.idtbl_product_media_master', '=', 'tbl_product_media_master.idtbl_product_media_master')
					->join('tbl_media_types', 'tbl_product_media_master.idtbl_media_types', '=', 'tbl_media_types.idtbl_media_types')
					->where('tbl_product_media_master.idtbl_products', $id)
					->where('tbl_media_types.type_name', 'view360')
					->where('tbl_product_media_details.status', 1)
					->select('tbl_product_media_details.file_path', 'tbl_product_media_details.file_name')
					->first();

				$productCustomFields = \DB::table('tbl_product_custom_field_values')
					->where('idtbl_products', $id)
					->where('status', 1)
					->pluck('field_value', 'idtbl_custom_fields')
					->toArray();
			}

			$auditLogs = \DB::table('tbl_audit_logs')
				->leftJoin('tbl_user', 'tbl_audit_logs.user_id', '=', 'tbl_user.idtbl_user')
				->where('tbl_audit_logs.entity_type', 'tbl_products')
				->where('tbl_audit_logs.entity_id', $id)
				->where('tbl_audit_logs.status', 1)
				->select(
					'tbl_audit_logs.*',
					'tbl_user.name as user_name'
				)
				->orderBy('tbl_audit_logs.insertdatetime', 'desc')
				->get();
		}

		$customFields = \DB::table('tbl_custom_fields')
			->where('idtbl_product_types', $productTypeId)
			->where('status', 1)
			->orderBy('sort_order', 'asc')
			->get();

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
			'auditLogs',
			'partners',
			'certificateLabs',
			'product',
			'customFields',
			'productCustomFields'
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

		// 3. Calculate next number: max(highest existing SKU suffix, counter) + 1
		$next = $this->getNextSkuNumber((int) $productTypeId);
		$nextNumber = str_pad($next, 2, '0', STR_PAD_LEFT);

		// 4. Return a JSON response
		$skuCode = ($productType->skuname ?? '') . $nextNumber;

		return response()->json([
			'prefix_name' => $prefixName,
			'sku_code' => $skuCode,
			'idtbl_skus' => $productType->idtbl_skus
		]);
	}

	public function update(Request $request)
	{
		$productId = $request->product_id;
		if (!$productId) {
			return response()->json(['success' => false, 'message' => 'Product ID is missing']);
		}

		$product = \App\Models\Inventory\Product::findOrFail($productId);
		$product->update([
			'inventory_type' => $request->inventory_type === 'lot' ? 'lot' : 'individual',
			'idtbl_product_types' => $this->intVal($request->idtbl_product_types) ?: $product->idtbl_product_types,
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
			'length_mm' => $this->floatVal($request->length_mm),
			'width_mm' => $this->floatVal($request->width_mm),
			'height_mm' => $this->floatVal($request->height_mm),
			'product_title' => $request->product_title,
			'product_description' => $request->product_description,
			'inventerysavestatus' => $request->inventerysavestatus,
			// status is intentionally left alone during update unless explicitly requested
		]);

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

		$productPurchasing = \App\Models\Inventory\ProductPurchasing::updateOrCreate(
			['idtbl_products' => $productId],
			[
				'idtbl_suppliers' => $this->intVal($request->idtbl_suppliers),
				'supplier_stone_ref' => $request->supplier_stone_ref,
				'date_of_purchase' => $dateOfPurchase,
				'idtbl_ownership_type' => $this->intVal($request->idtbl_ownership_type),
				'status' => 1,
			]
		);

		// Always save partners master/details
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
			if ($request->ajax() || $request->wantsJson()) {
				return response()->json(['success' => false, 'message' => 'Ownership and profit totals must equal 100%'], 422);
			}
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

		\Illuminate\Support\Facades\DB::transaction(function () use ($productPurchasing, $myCompanyId, $myOwnership, $myProfit, $partnerDetails) {
			// First, remove existing master and details to rebuild them (simplest approach for update)
			$existingMaster = \Illuminate\Support\Facades\DB::table('tbl_partners_master')
				->where('idtbl_product_purchasing', $productPurchasing->idtbl_product_purchasing ?? $productPurchasing->id)
				->first();

			if ($existingMaster) {
				\Illuminate\Support\Facades\DB::table('tbl_partners_details')
					->where('idtbl_partners_master', $existingMaster->idtbl_partners_master)
					->delete();
				\Illuminate\Support\Facades\DB::table('tbl_partners_master')
					->where('idtbl_partners_master', $existingMaster->idtbl_partners_master)
					->delete();
			}

			$masterId = \Illuminate\Support\Facades\DB::table('tbl_partners_master')->insertGetId([
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
					$existingPartner = \Illuminate\Support\Facades\DB::table('tbl_partners')->where('partner_name', $pid)->first();
					if ($existingPartner) {
						$pid = $existingPartner->idtbl_partners;
					} else {
						$pid = \Illuminate\Support\Facades\DB::table('tbl_partners')->insertGetId([
							'partner_name' => $pid,
							'status' => 1,
							'insertdatetime' => now(),
						]);
					}
				}

				\Illuminate\Support\Facades\DB::table('tbl_partners_details')->insert([
					'idtbl_partners_master' => $masterId,
					'idtbl_partners' => $pid,
					'ownership_percentage' => $detail['ownership_percentage'],
					'profit_share_percentage' => $detail['profit_share_percentage'],
					'status' => 1,
				]);
			}
		});

		$sellingUnit = ($request->pricing_unit === 'Quantity') ? 2 : 1;
		\App\Models\Inventory\ProductPricing::updateOrCreate(
			['idtbl_products' => $productId],
			[
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
			]
		);

		try {
			$auditData = $request->except(['_token']);
			\DB::table('tbl_audit_logs')->insert([
				'user_id' => \Session::get('userid') ?: 1,
				'org_id' => \Session::get('org_id') ?: 1,
				'action' => 'Updated',
				'entity_type' => 'tbl_products',
				'entity_id' => $productId,
				'old_values' => null,
				'new_values' => json_encode($auditData),
				'ip_address' => $request->ip(),
				'user_agent' => $request->userAgent(),
				'insertdatetime' => now(),
			]);
		} catch (\Exception $e) {}

		// Save Custom Fields
		if ($request->has('custom_fields') && is_array($request->custom_fields)) {
			foreach ($request->custom_fields as $fieldId => $fieldValue) {
				\DB::table('tbl_product_custom_field_values')->updateOrInsert(
					[
						'idtbl_products' => $productId,
						'idtbl_custom_fields' => $fieldId
					],
					[
						'field_value' => is_array($fieldValue) ? json_encode($fieldValue) : $fieldValue,
						'status' => 1,
						'updatedatetime' => now()
					]
				);
			}
		}

		if ($request->ajax() || $request->wantsJson()) {
			return response()->json([
				'success' => true,
				'message' => 'Product updated successfully'
			]);
		}

		return redirect()->route('inventory.myinventory.index')->with('success', 'Product updated successfully');
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

	/**
	 * Returns the next safe sequential number for a SKU, guaranteed to be
	 * strictly greater than both the highest number already in tbl_products
	 * AND the last recorded counter — so consumed / sold / deleted gems
	 * can never cause a SKU to be reused.
	 */
	private function getNextSkuNumber(int $productTypeId): int
	{
		$productType = \Illuminate\Support\Facades\DB::table('tbl_product_types')
			->where('idtbl_product_types', $productTypeId)
			->first();

		$prefix       = $productType->skuname ?? '';
		$prefixLength = strlen($prefix);

		// Highest numeric suffix already stored in tbl_products for this type
		$maxDbSku = 0;
		if ($prefixLength > 0) {
			$maxDbSku = (int) \Illuminate\Support\Facades\DB::table('tbl_products')
				->where('idtbl_product_types', $productTypeId)
				->where('sku_number', 'LIKE', $prefix . '%')
				->selectRaw('MAX(CAST(SUBSTRING(sku_number, ?) AS UNSIGNED)) as max_num', [$prefixLength + 1])
				->value('max_num') ?? 0;
		}

		// Counter table value
		$counterVal = (int) (\Illuminate\Support\Facades\DB::table('sku_counters')
			->where('idtbl_product_types', $productTypeId)
			->value('last_number') ?? 0);

		return max($maxDbSku, $counterVal) + 1;
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

		$skuNumber = $request->sku_number ?: 'DEFAULT-SKU';

		// If the requested SKU already exists or is default, generate a new one using the counter.
		if ($skuNumber === 'DEFAULT-SKU' || \Illuminate\Support\Facades\DB::table('tbl_products')->where('sku_number', $skuNumber)->exists()) {
			$productTypeId = $this->intVal($request->idtbl_product_types) ?: 1;
			$skuNumber = \Illuminate\Support\Facades\DB::transaction(function () use ($productTypeId) {
				$productType = \Illuminate\Support\Facades\DB::table('tbl_product_types')
					->where('idtbl_product_types', $productTypeId)
					->first();

				do {
					// Always use max(highest existing SKU, counter) + 1 to prevent reuse
					$next = $this->getNextSkuNumber($productTypeId);

					// Sync the counter table so it never falls behind
					\Illuminate\Support\Facades\DB::table('sku_counters')
						->updateOrInsert(
							['idtbl_product_types' => $productTypeId],
							['last_number' => $next, 'updated_at' => now()]
						);

					$proposedSku = ($productType->skuname ?? '') . str_pad($next, 2, '0', STR_PAD_LEFT);
				} while (\Illuminate\Support\Facades\DB::table('tbl_products')->where('sku_number', $proposedSku)->exists());

				return $proposedSku;
			});
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
			'sku_number' => $skuNumber,
			'inventory_type' => $request->inventory_type === 'lot' ? 'lot' : 'individual',
			'length_mm' => $this->floatVal($request->length_mm),
			'width_mm' => $this->floatVal($request->width_mm),
			'height_mm' => $this->floatVal($request->height_mm),
			'product_title' => $request->product_title,
			'product_description' => $request->product_description,
			'inventerysavestatus' => $request->inventerysavestatus,
			'status' => 1,
		]);

		// Record in tbl_audit_logs
		try {
			$auditData = $request->except(['_token']);
			$auditData['insertdatetime'] = $product->insertdatetime ?? now()->toDateTimeString();

			\DB::table('tbl_audit_logs')->insert([
				'user_id' => Session::get('userid') ?: 1,
				'org_id' => Session::get('org_id') ?: 1,
				'action' => 'Created',
				'entity_type' => 'tbl_products',
				'entity_id' => $product->idtbl_products,
				'old_values' => null,
				'new_values' => json_encode($auditData),
				'ip_address' => $request->ip(),
				'user_agent' => $request->userAgent(),
				'insertdatetime' => now(),
			]);
		} catch (\Exception $e) {
			// Silently skip if there's any database audit log constraint issue
		}

		$productPurchasing = \App\Models\Inventory\ProductPurchasing::create([
			'idtbl_products' => $product->idtbl_products,
			'idtbl_suppliers' => $this->intVal($request->idtbl_suppliers),
			'supplier_stone_ref' => $request->supplier_stone_ref,
			'date_of_purchase' => $dateOfPurchase,
			'idtbl_ownership_type' => $this->intVal($request->idtbl_ownership_type),
			'status' => 1,
		]);

		// Always save partners master/details
		$ownershipType = $this->intVal($request->idtbl_ownership_type);
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
			if ($request->ajax() || $request->wantsJson()) {
				return response()->json(['success' => false, 'message' => 'Ownership and profit totals must equal 100%'], 422);
			}
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

		// ── Production Sheet Completion ──────────────────────────────────────────
		if ($request->filled('production_sheet_id')) {
			$sheetId = (int) $request->production_sheet_id;
			$sheet   = \DB::table('tbl_production_sheets')
				->where('idtbl_production_sheets', $sheetId)
				->first();

			if ($sheet && $sheet->status !== 'completed' && $sheet->status !== 'deleted') {
				// 1. Collect linked product IDs from the sheet items
				$inputProductIds = \DB::table('tbl_production_sheet_items')
					->where('idtbl_production_sheets', $sheetId)
					->whereNotNull('idtbl_products')
					->pluck('idtbl_products');

				// 2. Mark input items as Consumed in Production (inventorystatus = 3)
				if ($inputProductIds->isNotEmpty()) {
					\DB::table('tbl_products')
						->whereIn('idtbl_products', $inputProductIds)
						->update([
							'inventorystatus'      => 3, // 3 = Consumed in Production
							'productionmanagetype' => null,
						]);

					// 2b. Track the SKU-id change: each consumed (Production stage) item
					// -> the newly registered gemstone (Inventory stage)
					foreach ($inputProductIds as $consumedProductId) {
						TrackSkuid::logChange(
							$consumedProductId,
							$product->idtbl_products,
							TrackSkuid::PISTATUS_PRODUCTION,
							'production_complete',
							auth()->id()
						);
					}
				}

				// 3. Close the production sheet
				\DB::table('tbl_production_sheets')
					->where('idtbl_production_sheets', $sheetId)
					->update([
						'status'      => 'completed',
						'closed_date' => now()->toDateString(),
					]);

				// 4. Log history (silently skip if table doesn't exist yet)
				try {
					\DB::table('tbl_production_sheet_history')->insert([
						'idtbl_production_sheets' => $sheetId,
						'action'                  => 'Completed',
						'note'                    => 'Production completed. New gemstone registered: ' . ($product->sku_number ?? 'N/A')
						                             . '. ' . $inputProductIds->count() . ' item(s) marked as Consumed.',
						'action_date'             => now()->toDateString(),
						'action_time'             => now()->toTimeString(),
						'action_user'             => auth()->id(),
						'insertdatetime'          => now(),
					]);
				} catch (\Exception $e) {
					// tbl_production_sheet_history may not exist yet – silently skip
				}

				return redirect()->route('production.overview.index')
					->with('success', 'Gemstone ' . $product->sku_number . ' added to inventory and production sheet completed successfully!');
			}
		}

		// Save Custom Fields
		if ($request->has('custom_fields') && is_array($request->custom_fields)) {
			foreach ($request->custom_fields as $fieldId => $fieldValue) {
				\DB::table('tbl_product_custom_field_values')->updateOrInsert(
					[
						'idtbl_products' => $product->idtbl_products,
						'idtbl_custom_fields' => $fieldId
					],
					[
						'field_value' => is_array($fieldValue) ? json_encode($fieldValue) : $fieldValue,
						'status' => 1,
						'updatedatetime' => now()
					]
				);
			}
		}

		// Map pending media to the newly created product
		if (\Illuminate\Support\Facades\Session::has('pending_media_masters')) {
			$masters = \Illuminate\Support\Facades\Session::get('pending_media_masters', []);
			if (!empty($masters)) {
				\DB::table('tbl_product_media_master')->whereIn('idtbl_product_media_master', $masters)->update(['idtbl_products' => $product->idtbl_products]);
			}
			\Illuminate\Support\Facades\Session::forget('pending_media_masters');
		}

		if (\Illuminate\Support\Facades\Session::has('pending_certificate_ids')) {
			$certs = \Illuminate\Support\Facades\Session::get('pending_certificate_ids', []);
			if (!empty($certs)) {
				\DB::table('tbl_product_certificates')->whereIn('idtbl_product_certificates', $certs)->update(['idtbl_products' => $product->idtbl_products]);
			}
			\Illuminate\Support\Facades\Session::forget('pending_certificate_ids');
		}

		if (\Illuminate\Support\Facades\Session::has('pending_document_ids')) {
			$docs = \Illuminate\Support\Facades\Session::get('pending_document_ids', []);
			if (!empty($docs)) {
				\DB::table('tbl_product_documents')->whereIn('idtbl_product_documents', $docs)->update(['idtbl_products' => $product->idtbl_products]);
			}
			\Illuminate\Support\Facades\Session::forget('pending_document_ids');
		}

		if (\Illuminate\Support\Facades\Session::has('pending_traceability_ids')) {
			$traces = \Illuminate\Support\Facades\Session::get('pending_traceability_ids', []);
			if (!empty($traces)) {
				\DB::table('tbl_product_traceability_docs')->whereIn('idtbl_product_traceability_docs', $traces)->update(['idtbl_products' => $product->idtbl_products]);
			}
			\Illuminate\Support\Facades\Session::forget('pending_traceability_ids');
		}

		if ($request->ajax() || $request->wantsJson()) {
			return response()->json([
				'success' => true,
				'message' => 'Product saved successfully!',
				'product' => $product
			]);
		}

		return redirect()->route('inventory.myinventory.show', ['id' => $product->idtbl_products])->with('success', 'Product saved successfully!');
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

	public function updateAuditLog(Request $request)
	{
		if (!Session::get('loggedin')) {
			return response()->json(['success' => false, 'message' => 'Not authenticated'], 401);
		}

		$request->validate([
			'log_id' => 'required|integer',
			'note' => 'required|string|max:1000'
		]);

		\DB::table('tbl_audit_logs')
			->where('idtbl_audit_logs', $request->log_id)
			->update([
				'note' => $request->note,
				'updateuser' => Session::get('userid'),
				'updatedatetime' => now()
			]);

		return response()->json(['success' => true, 'message' => 'Log updated successfully']);
	}

	public function destroy($id)
	{
		$product = \App\Models\Inventory\Product::findOrFail($id);
		$product->status = 0; // soft delete
		$product->save();

		\App\Models\Inventory\ProductPricing::where('idtbl_products', $id)->update(['status' => 0]);
		\App\Models\Inventory\ProductPurchasing::where('idtbl_products', $id)->update(['status' => 0]);
		\App\Models\Inventory\ProductAdvanceDetails::where('idtbl_products', $id)->update(['status' => 0]);
		\DB::table('tbl_partners_master')->where('idtbl_products', $id)->update(['status' => 0]);

		// Redirect back with success message
		return redirect()->back()->with('success', 'Product deleted successfully.');
	}

	public function deleteAuditLog(Request $request)
	{
		if (!Session::get('loggedin')) {
			return response()->json(['success' => false, 'message' => 'Not authenticated'], 401);
		}

		$request->validate([
			'log_id' => 'required|integer'
		]);

		\DB::table('tbl_audit_logs')
			->where('idtbl_audit_logs', $request->log_id)
			->update([
				'status' => 0,
				'updateuser' => Session::get('userid'),
				'updatedatetime' => now()
			]);

		return response()->json(['success' => true, 'message' => 'Log deleted successfully']);
	}

	public function getProductDetails($id)
	{
		if (!Session::get('loggedin')) {
			return response()->json(['success' => false, 'message' => 'Not authenticated'], 401);
		}

		$product = \DB::table('tbl_products')
			->leftJoin('tbl_product_types', 'tbl_products.idtbl_product_types', '=', 'tbl_product_types.idtbl_product_types')
			->leftJoin('tbl_varieties', 'tbl_products.idtbl_varieties', '=', 'tbl_varieties.idtbl_varieties')
			->leftJoin('tbl_colors', 'tbl_products.idtbl_colors', '=', 'tbl_colors.idtbl_colors')
			->leftJoin('tbl_color_grade', 'tbl_products.idtbl_color_grade', '=', 'tbl_color_grade.idtbl_color_grade')
			->leftJoin('tbl_shapes', 'tbl_products.idtbl_shapes', '=', 'tbl_shapes.idtbl_shapes')
			->leftJoin('tbl_cuts', 'tbl_products.idtbl_cuts', '=', 'tbl_cuts.idtbl_cuts')
			->leftJoin('tbl_treatments', 'tbl_products.idtbl_treatments', '=', 'tbl_treatments.idtbl_treatments')
			->leftJoin('tbl_origins', 'tbl_products.idtbl_origins', '=', 'tbl_origins.idtbl_origins')
			->leftJoin('tbl_storage_locations', 'tbl_products.idtbl_storage_locations', '=', 'tbl_storage_locations.idtbl_storage_locations')
			->leftJoin('tbl_tray_box', 'tbl_products.idtbl_tray_box', '=', 'tbl_tray_box.idtbl_tray_box')
			->where('tbl_products.idtbl_products', $id)
			->select(
				'tbl_products.*',
				'tbl_product_types.name as category_name',
				'tbl_varieties.name as variety_name',
				'tbl_colors.color_name',
				'tbl_color_grade.grade_name as color_grade_name',
				'tbl_shapes.name as shape_name',
				'tbl_cuts.name as cut_name',
				'tbl_treatments.treatment_name',
				'tbl_origins.origin_name',
				'tbl_storage_locations.location_name',
				'tbl_tray_box.tray_box_number as tray_box_name'
			)
			->first();

		if (!$product) {
			return response()->json(['success' => false, 'message' => 'Product not found'], 404);
		}

		$pricing = \DB::table('tbl_product_pricing')->where('idtbl_products', $id)->first();

		$purchasing = \DB::table('tbl_product_purchasing')
			->leftJoin('tbl_suppliers', 'tbl_product_purchasing.idtbl_suppliers', '=', 'tbl_suppliers.idtbl_suppliers')
			->leftJoin('tbl_ownership_type', 'tbl_product_purchasing.idtbl_ownership_type', '=', 'tbl_ownership_type.idtbl_ownership_type')
			->where('tbl_product_purchasing.idtbl_products', $id)
			->select('tbl_product_purchasing.*', 'tbl_suppliers.supplier_name', 'tbl_suppliers.contact_name', 'tbl_ownership_type.ownership_type_name')
			->first();

		$partners = [];
		if ($purchasing) {
			$master = \DB::table('tbl_partners_master')
				->leftJoin('tbl_partners', 'tbl_partners_master.idtbl_partners', '=', 'tbl_partners.idtbl_partners')
				->where('idtbl_product_purchasing', $purchasing->idtbl_product_purchasing ?? null)
				->select('tbl_partners_master.*', 'tbl_partners.partner_name')
				->first();

			if ($master) {
				$partners[] = [
					'name' => 'My Company',
					'ownership' => $master->ownership_percentage,
					'profit' => $master->profit_share_percentage
				];

				$details = \DB::table('tbl_partners_details')
					->leftJoin('tbl_partners', 'tbl_partners_details.idtbl_partners', '=', 'tbl_partners.idtbl_partners')
					->where('idtbl_partners_master', $master->idtbl_partners_master)
					->select('tbl_partners_details.*', 'tbl_partners.partner_name')
					->get();

				foreach ($details as $d) {
					$partners[] = [
						'name' => $d->partner_name,
						'ownership' => $d->ownership_percentage,
						'profit' => $d->profit_share_percentage
					];
				}
			}
		}

		return response()->json([
			'success' => true,
			'data' => [
				'product' => $product,
				'pricing' => $pricing,
				'purchasing' => $purchasing,
				'partners' => $partners
			]
		]);
	}
	public function createDropdownValue(Request $request)
	{
		if (!Session::get('loggedin')) {
			return response()->json(['success' => false, 'message' => 'Not authenticated'], 401);
		}

		$request->validate([
			'table_name' => 'required|string',
			'value' => 'required|string'
		]);

		$table = $request->table_name;
		$value = $request->value;
		$productTypeId = Session::get('selected_product_type_id') ?: 1;

		$map = [
			'tbl_sub_categories' => ['pk' => 'idtbl_sub_categories', 'name' => 'sub_category_name', 'has_pt' => true],
			'tbl_varieties' => ['pk' => 'idtbl_varieties', 'name' => 'name', 'has_pt' => true],
			'tbl_colors' => ['pk' => 'idtbl_colors', 'name' => 'color_name', 'has_pt' => true],
			'tbl_shapes' => ['pk' => 'idtbl_shapes', 'name' => 'name', 'has_pt' => true],
			'tbl_cuts' => ['pk' => 'idtbl_cuts', 'name' => 'name', 'has_pt' => true],
			'tbl_treatments' => ['pk' => 'idtbl_treatments', 'name' => 'treatment_name', 'has_pt' => true],
			'tbl_origins' => ['pk' => 'idtbl_origins', 'name' => 'origin_name', 'has_pt' => true],
			'tbl_color_grade' => ['pk' => 'idtbl_color_grade', 'name' => 'grade_name', 'has_pt' => true],
			'tbl_cuttinggrade' => ['pk' => 'idtbl_cuttinggrade', 'name' => 'cuttinggradename', 'has_pt' => true],
			'tbl_clarity_grade' => ['pk' => 'idtbl_clarity_grade', 'name' => 'clarity_grade_name', 'has_pt' => true],
			'tbl_storage_locations' => ['pk' => 'idtbl_storage_locations', 'name' => 'location_name', 'has_pt' => false],
			'tbl_tray_box' => ['pk' => 'idtbl_tray_box', 'name' => 'tray_box_number', 'has_pt' => false],
			'tbl_suppliers' => ['pk' => 'idtbl_suppliers', 'name' => 'supplier_name', 'has_pt' => false],
			'tbl_ownership_type' => ['pk' => 'idtbl_ownership_type', 'name' => 'ownership_type_name', 'has_pt' => false],
			'tbl_partners' => ['pk' => 'idtbl_partners', 'name' => 'partner_name', 'has_pt' => false]
		];

		if (!array_key_exists($table, $map)) {
			return response()->json(['success' => false, 'message' => 'Invalid table'], 400);
		}

		$config = $map[$table];

		$data = [
			$config['name'] => $value,
			'status' => 1,
			'insertuser' => Session::get('userid') ?: 1,
			'insertdatetime' => now()
		];

		if ($config['has_pt']) {
			$data['idtbl_product_types'] = $productTypeId;
		}

		try {
			$id = \DB::table($table)->insertGetId($data);

			return response()->json([
				'success' => true,
				'id' => $id,
				'value' => $value
			]);
		} catch (\Exception $e) {
			return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
		}
	}
}
