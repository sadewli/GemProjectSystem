<?php

namespace App\Models\Production;

use Illuminate\Database\Eloquent\Model;

class ProductionSheetItem extends Model
{
    protected $table      = 'tbl_production_sheet_items';
    protected $primaryKey = 'idtbl_production_sheet_items';
    public $timestamps    = false;

    protected $fillable = [
        'idtbl_production_sheets',
        'idtbl_products',
        'sku_number',
        'description',
        'quantity',
        'weight',
        'weight_unit',
        'cost',
        'status',
        'insertuser',
        'insertdatetime',
    ];

    public function sheet()
    {
        return $this->belongsTo(
            ProductionSheet::class,
            'idtbl_production_sheets',
            'idtbl_production_sheets'
        );
    }

    public function product()
    {
        return $this->belongsTo(\App\Models\Inventory\Product::class, 'idtbl_products', 'idtbl_products');
    }
}
