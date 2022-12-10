<?php

use App\Http\Livewire\Auth\SigninLivewire;
use App\Http\Livewire\College\CollegeFormLivewire;
use App\Http\Livewire\College\CollegeLivewire;
use App\Http\Livewire\Course\CourseFormLivewire;
use App\Http\Livewire\Course\CourseLivewire;
use App\Http\Livewire\Curriculum\CurriculumCourseLivewire;
use App\Http\Livewire\Curriculum\CurriculumFormLivewire;
use App\Http\Livewire\Curriculum\CurriculumLivewire;
use App\Http\Livewire\Curriculum\Form\CurriculumCourseLivewire as CurriculumCourseFormLivewire;
use App\Http\Livewire\Dashboard\DashboardLivewire;
use App\Http\Livewire\Officer\OfficerFormLivewire;
use App\Http\Livewire\Officer\OfficerLivewire;
use App\Http\Livewire\Permission\PermissionLivewire;
use App\Http\Livewire\Program\ProgramFormLivewire;
use App\Http\Livewire\Program\ProgramLivewire;
use App\Http\Livewire\Role\RoleLivewire;
use App\Http\Livewire\Role\RolePermissionLivewire;
use App\Http\Livewire\Student\StudentFormLivewire;
use App\Http\Livewire\Student\StudentLivewire;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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
    
    Route::get('/dashboard', DashboardLivewire::class)->name('dashboard');

    Route::get('/college', CollegeLivewire::class)->name('college');
    
    Route::get('/college/form/{college_id?}', CollegeFormLivewire::class)->name('college.form');
    
    Route::get('/program', ProgramLivewire::class)->name('program');

    Route::get('/program/form/{program_id?}', ProgramFormLivewire::class)->name('program.form');

    Route::get('/student', StudentLivewire::class)->name('student');

    Route::get('/student/form/{user_id?}', StudentFormLivewire::class)->name('student.form');
    
    Route::get('/course', CourseLivewire::class)->name('course');

    Route::get('/course/form/{course_id?}', CourseFormLivewire::class)->name('course.form');

    Route::get('/officer', OfficerLivewire::class)->name('officer');

    Route::get('/officer/form/{user_id?}', OfficerFormLivewire::class)->name('officer.form');

    Route::prefix('/curriculum')->group(function () {

        Route::get('/', CurriculumLivewire::class)->name('curriculum');

        Route::get('/form/{curriculum_id?}', CurriculumFormLivewire::class)->name('curriculum.form');

        Route::get('/{curriculum}/course', CurriculumCourseLivewire::class)->name('curriculum.course');

        Route::get('/{curriculum}/course/form', CurriculumCourseFormLivewire::class)->name('curriculum.course.form');

    });

    Route::prefix('/setting')->group(function () {

        Route::get('/permission', PermissionLivewire::class)->name('permission');

        Route::get('/role', RoleLivewire::class)->name('role');

        Route::get('/role/{role}/permission', RolePermissionLivewire::class)->name('role.permission');

    });

});
