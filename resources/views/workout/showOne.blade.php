@extends('app')

@section('content')
	<div class="container-fluid">

		<div>@include('errors.list')</div>

		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="row">
	        <div class="col-xs-6 col-sm-9 col-md-10">
						<h3 class="panel-title text-center">{{ $workout->name }}</h3>
					</div>
					<div class="col-xs-6 col-sm-3 col-md-2">
						<a href="{{ url('/logs', [$workout->id]) }}"
		        	 class="btn btn-primary btn-block">
		        	<span class="glyphicon glyphicon-send"></span>
		          Generate Log
		        </a>
		      </div>
		    </div>
			</div>

			<div class="panel-body">
				@if(count($workout->exercises))
		  		@foreach($workout->exercises as $exercise)
	          <div class="row">
	            <div class="col-xs-9 col-sm-10 col-md-11">
	            	<a href="{{ url('/exercises', [$exercise->id]) }}"
	            		 class="btn btn-default btn-block">
	                {{ $exercise->name }}
	              </a>
	            </div>

	            <div class="col-xs-3 col-sm-2 col-md-1">
	      			  @include('partials.detachExercise')
	            </div>
	          </div>
		  		@endforeach
		  	@else 
		  	    This workout does not contain any exercises
		  	@endif
		  </div>

		  <div class="panel-footer">
			  @include('partials.attachExercise')
			</div>
		</div>

		<div class="well">
			<button class="btn btn-danger btn-block" data-toggle="collapse" data-target="#showEditForm">
				Edit Workout
			</button>
		</div>

		<div class="well collapse" id="showEditForm">
			<h3 class="text-center">Edit Workout</h3>

			{!! Form::model($workout, ['method' => 'PATCH', 'action' => ['WorkoutController@update', $workout->id]]) !!}
				@include('partials.workoutForm', [
					'submitButtonText' => 'Edit Workout Name',
					'placeholder' => 'Name'
				])
			{!! Form::close() !!}

			{!! Form::open(array('url' => 'workouts/' . $workout->id)) !!}
        {!! Form::hidden('_method', 'DELETE') !!}
        {!! Form::button('Delete Workout', array('type' => 'submit', 'class' => 'btn btn-block btn-danger')) !!}
      {!! Form::close() !!}
		</div>
	</div>
@stop