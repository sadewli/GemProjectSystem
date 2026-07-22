<?php

namespace App\Http\Controllers;

use App\Models\Distributorgrn;
use App\Models\Distributorgrndetail;
use App\Models\Distributorpo;
use App\Models\Ditributorpodetails;
use App\Models\DistributorStock;
use App\Models\Distributor;
use App\Models\Product;
use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class DistributorGRNController extends Controller
{
    public function index()
    {
        // Generate new GRN number
        $grnNumber = $this->generateGRNNumber();

        return view('distributor.grn', compact('grnNumber'));
    }

    // Generate GRN Number
    private function generateGRNNumber()
    {
        $lastGRN = Distributorgrn::orderBy('idtbl_grn', 'desc')->first();

        if ($lastGRN) {
            $lastNumber = intval(substr($lastGRN->grn_no, 4));
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }

        return 'GRN-' . str_pad($newNumber, 6, '0', STR_PAD_LEFT);
    }

    // List GRNs
    public function list(Request $request)
    {
        if ($request->ajax()) {
            $grns = Distributorgrn::with('distributor')
                ->where('status', 1)
                ->orderBy('idtbl_grn', 'desc');

            return DataTables::of($grns)
                ->addIndexColumn()
                ->make(true);
        }
    }

    // Get Confirmed Purchase Orders
    public function getConfirmedPO(Request $request)
    {
        $search = $request->q;
        $page = $request->page ?? 1;
        $perPage = 10;

        $query = Distributorpo::with('distributor')
            ->where('confirmstatus', 1)
            ->where('completestatus', 1)
            ->where('grnissuestatus', 0)
            ->where('status', 1);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('order_no', 'like', "%{$search}%")
                    ->orWhereHas('distributor', function ($dq) use ($search) {
                        $dq->where('name', 'like', "%{$search}%");
                    });
            });
        }

        $total = $query->count();
        $pos = $query->skip(($page - 1) * $perPage)
            ->take($perPage)
            ->get();

        $results = $pos->map(function ($po) {
            return [
                'id' => $po->idtbl_porder,
                'text' => $po->order_no . ' - ' . $po->distributor->name . ' (' . $po->order_date . ')'
            ];
        });

        return response()->json([
            'results' => $results,
            'pagination' => [
                'more' => ($page * $perPage) < $total
            ]
        ]);
    }

    // Get Purchase Order Details
    public function getPODetails(Request $request)
    {
        try {
            $po = Distributorpo::with(['details.product', 'distributor'])
                ->findOrFail($request->po_id);

            $items = $po->details->map(function ($detail) {
                return [
                    'product_id' => $detail->product_id,
                    'product_name' => $detail->product->product_name,
                    'unitprice' => $detail->unitprice,
                    'saleprice' => $detail->saleprice,
                    'retailprice' => $detail->retailprice,
                    'qty' => $detail->qty,
                    'total' => $detail->total
                ];
            });

            return response()->json([
                'success' => true,
                'po' => $po,
                'items' => $items
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to load purchase order details'
            ], 500);
        }
    }

    // Store GRN
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $request->validate([
                'grn_date' => 'required|date',
                'po_id' => 'required|exists:tbl_distributor_porder,idtbl_porder',
                'invoice_num' => 'required|string',
                'delivery_num' => 'required|string',
                'items' => 'required|array'
            ]);

            // Get PO details
            $po = Distributorpo::findOrFail($request->po_id);

            $grnNumber = $this->generateGRNNumber();

            // Create GRN Header with placeholder batch number
            $grn = Distributorgrn::create([
                'grn_no' => $grnNumber,
                'date' => $request->grn_date,
                'total' => $request->total,
                'vatamount' => $request->vat_amount,
                'nettotal' => $request->net_total,
                'invoicenum' => $request->invoice_num,
                'dispatchnum' => $request->delivery_num,
                'batchno' => 'PENDING-' . $grnNumber,
                'porder_id' => $request->po_id,
                'distributor_id' => $po->distributor_id,
                'status' => 1,
                'confirm_status' => 0,
                'transfer_status' => 0,
                'updateuser' => Auth::id(),
                'updatedatetime' => now()
            ]);

            // Create GRN Details
            foreach ($request->items as $item) {
                Distributorgrndetail::create([
                    'date' => $request->grn_date,
                    'type' => 1,
                    'qty' => $item['quantity'],
                    'unitprice' => $item['unit_price'],
                    'saleprice' => $item['sale_price'],
                    'retailprice' => $item['retail_price'],
                    'total' => $item['total'],
                    'grn_id' => $grn->idtbl_grn,
                    'product_id' => $item['product_id'],
                    'status' => 1,
                    'insertdatetime' => now(),
                    'updateuser' => Auth::id(),
                    'updatedatetime' => now()
                ]);
            }

            // Update PO GRN Issue Status
            $po->grnissuestatus = 1;
            $po->updateuser = Auth::id();
            $po->updatedatetime = now();
            $po->save();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'GRN created successfully'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed to create GRN: ' . $e->getMessage()
            ], 500);
        }
    }

    // View GRN
    public function view(Request $request)
    {
        try {
            $grn = Distributorgrn::with('distributor')->findOrFail($request->id);

            $items = Distributorgrndetail::where('grn_id', $request->id)
                ->where('status', 1)
                ->with('product')
                ->get()
                ->map(function ($item) {
                    return [
                        'product_name' => $item->product->product_name ?? 'Unknown',
                        'unitprice' => $item->unitprice,
                        'qty' => $item->qty,
                        'total' => $item->total
                    ];
                });

            return response()->json([
                'success' => true,
                'grn' => $grn,
                'items' => $items
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to load GRN'
            ], 500);
        }
    }

    // Update GRN Status
    public function updateStatus(Request $request)
    {
        try {
            $grn = Distributorgrn::findOrFail($request->id);

            if ($request->action == 'confirm') {
                $grn->confirm_status = 1;
                $message = 'GRN confirmed successfully';
            }

            $grn->updateuser = Auth::id();
            $grn->updatedatetime = now();
            $grn->save();

            return response()->json([
                'success' => true,
                'message' => $message
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update GRN status'
            ], 500);
        }
    }

    // Transfer Stock to Distributor
    public function transferStock(Request $request)
    {
        DB::beginTransaction();
        try {
            $grn = Distributorgrn::findOrFail($request->grn_id);

            // Check if already transferred
            if ($grn->transfer_status == 1) {
                return response()->json([
                    'success' => false,
                    'message' => 'Stock already transferred'
                ], 400);
            }

            // Check if GRN is confirmed
            if ($grn->confirm_status == 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Please confirm GRN before transferring stock'
                ], 400);
            }

            // Get GRN details
            $grnDetails = Distributorgrndetail::where('grn_id', $grn->idtbl_grn)
                ->where('status', 1)
                ->get();

            $usedBatchNumbers = []; // Track all batch numbers used in this GRN

            foreach ($grnDetails as $detail) {
                $remainingQty = $detail->qty;

                // Get main stock batches for this product 
                $mainStockBatches = Stock::where('tbl_product_idtbl_product', $detail->product_id)
                    ->where('status', 1)
                    ->where('qty', '>', 0)
                    ->orderBy('insertdatetime', 'asc')
                    ->get();

                if ($mainStockBatches->sum('qty') < $remainingQty) {
                    DB::rollBack();

                    // Get product name for better error message
                    $product = Product::find($detail->product_id);
                    $productName = $product ? $product->product_name : "Product ID: {$detail->product_id}";

                    return response()->json([
                        'success' => false,
                        'message' => "Insufficient stock for {$productName}. Required: {$remainingQty}, Available: {$mainStockBatches->sum('qty')}"
                    ], 400);
                }

                // Transfer from each batch until quantity is fulfilled
                foreach ($mainStockBatches as $mainStock) {
                    if ($remainingQty <= 0) {
                        break;
                    }

                    // Track batch numbers used
                    if (!in_array($mainStock->batchno, $usedBatchNumbers)) {
                        $usedBatchNumbers[] = $mainStock->batchno;
                    }

                    // Calculate quantity to transfer from this batch
                    $qtyToTransfer = min($remainingQty, $mainStock->qty);

                    // Reduce quantity from main stock
                    $mainStock->qty -= $qtyToTransfer;
                    $mainStock->updatedatetime = now();
                    $mainStock->tbl_user_idtbl_user = Auth::id();
                    $mainStock->save();

                    // Check if distributor stock already exists with this main stock batch number
                    $existingStock = DistributorStock::where('batchno', $mainStock->batchno)
                        ->where('item_id', $detail->product_id)
                        ->where('tbl_distributor_idtbl_distributor', $grn->distributor_id)
                        ->where('status', 1)
                        ->first();

                    if ($existingStock) {
                        // Update existing distributor stock
                        $existingStock->batch_qty += $qtyToTransfer;
                        $existingStock->qty += $qtyToTransfer;
                        // Update prices from GRN detail
                        $existingStock->item_saleprice = $detail->saleprice;
                        $existingStock->item_bulkprice = $detail->unitprice;
                        $existingStock->tbl_user_idtbl_user = Auth::id();
                        $existingStock->update_time = now();
                        $existingStock->save();
                    } else {
                        // Create new distributor stock entry with main stock batch number
                        DistributorStock::create([
                            'batchno' => $mainStock->batchno, // Use main stock batch number directly
                            'item_id' => $detail->product_id,
                            'item_saleprice' => $detail->saleprice,
                            'item_bulkprice' => $detail->unitprice,
                            'batch_qty' => $qtyToTransfer,
                            'qty' => $qtyToTransfer,
                            'status' => 1,
                            'tbl_distributor_idtbl_distributor' => $grn->distributor_id,
                            'tbl_user_idtbl_user' => Auth::id(),
                            'insert_time' => now(),
                            'update_time' => now()
                        ]);
                    }

                    $remainingQty -= $qtyToTransfer;
                }
            }

            // Update GRN with all batch numbers used (comma-separated if multiple)
            $grn->batchno = implode(', ', array_unique($usedBatchNumbers));
            $grn->transfer_status = 1;
            $grn->updateuser = Auth::id();
            $grn->updatedatetime = now();
            $grn->save();

            DB::commit();

            $batchInfo = count($usedBatchNumbers) > 1
                ? 'Multiple batches: ' . implode(', ', array_unique($usedBatchNumbers))
                : 'Batch: ' . $usedBatchNumbers[0];

            return response()->json([
                'success' => true,
                'message' => "Stock transferred successfully to distributor inventory. {$batchInfo}",
                'batch_numbers' => array_unique($usedBatchNumbers)
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed to transfer stock: ' . $e->getMessage()
            ], 500);
        }
    }

    // Delete GRN
    public function delete(Request $request)
    {
        DB::beginTransaction();
        try {
            $grn = Distributorgrn::findOrFail($request->id);

            if ($grn->transfer_status == 1) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot delete GRN. Stock has already been transferred.'
                ], 400);
            }

            $grn->status = 0;
            $grn->updateuser = Auth::id();
            $grn->updatedatetime = now();
            $grn->save();

            Distributorgrndetail::where('grn_id', $grn->idtbl_grn)
                ->update([
                    'status' => 0,
                    'updateuser' => Auth::id(),
                    'updatedatetime' => now()
                ]);

            // Update PO GRN Issue Status
            $po = Distributorpo::find($grn->porder_id);
            if ($po) {
                $po->grnissuestatus = 0;
                $po->updateuser = Auth::id();
                $po->updatedatetime = now();
                $po->save();
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'GRN deleted successfully'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete GRN'
            ], 500);
        }
    }
}
