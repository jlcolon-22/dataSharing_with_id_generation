<?php

namespace App\Http\Controllers\API\cashier;

use Carbon\Carbon;
use App\Models\OtherPayment;
use Illuminate\Http\Request;
use App\Models\StudentPayment;
use App\Models\CashierPartition;
use App\Http\Controllers\Controller;
use App\Models\CashierStudentTuition;
use App\Models\Cashier_student_feeItem;

class AddStudentPaymentController extends Controller
{
    // check student details
    public function checkStudentDetails(Request $request)
    {
        $details = CashierStudentTuition::query()
                                            ->with('getFeeDetails',function($q)
                                            {
                                                $q->where('type',0);
                                            })
                                            ->where('student_id',$request->student_id)
                                            ->where('school_year_semester',$request->school_year_semester)
                                            ->first();

        if($details)
        {
            return response()->json($details);
        }
        return response()->noContent();
    }
    // update other payment
    public function updateOtherPayment(Request $request, OtherPayment $id)
    {
        $id->update([
            'fullname'=>$request->fullname,
            'remarks'=>$request->remarks,
            'amount'=>number_format($request->amount, 2, '.', ''),
        ]);
    }
    public function deleteOtherPayment( OtherPayment $id)
    {
        $id->delete();
    }

    //get all other fee
    public function getAllOtherPayment()
    {
        $payments = OtherPayment::query()->orderBy('id','desc')->get();
        if(count($payments) > 0)
        {
            return response()->json($payments);
        }
        return response()->json(null,204);
    }

    // store parent request or student request
    public function storeOtherPayment(Request $request)
    {
        OtherPayment::query()
                     ->create([
                        'fullname'=>$request->fullname,
                        'remarks'=>$request->remarks,
                        'amount'=>number_format($request->amount, 2, '.', ''),
                        'created_at'=>Carbon::now()
                     ]);
    }

    // get parent quest or student request
    public function getOtherPayment(Request $request)
    {
        $payments = OtherPayment::query()->whereDate('created_at',$request->date)->get();

        if(count($payments) > 0)
        {
            return response()->json($payments);
        }
        return response()->json(null,204);

    }


    // delete other student payment
    public function deleteOtherStudentPayment(StudentPayment $id)
    {
        Cashier_student_feeItem::query()->where('fee_type',$id->remarks)->where('cashier_student_tuition_id',$id->cashier_student_tuition_id)->update(['status'=>false]);
        $id->delete();
    }

    // update other fee Item
    public function updateOtherStudentPayment(Request $request,Cashier_student_feeItem $id)
    {
        $id->update([
            'fee_type'=>$request->fee,
            'amount'=>$request->amount,
            'type'=>true
        ]);
    }


    // delete other fee Item
    public function deleteOtherFee(Cashier_student_feeItem $id)
    {
        $id->delete();
    }

    // get all other fee Item
    public function getOtherStudentPayment(Request $request)
    {
        $tuitionDetails = CashierStudentTuition::query()
        ->where('student_id',$request->student_id)
        ->where('school_year_semester',$request->school_year_semester)
        ->first();
        $x = CashierStudentTuition::where('student_id',$tuitionDetails->student_id)->whereDate('created_at','<',$tuitionDetails->created_at)->latest()->first();
        if($x)
        {
            $otherFee = Cashier_student_feeItem::query()
                                    ->where('cashier_student_tuition_id',$x->id)->where('type',1)->where('status',0)->get();
            if(count($otherFee) > 0)
            {
                $total = 0;
                foreach($otherFee as $value)
                {
                    $total = $total + number_format($value->amount, 2, '.', '');
                }
            }else{
                $total = 0;
            }

        }else{
            $total = 0;
        }

        if($tuitionDetails)
        {
            $payments = StudentPayment::query()->where('cashier_student_tuition_id',$tuitionDetails->id)->where('type',1)->get();
            return response()->json([$payments,$total]);

        }
       return response()->json(null,204);
    }

    // get all other fee
    public function getOtherStudentFee(Request $request)
    {
        $tuitionDetails = CashierStudentTuition::query()
        ->with('getFeeDetails',function($q){
            $q->where('type',1)->orderBy('id','desc');
        })
        ->where('student_id',$request->student_id)
        ->where('school_year_semester',$request->school_year_semester)
        ->first();
        if($tuitionDetails)
        {
            return response()->json($tuitionDetails);
        }
        return response()->json(null,204);
    }


