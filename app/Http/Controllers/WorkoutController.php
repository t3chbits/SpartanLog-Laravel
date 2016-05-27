<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use App\Workout;
use App\Http\Requests\WorkoutRequest;

class WorkoutController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $workouts = Auth::user()->workouts()->simplePaginate(15);
        return view('workout.showAll', compact('workouts'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\WorkoutRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(WorkoutRequest $request)
    {
        $workout = new Workout($request->all());
        Auth::user()->workouts()->save($workout);
        return redirect('workouts');
    }

    /**
     * Display the specified resource.
     * Get a list of all exercises to populate a multiple select form.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $workout = Auth::user()->workouts()->findOrFail($id);

        $exerciseList = Auth::user()->exercises()
            ->select('exercises.id as exerciseID', 'exercises.name')
            ->lists('name', 'exerciseID');

        return view('workout.showOne', compact('workout', 'exerciseList'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\WorkoutRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(WorkoutRequest $request, $id)
    {
        $workout = Auth::user()->workouts()->findOrFail($id);
        $workout->update($request->all());
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $workout = Auth::user()->workouts()->findOrFail($id);
        $workout->delete();
        return redirect('workouts');
    }

    /**
     * Attach an exercise or several exercises to a workout.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function attachExercise(Request $request, $id) 
    {   
        $workout = Auth::user()->workouts()->findOrFail($id);
        $exerciseIDs = $request->exerciseID;
        
        if($exerciseIDs) {
            foreach($exerciseIDs as $exercise_id) {
                $exercise = Auth::user()->exercises()->findOrFail($exercise_id);

                if(!$workout->exercises()->find($exercise_id)) {
                    $workout->exercises()->attach($exercise_id);
                } 
            }
        }
        return redirect()->back();
    }

    /**
     * Detach an exercise from a workout.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function detachExercise(Request $request, $id) 
    {
        $workout = Auth::user()->workouts()->findOrFail($id);
        $workout->exercises()->detach($request->exercise_id);
        
        return redirect()->back();
    }

    /**
     * Attach a group or several groups to a workout.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function attachGroup(Request $request, $id) 
    {   
        $workout = Auth::user()->workouts()->findOrFail($id);
        $groupIDs = $request->id;

        foreach($groupIDs as $group_id) {
            $group = Auth::user()->groups()->findOrFail($group_id);

            if(!$workout->groups()->find($group_id)) {
                $workout->groups()->attach($group_id);
            } 
        }
        return redirect()->back();
    }

    /**
     * Detach a group from a workout.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function detachGroup(Request $request, $id) 
    {
        $workout = Auth::user()->workouts()->findOrFail($id);
        $workout->groups()->detach($request->group_id);
        
        return redirect()->back();
    }
}
