<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $table = 'tbl_country';
    protected $primaryKey = 'idtbl_country';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = true;
    protected $guarded = [];

    /**
     * Scope to filter active countries.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }
}
