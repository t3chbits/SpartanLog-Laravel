<?php

namespace App\Api\V1\Controllers;

use JWTAuth;
use App\Workout;
use App\Http\Requests;
use Illuminate\Http\Request;
use Dingo\Api\Routing\Helpers;
use App\Http\Controllers\Controller;
use App\Http\Requests\WorkoutRequest;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class WorkoutController extends Controller
{
    use Helpers;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $currentUser = JWTAuth::parseToken()->authenticate();
        return $currentUser
            ->workouts()
            ->orderBy('created_at', 'DESC')
            ->get()
            ->toArray();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\WorkoutRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(WorkoutRequest $request)
    {
        $currentUser = JWTAuth::parseToken()->authenticate();

        $workout = new Workout($request->all());

        if($currentUser->workouts()->save($workout))
            return $this->response->created();
        else
            return $this->response->error('could_not_create_workout', 500);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $currentUser = JWTAuth::parseToken()->authenticate();

        $workout = $currentUser->workouts()->with('exercises')->find($id);

        if(!$workout)
            throw new NotFoundHttpException; 

        return $workout;
    }

    /*
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\WorkoutRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(WorkoutRequest $request, $id)
    {
        $currentUser = JWTAuth::parseToken()->authenticate();

        $workout = $currentUser->workouts()->find($id);
        if(!$workout)
            throw new NotFoundHttpException;

        if($workout->update($request->all()))
            return $workout;
        else
            return $this->response->error('could_not_update_workout', 500);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $currentUser = JWTAuth::parseToken()->authenticate();

        $workout = $currentUser->workouts()->find($id);

        if(!$workout)
            throw new NotFoundHttpException;

        if($workout->delete())
            return $this->response->noContent();
        else
            return $this->response->error('could_not_delete_workout', 500);
    }

    /**
     * Attach an exercise to a workout.
     *
     * @param  int  $id, int $exercise_id
     * @return \Illuminate\Http\Response
     */
    public function attachExercise($exercise_id, $id) 
    {   
        $currentUser = JWTAuth::parseToken()->authenticate();

        $workout = $currentUser->workouts()->find($id);

        if(!$workout)
            throw new NotFoundHttpException;

        // If the exercise corresponding to $exercise_id,
        // does not exist throw an error
        $exercise = $currentUser->exercises()->find($exercise_id);

        if(!$exercise)
            throw new NotFoundHttpException;

        // If the exercise is not already attached to the workout,
        // attach it.  Otherwise, throw an error.  
        if(!$workout->exercises()->find($exercise_id)) {
            
            // The attach method does not return a boolean value.
            $workout->exercises()->attach($exercise_id);
            return $this->response->noContent();
        
        } else {
            return $this->response->error('exercise_already_attached_to_workout', 500);
        }
    }

    /**
     * Detach an exercise from a workout.
     *
     * @param  int  $id, int $exercise_id
     * @return \Illuminate\Http\Response
     */
    public function detachExercise($exercise_id, $id) 
    {
        $currentUser = JWTAuth::parseToken()->authenticate();

        $workout = $currentUser->workouts()->find($id);

        if(!$workout)
            throw new NotFoundHttpException;

        $exercise = $currentUser->exercises()->find($exercise_id);

        if(!$exercise)
            throw new NotFoundHttpException;

        if($workout->exercises()->detach($exercise_id))
            return $this->response->noContent();
        else
            return $this->response->error('could_not_update_workout', 500);
    }

    /**
     * Attach a group to a workout.
     *
     * @param  int  $id, int $group_id
     * @return \Illuminate\Http\Response
     */
    public function attachGroup($group_id, $id) 
    {   
        $currentUser = JWTAuth::parseToken()->authenticate();

        $workout = $currentUser->workouts()->find($id);

        if(!$workout)
            throw new NotFoundHttpException;

        // If the group corresponding to $group_id,
        // does not exist throw an error
        $group = $currentUser->groups()->find($group_id);

        if(!$group)
            throw new NotFoundHttpException;

        // If the group is not already attached to the workout,
        // attach it.  Otherwise, throw an error.  
        if(!$workout->groups()->find($group_id)) {
            
            // The attach method does not return a boolean value.
            $workout->groups()->attach($group_id);
            return $this->response->noContent();
        
        } else {
            return $this->response->error('group_already_attached_to_workout', 500);
        }
    }

    /**
     * Detach a group from a workout.
     *
     * @param  int  $id, int $group_id
     * @return \Illuminate\Http\Response
     */
    public function detachGroup($group_id, $id) 
    {
        $currentUser = JWTAuth::parseToken()->authenticate();

        $workout = $currentUser->workouts()->find($id);

        if(!$workout)
            throw new NotFoundHttpException;

        $group = $currentUser->groups()->find($group_id);

        if(!$group)
            throw new NotFoundHttpException;

        if($workout->groups()->detach($group_id))
            return $this->response->noContent();
        else
            return $this->response->error('could_not_update_workout', 500);
    }
}