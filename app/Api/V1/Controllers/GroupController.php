<?php

namespace App\Api\V1\Controllers;

use JWTAuth;
use App\Group;
use Illuminate\Http\Request;
use App\Http\Requests\GroupRequest;
use App\Api\V1\Controllers\BaseController;

class GroupController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $currentUser = JWTAuth::parseToken()->authenticate();
        return $currentUser
            ->groups()
            ->orderBy('created_at', 'DESC')
            ->get()
            ->toArray();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\GroupRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(GroupRequest $request)
    {
        $currentUser = JWTAuth::parseToken()->authenticate();

        $group = new Group($request->all());

        if($currentUser->groups()->save($group))
            return $this->response->array($group->toArray())->setStatusCode(201);
        else
            return $this->response->error('could_not_create_group', 500);
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

        $group = $currentUser->groups()->with('workouts')->find($id);

        if(!$group)
            return $this->response->errorNotFound(); 

        return $group;
    }

    /*
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\GroupRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(GroupRequest $request, $id)
    {
        $currentUser = JWTAuth::parseToken()->authenticate();

        $group = $currentUser->groups()->find($id);
        if(!$group)
            return $this->response->errorNotFound();

        if($group->update($request->all()))
            return $group;
        else
            return $this->response->error('could_not_update_group', 500);
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

        $group = $currentUser->groups()->find($id);

        if(!$group)
            return $this->response->errorNotFound();

        if($group->delete())
            return $this->response->noContent();
        else
            return $this->response->error('could_not_delete_group', 500);
    }

    /**
     * Attach a workout to a group.
     *
     * @param  int  $id, int $workout_id
     * @return \Illuminate\Http\Response
     */
    public function attachWorkout($workout_id, $id) // order of parameters matters
    {   
        $currentUser = JWTAuth::parseToken()->authenticate();

        $group = $currentUser->groups()->find($id);

        if(!$group)
            return $this->response->errorNotFound();

        // If the workout corresponding to $workout_id,
        // does not exist throw an error.
        $workout = $currentUser->workouts()->find($workout_id);

        if(!$workout)
            return $this->response->errorNotFound();

        // If the workout is not already attached to the workout,
        // attach it.  Otherwise, throw an error.  
        if(!$group->workouts()->find($workout_id)) {
            
            // The attach method does not return a boolean value.
            $group->workouts()->attach($workout_id);
            return $this->response->noContent();
        
        } else {
            return $this->response->error('workout_already_attached_to_group', 500);
        }
    }

    /**
     * Detach a workout from a group.
     *
     * @param  int  $id, int $workout_id
     * @return \Illuminate\Http\Response
     */
    public function detachWorkout($workout_id, $id) 
    {
        $currentUser = JWTAuth::parseToken()->authenticate();

        $group = $currentUser->groups()->find($id);

        if(!$group)
            return $this->response->errorNotFound();

        $workout = $currentUser->workouts()->find($workout_id);

        if(!$workout)
            return $this->response->errorNotFound();

        if($group->workouts()->detach($workout_id))
            return $this->response->noContent();
        else
            return $this->response->error('could_not_update_group', 500);
    }
}