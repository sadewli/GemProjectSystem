<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shape extends Model
{
    use HasFactory;

    protected $table = 'tbl_shapes';
    protected $primaryKey = 'idtbl_shapes';
    const CREATED_AT = 'insertdatetime';
    const UPDATED_AT = 'updatedatetime';
    protected $guarded = [];

    public function productType()
    {
        return $this->belongsTo(ProductType::class, 'idtbl_product_types', 'idtbl_product_types');
    }
}
