<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OwnershipType extends Model
{
    protected $table = 'tbl_ownership_type';
    protected $primaryKey = 'idtbl_ownership_type';
    const CREATED_AT = 'insertdatetime';
    const UPDATED_AT = 'updatedatetime';
    protected $guarded = [];
}
