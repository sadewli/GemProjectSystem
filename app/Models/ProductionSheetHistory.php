<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductionSheetHistory extends Model
{
    protected $table      = 'tbl_production_sheet_history';
    protected $primaryKey = 'idtbl_production_sheet_history';
    public $timestamps    = false;

    protected $fillable = [
        'idtbl_production_sheets',
        'action_date',
        'action_time',
        'action_user',
        'action',
        'note',
        'insertdatetime',
    ];

    public function sheet()
    {
        return $this->belongsTo(
            ProductionSheet::class,
            'idtbl_production_sheets',
            'idtbl_production_sheets'
        );
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'action_user', 'idtbl_user');
    }
}
