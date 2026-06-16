<?php

namespace App\Http\Controllers\production;

use App\Http\Controllers\Controller;
use App\Models\ProductionSheet;
use App\Models\ProductionSheetHistory;
use App\Models\ProductionSheetItem;
use App\Models\ProductionType;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

        // ── Creators from DB (all active users) ──────────────────────────────
        $users = User::active()
            ->orderBy('name')
            ->get(['idtbl_user', 'name']);

        $creators   = [];
        $creators[] = ['value' => 'all',          'label' => 'All'];
        $creators[] = ['value' => 'created-by-me', 'label' => 'Created by me'];

        foreach ($users as $u) {
            $creators[] = [
                'value' => $u->idtbl_user,
                'label' => $u->name,
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
            'creators',
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
            $creatorId = null;
            if ($request->filled('creator_id') && is_numeric($request->creator_id)) {
                $creatorId = (int) $request->creator_id;
            } else {
                $creatorId = auth()->id();
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
                'template'               => $request->input('template', 'default'),
                'reference'              => $request->input('reference'),
                'due_date'               => $request->input('due_date') ?: null,
                'creator_id'             => $creatorId,
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
                'loss_percent'           => $request->input('loss_percent') ?: null,
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
                    $sku  = trim($item['sku']         ?? '');
                    $desc = trim($item['description'] ?? '');
                    if ($sku === '' && $desc === '') continue; // skip blank rows

                    $itemRows[] = [
                        'idtbl_production_sheets' => $sheet->idtbl_production_sheets,
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

            return redirect()
                ->route('production.overview.index')
                ->with('success', 'Production sheet ' . $sheetNumber . ' created successfully.');

        } catch (\Throwable $e) {
            DB::rollBack();

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
        $query = ProductionSheet::with(['productionType', 'insertUser'])
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

        // Filter: creator
        if ($request->filled('creator') && $request->creator !== 'all') {
            if ($request->creator === 'created-by-me') {
                $query->where('insertuser', auth()->id());
            } elseif (is_numeric($request->creator)) {
                $query->where('creator_id', $request->creator);
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
            return [
                'id'                 => $s->idtbl_production_sheets,
                'sheet_number'       => $s->sheet_number,
                'production_type'    => $s->productionType?->type_name ?? '—',
                'reference'          => $s->reference ?? '—',
                'status'             => $s->status,
                'creation_date'      => $s->insertdatetime?->format('d M Y') ?? '—',
                'due_date'           => $s->due_date?->format('d M Y') ?? '—',
                'closed_date'        => $s->closed_date?->format('d M Y') ?? '—',
                'original_quantity'  => $s->original_quantity ?? '—',
                'original_weight'    => $s->original_weight
                    ? number_format($s->original_weight, 2) . ' ' . $s->weight_unit
                    : '—',
                'original_total_cost'=> $s->original_total_cost
                    ? number_format($s->original_total_cost, 2) . ' ' . $s->currency
                    : '—',
                'discrepancy_reason' => $s->discrepancy_reason ?? '—',
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
}
