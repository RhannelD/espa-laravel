<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CollegeController;
use App\Http\Controllers\Api\CourseController;
use App\Http\Controllers\Api\Form\SelectController;
use App\Http\Controllers\Api\OfficerController;
use App\Http\Controllers\Api\ProgramController;
use App\Http\Controllers\Api\StudentController;
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

Route::post('/signin', [AuthController::class, 'signin']);

Route::middleware(['auth:sanctum'])->group(function () {

    Route::get('/user', [AuthController::class, 'user']);

    Route::post('/signout', [AuthController::class, 'signout']);

    Route::apiResource('/college', CollegeController::class);

    Route::apiResource('/program', ProgramController::class);

    Route::apiResource('/course', CourseController::class);

    Route::apiResource('/officer', OfficerController::class);

    Route::apiResource('/student', StudentController::class);

    Route::prefix('/form')->group(function () {

        Route::get('/college', [SelectController::class, 'college']);

        Route::get('/program', [SelectController::class, 'program']);

    });

});