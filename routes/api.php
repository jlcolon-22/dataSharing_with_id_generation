<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\ModuleController;
// use App\Models\Template;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TemplateController;
use App\Http\Controllers\GeneratedIDController;
use App\Http\Controllers\API\Saso\SasoController;
use App\Http\Controllers\API\Clinic\ClinicController;
use App\Http\Controllers\API\cashier\AddStudentPaymentController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::get('/id_template/{filename}', function ($filename) {
//     $path = public_path('id_template/' . $filename);

//     if (file_exists($path)) {
//         $file = file_get_contents($path);
//         return response($file, 200)->header('Content-Type', 'image/png');
//     } else {
//         abort(404);
//     }
// })->where('filename', '.*');

Route::post('/',[LoginController::class, 'index']);
Route::post('/logout', [LogoutController::class, 'logout'])->middleware('auth:sanctum');
Route::post('/generateId',[ModuleController::class, 'generateID']);
Route::post('/previewID',[ModuleController::class, 'previewID']);

// read data
Route::get('/students',[StudentController::class, 'students']);
Route::post('/save-cropped-image',[StudentController::class, 'get_Profile']);

// template
Route::get('/image-templates', [TemplateController::class, 'getImageTemplates']);
Route::get('/image-templates-coord', [TemplateController::class, 'getTemplateCoordinates']);
Route::post('/save-template', [TemplateController::class, 'saveImageTemplates']);

// student generated ID
Route::post('/get-generated-id', [GeneratedIDController::class, 'getGeneratedStID']);

// get images save in public folder
Route::get('/get-images', [ImageController::class, 'getImages']);
Route::get('/get-signatures', [ImageController::class, 'getSignatures']);
// upload images template
Route::post('/upload-images', [ImageController::class, 'handleUpload']);
Route::post('/save-signature-image', [ImageController::class, 'handleUploadSignature']);

// get id generated
Route::get('/id-generated', [ImageController::class, 'getGeneratedId']);


// ######################### Cashier ################################

// records
Route::post('/cashier/add/student_payment',[AddStudentPaymentController::class,'store']);
Route::post('/cashier/add/other/student_payment',[AddStudentPaymentController::class,'storeOtherFee']);
Route::post('/cashier/student_payment',[AddStudentPaymentController::class,'show']);
Route::get('/cashier/student_payment/{id}',[AddStudentPaymentController::class,'getStudentPayment']);
Route::delete('/cashier/delete/student_payment/{id}',[AddStudentPaymentController::class,'deleteStudentPayment']);
Route::post('/cashier/update/student_payment',[AddStudentPaymentController::class,'update']);
Route::post('/cashier/update/other/student_payment',[AddStudentPaymentController::class,'updateOther']);
Route::post('/cashier/other/student_payment',[AddStudentPaymentController::class,'getOtherStudentPayment']);
Route::post('/cashier/other/fee',[AddStudentPaymentController::class,'getOtherStudentFee']);
Route::put('/cashier/update/other/student_payment/{id}',[AddStudentPaymentController::class,'updateOtherStudentPayment']);
Route::delete('/cashier/other/fee/delete/{id}',[AddStudentPaymentController::class,'deleteOtherFee']);
Route::delete('/cashier/delete/other/student_payment/{id}',[AddStudentPaymentController::class,'deleteOtherStudentPayment']);
Route::post('/cashier/check/student_details',[AddStudentPaymentController::class,'checkStudentDetails']);

// reports
Route::post('/cashier/reports',[AddStudentPaymentController::class,'getReports']);

// other payment
Route::post('/cashier/other_payment',[AddStudentPaymentController::class,'storeOtherPayment']);
Route::put('/cashier/other_payment/{id}',[AddStudentPaymentController::class,'updateOtherPayment']);
Route::delete('/cashier/other_payment/{id}',[AddStudentPaymentController::class,'deleteOtherPayment']);
Route::get('/cashier/other_payment',[AddStudentPaymentController::class,'getOtherPayment']);
Route::get('/cashier/other_payments',[AddStudentPaymentController::class,'getAllOtherPayment']);



// ########################## Clinic #############################################
Route::put('/clinic/record/{id}/update',[ClinicController::class,'updateStudentRecord']);
Route::post('/clinic/add/record',[ClinicController::class,'addStudentRecord']);
Route::post('/clinic/student/record',[ClinicController::class,'getStudentRecord']);
Route::delete('/clinic/delete/student/record/{id}',[ClinicController::class,'deleteStudentRecord']);
Route::post('/clinic/reports',[ClinicController::class,'getAllRecord']);




// ########################## Saso #############################################
// template
Route::post('/saso/upload/id/template',[SasoController::class,'uploadTemplate']);
Route::get('/saso/upload/id/template',[SasoController::class,'getTemplate']);
Route::put('/saso/upload/id/template/{id}',[SasoController::class,'activeTemplate']);
// positions
Route::post('/saso/template/position',[SasoController::class,'storeTemplatePosition']);
Route::get('/saso/template/position/{id}',[SasoController::class,'getTemplatePosition']);


// upload
Route::post('/saso/student/details',[SasoController::class,'getDetails']);

// save student id position and font
Route::post('/saso/student/template/position',[SasoController::class,'storeStudentTemplatePosition']);
Route::post('/saso/student/template/position/get',[SasoController::class,'getStudentTemplatePosition']);

// generate id
Route::post('/saso/fetch_student_details',[SasoController::class,'getStudentDetails']);
Route::get('/saso/status',[SasoController::class,'getStatus']);
Route::put('/saso/update/status',[SasoController::class,'updateStatus']);

