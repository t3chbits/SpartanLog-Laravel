{!! Form::open(['action' => ['WorkoutController@detachExercise', $workout->id]]) !!}
	<div class"form-group">
		{!! Form::hidden('exercise_id', $exercise->id) !!}
	</div>
    <div class="form-group">
    	{!! Form::button(
    		'<span class="glyphicon glyphicon-minus-sign"></span>', 
    		['type' => 'submit', 'class' => 'btn btn-danger btn-block']) !!}
	</div>
{!! Form::close() !!}