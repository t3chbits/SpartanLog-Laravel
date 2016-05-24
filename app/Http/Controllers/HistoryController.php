<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use JavaScript;
use App\Http\Requests;

class HistoryController extends Controller
{
	/**
     * Get all exercises with at least one set.
     * Format exercises for javascript to be used 
     * in generating a line chart using Chart.js
     *
     * @return \Illuminate\Http\Response
     */
    public function getExercisesForLineChart() {
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
