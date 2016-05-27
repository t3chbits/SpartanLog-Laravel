@extends('app')

@section('content')
	<div class="container-fluid">

		<div>@include('errors.list')</div>

		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title text-center">{{ $group->name }}</h3>
			</div>

			<div class="panel-body">
				@if(count($group->workouts))
		  		@foreach($group->workouts as $workout)
	          <div class="row">
	          	<div class="col-xs-8 col-sm-10">
		            <div class="col-xs-12 col-sm-6">
		            	<a href="{{ url('/workouts', [$workout->id]) }}"
		            		 class="btn btn-default btn-block">
		                {{ $workout->name }}
		              </a>
		            </div>

		            <div class="col-xs-12 col-sm-6">
		              <a href="{{ url('/logs', [$workout->id]) }}"
		              	 class="btn btn-primary btn-block">
		              	<span class="glyphicon glyphicon-send"></span>
		                Generate Log
		              </a>
		            </div>
		          </div>

	            <div class="col-xs-4 col-sm-2">
	      			  @include('partials.detachWorkout')
	            </div>
	          </div>
	          <br>
		  		@endforeach
		  	@else 
		  	    <h5 class="text-center">This group does not contain any workouts</h5>
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