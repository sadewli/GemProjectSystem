<?php

namespace App\Models\Production;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Supplier;

class ProductionSheet extends Model
{
    protected $table      = 'tbl_production_sheets';
    protected $primaryKey = 'idtbl_production_sheets';
    public $timestamps    = false;

    protected $fillable = [
        'sheet_number',
        'idtbl_production_types',
        'production_category',
        'reference',
        'due_date',
        'closed_date',
        'creator_id',
        'supplier_id',
        'original_quantity',
        'original_weight',
        'weight_unit',
        'original_total_cost',
        'currency',
        'cost_per_unit',
        'total_cost',
        'my_cost_per_unit',
        'my_total_cost',
        'expected_output_weight',
        'output_weight_unit',
        'expected_output_quantity',
        'loss_percent',
        'loss_weight',
        'discrepancy_reason',
        'notes',
        'status',
        'insertuser',
        'insertdatetime',
        'updateuser',
        'updatedatetime',
    ];

    protected $casts = [
        'due_date'      => 'date',
        'closed_date'   => 'date',
        'insertdatetime'=> 'datetime',
        'updatedatetime'=> 'datetime',
    ];

    // ── Relationships ──────────────────────────────────────────────────────────

    public function productionType()
    {
        return $this->belongsTo(
            ProductionType::class,
            'idtbl_production_types',
            'idtbl_production_types'
        );
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id', 'idtbl_user');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id', 'idtbl_suppliers');
    }

    public function insertUser()
    {
        return $this->belongsTo(User::class, 'insertuser', 'idtbl_user');
    }

    public function items()
    {
        return $this->hasMany(
            ProductionSheetItem::class,
            'idtbl_production_sheets',
            'idtbl_production_sheets'
        );
    }

    public function history()
    {
        return $this->hasMany(
            ProductionSheetHistory::class,
            'idtbl_production_sheets',
            'idtbl_production_sheets'
        );
    }

    public function media()
    {
        return $this->hasMany(
            ProductionSheetMedia::class,
            'idtbl_production_sheets',
            'idtbl_production_sheets'
        );
    }

    // ── Helpers ────────────────────────────────────────────────────────────────

    /**
     * Generate next sheet number: PS-0001, PS-0002, …
     */
    public static function generateSheetNumber(): string
    {
        $last = static::orderBy('idtbl_production_sheets', 'desc')->first();
        $next = $last ? ($last->idtbl_production_sheets + 1) : 1;
        return 'PS-' . str_pad($next, 4, '0', STR_PAD_LEFT);
    }
}
