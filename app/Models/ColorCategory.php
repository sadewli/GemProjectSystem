<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ColorCategory extends Model
{
    protected $table = 'tbl_color_categories';
    protected $primaryKey = 'idtbl_color_categories';
    const CREATED_AT = 'insertdatetime';
    const UPDATED_AT = 'updatedatetime';
    protected $guarded = [];
}
