<?php

namespace App\Http\Controllers\API\Clinic;

use Illuminate\Http\Request;
use App\Models\ClinicStudentRecord;
use App\Http\Controllers\Controller;

class ClinicController extends Controller
{
    // get all records
    public function getAllRecord(Request $request)
    {
        $records = ClinicStudentRecord::query()
                                    ->whereDate('created_at',$request->date)
                                    ->get();
        return response()->json($records);
    }

    //delete student record
    public function deleteStudentRecord(ClinicStudentRecord $id)
    {
        $id->delete();
    }

    // store student record
    public function addStudentRecord(Request $request)
    {
            ClinicStudentRecord::query()
                                ->create([
                                    'student_id'=>$request->student_id,
                                    'school_year_semester'=>$request->school_year_semester,
                                    'student_name'=>$request->student_name,
                                    'temp'=>$request->temp,
                                    'bp'=>$request->bp,
                                    'rr'=>$request->rr,
                                    'pr'=>$request->pr,
                                    'chief_complain'=>$request->chief_complain,
                                    'medication_given'=>$request->medication_given,
                                ]);
    }

    // get all student record by school year and sem
    public function getStudentRecord(Request $request)
    {
        $records = ClinicStudentRecord::query()
                                        ->where('school_year_semester',$request->school_year_semester)
                                        ->where('student_id',$request->student_id)
                                        ->orderBy('id','desc')
                                        ->get();


        if(count($records) > 0)
        {
            return response()->json($records);
        }
        return response()->json(null,204);

    }

    public function updateStudentRecord(ClinicStudentRecord $id,Request $request)
    {
        $id->update([

                                    'temp'=>$request->temp,
                                    'bp'=>$request->bp,
                                    'rr'=>$request->rr,
                                    'pr'=>$request->pr,
                                    'chief_complain'=>$request->chief_complain,
                                    'medication_given'=>$request->medication_given,
                                    'adviser'=>$request->adviser
        ]);

    }
}
