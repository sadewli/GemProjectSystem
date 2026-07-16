<?php

namespace App\Models\Crm;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Crm\CreateContact;

class CreateCompany extends Model
{
    protected $table = 'tbl_create_company';
    protected $primaryKey = 'idtbl_create_company';
    protected $guarded = [];
    protected $casts = ['status' => 'integer'];

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
        return $this->hasMany(CreateContact::class, 'company_id', 'idtbl_create_company');
    }
}
