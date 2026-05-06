<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyBranch extends Model
{
    protected $table = 'tbl_company_branch';
    protected $primaryKey = 'idtbl_company_branch';
    public $timestamps = false;
    protected $guarded = [];

    public function company()
    {
        return $this->belongsTo(Company::class, 'tbl_company_idtbl_company', 'idtbl_company');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }
}