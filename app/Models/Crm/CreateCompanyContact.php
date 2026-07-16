<?php

namespace App\Models\Crm;

use Illuminate\Database\Eloquent\Model;

/**
 * @deprecated This model is no longer written to. Legacy rows are kept in tbl_create_company_contacts for historical purposes. Use CreateContact instead.
 */
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
