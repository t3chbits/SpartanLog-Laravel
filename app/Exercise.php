<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Exercise extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'bodyRegion'
	];

    public function user()
	{
		return $this->belongsTo('App\User');
	}

	public function workouts()
    {
        return $this->belongsToMany('App\Workout', 'workout_exercise');
    }

    public function sets()
    {
        return $this->hasMany('App\Set');
    }
}
