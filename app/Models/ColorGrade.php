<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ColorGrade extends Model
{
    use HasFactory;

    protected $table = 'tbl_color_grade';
    protected $primaryKey = 'idtbl_color_grade';
    const CREATED_AT = 'insertdatetime';
    const UPDATED_AT = 'updatedatetime';
    protected $guarded = [];

    public function productType()
    {
        return $this->belongsTo(ProductType::class, 'idtbl_product_types', 'idtbl_product_types');
    }
}
