<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $fillable = [
        'user_id',
        'name',
	];

    public function user()
	{
		return $this->belongsTo('App\User');
	}

	public function workouts()
    {
        return $this->belongsToMany('App\Workout', 'group_workout');
    }
}
