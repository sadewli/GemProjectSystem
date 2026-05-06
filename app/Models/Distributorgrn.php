<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Distributorgrn extends Model
{
    use HasFactory;

    protected $table = 'tbl_distributor_grn';
    protected $primaryKey = 'idtbl_grn';
    public $timestamps = false;

    protected $fillable = [
        'grn_no',
        'date',
        'total',
        'vatamount',
        'nettotal',
        'invoicenum',
        'dispatchnum',
        'batchno',
        'porder_id',
        'distributor_id',
        'status',
        'confirm_status',
        'transfer_status',
        'updateuser',
        'updatedatetime'
    ];

    public function distributor()
    {
        return $this->belongsTo(Distributor::class, 'distributor_id', 'idtbl_distributor');
    }

    public function details()
    {
        return $this->hasMany(Distributorgrndetail::class, 'grn_id', 'idtbl_grn');
    }

    public function purchaseOrder()
    {
        return $this->belongsTo(Distributorpo::class, 'porder_id', 'idtbl_porder');
    }
}
