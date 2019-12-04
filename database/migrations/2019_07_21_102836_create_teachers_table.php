<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Carbon\Carbon;
class CreateTeachersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teachers', function (Blueprint $table) {
          $table->increments('id');
          $table->string('firstName');
          $table->string('lastName');
          $table->integer('gender')->nullable();
          $table->integer('salary')->nullable();
          $table->string('phoneNumber');
          $table->text('address')->nullable();
          $table->string('email')->unique();
          $table->string('password');
          $table->timestamps();
          $table->rememberToken()->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('teachers');
    }
}
