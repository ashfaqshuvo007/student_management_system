<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Carbon\Carbon;
class CreateTeacherHasSectionsTable extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
       Schema::create('teacher_has_sections', function (Blueprint $table) {
           $table->integer('teacher_id')->unsigned();
           $table->integer('section_id')->unsigned();
           $table->integer('class_teacher');
           $table->primary(['teacher_id','section_id']);
           $table->foreign('teacher_id')->references('id')->on('teachers');
           $table->foreign('section_id')->references('id')->on('sections');
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
       Schema::dropIfExists('teacher_has_sections');
   }
}
