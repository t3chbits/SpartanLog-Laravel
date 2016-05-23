@extends('app')

@section('content')
	<div class="container">	

		<div>@include('errors.list')</div>	

		@if(count($workouts))
			<div class="well">
			<h3 class="text-center">Select a Workout</h3>
			@foreach ($workouts as $workout)
				<div class="text-center">
				<a class="btn btn-default btn-block" href="{{ url('workouts', [$workout->id]) }}">
					{{ $workout->name }}
				</a>
				</div>
			@endforeach
			</div>
		@endif

		<div class="well">
			<button class="btn btn-primary btn-block" data-toggle="collapse" data-target="#createWk">
				Create a New Workout
			</button>
		</div>

		<div class="well collapse" id="createWk">
			<h3 class="text-center">Create A New Workout</h3>

			{!! Form::open(['url' => 'workouts']) !!}

				@include('partials.workoutForm', [
					'submitButtonText' => 'Create Workout',
					'placeholder' => 'Name'
				])

			{!! Form::close() !!}
		</div>

	</div>
@stop