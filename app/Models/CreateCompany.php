<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CreateCompany extends Model
{
    protected $table = 'tbl_create_company';
    protected $primaryKey = 'idtbl_create_company';
    protected $guarded = [];

    /**
     * Get the owner (user) of the company.
     */
    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id', 'idtbl_user');
    }

    /**
     * Get the contacts associated with the company.
     */
    public function contacts()
    {
        return $this->hasMany(CreateCompanyContact::class, 'tbl_create_company_idtbl_create_company', 'idtbl_create_company');
    }
}
