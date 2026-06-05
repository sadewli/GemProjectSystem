<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'tbl_role';
    protected $primaryKey = 'idtbl_role';
    public $timestamps = true;
    protected $guarded = [];

    /**
     * Scope to filter active roles.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }
}
