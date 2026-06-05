<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PhoneCode extends Model
{
    protected $table = 'tbl_phone_code';
    protected $primaryKey = 'idtbl_phone_code';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = true;
    protected $guarded = [];

    /**
     * Scope to filter active phone codes.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    /**
     * Accessor to compute regional indicator flag emojis dynamically.
     */
    public function getFlagEmojiAttribute()
    {
        $code = $this->idtbl_phone_code;
        if (strlen($code) !== 2) {
            return '🌐';
        }
        $code = strtoupper($code);
        $c1 = ord($code[0]) - 65 + 127462;
        $c2 = ord($code[1]) - 65 + 127462;
        return mb_chr($c1, 'UTF-8') . mb_chr($c2, 'UTF-8');
    }
}
