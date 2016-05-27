<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use App\Group;
use App\Http\Requests\GroupRequest;

class GroupController extends Controller
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
        $groups = Auth::user()->groups()->simplePaginate(15);
        return view('group.showAll', compact('groups'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\GroupRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(GroupRequest $request)
    {
        $group = new Group($request->all());
        Auth::user()->groups()->save($group);
        return redirect('groups');
    }

    /**
     * Display the specified resource.
     * Get a list of all workouts to populate a multiple select form.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $group = Auth::user()->groups()->findOrFail($id);

        $workoutList = Auth::user()->workouts()
            ->select('workouts.id as workoutID', 'workouts.name')
            ->lists('name', 'workoutID');

        return view('group.showOne', compact('group', 'workoutList'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\groupRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(GroupRequest $request, $id)
    {
        $group = Auth::user()->groups()->findOrFail($id);
        $group->update($request->all());
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
        $group = Auth::user()->groups()->findOrFail($id);
        $group->delete();
        return redirect('groups');
    }

    /**
     * Attach a workout or several workouts to a group.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function attachWorkout(Request $request, $id) 
    {   
        $group = Auth::user()->groups()->findOrFail($id);
        $workoutIDs = $request->workoutID;

        if($workoutIDs) {
            foreach($workoutIDs as $workout_id) {
                $workout = Auth::user()->workouts()->findOrFail($workout_id);

                if(!$group->workouts()->find($workout_id)) {
                    $group->workouts()->attach($workout_id);
                } 
            }
        }
        return redirect()->back();
    }

    /**
     * Detach a workout from a group.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function detachWorkout(Request $request, $id) 
    {
        $group = Auth::user()->groups()->findOrFail($id);
        $group->workouts()->detach($request->workout_id);
        
        return redirect()->back();
    }
}
