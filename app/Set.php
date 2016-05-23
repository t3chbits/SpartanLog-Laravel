<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Set extends Model
{
    protected $fillable = [
        'user_id',
        'workout_id',
        'exercise_id',
        'repetitions',
        'weight'
	];

    public function user()
	{
		return $this->belongsTo('App\User');
	}

    public function workout()
    {
        return $this->belongsTo('App\Workout');
    }

    public function exercise()
    {
        return $this->belongsTo('App\Exercise');
    }
}
