<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PartnersMaster extends Model
{
    use HasFactory;

    protected $table = 'tbl_partners_master';
    protected $primaryKey = 'idtbl_partners_master';
    const CREATED_AT = 'insertdatetime';
    const UPDATED_AT = 'updatedatetime';
    protected $guarded = [];
}
