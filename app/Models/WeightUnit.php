<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WeightUnit extends Model
{
    protected $table = 'tbl_weight_units';
    protected $primaryKey = 'idtbl_weight_units';
    const CREATED_AT = 'insertdatetime';
    const UPDATED_AT = 'updatedatetime';
    protected $guarded = [];
}
