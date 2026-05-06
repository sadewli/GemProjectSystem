<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserType extends Model
{
    protected $table = 'tbl_user_type';
    protected $primaryKey = 'idtbl_user_type';
    public $timestamps = false;
    protected $guarded = [];

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }
}