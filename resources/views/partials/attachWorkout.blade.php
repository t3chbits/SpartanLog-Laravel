{!! Form::open(['action' => ['GroupController@attachWorkout', $group->id]]) !!}

    <div class="form-group">
	    {!! Form::select('id[]', $workoutList, null, [
	    	'id' => 'workout_list', 
	    	'class' => 'form-control', 
	    	'multiple', 
	    	'style' => 'width:100%'
	    ]) !!}
	</div>

	<div class="form-group">
		{!! Form::submit('Add Workouts to Group', ['class' => 'btn btn-primary form-control']) !!}
	</div>

{!! Form::close() !!}