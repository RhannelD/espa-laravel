<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CollegeController;
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

    Route::apiResource('/college', CollegeController::class);

});
