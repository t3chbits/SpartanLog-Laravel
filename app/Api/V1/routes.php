<?php
	
$api = app('Dingo\Api\Routing\Router');

$api->version('v1', function ($api) {

	$api->post('auth/login', 'App\Api\V1\Controllers\AuthController@login');
	$api->post('auth/signup', 'App\Api\V1\Controllers\AuthController@signup');
	$api->post('auth/recovery', 'App\Api\V1\Controllers\AuthController@recovery');
	$api->post('auth/reset', 'App\Api\V1\Controllers\AuthController@reset');

	$api->group([
			'middleware' => ['api.auth', 'cors', 'throttle'], 
			'namespace' => 'App\Api\V1\Controllers'
		], function ($api) {

		$api->post('workouts/{id}/attach', 'WorkoutController@attachExercise');
		$api->post('workouts/{id}/detach', 'WorkoutController@detachExercise');
		
		$api->post('groups/{id}/attach', 'GroupController@attachWorkout');
		$api->post('groups/{id}/detach', 'GroupController@detachWorkout');

		$api->resource('sets', 'SetController', ['except' => ['edit', 'create']]);
		$api->resource('exercises', 'ExerciseController', ['except' => ['edit', 'create']]);
		$api->resource('workouts', 'WorkoutController', ['except' => ['edit', 'create']]);
		$api->resource('groups', 'GroupController', ['except' => ['edit', 'create']]);
	});
});
