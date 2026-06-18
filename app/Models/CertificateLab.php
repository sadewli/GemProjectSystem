<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CertificateLab extends Model
{
    protected $table = 'tbl_certificate_labs';
    protected $primaryKey = 'idtbl_certificate_labs';
    public $timestamps = false;

    protected $fillable = [
        'lab_name',
        'status',
        'insertuser',
        'insertdatetime',
        'updateuser',
        'updatedatetime',
    ];
}
