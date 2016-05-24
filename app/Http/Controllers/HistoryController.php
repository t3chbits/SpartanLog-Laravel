<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use JavaScript;
use App\Http\Requests;

class HistoryController extends Controller
{
	/**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function exerciseLineChart() {
    	$exercises = Auth::user()->exercises()
    		->has('sets') 	// only exercises with more than one set
    		->with('sets')
    		->get();

        JavaScript::put([
	        'exercises' => $exercises,
	    ]);

        return view('history', compact('exercises'));
    }
}
