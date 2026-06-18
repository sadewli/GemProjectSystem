<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Model representing tbl_partners_details (Other companies % per product purchasing)
 *
 * @property int    $idtbl_partners_details
 * @property int    $idtbl_partners_master      Master reference
 * @property int    $idtbl_partners             Other company reference
 * @property float  $ownership_percentage       % of ownership
 * @property float  $profit_share_percentage    % of profit share
 * @property int    $status                     1=Active, 2=Inactive, 0=Deleted
 * @property int|null $insertuser
 * @property \Carbon\Carbon|null $insertdatetime
 * @property string|null $updateuser
 * @property \Carbon\Carbon|null $updatedatetime
 */
class PartnersDetail extends Model
{
    protected $table = 'tbl_partners_details';
    protected $primaryKey = 'idtbl_partners_details';
    public $timestamps = false;

    protected $fillable = [
        'idtbl_partners_master',
        'idtbl_partners',
        'ownership_percentage',
        'profit_share_percentage',
        'status',
        'insertuser',
        'insertdatetime',
        'updateuser',
        'updatedatetime',
    ];

    /**
     * The master record this detail belongs to.
     */
    public function master()
    {
        return $this->belongsTo(PartnersMaster::class, 'idtbl_partners_master', 'idtbl_partners_master');
    }

    /**
     * The partner (other company) this detail references.
     */
    public function partner()
    {
        return $this->belongsTo(Partner::class, 'idtbl_partners', 'idtbl_partners');
    }

    /**
     * The user who created this record.
     */
    public function creator()
    {
        return $this->belongsTo(\App\Models\User::class, 'insertuser', 'idtbl_user');
    }
}
