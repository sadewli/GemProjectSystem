<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Variety extends Model
{
    protected $table = 'tbl_varieties';
    protected $primaryKey = 'idtbl_varieties';
    const CREATED_AT = 'insertdatetime';
    const UPDATED_AT = 'updatedatetime';
    protected $guarded = [];

    public function subcategories()
    {
        return $this->hasMany(SubCategory::class, 'variety_id', 'idtbl_varieties');
    }

    public function productType()
    {
        return $this->belongsTo(ProductType::class, 'idtbl_product_types', 'idtbl_product_types');
    }
}
