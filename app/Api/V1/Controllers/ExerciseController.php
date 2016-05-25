<?php

namespace App\Api\V1\Controllers;

use JWTAuth;
use App\Exercise;
use App\Http\Requests;
use Illuminate\Http\Request;
use Dingo\Api\Routing\Helpers;
use App\Http\Controllers\Controller;
use App\Http\Requests\ExerciseRequest;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ExerciseController extends Controller
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
            ->exercises()
            ->orderBy('created_at', 'DESC')
            ->get()
            ->toArray();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\ExerciseRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ExerciseRequest $request)
    {
        $currentUser = JWTAuth::parseToken()->authenticate();

        $exercise = new Exercise($request->all());

        if($currentUser->exercises()->save($exercise))
            return $this->response->created();
        else
            return $this->response->error('could_not_create_exercise', 500);
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

        $exercise = $currentUser->exercises()->with('workouts')->find($id);

        if(!$exercise)
            throw new NotFoundHttpException; 

        return $exercise;
    }

    /*
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\ExerciseRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ExerciseRequest $request, $id)
    {
        $currentUser = JWTAuth::parseToken()->authenticate();

        $exercise = $currentUser->exercises()->find($id);
        if(!$exercise)
            throw new NotFoundHttpException;

        if($exercise->update($request->all()))
            return $exercise;
        else
            return $this->response->error('could_not_update_exercise', 500);
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

        $exercise = $currentUser->exercises()->find($id);

        if(!$exercise)
            throw new NotFoundHttpException;

        if($exercise->delete())
            return $this->response->noContent();
        else
            return $this->response->error('could_not_delete_exercise', 500);
    }

    /**
     * Attach a workout to an exercise.
     *
     * @param  int  $id, int $workout_id
     * @return \Illuminate\Http\Response
     */
    public function attachWorkout($workout_id, $id) 
    {   
        $currentUser = JWTAuth::parseToken()->authenticate();

        $exercise = $currentUser->exercises()->find($id);

        if(!$exercise)
            throw new NotFoundHttpException;

        // If the workout corresponding to $workout_id,
        // does not exist throw an error.
        $workout = $currentUser->workouts()->find($workout_id);

        if(!$workout)
            throw new NotFoundHttpException;

        // If the workout is not already attached to the workout,
        // attach it.  Otherwise, throw an error.  
        if(!$exercise->workouts()->find($workout_id)) {
            
            // The attach method does not return a boolean value.
            $exercise->workouts()->attach($workout_id);
            return $this->response->noContent();
        
        } else {
            return $this->response->error('workout_already_attached_to_exercise', 500);
        }
    }

    /**
     * Detach a workout from an exercise.
     *
     * @param  int  $id, int $workout_id
     * @return \Illuminate\Http\Response
     */
    public function detachWorkout($workout_id, $id) 
    {
        $currentUser = JWTAuth::parseToken()->authenticate();

        $exercise = $currentUser->exercises()->find($id);

        if(!$exercise)
            throw new NotFoundHttpException;

        $workout = $currentUser->workouts()->find($workout_id);

        if(!$workout)
            throw new NotFoundHttpException;

        if($exercise->workouts()->detach($workout_id))
            return $this->response->noContent();
        else
            return $this->response->error('could_not_update_exercise', 500);
    }
}