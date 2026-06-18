<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Model representing tbl_partners
 *
 * @property int    $idtbl_partners
 * @property string $partner_name
 * @property string|null $contact_name
 * @property string|null $email
 * @property string|null $phone
 * @property string|null $address
 * @property string|null $country
 * @property string|null $currency
 * @property int    $status          1=Active, 2=Inactive, 0=Deleted
 * @property int|null $insertuser
 * @property \Carbon\Carbon|null $insertdatetime
 * @property string|null $updateuser
 * @property \Carbon\Carbon|null $updatedatetime
 */
class Partner extends Model
{
    use HasFactory;

    protected $table = 'tbl_partners';
    protected $primaryKey = 'idtbl_partners';
    public $timestamps = false; // Using custom datetime fields

    protected $fillable = [
        'partner_name',
        'contact_name',
        'email',
        'phone',
        'address',
        'country',
        'currency',
        'status',
        'insertuser',
        'insertdatetime',
        'updateuser',
        'updatedatetime',
    ];

    /**
     * Partner master records where this partner is "My Company".
     */
    public function masterRecords()
    {
        return $this->hasMany(PartnersMaster::class, 'idtbl_partners', 'idtbl_partners');
    }

    /**
     * Partner detail records where this partner appears as "Other company".
     */
    public function detailRecords()
    {
        return $this->hasMany(PartnersDetail::class, 'idtbl_partners', 'idtbl_partners');
    }

    /**
     * The user who created this record.
     */
    public function creator()
    {
        return $this->belongsTo(\App\Models\User::class, 'insertuser', 'idtbl_user');
    }
}
