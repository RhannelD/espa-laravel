<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCurriculumReferencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('curriculum_references', function (Blueprint $table) {
            $table->id();
            $table->foreignId('curriculum_id');
            $table->string('reference');
            $table->timestamps();
            
            $table->foreign('curriculum_id')->references('id')->on('curricula')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('curriculum_references');
    }
}
