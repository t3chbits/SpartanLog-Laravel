<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use App\Set;
use App\Http\Requests\SetRequest;

class SetController extends Controller
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
    public function index($workout_id, $exercise_id)
    {
        $sets = Auth::user()->sets()
            ->where('workout_id', '=', $workout_id)
            ->where('exercise_id', '=', $exercise_id)
            ->orderBy('created_at', 'DESC')
            ->get();
            
        return view('set.showAll', compact('sets'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\SetRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SetRequest $request)
    {
        $set = new Set($request->all());
        Auth::user()->sets()->save($set);
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $set = Auth::user()->sets()->findOrFail($id);
        return view('set.showOne', compact('set'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $set = Auth::user()->sets()->findOrFail($id);
        return view('set.edit', compact('set'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\SetRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SetRequest $request, $id)
    {
        $set = Auth::user()->sets()->findOrFail($id);
        $set->update($request->all());
        return redirect()->action('LogController@show', [$set->workout->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $set = Auth::user()->sets()->findOrFail($id);
        $set->delete();
        return redirect()->action('LogController@show', [$set->workout->id]);
    }
}
