<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return redirect('logs');
});

// description of api
Route::get('api', function () {
    return view('api');
});

Route::group(['middleware' => 'auth'], function () {

	Route::get('history', 'HistoryController@exerciseLineChart');

	Route::post('workouts/{id}/attachExercise', 'WorkoutController@attachExercise');
	Route::post('workouts/{id}/detachExercise', 'WorkoutController@detachExercise');
	Route::post('workouts/{id}/attachGroup', 'WorkoutController@attachGroup');
	Route::post('workouts/{id}/detachGroup', 'WorkoutController@detachGroup');
	Route::post('exercises/{id}/attachWorkout', 'ExerciseController@attachWorkout');
	Route::post('exercises/{id}/detachWorkout', 'ExerciseController@detachWorkout');
	Route::post('groups/{id}/attachWorkout', 'GroupController@attachWorkout');
	Route::post('groups/{id}/detachWorkout', 'GroupController@detachWorkout');

	Route::get('logs', 'LogController@index');
	Route::get('logs/{workout_id}', 'LogController@show');
	Route::resource('sets', 'SetController', ['except' => ['index', 'show', 'create']]);
	Route::resource('exercises', 'ExerciseController', ['except' => ['create', 'edit']]);
	Route::resource('workouts', 'WorkoutController', ['except' => ['create', 'edit']]);
	Route::resource('groups', 'GroupController', ['except' => ['create', 'edit']]);
});

// Authentication routes...
Route::get('login', 'Auth\AuthController@getLogin'); 
Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', 'Auth\AuthController@getLogout');
// Registration routes...
Route::get('auth/register', 'Auth\AuthController@getRegister');
Route::post('auth/register', 'Auth\AuthController@postRegister');