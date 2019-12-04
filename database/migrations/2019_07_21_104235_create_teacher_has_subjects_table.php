<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Carbon\Carbon;
class CreateTeacherHasSubjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teacher_has_subjects', function (Blueprint $table) {
          $table->integer('teacher_id')->unsigned();
          $table->integer('subject_id')->unsigned();
          $table->primary(['teacher_id','subject_id']);
          $table->foreign('teacher_id')->references('id')->on('teachers');
          $table->foreign('subject_id')->references('id')->on('subjects');
          $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('teacher_has_subjects');
    }
}
