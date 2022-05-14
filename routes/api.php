<?php

use App\Http\Controllers\Auth\SactumController;
use App\Http\Controllers\StudentSubjectController;
use App\Http\Controllers\TeacherSubjectController;
use App\Http\Controllers\TeacherTaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::group(['middleware' => ['auth:sanctum']], function() {
    Route::apiResource('/subject',TeacherSubjectController::class);
    Route::post('/logout',[SactumController::class,'logout']);
    Route::post('/addSubjectToStudentList',[StudentSubjectController::class,'addSubjectToStudentList']);
    Route::get('/teacherHomePage',[TeacherSubjectController::class,'teacherHomePage']);
    Route::post('/teacherCreateTask/{id}',[TeacherTaskController::class,'createTaskForSubject']);
    Route::apiResource('/teacherTask',TeacherTaskController::class);
    Route::put('/evaluateSolution/{id}',[TeacherTaskController::class,'evaluateSolution']);
    Route::get('/showTeacherTask/{id}',[TeacherTaskController::class,'showTask']);
    Route::post('/updateTask/{id}',[TeacherTaskController::class,'updateTask']);
    Route::delete('/deleteTask/{id}',[TeacherTaskController::class,'destroyTask']);
    Route::post('/putAnswerToTask/{id}',[StudentSubjectController::class,'putAnswerToTask']);
    Route::get('/showAnswerToTask/{id}',[StudentSubjectController::class,'showAnswerToTask']);
    Route::get('/studentSubjectRegistered',[StudentSubjectController::class,'studentSubjectRegistered']);
    Route::get('/showStudentSubjectNotRegistered',[StudentSubjectController::class,'showStudentSubjectNotRegistered']);
    Route::post('/addSubjectToStudentList/{id}',[StudentSubjectController::class,'addSubjectToStudentList']);
    Route::delete('/removeSubjectToStudentList/{id}',[StudentSubjectController::class,'removeSubjectToStudentList']);
    Route::get('/showAnswerToTask/{id}',[StudentSubjectController::class,'showAnswerToTask']);
    Route::post('/putAnswerToTask/{id}',[StudentSubjectController::class,'putAnswerToTask']);
});

Route::post('/login',[SactumController::class,'login']);

Route::post('/register',[SactumController::class,'register']);

Route::get('/user',[TeacherSubjectController::class,'user']);





