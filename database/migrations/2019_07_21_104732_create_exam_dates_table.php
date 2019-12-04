<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Carbon\Carbon;
class CreateExamDatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::create('exam_dates', function (Blueprint $table) {
        //     $table->increments('id');
        //     $table->integer('exam_id')->unsigned();
        //     $table->integer('section_id')->unsigned()->nullable();
        //     $table->integer('subject_id')->unsigned()->nullable();
        //     $table->date('date');
        //     $table->timestamps();

        //     $table->foreign('exam_id')->references('id')->on('exams');
        //     $table->foreign('section_id')->references('id')->on('sections');
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    // public function down()
    // {
    //     Schema::dropIfExists('exam_dates');
    // }
}
