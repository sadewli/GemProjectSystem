<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductType extends Model
{
    protected $table = 'tbl_product_types';

    protected $primaryKey = 'idtbl_product_types';

    public $timestamps = false;

    protected $fillable = [
        'idtbl_skus',
        'name',
        'skuname',
        'status',
        'insertuser',
        'insertdatetime',
        'updateuser',
        'updatedatetime',
    ];

    protected $casts = [
        'status'         => 'integer',
        'insertuser'     => 'integer',
        'insertdatetime' => 'datetime',
        'updatedatetime' => 'datetime',
    ];

    public function sku(): BelongsTo
    {
        return $this->belongsTo(Sku::class, 'idtbl_skus', 'idtbl_skus');
    }
}
