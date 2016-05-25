<?php

namespace App\Api\V1\Controllers;

use JWTAuth;
use App\Set;
use Carbon\Carbon;
use App\Http\Requests;
use Illuminate\Http\Request;
use Dingo\Api\Routing\Helpers;
use App\Http\Requests\SetRequest;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

use Illuminate\Database\Query\Builder;

// This is used to add optional query statements.
// This seemed to be a more concise solution compared
// to using the when method.
Builder::macro('if', function ($condition, $column, $operator, $value) {
    if($condition) {
        return $this->where($column, $operator, $value);
    }
    return $this;
});

class SetController extends Controller
{
    use Helpers;

    /**
     * Display a listing of the sets that are associated with a workout 
     * and an exercise, and that were created between a start date
     * and an end date.  
     *
     * If no date query parameters are supplied, then it defaults to getting
     * all sets created today.    
     *
     * If Carbon::create fails, an internal server error is returned, along
     * with a helpful error message.  Catching illegalArgumentExceptions
     * was not successful, so try-catch blocks were removed.
     *
     * @param  int  $workout_id, int  $exercise_id
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $currentUser = JWTAuth::parseToken()->authenticate();

        $startDate = Carbon::today('CST');
        if($request->start_year and $request->start_month and $request->start_day) {
            $startDate = Carbon::create($request->start_year, 
                $request->start_month, $request->start_day, $request->start_hour, 
                $request->start_minute, $request->start_second, $request->tz);
        }

        $endDate = Carbon::tomorrow('CST');
        if($request->end_year and $request->end_month and $request->end_day) {
            $endDate = Carbon::create($request->end_year, 
                $request->end_month, $request->end_day, $request->end_hour, 
                $request->end_minute, $request->end_second, $request->tz);
        }

        if($request->workout_id) {
            $workout = $currentUser->workouts()->find($request->workout_id);

            if(!$workout)
                throw new NotFoundHttpException;
        }

        if($request->exercise_id) {
            $exercise = $currentUser->exercises()->find($request->exercise_id);

            if(!$exercise)
                throw new NotFoundHttpException;
        }

        return $currentUser->sets()
            ->if($request->workout_id, 'workout_id', '=', $request->workout_id)
            ->if($request->exercise_id, 'exercise_id', '=', $request->exercise_id)
            ->whereBetween('sets.created_at', [$startDate, $endDate])
            ->orderBy('created_at', 'DESC')
            ->get()
            ->toArray();

        return $response;
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

        if($set->update($request->all()))
            return $set;
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