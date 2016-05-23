@extends('app')

@section('content')
	<div class="container-fluid">	

		<div>@include('errors.list')</div>	

		<div class="well">
			<h3 class="text-center">{{$workout->name}}</h3>
		</div>

		@if(count($workout->exercises))
			@foreach($workout->exercises as $exercise)
				<h4>{{$exercise->name}}</h4>
				@if(count($exercise->sets))
					@foreach($exercise->sets as $set)
						<a class="btn btn-default" href="{{ url('/sets', [$set->id, 'edit']) }}">
							<h5>{{$set->repetitions}}</h5>
							<h5>{{$set->weight}}</h5>
						</a>
					@endforeach
				@else 
		      This exercise does not contain any sets
		    @endif

				@include('partials.detachExercise')

				{!! Form::open(['url' => 'sets']) !!}

				@include('partials.setForm', [
					'submitButtonText' => 'Create Set',
					'workout_id' => $workout->id,
					'exercise_id' => $exercise->id
				])

				{!! Form::close() !!}
			@endforeach
		@else 
      This workout does not contain any exercises
    @endif

		@include('partials.attachExercise')
	</div>
@stop