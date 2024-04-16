<?php

namespace App\Http\Controllers;

use App\Models\Saso;
use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    // students
    public function students(){
        $jsonFilePath = public_path('json/students.json');
        $jsonData = file_get_contents($jsonFilePath);
        // $data = json_decode($jsonData);

        return response()->json($jsonData);
    }

    // student profile

    public function get_Profile(Request $request){
        // dd($request->croppedImage);
        // $request->validate([
        //     'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        // ]);
        $check = Saso::where('student_id',$request->student_id)->where('school_year_semester',$request->school_year_semester)->first();
        if($check)
        {
            if($check->image != null)
            {
                unlink('storage/studentImage/'.$check->image);
                $filename = time().'.'.$request->croppedImage->extension();
                $check->update([
                    'image'=>$filename,

                ]);

                $request->croppedImage->storeAs('public/studentImage',$filename);
            }else{
                $filename = time().'.'.$request->croppedImage->extension();
            $check->update([
                'image'=>$filename,

            ]);
            $request->croppedImage->storeAs('public/studentImage',$filename);
            }
        }else{
            $filename = time().'.'.$request->croppedImage->extension();
            Saso::create([
                'student_id'=>$request->student_id,
                'school_year_semester'=>$request->school_year_semester,
                'image'=>$filename,

            ]);
            $request->croppedImage->storeAs('public/studentImage',$filename);
        }


        // if ($request->hasFile('croppedImage')) {
        //     $path = public_path('id_image/');
        //     !is_dir($path) &&
        //     mkdir($path, 0777, true);
        //     // $imageName = time() . '.' . $request->croppedImage->extension();
        //     $imageName = $request->croppedImage->getClientOriginalName();
        //     $request->croppedImage->move($path, $imageName);

        //     // Check if the student exists in the database
        //     $student = Student::where('profile', $imageName)->first();
        //     if($student){
        //         // Update the image name if the student record exists
        //         $student->profile = $imageName;
        //         $student->save();
        //     }else{
        //          // Insert a new student record with the image name
        //             $student = new Student();
        //             $student->profile = $imageName;
        //             $student->save();
        //     }
        //     $id = explode('.', $imageName);
        //     return response()->json(['message' => 'Image saved successfully', 'id'=>$id[0]]);
        // } else {
        //     return response()->json(['error' => 'No image file found']);
        // }
    }
}
