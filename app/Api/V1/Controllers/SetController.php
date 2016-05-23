<?php

namespace App\Api\V1\Controllers;

use JWTAuth;
use App\Set;
use App\Http\Requests;
use Illuminate\Http\Request;
use Dingo\Api\Routing\Helpers;
use App\Http\Requests\SetRequest;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class SetController extends Controller
{
    use Helpers;

    /**
     * Display a listing of the resource.
     *
     * @param  int  $workout_id, int  $exercise_id
     * @return \Illuminate\Http\Response
     */
    public function index($workout_id, $exercise_id)
    {
        $currentUser = JWTAuth::parseToken()->authenticate();
        return $currentUser
            ->sets()
            ->where('workout_id', '=', $workout_id)
            ->where('exercise_id', '=', $exercise_id)
            ->orderBy('created_at', 'DESC')
            ->get()
            ->toArray();
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

        $set = new Set;

        $set->fill($request->all());

        if($currentUser->sets()->save($set))
            return $this->response->created();
        else
            return $this->response->error('could_not_create_set', 500);
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

        $set = $currentUser->sets()->find($id);

        if(!$set)
            throw new NotFoundHttpException; 

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
            throw new NotFoundHttpException;

        $set->fill($request->all());

        if($set->save())
            return $this->response->noContent();
        else
            return $this->response->error('could_not_update_set', 500);
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
            throw new NotFoundHttpException;

        if($set->delete())
            return $this->response->noContent();
        else
            return $this->response->error('could_not_delete_set', 500);
    }
}