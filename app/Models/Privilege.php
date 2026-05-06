<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Privilege extends Model
{
    protected $table = 'tbl_privilege';
    protected $primaryKey = 'idtbl_privilege';
    public $timestamps = false;
    protected $guarded = [];

    public function user() {
        return $this->belongsTo(User::class, 'tbl_user_idtbl_user', 'idtbl_user');
    }

    public function menu() {
        return $this->belongsTo(MenuList::class, 'tbl_menu_list_idtbl_menu_list', 'idtbl_menu_list');
    }

    public function scopeActive($query) {
        return $query->where('status', 1);
    }
}