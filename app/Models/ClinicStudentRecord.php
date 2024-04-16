<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClinicStudentRecord extends Model
{
    use HasFactory;
    protected $fillable = [
        'student_id',
        'school_year_semester',
        'student_name',
        'section',
        'temp',
        'bp',
        'rr',
        'pr',
        'chief_complain',
        'medication_given',
        'adviser'
    ];
}
