<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Carbon\Carbon;
class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('fatherName')->nullable();
            $table->string('motherName')->nullable();
            $table->string('DOB')->nullable();
            $table->integer('gender');
            $table->string('address')->nullable();
            $table->string('contact');
            $table->string('bloodGroup')->nullable();
            $table->string('rollNumber')->nullable();
            $table->string('birthCertificate')->nullable();
            $table->double('familyIncome')->nullable();
            $table->string('father_occupation')->nullable();
            $table->string('mother_occupation')->nullable();
            $table->double('height')->nullable();
            $table->double('weight')->nullable();
            $table->integer('is_shown')->default(1);
            $table->integer('no_of_siblings')->nullable();
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
        Schema::dropIfExists('students');
    }
}
