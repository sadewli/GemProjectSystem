<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductPurchasing extends Model
{
    use HasFactory;

    protected $table = 'tbl_product_purchasing';
    protected $primaryKey = 'idtbl_product_purchasing';
    const CREATED_AT = 'insertdatetime';
    const UPDATED_AT = 'updatedatetime';
    protected $guarded = [];
}
