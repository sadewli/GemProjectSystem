<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MenuList extends Model
{
    protected $table = 'tbl_menu_list';
    protected $primaryKey = 'idtbl_menu_list';
    public $timestamps = false;
    protected $guarded = [];

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }
}
