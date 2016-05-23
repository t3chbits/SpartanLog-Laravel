<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGroupWorkoutTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('group_workout', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('group_id')->unsigned();
            $table->integer('workout_id')->unsigned();
            $table->timestamps();

            $table->foreign('group_id')
                  ->references('id')
                  ->on('groups')
                  ->onDelete('cascade');

            $table->foreign('workout_id')
                  ->references('id')
                  ->on('workouts')
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
        Schema::drop('group_workout');
    }
}
