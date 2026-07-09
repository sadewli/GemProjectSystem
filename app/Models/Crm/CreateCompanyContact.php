<?php

namespace App\Models\Crm;

use Illuminate\Database\Eloquent\Model;

class CreateCompanyContact extends Model
{
    protected $table = 'tbl_create_company_contacts';
    protected $primaryKey = 'idtbl_create_company_contacts';
    protected $guarded = [];

    /**
     * Get the company that owns the contact.
     */
    public function company()
    {
        return $this->belongsTo(CreateCompany::class, 'tbl_create_company_idtbl_create_company', 'idtbl_create_company');
    }
}
