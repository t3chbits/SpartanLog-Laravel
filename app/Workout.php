<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Workout extends Model
{
    protected $fillable = [
        'user_id',
        'name',
	];

    public function user()
	{
		return $this->belongsTo('App\User');
	}

	public function groups()
    {
        return $this->belongsToMany('App\Group', 'group_workout');
    }

    public function exercises()
    {
        return $this->belongsToMany('App\Exercise', 'workout_exercise');
    }

    public function sets()
    {
        return $this->hasMany('App\Set');
    }
}
