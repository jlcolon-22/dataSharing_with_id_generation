<?php

namespace App\Models;

use App\Models\CashierStudentTuition;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StudentPayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'cashier_student_tuition_id',
        'student_id',
        'remarks',
        'or_number',
        'amount',
        'type'
    ];

    public function StudentTuition()
    {
        return $this->belongsTo(CashierStudentTuition::class,'cashier_student_tuition_id');
    }
}
