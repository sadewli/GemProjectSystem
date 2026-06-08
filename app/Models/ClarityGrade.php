<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClarityGrade extends Model
{
    use HasFactory;

    protected $table = 'tbl_clarity_grade';
    protected $primaryKey = 'idtbl_clarity_grade';
    const CREATED_AT = 'insertdatetime';
    const UPDATED_AT = 'updatedatetime';
    protected $guarded = [];

    public function productType()
    {
        return $this->belongsTo(ProductType::class, 'idtbl_product_types', 'idtbl_product_types');
    }
}