    // add other fee
    public function storeOtherFee(Request $request)
    {
        $check = CashierStudentTuition::query()
                                     ->where('student_id',$request->student_id)->where('school_year_semester',$request->school_year_semester)->first();
        if($check != null)
        {
            Cashier_student_feeItem::query()
            ->create([
                'cashier_student_tuition_id'=>$check->id,
                'fee_type'=>$request->fee,
                'amount'=>$request->amount,
                'type'=>true
            ]);
        }
    }

    // add student payment fee type and details
    public function store(Request $request)
    {

        $check = CashierStudentTuition::query()
                                     ->where('student_id',$request->student_id)->where('school_year_semester',$request->school_year_semester)->first();


        if($check == null)
        {
            $payment = CashierStudentTuition::query()
            ->create([
                'student_id'=>$request->student_id,
                'school_year_semester'=>$request->school_year_semester,
                'partition'=>$request->selectedPartition,
                'total_school_fee'=>$request->totalSchoolFee,
                'total_payable_fee'=>$request->Total_Payable_Fee,
                'section'=>$request->section,
                'student_name'=>$request->student_name,
            ]);
            $semi = number_format($request->Total_Payable_Fee, 2, '.', '') / number_format($request->selectedPartition, 2, '.', '');
            for($i = 0; $i < $request->selectedPartition;$i++)
            {
                if( $i == 0)
                {
                    $par = '1st';
                }
                if( $i == 1)
                {
                    $par = '2nd';
                }
                if( $i == 2)
                {
                    $par = '3rd';
                }
                if( $i > 2)
                {
                    $par = ($i + 1).'th';
                }


                CashierPartition::query()
                                ->create([
                                    'partition'=>$par.' '.'Payment',
                                    'amount'=>number_format($semi, 10, '.', ''),
                                    'cashier_student_tuition_id'=>$payment->id,


                                ]);
            }
            foreach ($request->fee_type as $key => $value) {

                Cashier_student_feeItem::query()
                                        ->create([
                                            'cashier_student_tuition_id'=>$payment->id,
                                            'fee_type'=>$value['fee_type'],
                                            'amount'=>$value['amount'],
                                        ]);
            }
            Cashier_student_feeItem::query()
                                        ->create([
                                            'cashier_student_tuition_id'=>$payment->id,
                                            'fee_type'=>'Downpayment',
                                            'amount'=>$request->downpayment,
                                        ]);
            return response()->json(null,200);


        }

        return response()->json(['errors'=>'Student already exist'],422);


    }

    // show student tuition details
    public function show(Request $request)
    {
        $tuitionDetails = CashierStudentTuition::query()
                                        ->with('getFeeDetails')
                                        ->with('getStudentPartition')
                                        ->where('student_id',$request->student_id)
                                        ->where('school_year_semester',$request->school_year_semester)
                                        ->first();
        if($tuitionDetails)
        {
            return response()->json($tuitionDetails);

        }
       return response()->json(null,204);

    }
    // add student payment
    public function update(Request $request)
    {
        $studentFeeDetails = CashierStudentTuition::query()
                                                    ->where('student_id',$request->student_id)
                                                    ->where('id',$request->payment_details_id)
                                                    ->first();
        $request->validate([
            'or_number'=>'required|unique:student_payments'
        ]);
        StudentPayment::query()
                        ->create([
                            'cashier_student_tuition_id'=>$studentFeeDetails->id,
                            'student_id'=>$studentFeeDetails->student_id,
                            'remarks'=>$request->remarks,
                            'amount'=>number_format($request->amount, 2, '.', ''),
                            'or_number'=>$request->or_number,
                        ]);
        $studentPartition = CashierPartition::query()->where('cashier_student_tuition_id',$studentFeeDetails->id)->where('status',0)->get();
        // return response()->json($studentPartition);
        $amount = number_format($request->amount, 2, '.', '');
        $i = 0;

        foreach($studentPartition as $key => $partition)
        {

            $minus = number_format($amount, 2, '.', '') - number_format($partition->amount, 2, '.', '');

            $amount = number_format($minus, 2, '.', '');
            if(number_format($minus, 2, '.', '') < 0.0)
            {
                if(($key + 1 - $i) == 1)
                {
                    $new = number_format($amount, 2, '.', '') + number_format($partition->amount, 2, '.', '');
                    $final = number_format($partition->amount, 2, '.', '') - number_format($new, 2, '.', '');
                    $partition->update([

                        'amount'=>round($final,2)
                    ]);
                }
            }else{

                if(number_format($minus, 2, '.', '') >= number_format($partition->amount, 2, '.', '') || $minus == 0)
                {
                    $partition->update([
                        'status'=>true,
                        'amount'=>0
                    ]);
                }else{
                    $partition->update([
                        'status'=>true,
                        'amount'=>0
                    ]);
                    $i = $key + 1;
                }


            }

        }

    }

