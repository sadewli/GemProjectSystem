<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PartnersDetails extends Model
{
    use HasFactory;

    protected $table = 'tbl_partners_details';
    protected $primaryKey = 'idtbl_partners_details';
    const CREATED_AT = 'insertdatetime';
    const UPDATED_AT = 'updatedatetime';
    protected $guarded = [];
}
