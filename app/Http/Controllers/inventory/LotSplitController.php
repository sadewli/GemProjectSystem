<?php

namespace App\Http\Controllers\inventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Inventory\Product;
use Carbon\Carbon;

class LotSplitController extends Controller
{
    public function index()
    {
        return view('inventory.lotsplit');
    }

    public function searchLot(Request $request)
    {
        $query = $request->input('q');
        $lots = DB::table('tbl_products')
            ->leftJoin('tbl_product_pricing', 'tbl_products.idtbl_products', '=', 'tbl_product_pricing.idtbl_products')
            ->where('tbl_products.status', 1)
            ->where('tbl_products.inventory_type', 'lot')
            ->when(!empty($query), function ($q) use ($query) {
                return $q->where(function($subQ) use ($query) {
                    $subQ->where('tbl_products.sku_number', 'like', "%{$query}%")
                         ->orWhere('tbl_products.product_title', 'like', "%{$query}%");
                });
            })
            ->select(
                'tbl_products.idtbl_products as id',
                'tbl_products.sku_number',
                'tbl_products.product_title',
                'tbl_product_pricing.quantity',
                'tbl_product_pricing.weight as weight_ct',
                'tbl_product_pricing.total_cost',
                'tbl_product_pricing.cost_per_unit'
            )
            ->limit(10)
            ->get();

        return response()->json($lots);
    }

    public function store(Request $request)
    {
        $request->validate([
            'parent_product_id' => 'required|integer',
            'splits' => 'required|array|min:2',
            'splits.*.quantity' => 'required|integer|min:1',
            'splits.*.weight_ct' => 'required|numeric|min:0.01',
            'splits.*.cost' => 'required|numeric|min:0',
        ]);

        $parentId = $request->input('parent_product_id');
        $splits = $request->input('splits');

        DB::beginTransaction();

        try {
            $parentProduct = Product::where('idtbl_products', $parentId)
                ->where('status', 1)
                ->where('inventory_type', 'lot')
                ->firstOrFail();

            $parentPricing = DB::table('tbl_product_pricing')->where('idtbl_products', $parentId)->first();
            $parentCost = $parentPricing ? $parentPricing->total_cost : 0;

            // Reconciliation Check
            $totalSplitQty = 0;
            $totalSplitWeight = 0;
            $totalSplitCost = 0;

            foreach ($splits as $split) {
                $totalSplitQty += $split['quantity'];
                $totalSplitWeight += $split['weight_ct'];
                $totalSplitCost += $split['cost'];
            }

            if (
                $totalSplitQty != $parentProduct->quantity || 
                abs($totalSplitWeight - $parentProduct->weight_ct) > 0.01 || 
                abs($totalSplitCost - $parentCost) > 0.01
            ) {
                return response()->json(['success' => false, 'message' => 'Split totals must exactly match parent lot totals.']);
            }

            // Mark Parent as Inactive and Out of Stock
            $parentProduct->status = 0;
            $parentProduct->inventorystatus = 2; // Out of stock
            $parentProduct->quantity = 0;
            $parentProduct->save();

            // Create Production Sheet
            $productionSheetId = DB::table('tbl_production_sheets')->insertGetId([
                'sheet_number' => 'SPLIT-' . date('YmdHis'),
                'status' => 'completed',
                'date_created' => Carbon::now(),
                'created_by' => auth()->id() ?? 1,
            ]);

            // Create Child Products
            foreach ($splits as $split) {
                $child = $parentProduct->replicate();
                
                // Get next SKU
                $typePrefix = DB::table('tbl_product_types')->where('idtbl_product_types', $child->idtbl_product_types)->first();
                $prefix = $typePrefix ? $typePrefix->skuname : 'SPT';
                
                $counter = DB::table('tbl_sku_counters')->where('idtbl_product_types', $child->idtbl_product_types)->value('current_number');
                if (!$counter) {
                    $counter = 1;
                    DB::table('tbl_sku_counters')->insert(['idtbl_product_types' => $child->idtbl_product_types, 'current_number' => $counter]);
                } else {
                    $counter++;
                    DB::table('tbl_sku_counters')->where('idtbl_product_types', $child->idtbl_product_types)->update(['current_number' => $counter]);
                }
                
                $child->sku_number = $prefix . str_pad($counter, 2, '0', STR_PAD_LEFT);
                $child->quantity = $split['quantity'];
                $child->weight_ct = $split['weight_ct'];
                $child->inventory_type = $split['quantity'] > 1 ? 'lot' : 'individual';
                $child->status = 1;
                $child->inventorystatus = 1; // In stock
                $child->save();

                $childId = $child->idtbl_products;

                // Copy Pricing and update
                if ($parentPricing) {
                    $newPricing = (array) $parentPricing;
                    unset($newPricing['id']); // remove auto-increment
                    $newPricing['idtbl_products'] = $childId;
                    $newPricing['total_cost'] = $split['cost'];
                    $newPricing['unit_cost'] = $split['quantity'] > 0 ? $split['cost'] / $split['quantity'] : 0;
                    DB::table('tbl_product_pricing')->insert($newPricing);
                }

                // Copy other related tables (Purchasing, Advance) if needed
                $parentPurchasing = DB::table('tbl_product_purchasing')->where('idtbl_products', $parentId)->first();
                if ($parentPurchasing) {
                    $newPurchasing = (array) $parentPurchasing;
                    unset($newPurchasing['id']);
                    $newPurchasing['idtbl_products'] = $childId;
                    DB::table('tbl_product_purchasing')->insert($newPurchasing);
                }

                // Insert into tbl_lot_split
                DB::table('tbl_lot_split')->insert([
                    'parent_product_id' => $parentId,
                    'child_product_id' => $childId,
                    'split_quantity' => $split['quantity'],
                    'split_weight_ct' => $split['weight_ct'],
                    'split_cost' => $split['cost'],
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);

                // Insert into tbl_track_skuid
                DB::table('tbl_track_skuid')->insert([
                    'original_product_id' => $parentId,
                    'new_product_id' => $childId,
                    'production_sheet_id' => $productionSheetId,
                    'change_type' => 'lot_split',
                    'changed_by' => auth()->id() ?? 1,
                    'changed_date' => Carbon::now(),
                ]);
            }

            DB::commit();

            return response()->json(['success' => true, 'message' => 'Lot successfully split into ' . count($splits) . ' products.']);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
        }
    }
}
