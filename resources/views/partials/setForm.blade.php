<div class"form-group">
	{!! Form::hidden('workout_id', $workout_id) !!}
</div>

<div class"form-group">
	{!! Form::hidden('exercise_id', $exercise_id) !!}
</div>

<div class="form-group">
	{!! Form::input('number', 'repetitions', null, ['class' => 'form-control', 'placeholder' => 'Repetitions']) !!}
</div>

<div class="form-group">
	{!! Form::input('number', 'weight', null, ['class' => 'form-control', 'placeholder' => 'Weight']) !!}
</div>

<div class="form-group">
	{!! Form::submit($submitButtonText, ['class' => 'btn btn-primary form-control']) !!}
</div>