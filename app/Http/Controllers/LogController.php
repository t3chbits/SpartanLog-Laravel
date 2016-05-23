<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use Carbon\Carbon;

class LogController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * If a set has been created today,
     * redirect to the show function with the associted workout id.
     * Otherwise, redirect to WorkoutController@index
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $workout_id = Auth::user()->workouts()
            ->join('sets', 'sets.workout_id', '=', 'workouts.id')
            ->whereBetween('sets.created_at', 
                [Carbon::today(), Carbon::tomorrow()])
            ->select('workouts.id')
            ->first();

        if(!$workout_id) {
            return redirect()->action('WorkoutController@index');
        }

        return redirect()->action('LogController@show', [$workout_id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id, id of a workout
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $workout = Auth::user()->workouts()
            ->with('exercises')
            ->with('exercises.sets')
            ->findOrFail($id);

        // order by bodyRegion
        $exerciseList = Auth::user()->exercises()
            ->select('exercises.id', 'exercises.name')
            ->lists('name', 'id');

        return view('log', compact('workout', 'exerciseList'));
    }
}
