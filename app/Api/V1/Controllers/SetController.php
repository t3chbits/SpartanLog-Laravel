<?php

namespace App\Api\V1\Controllers;

use JWTAuth;
use App\Set;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests\SetRequest;
use Illuminate\Support\Facades\Schema;
use App\Api\V1\Controllers\BaseController;

class SetController extends BaseController
{
    /**
     * Display a listing of the sets that are associated with a workout 
     * and an exercise, and that were created between a start date
     * and an end date.  
     *
     * If no date query parameters are supplied, then it defaults to getting
     * all sets created today.    
     *
     * The orderByWhen statement defaults to orderBy('created_at', 'asc').
     * orderByDirection must be either 'asc' or 'desc' if supplied.
     * orderByColumn must be a column in sets table if supplied.
     * If no direction is supplied and a column is supplied, 
     * then the direction defaults to 'desc'.
     *
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $currentUser = JWTAuth::parseToken()->authenticate();

        $startDate = Carbon::today('CST'); // default to today at 12:00am
        if($request->startYear and $request->startMonth and $request->startDay) {
            try { 
                $startDate = Carbon::create($request->startYear, 
                    $request->startMonth, $request->startDay, $request->startHour, 
                    $request->startMinute, $request->startSecond, $request->tz);
            
            // For \InvalidArgumentException, the backslash is necessary
            // because of namespacing issues
            } catch(\InvalidArgumentException $x) { 
                return $this->response->error('Carbon create start date failed.', 400);
            }
        }

        $endDate = Carbon::tomorrow('CST'); // default to tomorrow at 12:00am
        if($request->endYear and $request->endMonth and $request->endDay) {
            try { 
                $endDate = Carbon::create($request->endYear, 
                    $request->endMonth, $request->endDay, $request->endHour, 
                    $request->endMinute, $request->endSecond, $request->tz);

            // For \InvalidArgumentException, the backslash is necessary
            // because of namespacing issues
            } catch(\InvalidArgumentException $x) { 
                return $this->response->error('Carbon create start date failed.', 400);
            }
        }

        if($request->workoutID) {
            $workout = $currentUser->workouts()->find($request->workoutID);

            if(!$workout)
                return $this->response->errorNotFound();
        }

        if($request->exerciseID) {
            $exercise = $currentUser->exercises()->find($request->exerciseID);

            if(!$exercise)
                return $this->response->errorNotFound();
        }

        if($request->orderByColumn and !Schema::hasColumn('sets', $request->orderByColumn))
        {
            return $this->response->error('OrderByColumn does not exist in the table.', 400);
        }

        return $currentUser->sets()
            ->if($request->workoutID, 'workout_id', '=', $request->workoutID)
            ->if($request->exerciseID, 'exercise_id', '=', $request->exerciseID)
            ->whereBetween('sets.created_at', [$startDate, $endDate])
            ->orderByWhen($request->orderByColumn, $request->orderByDirection)
            ->paginate(25);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\SetRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SetRequest $request)
    {
        $currentUser = JWTAuth::parseToken()->authenticate();

        $set = new Set($request->all());

        if($currentUser->sets()->save($set)) // should return updated resource
            return $this->response->array($set->toArray())->setStatusCode(201);
        else
            return $this->response->error('Unable to create the set.', 500);
    }

    /**
     * Display the specified resource.
     *
     * If expand=false, the exercise and workout associated with
     * the set are not loaded.
     * homestead.app/api/v1/sets/1?expand=false
     *
     * If expand=true or expand is not specified in the query string, 
     * the exercise and workout associated with the set are not loaded.
     * 
     *
     * @param  int  $id, Request $request
     * @return \Illuminate\Http\Response
     */
    public function show($id, Request $request)
    {
        $currentUser = JWTAuth::parseToken()->authenticate();

        $expand = $request->expand;

        if($expand == null or filter_var($expand, FILTER_VALIDATE_BOOLEAN)) {
            $set = $currentUser->sets()
                ->with('exercise', 'workout')
                ->find($id);

        } else {
            $set = $currentUser->sets()->find($id);
        }

        if(!$set)
            return $this->response->errorNotFound();

        return $set;
    }

    /*
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\SetRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SetRequest $request, $id)
    {
        $currentUser = JWTAuth::parseToken()->authenticate();

        $set = $currentUser->sets()->find($id);
        if(!$set)
            return $this->response->errorNotFound();

        if($set->update($request->all()))
            return $set;
        else
            return $this->response->error('Unable to update the set.', 500);
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

        $set = $currentUser->sets()->find($id);

        if(!$set)
            return $this->response->errorNotFound();

        if($set->delete())
            return $this->response->noContent();
        else
            return $this->response->error('Unable to destroy the set.', 500);
    }
}