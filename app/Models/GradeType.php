<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GradeType extends Model
{
    use HasFactory;

    protected $table = 'tbl_grade_types';
    protected $primaryKey = 'idtbl_grade_types';
    const CREATED_AT = 'insertdatetime';
    const UPDATED_AT = 'updatedatetime';
    protected $guarded = [];

    public function grades()
    {
        return $this->hasMany(Grade::class, 'grade_type_id', 'idtbl_grade_types');
    }
}
