<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\authController;
use App\Http\Controllers\studentController;
use App\Http\Controllers\TrackController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\AnswerController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register', [authController::class, 'register']);
Route::post('/login', [authController::class, 'login']);


Route::middleware('auth:sanctum')->group(function (){
    //here we will find the routes that needs to be login inorder to access



    Route::post('/logout', [authController::class, 'logout']);

    // this route will allow a student to register in a track
    Route::post('/trackRegister', [studentController::class, 'trackRegister']);



    Route::middleware('checkRole')->group(function(){
        //here we will define the routes that need to be admin to access
        Route::apiResource('tracks',TrackController::class);
        Route::apiResource('students',StudentController::class);

        Route::get('registered-tracks', [studentController::class, 'getAllRegisteredTracks']);



        Route::get("questions-of-track/{id}",[QuestionController::class,'QuestionsOfTrack']);
        Route::post('question',[QuestionController::class,'store']);//this will add a new question
        Route::post('assign-question',[QuestionController::class,'assignQuestionToTrack']);//this will add a new question
        Route::get('answers-of-question/{id}',[QuestionController::class,'possibleAnswers']);




        Route::get('students-enrolled-in-track/{id}',[TrackController::class, 'getStudentsEnrolledInTrack']);

        Route::apiResource('questions',QuestionController::class);
        Route::get('questions-and-answers-of-track/{id}',[QuestionController::class,'questionsAndAnswersOfTrack']);


        
        Route::get('answers/{question_id}',[AnswerController::class,'index']);
        Route::post('add-answer/{question_id}',[AnswerController::class,'store']);
        Route::get('question-of-answer/{answer_id}',[AnswerController::class,'getQuestionOfAnswer']);
        Route::delete('delete-answer/{answer_id}',[AnswerController::class,'destroy']);
        Route::get('show-answer/{id}',[AnswerController::class,'show']);
        Route::put('update-answer/{id}',[AnswerController::class,'update']);

    });
    

});

