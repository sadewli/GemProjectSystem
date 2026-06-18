<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * Model representing tbl_partners_master (My Company % per product purchasing)
 *
 * @property int    $idtbl_partners_master
 * @property int    $idtbl_product_purchasing   Purchasing reference
 * @property int    $idtbl_partners             My Company reference
 * @property float  $ownership_percentage       % of ownership
 * @property float  $profit_share_percentage    % of profit share
 * @property int    $status                     1=Active, 2=Inactive, 0=Deleted
 * @property int|null $insertuser
 * @property \Carbon\Carbon|null $insertdatetime
 * @property string|null $updateuser
 * @property \Carbon\Carbon|null $updatedatetime
 */
class PartnersMaster extends Model
{
    protected $table = 'tbl_partners_master';
    protected $primaryKey = 'idtbl_partners_master';
    public $timestamps = false; // we manage timestamps manually

    protected $fillable = [
        'idtbl_product_purchasing',
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
     * Relationship to partner details rows (Other companies).
     */
    public function details()
    {
        return $this->hasMany(PartnersDetail::class, 'idtbl_partners_master', 'idtbl_partners_master');
    }

    /**
     * The partner (My Company) this master record belongs to.
     */
    public function partner()
    {
        return $this->belongsTo(Partner::class, 'idtbl_partners', 'idtbl_partners');
    }

    /**
     * The product purchasing record this master belongs to.
     */
    public function productPurchasing()
    {
        return $this->belongsTo(\App\Models\ProductPurchasing::class, 'idtbl_product_purchasing', 'idtbl_product_purchasing');
    }

    /**
     * The user who created this record.
     */
    public function creator()
    {
        return $this->belongsTo(\App\Models\User::class, 'insertuser', 'idtbl_user');
    }

    /**
     * Create a master record and its related partner details in a transaction.
     *
     * @param  array  $data  Expected keys:
     *                       - idtbl_product_purchasing
     *                       - my_company_id
     *                       - my_ownership_percentage
     *                       - my_profit_share_percentage
     *                       - partner_ids (array)
     *                       - partner_ownership (array)
     *                       - partner_profit (array)
     *                       - insertuser (optional)
     * @return PartnersMaster|bool
     */
    public static function createWithDetails(array $data)
    {
        return DB::transaction(function () use ($data) {
            // 1. Insert master (My Company) row
            $master = self::create([
                'idtbl_product_purchasing'    => $data['idtbl_product_purchasing'],
                'idtbl_partners'              => $data['my_company_id'],
                'ownership_percentage'        => $data['my_ownership_percentage'],
                'profit_share_percentage'     => $data['my_profit_share_percentage'],
                'status'                      => 1,
                'insertuser'                  => $data['insertuser'] ?? null,
                'insertdatetime'              => now(),
                'updateuser'                  => null,
                'updatedatetime'              => null,
            ]);

            // 2. Insert other partner rows if any
            $partnerIds        = $data['partner_ids'] ?? [];
            $partnerOwnerships = $data['partner_ownership'] ?? [];
            $partnerProfits    = $data['partner_profit'] ?? [];

            $detailRows = [];
            foreach ($partnerIds as $index => $partnerId) {
                if (empty($partnerId)) {
                    continue; // skip empty selects
                }
                $detailRows[] = [
                    'idtbl_partners_master'   => $master->idtbl_partners_master,
                    'idtbl_partners'          => $partnerId,
                    'ownership_percentage'    => $partnerOwnerships[$index] ?? 0,
                    'profit_share_percentage' => $partnerProfits[$index] ?? 0,
                    'status'                  => 1,
                    'insertuser'              => $data['insertuser'] ?? null,
                    'insertdatetime'          => now(),
                    'updateuser'              => null,
                    'updatedatetime'          => null,
                ];
            }

            if (!empty($detailRows)) {
                PartnersDetail::insert($detailRows);
            }

            return $master;
        });
    }
}
