<?php

namespace App\Api\V1\Controllers;

use JWTAuth;
use App\Workout;
use Illuminate\Http\Request;
use App\Http\Requests\WorkoutRequest;
use Illuminate\Support\Facades\Schema;
use App\Api\V1\Controllers\BaseController;

class WorkoutController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $currentUser = JWTAuth::parseToken()->authenticate();

        if($request->orderByColumn and !Schema::hasColumn('workouts', $request->orderByColumn)) {
            return $this->response->error('OrderByColumn does not exist in the table.', 400);
        }

        $itemsPerPage = 25;
        if($request->itemsPerPage and $request->itemsPerPage <= 0) {
            return $this->response->error('ItemsPerPage must be greater than 0.', 400);
        
        } else {
            $itemsPerPage = $request->itemsPerPage;
        }

        return $currentUser
            ->workouts()
            ->orderByIf($request->orderByColumn, $request->orderByDirection)
            ->paginate($itemsPerPage);
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
            return $this->response->array($workout->toArray())->setStatusCode(201);
        else
            return $this->response->error('Unable to create the workout.', 500);
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

        $workout = $currentUser->workouts()
            ->with('exercises', 'groups')
            ->find($id);

        if(!$workout)
            return $this->response->errorNotFound(); 

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
            return $this->response->errorNotFound();

        if($workout->update($request->all()))
            return $workout;
        else
            return $this->response->error('Unable to update the workout.', 500);
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
            return $this->response->errorNotFound();

        if($workout->delete())
            return $this->response->noContent();
        else
            return $this->response->error('Unable to delete the workout.', 500);
    }

    /**
     * Attach an exercise to a workout.
     * 
     * Example query string:
     * homestead.app/api/v1/workouts/1/attach?exerciseID=1
     *
     * @param  int  $id, Request $request
     * @return \Illuminate\Http\Response
     */
    public function attachExercise($id, Request $request) 
    {   
        $currentUser = JWTAuth::parseToken()->authenticate();

        $workout = $currentUser->workouts()->find($id);

        if(!$workout)
            return $this->response->errorNotFound();

        $exerciseID = $request->input('exerciseID');

        // If the exercise corresponding to $exerciseID,
        // does not exist throw an error
        $exercise = $currentUser->exercises()->find($exerciseID);

        if(!$exercise)
            return $this->response->errorNotFound();

        // If the exercise is not already attached to the workout,
        // attach it.  Otherwise, throw an error because it will get
        // attached multiple times.
        if(!$workout->exercises()->find($exerciseID)) {
            
            // The attach method does not return a boolean value.
            $workout->exercises()->attach($exerciseID);
            return $this->response->noContent();
        
        } else {
            return $this->response->error(
                'The exercise is already attached to the workout.', 400);
        }
    }

    /**
     * Detach an exercise or several exercises from a workout.
     *
     * Example query string:
     * homestead.app/api/v1/workouts/1/detach?exerciseID=1
     *
     * @param  int  $id, Request $request
     * @return \Illuminate\Http\Response
     */
    public function detachExercise($id, Request $request) 
    {
        $currentUser = JWTAuth::parseToken()->authenticate();

        $workout = $currentUser->workouts()->find($id);

        if(!$workout)
            return $this->response->errorNotFound();

        $exerciseID = $request->input('exerciseID');

        $exercise = $currentUser->exercises()->find($exerciseID);

        if(!$exercise)
            return $this->response->errorNotFound();

        if($workout->exercises()->find($exerciseID)) {
            if($workout->exercises()->detach($exerciseID))
                return $this->response->noContent();
            else
                return $this->response->error('Unable to detach the exercise.', 500);
        } else {
            return $this->response->error('The exercise was already detached.', 400);
        }
    }
}