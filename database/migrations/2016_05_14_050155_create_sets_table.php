<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sets', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->integer('workout_id')->unsigned();
            $table->integer('exercise_id')->unsigned();
            $table->integer('repetitions')->unsigned();
            $table->integer('weight')->unsigned();
            $table->timestamps();

            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');

            $table->foreign('workout_id')
                  ->references('id')
                  ->on('workouts')
                  ->onDelete('cascade');

            $table->foreign('exercise_id')
                  ->references('id')
                  ->on('exercises')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('sets');
    }
}
