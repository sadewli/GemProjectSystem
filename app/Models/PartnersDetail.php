<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Model representing tbl_partners_details
 *
 * @property int $idtbl_partners_details
 * @property int $idtbl_partners_master
 * @property int $idtbl_partners
 * @property float $ownership_percentage
 * @property float $profit_share_percentage
 * @property int $status
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
    ];

    public function master()
    {
        return $this->belongsTo(PartnersMaster::class, 'idtbl_partners_master', 'idtbl_partners_master');
    }
}

?>
