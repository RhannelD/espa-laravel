<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCurriculumCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('curriculum_courses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('curriculum_id');
            $table->foreignId('course_id');
            $table->integer('year');
            $table->integer('semester');
            $table->string('requisite_standing');
            $table->timestamps();
            
            $table->foreign('curriculum_id')->references('id')->on('curricula')->onDelete('cascade');
            $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('curriculum_courses');
    }
}
