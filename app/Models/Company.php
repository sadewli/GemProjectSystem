<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $table = 'tbl_company';
    protected $primaryKey = 'idtbl_company';
    public $timestamps = false;
    protected $guarded = [];

    public function branches()
    {
        return $this->hasMany(CompanyBranch::class, 'tbl_company_idtbl_company', 'idtbl_company');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }
}