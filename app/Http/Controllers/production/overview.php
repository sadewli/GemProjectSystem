<?php

namespace App\Http\Controllers\production;

use App\Http\Controllers\Controller;
use App\Models\ProductionSheet;
use App\Models\ProductionSheetHistory;
use App\Models\ProductionSheetItem;
use App\Models\ProductionSheetMedia;
use App\Models\ProductionType;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class overview extends Controller
{
    // ────────────────────────────────────────────────────────────────────────────
    // INDEX – show the overview page
    // ────────────────────────────────────────────────────────────────────────────
    public function index(Request $request)
    {
        // ── Production types from DB ─────────────────────────────────────────
        $productionTypes = ProductionType::where('status', 1)
            ->orderBy('idtbl_production_types')
            ->get()
            ->map(fn($t) => [
                'value' => $t->type_value,
                'label' => $t->type_name,
            ])
            ->toArray();

        // ── Suppliers from DB (all active suppliers) ──────────────────────────────
        $suppliersList = \App\Models\Supplier::where('status', 1)
            ->orderBy('supplier_name')
            ->get(['idtbl_suppliers', 'supplier_name']);

        $suppliers   = [];
        $suppliers[] = ['value' => 'all', 'label' => 'All'];

        foreach ($suppliersList as $s) {
            $suppliers[] = [
                'value' => $s->idtbl_suppliers,
                'label' => $s->supplier_name,
            ];
        }

        // ── Tab counts & VEF totals from DB ──────────────────────────────────
        $rawCounts = ProductionSheet::select('status', DB::raw('COUNT(*) as cnt'))
            ->groupBy('status')
            ->pluck('cnt', 'status');

        $rawTotals = ProductionSheet::select('status', DB::raw('SUM(original_total_cost) as tot'))
            ->groupBy('status')
            ->pluck('tot', 'status');

        $statusKeys = ['draft', 'in_production', 'completed', 'deleted'];

        $total_all = 0;
        $count_all = 0;

        foreach ($statusKeys as $key) {
            $total_all += $rawTotals[$key] ?? 0;
            $count_all += $rawCounts[$key] ?? 0;
        }

        $counts = [
            'all'           => $count_all,
            'in_production' => $rawCounts['in_production'] ?? 0,
            'completed'     => $rawCounts['completed']     ?? 0,
            'deleted'       => $rawCounts['deleted']       ?? 0,
        ];

        $totals = [
            'all'           => number_format($total_all, 2) . ' VEF',
            'in_production' => number_format($rawTotals['in_production'] ?? 0, 2) . ' VEF',
            'completed'     => number_format($rawTotals['completed']     ?? 0, 2) . ' VEF',
            'deleted'       => number_format($rawTotals['deleted']       ?? 0, 2) . ' VEF',
        ];

        return view('production.overview', compact(
            'productionTypes',
            'suppliers',
            'counts',
            'totals'
        ));
    }

    // ────────────────────────────────────────────────────────────────────────────
    // STORE – save a new production sheet
    // ────────────────────────────────────────────────────────────────────────────
    public function store(Request $request)
    {
        $request->validate([
            'production_type'     => 'required|string',
            'production_category' => 'required|string',
        ]);

        DB::beginTransaction();

        try {
            // Resolve production type FK
            $productionType = ProductionType::where('type_value', $request->production_type)
                ->where('status', 1)
                ->firstOrFail();

            // Resolve creator FK (fallback to logged-in user)
            $creatorId = auth()->id();

            // Resolve supplier FK
            $supplierId = null;
            if ($request->filled('supplier_id') && is_numeric($request->supplier_id)) {
                $supplierId = (int) $request->supplier_id;
            }

            // Auto-generate sheet number
            $sheetNumber = ProductionSheet::generateSheetNumber();

            // Determine status
            $status = $request->input('status', 'in_production');

            // Create the sheet
            $sheet = ProductionSheet::create([
                'sheet_number'           => $sheetNumber,
                'idtbl_production_types' => $productionType->idtbl_production_types,
                'production_category'    => $request->production_category,
                'reference'              => $request->input('reference'),
                'due_date'               => $request->input('due_date') ?: null,
                'creator_id'             => $creatorId,
                'supplier_id'            => $supplierId,
                'original_quantity'      => $request->input('original_quantity') ?: null,
                'original_weight'        => $request->input('original_weight') ?: null,
                'weight_unit'            => $request->input('weight_unit', 'ct'),
                'original_total_cost'    => $request->input('original_total_cost') ?: null,
                'currency'               => $request->input('currency', 'VEF'),
                'cost_per_unit'          => $request->input('cost_per_unit') ?: null,
                'total_cost'             => $request->input('total_cost') ?: null,
                'my_cost_per_unit'       => $request->input('my_cost_per_unit') ?: null,
                'my_total_cost'          => $request->input('my_total_cost') ?: null,
                'expected_output_weight' => $request->input('expected_output_weight') ?: null,
                'output_weight_unit'     => $request->input('output_weight_unit', 'ct'),
                'expected_output_quantity'=> $request->input('expected_output_quantity') ?: null,
                'loss_percent'           => $request->filled('loss_percent')
                    ? (float) str_replace(['%', ' '], '', $request->input('loss_percent'))
                    : null,
                'loss_weight'            => $request->input('loss_weight') ?: null,
                'discrepancy_reason'     => $request->input('discrepancy_reason') ?: null,
                'notes'                  => $request->input('notes'),
                'status'                 => $status,
                'insertuser'             => auth()->id(),
                'insertdatetime'         => now(),
            ]);

            // ── Save submitted items to tbl_production_sheet_items ────────────
            $itemsInput = $request->input('items', []);
            if (is_array($itemsInput) && count($itemsInput) > 0) {
                $itemRows = [];
                $now      = now();
                foreach ($itemsInput as $item) {
                    $sku       = trim($item['sku']         ?? '');
                    $desc      = trim($item['description'] ?? '');
                    $productId = trim($item['product_id']  ?? '');
                    if ($sku === '' && $desc === '') continue; // skip blank rows

                    $itemRows[] = [
                        'idtbl_production_sheets' => $sheet->idtbl_production_sheets,
                        'idtbl_products'          => $productId ?: null,
                        'sku_number'              => $sku ?: null,
                        'description'             => $desc ?: null,
                        'quantity'                => isset($item['quantity'])    && $item['quantity']    !== '' ? (int)   $item['quantity']    : null,
                        'weight'                  => isset($item['weight'])      && $item['weight']      !== '' ? (float) $item['weight']      : null,
                        'weight_unit'             => $item['weight_unit'] ?? 'ct',
                        'cost'                    => isset($item['cost'])        && $item['cost']        !== '' ? (float) $item['cost']        : null,
                        'status'                  => 1,
                        'insertuser'              => auth()->id(),
                        'insertdatetime'          => $now,
                    ];
                }
                if (!empty($itemRows)) {
                    ProductionSheetItem::insert($itemRows);
                }
            }

            // Log history entry
            $itemCount = count($itemRows ?? []);
            ProductionSheetHistory::create([
                'idtbl_production_sheets' => $sheet->idtbl_production_sheets,
                'action_date'             => now()->toDateString(),
                'action_time'             => now()->toTimeString(),
                'action_user'             => auth()->id(),
                'action'                  => 'Created',
                'note'                    => 'Production sheet ' . $sheetNumber . ' created with status: ' . $status
                                             . ($itemCount > 0 ? ' (' . $itemCount . ' item(s) added)' : ''),
                'insertdatetime'          => now(),
            ]);

            DB::commit();

            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success'      => true,
                    'sheet_id'     => $sheet->idtbl_production_sheets,
                    'sheet_number' => $sheetNumber,
                ]);
            }

            return redirect()
                ->route('production.overview.index')
                ->with('success', 'Production sheet ' . $sheetNumber . ' created successfully.');

        } catch (\Throwable $e) {
            DB::rollBack();

            if ($request->expectsJson() || $request->ajax()) {
                return response()->json(['success' => false, 'message' => $e->getMessage()], 422);
            }

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Failed to create production sheet: ' . $e->getMessage());
        }
    }

    // ────────────────────────────────────────────────────────────────────────────
    // DATA – AJAX endpoint: return sheets filtered by status / type / date / creator
    // ────────────────────────────────────────────────────────────────────────────
    public function data(Request $request)
    {
        $query = ProductionSheet::with(['productionType', 'insertUser', 'media', 'supplier'])
            ->select('tbl_production_sheets.*');

        // Filter: status tab
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        // Filter: production type
        if ($request->filled('production_type')) {
            $query->whereHas('productionType', function ($q) use ($request) {
                $q->where('type_value', $request->production_type);
            });
        }

        // Filter: date range
        if ($request->filled('date_from')) {
            $query->whereDate('insertdatetime', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('insertdatetime', '<=', $request->date_to);
        }

        // Filter: supplier
        if ($request->filled('supplier') && $request->supplier !== 'all') {
            if (is_numeric($request->supplier)) {
                $query->where('supplier_id', $request->supplier);
            }
        }

        // Search
        if ($request->filled('search')) {
            $q = $request->search;
            $query->where(function ($sub) use ($q) {
                $sub->where('sheet_number', 'like', "%{$q}%")
                    ->orWhere('reference', 'like', "%{$q}%");
            });
        }

        // Paginate
        $perPage = (int) $request->input('per_page', 50);
        $sheets  = $query->orderByDesc('insertdatetime')->paginate($perPage);

        $rows = $sheets->map(function ($s) {
            $photos = $s->media->where('file_type', 'photo')->map(function ($m) {
                return [
                    'id'            => $m->idtbl_production_sheet_media,
                    'original_name' => $m->original_name,
                    'url'           => Storage::url($m->file_path),
                ];
            })->values();

            $documents = $s->media->where('file_type', 'document')->map(function ($m) {
                return [
                    'id'            => $m->idtbl_production_sheet_media,
                    'original_name' => $m->original_name,
                    'url'           => Storage::url($m->file_path),
                ];
            })->values();

            return [
                'id'                 => $s->idtbl_production_sheets,
                'sheet_number'       => $s->sheet_number,
                'production_type'    => $s->productionType?->type_name ?? '—',
                'reference'          => $s->reference ?? '—',
                'status'             => $s->status,
                'creation_date'      => $s->insertdatetime?->format('d M Y') ?? '—',
                'due_date'           => $s->due_date?->format('d M Y') ?? '—',
                'closed_date'        => $s->closed_date?->format('d M Y') ?? '—',
                'supplier'           => $s->supplier?->supplier_name ?? '—',
                'original_quantity'  => $s->original_quantity ?? '—',
                'original_weight'    => $s->original_weight
                    ? number_format($s->original_weight, 2) . ' ' . $s->weight_unit
                    : '—',
                'original_total_cost'=> $s->original_total_cost
                    ? number_format($s->original_total_cost, 2) . ' ' . $s->currency
                    : '—',
                'discrepancy_reason' => $s->discrepancy_reason ?? '—',
                'photos'             => $photos,
                'documents'          => $documents,
            ];
        });

        return response()->json([
            'data'         => $rows,
            'total'        => $sheets->total(),
            'current_page' => $sheets->currentPage(),
            'last_page'    => $sheets->lastPage(),
        ]);
    }

    // ────────────────────────────────────────────────────────────────────────────
    // COUNTS – AJAX endpoint: refresh tab counts & totals
    // ────────────────────────────────────────────────────────────────────────────
    public function counts()
    {
        $rawCounts = ProductionSheet::select('status', DB::raw('COUNT(*) as cnt'))
            ->groupBy('status')
            ->pluck('cnt', 'status');

        $rawTotals = ProductionSheet::select('status', DB::raw('SUM(original_total_cost) as tot'))
            ->groupBy('status')
            ->pluck('tot', 'status');

        $count_all = $rawCounts->sum();
        $total_all = $rawTotals->sum();

        return response()->json([
            'counts' => [
                'all'           => $count_all,
                'in_production' => $rawCounts['in_production'] ?? 0,
                'completed'     => $rawCounts['completed']     ?? 0,
                'deleted'       => $rawCounts['deleted']       ?? 0,
            ],
            'totals' => [
                'all'           => number_format($total_all, 2) . ' VEF',
                'in_production' => number_format($rawTotals['in_production'] ?? 0, 2) . ' VEF',
                'completed'     => number_format($rawTotals['completed']     ?? 0, 2) . ' VEF',
                'deleted'       => number_format($rawTotals['deleted']       ?? 0, 2) . ' VEF',
            ],
        ]);
    }

    // ────────────────────────────────────────────────────────────────────────────
    // UPLOAD MEDIA – AJAX: upload photos / documents for a production sheet
    // ────────────────────────────────────────────────────────────────────────────
    public function uploadMedia(Request $request)
    {
        $request->validate([
            'sheet_id'  => 'required|integer|exists:tbl_production_sheets,idtbl_production_sheets',
            'file_type' => 'required|in:photo,document',
            'file'      => 'required|file|max:20480', // max 20 MB
        ]);

        $file      = $request->file('file');
        $fileType  = $request->input('file_type');
        $sheetId   = (int) $request->input('sheet_id');
        $remarks   = $request->input('remarks');

        // Build a unique stored filename
        $ext          = $file->getClientOriginalExtension();
        $storedName   = Str::uuid() . '.' . $ext;
        $folder       = 'production_media/' . $sheetId . '/' . $fileType . 's';

        // Store in storage/app/public/...
        $path = $file->storeAs($folder, $storedName, 'public');

        $media = ProductionSheetMedia::create([
            'idtbl_production_sheets' => $sheetId,
            'file_type'               => $fileType,
            'file_name'               => $storedName,
            'original_name'           => $file->getClientOriginalName(),
            'file_path'               => $path,
            'mime_type'               => $file->getMimeType(),
            'file_size'               => $file->getSize(),
            'remarks'                 => $remarks ?: null,
            'insertuser'              => auth()->id(),
            'insertdatetime'          => now(),
        ]);

        return response()->json([
            'success' => true,
            'media'   => [
                'id'            => $media->idtbl_production_sheet_media,
                'file_type'     => $media->file_type,
                'original_name' => $media->original_name,
                'file_size'     => $media->file_size_human,
                'mime_type'     => $media->mime_type,
                'url'           => Storage::url($media->file_path),
                'inserted_at'   => $media->insertdatetime?->format('d M Y H:i'),
            ],
        ]);
    }

    // ────────────────────────────────────────────────────────────────────────────
    // DELETE MEDIA – AJAX: remove a single media record + its stored file
    // ────────────────────────────────────────────────────────────────────────────
    public function deleteMedia(Request $request, int $mediaId)
    {
        $media = ProductionSheetMedia::findOrFail($mediaId);

        // Delete the physical file from storage
        if (Storage::disk('public')->exists($media->file_path)) {
            Storage::disk('public')->delete($media->file_path);
        }

        $media->delete();

        return response()->json(['success' => true]);
    }

    // ────────────────────────────────────────────────────────────────────────────
    // SHOW – AJAX endpoint: get a single production sheet details with relations
    // ────────────────────────────────────────────────────────────────────────────
    public function show(int $id)
    {
        $sheet = ProductionSheet::with(['productionType', 'insertUser', 'items', 'media', 'supplier'])
            ->findOrFail($id);

        $photos = $sheet->media->where('file_type', 'photo')->map(function ($m) {
            return [
                'id'            => $m->idtbl_production_sheet_media,
                'original_name' => $m->original_name,
                'url'           => Storage::url($m->file_path),
                'file_size'     => $m->file_size_human,
            ];
        })->values();

        $documents = $sheet->media->where('file_type', 'document')->map(function ($m) {
            return [
                'id'            => $m->idtbl_production_sheet_media,
                'original_name' => $m->original_name,
                'url'           => Storage::url($m->file_path),
                'file_size'     => $m->file_size_human,
            ];
        })->values();

        $items = $sheet->items->map(function ($i) {
            return [
                'id'          => $i->idtbl_production_sheet_items,
                'sku'         => $i->sku_number ?? '—',
                'description' => $i->description ?? '—',
                'quantity'    => $i->quantity ?? '—',
                'weight'      => $i->weight ? number_format($i->weight, 4) . ' ' . $i->weight_unit : '—',
                'cost'        => $i->cost ? number_format($i->cost, 2) : '—',
            ];
        });

        return response()->json([
            'success' => true,
            'sheet'   => [
                'id'                 => $sheet->idtbl_production_sheets,
                'sheet_number'       => $sheet->sheet_number,
                'production_type'    => $sheet->productionType?->type_name ?? '—',
                'reference'          => $sheet->reference ?? '—',
                'status'             => $sheet->status,
                'creation_date'      => $sheet->insertdatetime?->format('d M Y') ?? '—',
                'due_date'           => $sheet->due_date?->format('d M Y') ?? '—',
                'closed_date'        => $sheet->closed_date?->format('d M Y') ?? '—',
                'creator'            => $sheet->insertUser?->name ?? '—',
                'supplier'           => $sheet->supplier?->supplier_name ?? '—',
                'original_quantity'  => $sheet->original_quantity ?? '—',
                'original_weight'    => $sheet->original_weight
                    ? number_format($sheet->original_weight, 2) . ' ' . $sheet->weight_unit
                    : '—',
                'original_total_cost'=> $sheet->original_total_cost
                    ? number_format($sheet->original_total_cost, 2) . ' ' . $sheet->currency
                    : '—',
                'notes'              => $sheet->notes ?? '—',
                'discrepancy_reason' => $sheet->discrepancy_reason ?? '—',
                'photos'             => $photos,
                'documents'          => $documents,
                'items'              => $items,
            ]
        ]);
    }

    // ────────────────────────────────────────────────────────────────────────────
    // PRODUCT SEARCH – AJAX autocomplete for the Items tab SKU dropdown
    // GET /production/product-search?q=<term>
    // Returns products matching sku_code or title from tbl_products (inventory)
    // ────────────────────────────────────────────────────────────────────────────
    public function productSearch(Request $request)
    {
        $q = trim($request->query('q', ''));

        if (strlen($q) < 1) {
            return response()->json(['results' => []]);
        }

        // Join tbl_product_pricing to get available stock quantity and weight
        $rows = DB::table('tbl_products as p')
            ->leftJoin('tbl_product_pricing as pr', 'pr.idtbl_products', '=', 'p.idtbl_products')
            ->leftJoin('tbl_weight_units as wu', 'wu.idtbl_weight_units', '=', 'pr.idtbl_weight_units')
            ->where('p.status', 1)
            ->where(function ($query) use ($q) {
                $query->where('p.sku_number', 'like', '%' . $q . '%')
                      ->orWhere('p.product_title', 'like', '%' . $q . '%');
            })
            ->select(
                'p.idtbl_products as id',
                'p.sku_number as sku',
                'p.product_title as description',
                DB::raw('COALESCE(pr.quantity, 0) as stock_qty'),
                DB::raw('COALESCE(pr.weight, 0) as stock_weight'),
                'wu.unit_name as stock_unit'
            )
            ->orderBy('p.sku_number')
            ->limit(30)
            ->get();

        // Format for Select2: { id, text, sku, description, stock_qty, stock_weight, stock_unit }
        $results = $rows->map(fn($r) => [
            'id'           => $r->id . ':::' . $r->sku,
            'text'         => $r->sku . ($r->description ? ' — ' . $r->description : ''),
            'sku'          => $r->sku,
            'description'  => $r->description ?? '',
            'stock_qty'    => (float) $r->stock_qty,
            'stock_weight' => (float) $r->stock_weight,
            'stock_unit'   => $r->stock_unit ?? 'ct',
        ]);

        return response()->json(['results' => $results]);
    }
}

