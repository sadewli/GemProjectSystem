<?php

namespace App\Models\Crm;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class CreateContact extends Model
{
    protected $table = 'tbl_create_contact';
    protected $primaryKey = 'idtbl_create_contact';
    protected $guarded = [];
    protected $casts = ['status' => 'integer'];

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
