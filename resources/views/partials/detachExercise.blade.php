{!! Form::open(['action' => ['WorkoutController@detachExercise', $workout->id]]) !!}
	<div class"form-group">
		{!! Form::hidden('exercise_id', $exercise->id) !!}
	</div>
    <div class="form-group">
		{!! Form::submit('Remove '.$exercise->name.' From '.$workout->name, ['class' => 'btn btn-danger form-control']) !!}
	</div>
{!! Form::close() !!}