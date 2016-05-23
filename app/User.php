<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * This mutator automatically hashes the password.
     *
     * @var string
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = \Hash::make($value);
    }

    public function groups()
    {
        return $this->hasMany('App\Group');
    }

    public function workouts()
    {
        return $this->hasMany('App\Workout');
    }

    public function exercises()
    {
        return $this->hasMany('App\Exercise');
    }

    public function sets()
    {
        return $this->hasMany('App\Set');
    }
}
