<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Auth\SigninLivewire;
use App\Http\Livewire\Student\StudentLivewire;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () { return redirect()->route('signin'); })->name('index');

Route::get('/signout', function () { Auth::logout(); return redirect()->route('index'); })->name('signout');

Route::middleware(['guest'])->group(function () {
    
    Route::get('/signin', SigninLivewire::class)->name('signin');
    
});

Route::middleware(['user'])->group(function () {
    
    Route::get('/student', StudentLivewire::class)->name('student');

});
