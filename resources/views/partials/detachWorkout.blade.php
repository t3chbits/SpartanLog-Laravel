{!! Form::open(['action' => ['GroupController@detachWorkout', $group->id]]) !!}
<div class"form-group">
	{!! Form::hidden('workout_id', $workout->id) !!}
</div>
<div class="form-group">
	{!! Form::submit('Remove Workout From Group', ['class' => 'btn btn-danger form-control']) !!}
</div>
{!! Form::close() !!}