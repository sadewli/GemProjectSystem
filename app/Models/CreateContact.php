<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CreateContact extends Model
{
    protected $table = 'tbl_create_contact';
    protected $primaryKey = 'idtbl_create_contact';
    protected $guarded = [];

    /**
     * The user who owns this contact.
     */
    public function owner()
    {
        return $this->belongsTo(User::class, 'owned_by', 'idtbl_user');
    }

    /**
     * The company this contact belongs to.
     */
    public function company()
    {
        return $this->belongsTo(CreateCompany::class, 'company_id', 'idtbl_create_company');
    }
}
