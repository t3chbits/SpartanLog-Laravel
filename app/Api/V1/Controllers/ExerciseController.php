<?php

namespace App\Api\V1\Controllers;

use JWTAuth;
use App\Exercise;
use Illuminate\Http\Request;
use App\Http\Requests\ExerciseRequest;
use Illuminate\Support\Facades\Schema;
use App\Api\V1\Controllers\BaseController;

class ExerciseController extends BaseController
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

        if($request->orderByColumn and !Schema::hasColumn('exercises', $request->orderByColumn))
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
            ->exercises()
            ->orderByIf($request->orderByColumn, $request->orderByDirection)
            ->paginate($itemsPerPage);
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
            return $this->response->array($exercise->toArray())->setStatusCode(201);
        else
            return $this->response->error('Unable to create the exercise.', 500);
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
            return $this->response->errorNotFound(); 

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
            return $this->response->errorNotFound();

        if($exercise->update($request->all()))
            return $exercise;
        else
            return $this->response->error('Unable to update the exercise.', 500);
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
            return $this->response->errorNotFound();

        if($exercise->delete())
            return $this->response->noContent();
        else
            return $this->response->error('Unable to destroy the exercise.', 500);
    }
}