@extends('app')

@section('content')
	<div class="container">

		<div>@include('errors.list')</div>

		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">{{ $group->name }}</h3>
			</div>

			<div class="panel-body">
				@if(count($group->workouts))
		  		@foreach($group->workouts as $workout)
	          <div class="row">
	            <div class="col-xs-4">
	            	<a href="{{ url('/workouts', [$workout->id]) }}">
	                	{{ $workout->name }}
	                </a>
	              </h3>
	            </div>

	            <div class="col-xs-4">
	              <a href="{{ url('/logs', [$workout->id]) }}">
	                Generate a log from {{ $workout->name }}
	              </a>
	            </div>

	            <div class="col-xs-4">
	      			  @include('partials.detachWorkout')
	            </div>
	          </div>
		  		@endforeach
		  	@else 
		  	    This group does not contain any workouts
		  	@endif
		  </div>

		  <div class="panel-footer">
			  @include('partials.attachWorkout')
			</div>
		</div>

		<div class="well">
			<button class="btn btn-danger btn-block" data-toggle="collapse" data-target="#showEditForm">
				Edit Group
			</button>
		</div>

		<div class="well collapse" id="showEditForm">
			<h3 class="text-center">Edit Group</h3>

			{!! Form::model($group, ['method' => 'PATCH', 'action' => ['GroupController@update', $group->id]]) !!}
				@include('partials.groupForm', [
					'submitButtonText' => 'Edit Group Name',
					'placeholder' => 'Name'
				])
			{!! Form::close() !!}

			{!! Form::open(array('url' => 'groups/' . $group->id)) !!}
		        {!! Form::hidden('_method', 'DELETE') !!}
		        {!! Form::button('Delete Group', array('type' => 'submit', 'class' => 'btn btn-block btn-danger')) !!}
		      {!! Form::close() !!}
		</div>
	</div>
@stop