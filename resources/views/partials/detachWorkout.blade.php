{!! Form::open(['action' => ['GroupController@detachWorkout', $group->id]]) !!}
	<div class"form-group">
		{!! Form::hidden('workout_id', $workout->id) !!}
	</div>
	<div class="form-group">
		{!! Form::button(
			'<span class="glyphicon glyphicon-minus-sign"></span>', 
			['type' => 'submit', 'class' => 'btn btn-danger btn-block']) !!}
	</div>
{!! Form::close() !!}