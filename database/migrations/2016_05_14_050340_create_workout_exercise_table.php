<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWorkoutExerciseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('workout_exercise', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('workout_id')->unsigned();
            $table->integer('exercise_id')->unsigned();
            $table->timestamps();

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
        Schema::drop('workout_exercise');
    }
}
