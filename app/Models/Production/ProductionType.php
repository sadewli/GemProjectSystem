<?php

namespace App\Models\Production;

use Illuminate\Database\Eloquent\Model;

class ProductionType extends Model
{
    protected $table      = 'tbl_production_types';
    protected $primaryKey = 'idtbl_production_types';
    public $timestamps    = false;

    protected $fillable = [
        'type_name',
        'type_value',
        'status',
        'insertuser',
        'insertdatetime',
    ];

    public function sheets()
    {
        return $this->hasMany(ProductionSheet::class, 'idtbl_production_types', 'idtbl_production_types');
    }
}
