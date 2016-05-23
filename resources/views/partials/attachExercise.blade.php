{!! Form::open(['action' => ['WorkoutController@attachExercise', $workout->id]]) !!}

    <div class="form-group">
	    {!! Form::select('id[]', $exerciseList, null, [
	    	'id' => 'exercise_list', 
	    	'class' => 'form-control', 
	    	'multiple', 
	    	'style' => 'width:100%'
	    ]) !!}
	</div>

	<div class="form-group">
		{!! Form::submit('Add Exercises to Workout', ['class' => 'btn btn-primary form-control']) !!}
	</div>

{!! Form::close() !!}