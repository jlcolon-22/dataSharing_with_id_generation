<?php

namespace App\Models;

use App\Models\CashierStudentTuition;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cashier_student_feeItem extends Model
{
    use HasFactory;

    protected $fillable = ['status','cashier_student_tuition_id','fee_type','amount','type'];

    public function getStudentInfo()
    {
        return $this->belongsTo(CashierStudentTuition::class,'cashier_student_tuition_id');
    }
}