    // ADD OTHER FEE
    public function updateOther(Request $request)
    {
        $item = Cashier_student_feeItem::query()->where('id',$request->id)->first();
        $item->update([
            'status'=>true,

        ]);
        $studentFeeDetails = CashierStudentTuition::query()
        ->where('student_id',$request->student_id)
        ->where('id',$request->payment_details_id)
        ->first();

        StudentPayment::query()
                        ->create([
                            'cashier_student_tuition_id'=>$studentFeeDetails->id,
                            'student_id'=>$studentFeeDetails->student_id,
                            'remarks'=>$item->fee_type,
                            'amount'=>number_format($request->amount, 2, '.', ''),

                            'type'=>1
                        ]);
    }

    // fetch student payment
    public function getStudentPayment(CashierStudentTuition $id)
    {


        $student_payments = StudentPayment::query()->where('cashier_student_tuition_id',$id->id)->where('type',0)->orderBy('id','desc')->get();
        $x = CashierStudentTuition::where('student_id',$id->student_id)->whereDate('created_at','<',$id->created_at)->latest()->first();
        if($x)
        {
            $old = CashierPartition::query()->where('cashier_student_tuition_id',$x->id)->orderBy('id','desc')->get();
            $total = 0;
            foreach ($old as $key => $value) {
                $total = $total + number_format($value->amount, 2, '.', '');
            }
            return response()->json([$total,$student_payments]);
        }


        return response()->json([0,$student_payments]);
    }


    // delete student payment
    public function deleteStudentPayment($id)
    {
        $payment = StudentPayment::query()->where('id',$id)->first();
        $cashier_student_tuition_id = $payment->cashier_student_tuition_id;
        $payment->delete();
        // cashier tuition fee details
        $feeDetails = CashierStudentTuition::query()
                                            ->where('id',$cashier_student_tuition_id)
                                            ->first();
        // get all student partition by cashier_student_tuition_id
        $partitions = CashierPartition::query()->where('cashier_student_tuition_id',$cashier_student_tuition_id)->get();

        // semi partition amount
        $semi = number_format($feeDetails->total_payable_fee, 2, '.', '') / number_format($feeDetails->partition, 2, '.', '');

        foreach($partitions as $partition)
        {
            $partition->update([
                'amount'=>number_format($semi, 10, '.', ''),
                'status'=>0
            ]);
        }

        // student payment
        $studentPayments = StudentPayment::query()->where('cashier_student_tuition_id',$cashier_student_tuition_id)->get();
        if(count($studentPayments) > 0)
        {
            $amount = 0;
            foreach($studentPayments as $payment)
            {
                $amount = number_format($amount, 2, '.', '') + number_format($payment->amount, 2, '.', '');
            }

            $i = 0;

            foreach($partitions as $key => $partition)
            {

                $minus = number_format($amount, 2, '.', '') - number_format($partition->amount, 2, '.', '');

                $amount = number_format($minus, 2, '.', '');
                if(number_format($minus, 2, '.', '') < 0.0)
                {
                    if(($key + 1 - $i) == 1)
                    {
                        $new = number_format($amount, 2, '.', '') + number_format($partition->amount, 2, '.', '');
                        $final = number_format($partition->amount, 2, '.', '') - number_format($new, 2, '.', '');
                        $partition->update([

                            'amount'=>round($final,2)
                        ]);
                    }
                }else{

                    if(number_format($minus, 2, '.', '') >= number_format($partition->amount, 2, '.', '') || $minus == 0)
                    {
                        $partition->update([
                            'status'=>true,
                            'amount'=>0
                        ]);
                    }else{
                        $partition->update([
                            'status'=>true,
                            'amount'=>0
                        ]);
                        $i = $key + 1;
                    }


                }

            }
            }

    }


    // get reports by date
    public function getReports(Request $request)
    {
        $reports = StudentPayment::query()
                                    ->with('StudentTuition')
                                    ->whereDate('created_at','=',$request->date)->orderBy('id','desc')->get();

        if(count($reports) > 0)
        {
            return response()->json($reports);
        }
        return response()->json([],204);

    }
}
