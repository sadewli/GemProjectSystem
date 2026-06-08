<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrayBox extends Model
{
    use HasFactory;

    protected $table = 'tbl_tray_box';
    protected $primaryKey = 'idtbl_tray_box';
    const CREATED_AT = 'insertdatetime';
    const UPDATED_AT = 'updatedatetime';
    protected $guarded = [];

    public function storageLocation()
    {
        return $this->belongsTo(StorageLocation::class, 'idtbl_storage_locations', 'idtbl_storage_locations');
    }
}
