<?php

namespace App\Http\Controllers;

use Auth;
use App\Exercise;
use Illuminate\Http\Request;
use App\Http\Requests\ExerciseRequest;

class ExerciseController extends Controller
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
        $exercises = Auth::user()->exercises()
            ->simplePaginate(15);
        return view('exercise.showAll', compact('exercises'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\ExerciseRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ExerciseRequest $request)
    {
        $exercise = new Exercise($request->all());

        Auth::user()->exercises()->save($exercise);

        return redirect('exercises');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $exercise = Auth::user()->exercises()->findOrFail($id);
        return view('exercise.showOne', compact('exercise'));    
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\ExerciseRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ExerciseRequest $request, $id)
    {
        $exercise = Auth::user()->exercises()->findOrFail($id);
        $exercise->update($request->all());
        return redirect()->action('ExerciseController@show', [$exercise->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $exercise = Auth::user()->exercises()->findOrFail($id);
        $exercise->delete();
        return redirect('exercises');
    }
}
