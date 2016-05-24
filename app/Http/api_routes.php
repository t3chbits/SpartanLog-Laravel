<?php
	
$api = app('Dingo\Api\Routing\Router');

$api->version('v1', function ($api) {

	$api->post('auth/login', 'App\Api\V1\Controllers\AuthController@login');
	$api->post('auth/signup', 'App\Api\V1\Controllers\AuthController@signup');
	$api->post('auth/recovery', 'App\Api\V1\Controllers\AuthController@recovery');
	$api->post('auth/reset', 'App\Api\V1\Controllers\AuthController@reset');

	$api->group([
			'middleware' => ['api.auth', 'cors'], 
			'namespace' => 'App\Api\V1\Controllers'
		], function ($api) {

		$api->group(['prefix' => 'workouts/{workout_id}/exercises/{exercise_id}'], function ($api) {
			$api->get('sets', 'SetController@index');
		});

		$api->group(['prefix' => 'exercises/{exercise_id}'], function ($api) {
			$api->get('workouts/{id}/attach', 'WorkoutController@attachExercise');
			$api->get('workouts/{id}/detach', 'WorkoutController@detachExercise');
		});

		$api->group(['prefix' => 'workouts/{workout_id}'], function ($api) {
			$api->get('exercises/{id}/attach', 'ExerciseController@attachWorkout');
			$api->get('exercises/{id}/detach', 'ExerciseController@detachWorkout');
			
			$api->get('groups/{id}/attach', 'GroupController@attachWorkout');
			$api->get('groups/{id}/detach', 'GroupController@detachWorkout');
		});

		$api->group(['prefix' => 'groups/{group_id}'], function ($api) {
			$api->get('workouts/{id}/attach', 'WorkoutController@attachGroup');
			$api->get('workouts/{id}/detach', 'WorkoutController@detachGroup');
		});

		$api->resource('sets', 'SetController', ['except' => ['index', 'edit', 'create']]);
		$api->resource('exercises', 'ExerciseController', ['except' => ['edit', 'create']]);
		$api->resource('workouts', 'WorkoutController', ['except' => ['edit', 'create']]);
		$api->resource('groups', 'GroupController', ['except' => ['edit', 'create']]);
	});

});
