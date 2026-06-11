<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCustomPricing extends Model
{
    use HasFactory;

    protected $table = 'tbl_product_custom_pricing';
    protected $primaryKey = 'idtbl_product_custom_pricing';
    const CREATED_AT = 'insertdatetime';
    const UPDATED_AT = 'updatedatetime';
    protected $guarded = [];
}
