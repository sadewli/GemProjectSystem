<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    protected $table = 'tbl_state';
    protected $primaryKey = 'idtbl_state';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = true;
    protected $guarded = [];

    /**
     * Scope to filter active states.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    /**
     * Get the country that the state belongs to.
     */
    public function country()
    {
        return $this->belongsTo(Country::class, 'idtbl_country', 'idtbl_country');
    }
}
