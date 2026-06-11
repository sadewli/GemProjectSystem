<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WherehouseLocation extends Model
{
    use HasFactory;

    protected $table = 'tbl_wherehouselocation';

    protected $fillable = [
        'location_name',
        'address',
        'city',
        'state',
        'zip_code',
    ];
}
