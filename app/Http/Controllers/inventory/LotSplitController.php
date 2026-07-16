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
        $initialLots = DB::table('tbl_products')
            ->leftJoin('tbl_product_pricing', 'tbl_products.idtbl_products', '=', 'tbl_product_pricing.idtbl_products')
            ->where('tbl_products.status', 1)
            ->where('tbl_products.inventory_type', 'lot')
            ->select(
                'tbl_products.idtbl_products as id',
                'tbl_products.sku_number',
                'tbl_products.product_title',
                'tbl_product_pricing.quantity',
                'tbl_product_pricing.weight as weight_ct',
                'tbl_product_pricing.total_cost',
                'tbl_product_pricing.cost_per_unit'
            )
            ->orderBy('tbl_products.idtbl_products', 'desc')
            ->limit(5)
            ->get();

        $lotSplits = DB::table('tbl_lot_split')
            ->leftJoin('tbl_products as parent', 'tbl_lot_split.parent_product_id', '=', 'parent.idtbl_products')
            ->leftJoin('tbl_products as child', 'tbl_lot_split.child_product_id', '=', 'child.idtbl_products')
            ->select(
                'tbl_lot_split.*',
                'parent.sku_number as parent_sku',
                'parent.product_title as parent_title',
                'child.sku_number as child_sku',
                'child.product_title as child_title'
            )
            ->orderBy('tbl_lot_split.id', 'desc')
            ->limit(100)
            ->get();

        return view('inventory.lotsplit', compact('initialLots', 'lotSplits'));
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
            $parentQty = $parentPricing ? $parentPricing->quantity : 0;
            $parentWeight = $parentPricing ? $parentPricing->weight : 0;
            
            // Calculate totals from splits
            $totalSplitQty = 0;
            $totalSplitWeight = 0;
            $totalSplitCost = 0;

            foreach ($splits as $split) {
                $totalSplitQty += $split['quantity'];
                $totalSplitWeight += $split['weight_ct'];
                $totalSplitCost += $split['cost'];
            }

            // Validation: Ensure split totals match the parent lot
            if (
                $totalSplitQty != $parentQty || 
                abs($totalSplitWeight - $parentWeight) > 0.01 || 
                abs($totalSplitCost - $parentCost) > 0.01
            ) {
                return response()->json([
                    'success' => false, 
                    'message' => "Split totals must exactly match parent lot totals. Parent: Qty $parentQty, Wt $parentWeight, Cost $parentCost. Split: Qty $totalSplitQty, Wt $totalSplitWeight, Cost $totalSplitCost."
                ]);
            }

            // Mark Parent as Inactive and Out of Stock (quantity is tracked in pricing)
            $parentProduct->status = 0;
            $parentProduct->inventorystatus = 3; // Archived
            $parentProduct->save();

            // Zero out parent quantity in pricing table
            DB::table('tbl_product_pricing')->where('idtbl_products', $parentId)->update([
                'quantity' => 0
            ]);

            // Create Production Sheet
            $productionSheetId = DB::table('tbl_production_sheets')->insertGetId([
                'sheet_number' => 'SPLIT-' . date('YmdHis'),
                'idtbl_production_types' => 1, // Re-assortment
                'status' => 1,
                'insertdatetime' => Carbon::now(),
                'insertuser' => auth()->id() ?? 1,
            ]);

            $splitIndex = 1;

            // Create Child Products
            foreach ($splits as $split) {
                $child = $parentProduct->replicate();
                
                // Get next SKU based on parent SKU
                $child->sku_number = $parentProduct->sku_number . '-' . $splitIndex;
                $splitIndex++;
                
                $child->inventory_type = $split['quantity'] > 1 ? 'lot' : 'individual';
                $child->status = 1;
                $child->inventorystatus = 1; // In stock
                $child->save();

                $childId = $child->idtbl_products;

                // Copy Pricing and update
                if ($parentPricing) {
                    $newPricing = (array) $parentPricing;
                    unset($newPricing['idtbl_product_pricing']); // remove auto-increment
                    $newPricing['idtbl_products'] = $childId;
                    $newPricing['quantity'] = $split['quantity'];
                    $newPricing['weight'] = $split['weight_ct'];
                    $newPricing['total_cost'] = $split['cost'];
                    $newPricing['cost_per_unit'] = $split['quantity'] > 0 ? $split['cost'] / $split['quantity'] : 0;
                    DB::table('tbl_product_pricing')->insert($newPricing);
                }

                // Copy other related tables (Purchasing, Advance) if needed
                $parentPurchasing = DB::table('tbl_product_purchasing')->where('idtbl_products', $parentId)->first();
                if ($parentPurchasing) {
                    $newPurchasing = (array) $parentPurchasing;
                    unset($newPurchasing['idtbl_product_purchasing']); // remove auto-increment
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

    public function updateSku(Request $request)
    {
        $request->validate([
            'id' => 'required|integer',
            'sku_number' => 'required|string|max:100',
        ]);

        try {
            // Check if SKU already exists in other products
            $exists = Product::where('sku_number', $request->sku_number)
                             ->where('idtbl_products', '!=', $request->id)
                             ->exists();
            
            if ($exists) {
                return response()->json(['success' => false, 'message' => 'This SKU is already taken by another product.']);
            }

            $product = Product::findOrFail($request->id);
            $product->sku_number = $request->sku_number;
            $product->save();

            return response()->json(['success' => true, 'message' => 'SKU updated successfully.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
        }
    }
}
