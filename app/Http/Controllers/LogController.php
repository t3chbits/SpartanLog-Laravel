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
            ->first();

        if(!$workout_id) {
            return redirect()->action('WorkoutController@index');
        }

        return redirect()->action('LogController@show', [$workout_id]);
    }

    /**
     * Get all exercises associated with the specified workout
     * and paginate them so that only one exercise is shown at a time.
     *
     * @param  int $workout_id
     * @return \Illuminate\Http\Response
     */
    public function show($workout_id)
    {
        $workout = Auth::user()->workouts()
            ->findOrFail($workout_id);

        $exercises = Auth::user()->exercises()
            ->join('workout_exercise', 'workout_exercise.exercise_id', '=', 'exercises.id')
            ->where('workout_exercise.workout_id', '=', $workout_id)
            ->select('exercises.id', 'exercises.name')
            ->with('sets')
            ->paginate(1);

        return view('log', compact('workout', 'exercises'));
    }
}
