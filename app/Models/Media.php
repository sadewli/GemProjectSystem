<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    use HasFactory;

    protected $fillable = [
        'sku_id',
        'type', // 'photo' or 'video'
        'path',
    ];

    public function sku()
    {
        return $this->belongsTo(Sku::class);
    }
}
