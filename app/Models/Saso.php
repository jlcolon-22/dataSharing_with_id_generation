<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Student_id_Position;

class Saso extends Model
{
    use HasFactory;
    protected $table = 'saso_table';

    protected $fillable = [
        'student_id',
        'school_year_semester',
        'signature',
        'image',
        'status'
    ];

    public function student_position()
    {
        return $this->hasMany(Student_id_Position::class,'saso_id','id');
    }
}
