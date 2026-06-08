<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    use HasFactory;

    protected $table = 'tbl_grades';
    protected $primaryKey = 'idtbl_grades';
    const CREATED_AT = 'insertdatetime';
    const UPDATED_AT = 'updatedatetime';
    protected $guarded = [];

    public function gradeType()
    {
        return $this->belongsTo(GradeType::class, 'grade_type_id', 'idtbl_grade_types');
    }
}
