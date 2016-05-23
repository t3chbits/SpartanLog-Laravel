@extends('app')

@section('content')
	<div class="container-fluid">	

		<div>@include('errors.list')</div>	

		<div class="well">
			<h3 class="text-center">{{$workout->name}}</h3>
		</div>

		@if(count($workout->exercises))
			@foreach($workout->exercises as $exercise)
				<div class="row">
					<div class="col-xs-6">
						<h4>{{$exercise->name}}</h4>
					</div>
					<div class="col-xs-6">
						@include('partials.detachExercise')
					</div>
				</div>

				<div class="row">
					<div class="col-xs-6">
						@if(count($exercise->sets))
							@foreach($exercise->sets as $set)
								<a class="btn btn-default" 
								   href="{{ url('/sets', [$set->id, 'edit']) }}">
									<h5>{{$set->repetitions}}</h5>
									<h5>{{$set->weight}}</h5>
								</a>
							@endforeach
						@else 
				      This exercise does not contain any sets
				    @endif
				  </div>
				  <div class="col-xs-6">
						@include('partials.createSet')
					</div>
				</div>
			@endforeach
		@else 
      This workout does not contain any exercises
    @endif

		@include('partials.attachExercise')
	</div>
@stop