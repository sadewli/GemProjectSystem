<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyType extends Model
{
    protected $table = 'tbl_company_type';
    protected $primaryKey = 'idtbl_company_type';
    public $timestamps = true;
    protected $guarded = [];

    /**
     * Scope to filter active company types.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }
}
