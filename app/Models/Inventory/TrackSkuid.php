<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Model;

class TrackSkuid extends Model
{
    protected $table = 'tbl_track_skuid';

    // Table only has changed_date, not created_at/updated_at
    public $timestamps = false;

    protected $fillable = [
        'original_product_id',
        'new_product_id',
        'pistatus',
        'change_type',
        'changed_by',
        'changed_date',
    ];

    protected $casts = [
        'changed_date' => 'datetime',
    ];

    // pistatus values (per DB comment: 1=Production, 2=Inventory)
    const PISTATUS_PRODUCTION = 1;
    const PISTATUS_INVENTORY  = 2;

    public function originalProduct()
    {
        return $this->belongsTo(Product::class, 'original_product_id', 'idtbl_products');
    }

    public function newProduct()
    {
        return $this->belongsTo(Product::class, 'new_product_id', 'idtbl_products');
    }

    /**
     * Central place to record a SKU/product-id change.
     * Call this from ANY flow that turns one product record into another
     * (lot split, production completion, re-cutting, re-grading, etc.)
     *
     * @param int         $originalProductId  idtbl_products of the item BEFORE the change
     * @param int         $newProductId       idtbl_products of the item AFTER the change
     * @param int         $pistatus           TrackSkuid::PISTATUS_PRODUCTION (1) or TrackSkuid::PISTATUS_INVENTORY (2)
     * @param string      $changeType         short label e.g. 'lot_split', 'production_complete'
     * @param int|null    $changedBy          user id (defaults to logged-in user)
     */
    public static function logChange(
        int $originalProductId,
        int $newProductId,
        int $pistatus,
        string $changeType,
        ?int $changedBy = null
    ): self {
        return self::create([
            'original_product_id' => $originalProductId,
            'new_product_id'      => $newProductId,
            'pistatus'            => $pistatus,
            'change_type'         => $changeType,
            'changed_by'          => $changedBy ?? auth()->id(),
            'changed_date'        => now(),
        ]);
    }
}
