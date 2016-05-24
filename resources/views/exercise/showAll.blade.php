@extends('app')

@section('content')
	<div class="container">	

		<div>@include('errors.list')</div>	

		@if(count($exercises))
			<div class="well">
			<h3 class="text-center">Select an Exercise</h3>
			@foreach ($exercises as $exercise)
				<div class="text-center">
				<a class="btn btn-default btn-block" href="{{ url('exercises', [$exercise->id]) }}">
					{{ $exercise->name }}
				</a>
				</div>
			@endforeach
			</div>
		@endif

		<div class="well">
			<button class="btn btn-primary btn-block" data-toggle="collapse" data-target="#showExerciseForm">
				Create a New Exercise
			</button>
		</div>

		<div class="well collapse" id="showExerciseForm">

			<h2 class="text-center">Create A New Exercise</h2>

			{!! Form::open(['action' => 'ExerciseController@store']) !!}
		
				@include('partials.exerciseForm', [
					'submitButtonText' => 'Create Exercise',
					'placeholder' => 'Name'
				])

			{!! Form::close() !!}

		</div>

		{!! $exercises->links() !!}
	</div>
@stop