<?php

namespace App\Models;

use App\Models\CashierStudentTuition;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CashierPartition extends Model
{
    use HasFactory;

    protected $fillable = ['partition','amount','status','cashier_student_tuition_id'];

    public function tuition()
    {
        return $this->belongsTo(CashierStudentTuition::class,'cashier_student_tuition_id');
    }
}
