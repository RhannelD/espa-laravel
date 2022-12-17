<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCurriculumCoursePrerequisitesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('curriculum_course_prerequisites', function (Blueprint $table) {
            $table->id();
            $table->foreignId('prerequisite_cc_id');
            $table->foreignId('corequisite_cc_id');
            $table->timestamps();

            $table->foreign('prerequisite_cc_id')->references('id')->on('curriculum_courses')->onDelete('cascade');
            $table->foreign('corequisite_cc_id')->references('id')->on('curriculum_courses')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('curriculum_course_prerequisites');
    }
}
