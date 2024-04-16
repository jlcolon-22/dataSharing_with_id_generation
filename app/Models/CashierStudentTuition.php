<?php

namespace App\Models;

use App\Models\StudentPayment;
use App\Models\CashierPartition;
use App\Models\Cashier_student_feeItem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CashierStudentTuition extends Model
{
    use HasFactory;
    protected $fillable = ['student_id','partition','total_school_fee','total_payable_fee','school_year_semester','section','student_name'];
    protected $casts = [
        'created_at' => 'date:d-m-Y'
    ];


    public function getFeeDetails()
    {
        return $this->hasMany(Cashier_student_feeItem::class,'cashier_student_tuition_id','id');
    }

    public function getStudentPayment()
    {
        return $this->hasMany(StudentPayment::class,'cashier_student_tuition_id','id');
    }

    public function getStudentPartition()
    {
        return $this->hasMany(CashierPartition::class,'cashier_student_tuition_id','id');
    }
}
