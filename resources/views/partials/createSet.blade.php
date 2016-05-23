{!! Form::open(['url' => 'sets']) !!}

@include('partials.setForm', [
	'submitButtonText' => 'Create Set',
	'workout_id' => $workout->id,
	'exercise_id' => $exercise->id
])

{!! Form::close() !!}