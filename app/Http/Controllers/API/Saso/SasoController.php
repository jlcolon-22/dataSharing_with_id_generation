<?php

namespace App\Http\Controllers\API\Saso;

use App\Models\Saso;
use App\Models\ID_Position;
use App\Models\Student_id_Position;
use App\Models\ID_Template;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SasoController extends Controller
{
    // ################################# status ####################
    public function getStatus()
    {
        $saso = Saso::get();
        return response()->json($saso);
    }

    public function updateStatus(Request $request)
    {
        foreach($request['data'] as $value)
        {

           $data = Saso::where('student_id',$value['id'])->where('school_year_semester',$value['sys'])->update([
            'status'=>true
           ]);

        }
    }


    // ###################### generate id ############################
    public function getStudentDetails(Request $request)
    {

        $arr = [];
        foreach($request['ids'] as $value)
        {

           $data = Saso::with('student_position')->where('student_id',$value['id'])->where('school_year_semester',$value['sys'])->first();
           $arr[] = $data;
        }
        return response()->json($arr);
    }


    // ############################### Saso ########################
    public function getDetails(Request $request)
    {
        $details = Saso::where('student_id',$request->student_id)->where('school_year_semester',$request->school_year_semester)->first();
        if($details)
        {
            return response()->json($details);
        }
        return response()->noContent();
    }

    //################################ template##########################
    public function uploadTemplate(Request $request)
    {
        $front = time().'-front.'.$request->front->extension();
        $back = time().'-back.'.$request->back->extension();
        ID_Template::query()
                    ->create([
                        'front'=>$front,
                        'back'=>$back
                    ]);

        $request->front->storeAs('public/template',$front);
        $request->back->storeAs('public/template',$back);
    }

    public function getTemplate()
    {
        $templates = ID_Template::query()
                                    ->get();

        return response()->json($templates);
    }

    public function activeTemplate($id)
    {
        $templates = ID_Template::query()
                                    ->get();

        foreach($templates as $template)
        {
            if($template->id == $id)
            {
                $template->update([
                    'status'=>true
                ]);
            }else{
                $template->update([
                    'status'=>false
                ]);
            }
        }
    }
    // ########################3 studentid ########################3
    public function storeStudentTemplatePosition(Request $request)
    {
        $first = Saso::where('student_id',$request->student_id)->where('school_year_semester',$request->school_year_semester)->first();
        $check = Student_id_Position::where('saso_id',$first->id)->first();
        if($check == null)
        {
            Student_id_Position::query()
                                ->create([
                                    'saso_id'=>$first->id,

                                    'firstname_x'=>$request->firstname['x'],
                                    'firstname_y'=>$request->firstname['y'],
                                    'firstname_fw'=>$request->firstname['fw'] == null ? null : $request->firstname['fw'],
                                    'firstname_ff'=>$request->firstname['ff'] == null ? null : $request->firstname['ff'],
                                    'firstname_b'=>$request->firstname['b'] == null ? null : $request->firstname['b'],

                                    'middlename_x'=>$request->middlename['x'],
                                    'middlename_y'=>$request->middlename['y'],
                                    'middlename_fw'=>$request->middlename['fw'] == null ? '' : $request->middlename['fw'],
                                    'middlename_ff'=>$request->middlename['ff'] == null ? '' : $request->middlename['ff'],
                                    'middlename_b'=>$request->middlename['b'] == null ? '' : $request->middlename['b'],

                                    'lastname_x'=>$request->lastname['x'],
                                    'lastname_y'=>$request->lastname['y'],
                                    'lastname_fw'=>$request->lastname['fw']  == null ? '' : $request->lastname['fw'],
                                    'lastname_ff'=>$request->lastname['ff']  == null ? '' : $request->lastname['ff'],
                                    'lastname_b'=>$request->lastname['b']  == null ? '' : $request->lastname['b'],

                                    'student_number_x'=>$request->student_number['x'],
                                    'student_number_y'=>$request->student_number['y'],
                                    'student_number_fw'=>$request->student_number['fw'] == null ? '' : $request->student_number['fw'],
                                    'student_number_ff'=>$request->student_number['ff'] == null ? '' : $request->student_number['ff'],
                                    'student_number_b'=>$request->student_number['b'] == null ? '' : $request->student_number['b'],

                                    'course_x'=>$request->course['x'],
                                    'course_y'=>$request->course['y'],
                                    'course_fw'=>$request->course['fw'] == null ? '' : $request->course['fw'],
                                    'course_ff'=>$request->course['ff'] == null ? '' : $request->course['ff'],
                                    'course_b'=>$request->course['b'] == null ? '' : $request->course['b'],

                                    'year_sem_x'=>$request->year_sem['x'],
                                    'year_sem_y'=>$request->year_sem['y'],
                                    'year_sem_fw'=>$request->year_sem['fw'] == null ? '' : $request->year_sem['fw'],
                                    'year_sem_ff'=>$request->year_sem['ff'] == null ? '' : $request->year_sem['ff'],
                                    'year_sem_b'=>$request->year_sem['b'] == null ? '' : $request->year_sem['b'],

                                    'contact_form_x'=>$request->contact_form['x'],
                                                    'contact_form_y'=>$request->contact_form['y'],
                                                    'contact_form_fw'=>$request->contact_form['fw'] == null ? '' : $request->contact_form['fw'],
                                                    'contact_form_ff'=>$request->contact_form['ff'] == null ? '' : $request->contact_form['ff'],
                                                    'contact_form_b'=>$request->contact_form['b'] == null ? '' : $request->contact_form['b'],

                                                'address_x'=>$request->address['x'],
                                                'address_y'=>$request->address['y'],
                                                'address_fw'=>$request->address['fw'] == null ? '' : $request->address['fw'],
                                                'address_ff'=>$request->address['ff'] == null ? '' : $request->address['ff'],
                                                'address_b'=>$request->address['b'] == null ? '' : $request->address['b'],
                                                'address_w'=>$request->address['w'] == null ? '' : $request->address['w'],
                                                'address_h'=>$request->address['h'] == null ? '' : $request->address['h'],

                                                'number_x'=>$request->number['x'],
                                                'number_y'=>$request->number['y'],
                                                'number_fw'=>$request->number['fw'] == null ? '' : $request->number['fw'],
                                                'number_ff'=>$request->number['ff'] == null ? '' : $request->number['ff'],
                                                'number_b'=>$request->number['b'] == null ? '' : $request->number['b'],

                                    'profile_x'=>$request->profile['x'],
                                    'profile_y'=>$request->profile['y'],
                                    'profile_w'=>$request->profile['w'],
                                    'profile_h'=>$request->profile['h'],

                                    'signature_x'=>$request->signature['x'],
                                    'signature_y'=>$request->signature['y'],
                                    'signature_w'=>$request->signature['w'],
                                    'signature_h'=>$request->signature['h'],
                                ]);
        }else{
            $check->update([


                'firstname_x'=>$request->firstname['x'],
                'firstname_y'=>$request->firstname['y'],
                'firstname_fw'=>$request->firstname['fw'] == null ? null : $request->firstname['fw'],
                'firstname_ff'=>$request->firstname['ff'] == null ? null : $request->firstname['ff'],
                'firstname_b'=>$request->firstname['b'] == null ? null : $request->firstname['b'],

                'middlename_x'=>$request->middlename['x'],
                'middlename_y'=>$request->middlename['y'],
                'middlename_fw'=>$request->middlename['fw'] == null ? '' : $request->middlename['fw'],
                'middlename_ff'=>$request->middlename['ff'] == null ? '' : $request->middlename['ff'],
                'middlename_b'=>$request->middlename['b'] == null ? '' : $request->middlename['b'],

                'lastname_x'=>$request->lastname['x'],
                'lastname_y'=>$request->lastname['y'],
                'lastname_fw'=>$request->lastname['fw']  == null ? '' : $request->lastname['fw'],
                'lastname_ff'=>$request->lastname['ff']  == null ? '' : $request->lastname['ff'],
                'lastname_b'=>$request->lastname['b']  == null ? '' : $request->lastname['b'],

                'student_number_x'=>$request->student_number['x'],
                'student_number_y'=>$request->student_number['y'],
                'student_number_fw'=>$request->student_number['fw'] == null ? '' : $request->student_number['fw'],
                'student_number_ff'=>$request->student_number['ff'] == null ? '' : $request->student_number['ff'],
                'student_number_b'=>$request->student_number['b'] == null ? '' : $request->student_number['b'],

                'course_x'=>$request->course['x'],
                'course_y'=>$request->course['y'],
                'course_fw'=>$request->course['fw'] == null ? '' : $request->course['fw'],
                'course_ff'=>$request->course['ff'] == null ? '' : $request->course['ff'],
                'course_b'=>$request->course['b'] == null ? '' : $request->course['b'],

                'year_sem_x'=>$request->year_sem['x'],
                'year_sem_y'=>$request->year_sem['y'],
                'year_sem_fw'=>$request->year_sem['fw'] == null ? '' : $request->year_sem['fw'],
                'year_sem_ff'=>$request->year_sem['ff'] == null ? '' : $request->year_sem['ff'],
                'year_sem_b'=>$request->year_sem['b'] == null ? '' : $request->year_sem['b'],

                'contact_form_x'=>$request->contact_form['x'],
                                'contact_form_y'=>$request->contact_form['y'],
                                'contact_form_fw'=>$request->contact_form['fw'] == null ? '' : $request->contact_form['fw'],
                                'contact_form_ff'=>$request->contact_form['ff'] == null ? '' : $request->contact_form['ff'],
                                'contact_form_b'=>$request->contact_form['b'] == null ? '' : $request->contact_form['b'],

                            'address_x'=>$request->address['x'],
                            'address_y'=>$request->address['y'],
                            'address_fw'=>$request->address['fw'] == null ? '' : $request->address['fw'],
                            'address_ff'=>$request->address['ff'] == null ? '' : $request->address['ff'],
                            'address_b'=>$request->address['b'] == null ? '' : $request->address['b'],
                            'address_w'=>$request->address['w'] == null ? '' : $request->address['w'],
                            'address_h'=>$request->address['h'] == null ? '' : $request->address['h'],

                            'number_x'=>$request->number['x'],
                            'number_y'=>$request->number['y'],
                            'number_fw'=>$request->number['fw'] == null ? '' : $request->number['fw'],
                            'number_ff'=>$request->number['ff'] == null ? '' : $request->number['ff'],
                            'number_b'=>$request->number['b'] == null ? '' : $request->number['b'],

                'profile_x'=>$request->profile['x'],
                'profile_y'=>$request->profile['y'],
                'profile_w'=>$request->profile['w'],
                'profile_h'=>$request->profile['h'],

                'signature_x'=>$request->signature['x'],
                'signature_y'=>$request->signature['y'],
                'signature_w'=>$request->signature['w'],
                'signature_h'=>$request->signature['h'],
            ]);
        }
    }

    public function getStudentTemplatePosition(Request $request)
    {
        $first = Saso::where('student_id',$request->student_id)->where('school_year_semester',$request->school_year_semester)->first();
        if($first != null)
        {
            $check = Student_id_Position::where('saso_id',$first->id)->first();
        if($check != null)
        {
            return response()->json($check);
        }
        }
        return response()->noContent();
    }
    // ############################# template position ###############################
    public function storeTemplatePosition(Request $request)
    {
        $position = ID_Position::query()->where('template_id',$request->template_id)->first();
        if($position == null)
        {
            ID_Position::query()
                    ->create([
                        'template_id'=>$request->template_id,

                        'firstname_x'=>$request->firstname['x'],
                        'firstname_y'=>$request->firstname['y'],
                        'firstname_fw'=>$request->firstname['fw'] == null ? null : $request->firstname['fw'],
                        'firstname_ff'=>$request->firstname['ff'] == null ? null : $request->firstname['ff'],
                        'firstname_b'=>$request->firstname['b'] == null ? null : $request->firstname['b'],

                        'middlename_x'=>$request->middlename['x'],
                        'middlename_y'=>$request->middlename['y'],
                        'middlename_fw'=>$request->middlename['fw'] == null ? '' : $request->middlename['fw'],
                        'middlename_ff'=>$request->middlename['ff'] == null ? '' : $request->middlename['ff'],
                        'middlename_b'=>$request->middlename['b'] == null ? '' : $request->middlename['b'],

                        'lastname_x'=>$request->lastname['x'],
                        'lastname_y'=>$request->lastname['y'],
                        'lastname_fw'=>$request->lastname['fw']  == null ? '' : $request->lastname['fw'],
                        'lastname_ff'=>$request->lastname['ff']  == null ? '' : $request->lastname['ff'],
                        'lastname_b'=>$request->lastname['b']  == null ? '' : $request->lastname['b'],

                        'student_number_x'=>$request->student_number['x'],
                        'student_number_y'=>$request->student_number['y'],
                        'student_number_fw'=>$request->student_number['fw'] == null ? '' : $request->student_number['fw'],
                        'student_number_ff'=>$request->student_number['ff'] == null ? '' : $request->student_number['ff'],
                        'student_number_b'=>$request->student_number['b'] == null ? '' : $request->student_number['b'],

                        'course_x'=>$request->course['x'],
                        'course_y'=>$request->course['y'],
                        'course_fw'=>$request->course['fw'] == null ? '' : $request->course['fw'],
                        'course_ff'=>$request->course['ff'] == null ? '' : $request->course['ff'],
                        'course_b'=>$request->course['b'] == null ? '' : $request->course['b'],

                        'year_sem_x'=>$request->year_sem['x'],
                        'year_sem_y'=>$request->year_sem['y'],
                        'year_sem_fw'=>$request->year_sem['fw'] == null ? '' : $request->year_sem['fw'],
                        'year_sem_ff'=>$request->year_sem['ff'] == null ? '' : $request->year_sem['ff'],
                        'year_sem_b'=>$request->year_sem['b'] == null ? '' : $request->year_sem['b'],

                        'contact_form_x'=>$request->contact_form['x'],
                                        'contact_form_y'=>$request->contact_form['y'],
                                        'contact_form_fw'=>$request->contact_form['fw'] == null ? '' : $request->contact_form['fw'],
                                        'contact_form_ff'=>$request->contact_form['ff'] == null ? '' : $request->contact_form['ff'],
                                        'contact_form_b'=>$request->contact_form['b'] == null ? '' : $request->contact_form['b'],

                                    'address_x'=>$request->address['x'],
                                    'address_y'=>$request->address['y'],
                                    'address_fw'=>$request->address['fw'] == null ? '' : $request->address['fw'],
                                    'address_ff'=>$request->address['ff'] == null ? '' : $request->address['ff'],
                                    'address_b'=>$request->address['b'] == null ? '' : $request->address['b'],
                                    'address_w'=>$request->address['w'] == null ? '' : $request->address['w'],
                                    'address_h'=>$request->address['h'] == null ? '' : $request->address['h'],

                                    'number_x'=>$request->number['x'],
                                    'number_y'=>$request->number['y'],
                                    'number_fw'=>$request->number['fw'] == null ? '' : $request->number['fw'],
                                    'number_ff'=>$request->number['ff'] == null ? '' : $request->number['ff'],
                                    'number_b'=>$request->number['b'] == null ? '' : $request->number['b'],


                        'profile_x'=>$request->profile['x'],
                        'profile_y'=>$request->profile['y'],
                        'profile_w'=>$request->profile['w'],
                        'profile_h'=>$request->profile['h'],

                        'signature_x'=>$request->signature['x'],
                        'signature_y'=>$request->signature['y'],
                        'signature_w'=>$request->signature['w'],
                        'signature_h'=>$request->signature['h'],
                    ]);
        }else{

                    $position->update([
                        'template_id'=>$request->template_id,

                        'firstname_x'=>$request->firstname['x'],
                        'firstname_y'=>$request->firstname['y'],
                        'firstname_fw'=>$request->firstname['fw'] == null ? null : $request->firstname['fw'],
                        'firstname_ff'=>$request->firstname['ff'] == null ? null : $request->firstname['ff'],
                        'firstname_b'=>$request->firstname['b'] == null ? null : $request->firstname['b'],

                        'middlename_x'=>$request->middlename['x'],
                        'middlename_y'=>$request->middlename['y'],
                        'middlename_fw'=>$request->middlename['fw'] == null ? '' : $request->middlename['fw'],
                        'middlename_ff'=>$request->middlename['ff'] == null ? '' : $request->middlename['ff'],
                        'middlename_b'=>$request->middlename['b'] == null ? '' : $request->middlename['b'],

                        'lastname_x'=>$request->lastname['x'],
                        'lastname_y'=>$request->lastname['y'],
                        'lastname_fw'=>$request->lastname['fw']  == null ? '' : $request->lastname['fw'],
                        'lastname_ff'=>$request->lastname['ff']  == null ? '' : $request->lastname['ff'],
                        'lastname_b'=>$request->lastname['b']  == null ? '' : $request->lastname['b'],

                        'student_number_x'=>$request->student_number['x'],
                        'student_number_y'=>$request->student_number['y'],
                        'student_number_fw'=>$request->student_number['fw'] == null ? '' : $request->student_number['fw'],
                        'student_number_ff'=>$request->student_number['ff'] == null ? '' : $request->student_number['ff'],
                        'student_number_b'=>$request->student_number['b'] == null ? '' : $request->student_number['b'],

                        'course_x'=>$request->course['x'],
                        'course_y'=>$request->course['y'],
                        'course_fw'=>$request->course['fw'] == null ? '' : $request->course['fw'],
                        'course_ff'=>$request->course['ff'] == null ? '' : $request->course['ff'],
                        'course_b'=>$request->course['b'] == null ? '' : $request->course['b'],

                        'year_sem_x'=>$request->year_sem['x'],
                        'year_sem_y'=>$request->year_sem['y'],
                        'year_sem_fw'=>$request->year_sem['fw'] == null ? '' : $request->year_sem['fw'],
                        'year_sem_ff'=>$request->year_sem['ff'] == null ? '' : $request->year_sem['ff'],
                        'year_sem_b'=>$request->year_sem['b'] == null ? '' : $request->year_sem['b'],

                        'contact_form_x'=>$request->contact_form['x'],
                                        'contact_form_y'=>$request->contact_form['y'],
                                        'contact_form_fw'=>$request->contact_form['fw'] == null ? '' : $request->contact_form['fw'],
                                        'contact_form_ff'=>$request->contact_form['ff'] == null ? '' : $request->contact_form['ff'],
                                        'contact_form_b'=>$request->contact_form['b'] == null ? '' : $request->contact_form['b'],

                                    'address_x'=>$request->address['x'],
                                    'address_y'=>$request->address['y'],
                                    'address_fw'=>$request->address['fw'] == null ? '' : $request->address['fw'],
                                    'address_ff'=>$request->address['ff'] == null ? '' : $request->address['ff'],
                                    'address_b'=>$request->address['b'] == null ? '' : $request->address['b'],
                                    'address_w'=>$request->address['w'] == null ? '' : $request->address['w'],
                                    'address_h'=>$request->address['h'] == null ? '' : $request->address['h'],

                                    'number_x'=>$request->number['x'],
                                    'number_y'=>$request->number['y'],
                                    'number_fw'=>$request->number['fw'] == null ? '' : $request->number['fw'],
                                    'number_ff'=>$request->number['ff'] == null ? '' : $request->number['ff'],
                                    'number_b'=>$request->number['b'] == null ? '' : $request->number['b'],
                        'profile_x'=>$request->profile['x'],
                        'profile_y'=>$request->profile['y'],
                        'profile_w'=>$request->profile['w'],
                        'profile_h'=>$request->profile['h'],

                        'signature_x'=>$request->signature['x'],
                        'signature_y'=>$request->signature['y'],
                        'signature_w'=>$request->signature['w'],
                        'signature_h'=>$request->signature['h'],
                    ]);
        }
    }

    public function getTemplatePosition($id)
    {
        $position = ID_Position::query()->where('template_id',$id)->first();
        if($position != null)
        {
            return response()->json($position);
        }
        return response()->json(null,204);
    }
}
