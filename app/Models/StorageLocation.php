<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StorageLocation extends Model
{
    use HasFactory;

    protected $table = 'tbl_storage_locations';
    protected $primaryKey = 'idtbl_storage_locations';
    const CREATED_AT = 'insertdatetime';
    const UPDATED_AT = 'updatedatetime';
    protected $guarded = [];
}
