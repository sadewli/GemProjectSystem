<?php

namespace App\Models\Production;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class ProductionSheetMedia extends Model
{
    protected $table      = 'tbl_production_sheet_media';
    protected $primaryKey = 'idtbl_production_sheet_media';
    public    $timestamps = false;

    protected $fillable = [
        'idtbl_production_sheets',
        'file_type',
        'file_name',
        'original_name',
        'file_path',
        'mime_type',
        'file_size',
        'remarks',
        'insertuser',
        'insertdatetime',
    ];

    protected $casts = [
        'insertdatetime' => 'datetime',
    ];

    // ── Relationships ──────────────────────────────────────────────────────────

    public function productionSheet()
    {
        return $this->belongsTo(
            ProductionSheet::class,
            'idtbl_production_sheets',
            'idtbl_production_sheets'
        );
    }

    public function insertUser()
    {
        return $this->belongsTo(User::class, 'insertuser', 'idtbl_user');
    }

    // ── Helpers ────────────────────────────────────────────────────────────────

    /**
     * Human-readable file size (e.g. "1.2 MB").
     */
    public function getFileSizeHumanAttribute(): string
    {
        $bytes = (int) $this->file_size;
        if ($bytes < 1024)        return $bytes . ' B';
        if ($bytes < 1048576)     return round($bytes / 1024, 1) . ' KB';
        return round($bytes / 1048576, 2) . ' MB';
    }
}
