<?php

namespace App\Api\V1\Controllers;

use JWTAuth;
use App\Group;
use Illuminate\Http\Request;
use App\Http\Requests\GroupRequest;
use Illuminate\Support\Facades\Schema;
use App\Api\V1\Controllers\BaseController;

class GroupController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * The orderByIf statement defaults to orderBy('created_at', 'asc').
     * orderByDirection must be either 'asc' or 'desc' if supplied.
     * orderByColumn must be a column in the groups table if supplied.
     * If no direction is supplied and a column is supplied, 
     * then the direction defaults to 'desc'.
     *
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $currentUser = JWTAuth::parseToken()->authenticate();

        if($request->orderByColumn and !Schema::hasColumn('groups', $request->orderByColumn))
        {
            return $this->response->error('OrderByColumn does not exist in the table.', 400);
        }

        $itemsPerPage = 25;
        if($request->itemsPerPage and $request->itemsPerPage <= 0) 
        {
            return $this->response->error('ItemsPerPage must be greater than 0.', 400);
        
        } else {
            $itemsPerPage = $request->itemsPerPage;
        }

        return $currentUser
            ->groups()
            ->orderByIf($request->orderByColumn, $request->orderByDirection)
            ->paginate($itemsPerPage);
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
            return $this->response->error('Unable to create the group.', 500);
    }

    /**
     * Display the specified resource.
     *
     * If the expand query parameter is set to false,
     * then the workouts associated with the group 
     * will not be returned in the response.
     *
     * @param  int  $id, Request $request
     * @return \Illuminate\Http\Response
     */
    public function show($id, Request $request)
    {
        $currentUser = JWTAuth::parseToken()->authenticate();

        $expand = $request->expand;

        if($expand == null or filter_var($expand, FILTER_VALIDATE_BOOLEAN)) {
            $group = $currentUser->groups()
                ->with('workouts')
                ->find($id);
        } else {
            $group = $currentUser->groups()->find($id);
        }

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
            return $this->response->error('Unable to update the group.', 500);
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
            return $this->response->error('Unable to delete the group.', 500);
    }

    /**
     * Attach an workout to a group.
     * 
     * Example query string:
     * homestead.app/api/v1/groups/1/attach?workoutID=1
     *
     * @param  int  $id, Request $request
     * @return \Illuminate\Http\Response
     */
    public function attachWorkout($id, Request $request) 
    {   
        $currentUser = JWTAuth::parseToken()->authenticate();

        $group = $currentUser->groups()->find($id);

        if(!$group)
            return $this->response->errorNotFound();

        $workoutID = $request->input('workoutID');

        // If the workout corresponding to $workoutID,
        // does not exist throw an error
        $workout = $currentUser->workouts()->find($workoutID);

        if(!$workout)
            return $this->response->errorNotFound();

        // If the workout is not already attached to the group,
        // attach it.  Otherwise, throw an error because it will get
        // attached multiple times.
        if(!$group->workouts()->find($workoutID)) {
            
            // The attach method does not return a boolean value.
            $group->workouts()->attach($workoutID);
            return $this->response->noContent();
        
        } else {
            return $this->response->error(
                'The workout is already attached to the group.', 400);
        }
    }

    /**
     * Detach an workout or several workouts from a group.
     *
     * Example query string:
     * homestead.app/api/v1/groups/1/detach?workoutID=1
     *
     * @param  int  $id, Request $request
     * @return \Illuminate\Http\Response
     */
    public function detachWorkout($id, Request $request) 
    {
        $currentUser = JWTAuth::parseToken()->authenticate();

        $group = $currentUser->groups()->find($id);

        if(!$group)
            return $this->response->errorNotFound();

        $workoutID = $request->input('workoutID');

        $workout = $currentUser->workouts()->find($workoutID);

        if(!$workout)
            return $this->response->errorNotFound();

        if($group->workouts()->find($workoutID)) {
            if($group->workouts()->detach($workoutID))
                return $this->response->noContent();
            else
                return $this->response->error('Unable to detach the workout.', 500);
        } else {
            return $this->response->error('The workout was already detached.', 400);
        }
    }
}