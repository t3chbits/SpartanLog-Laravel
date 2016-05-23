@extends('app')

@section('content')
	<div class="container">	

		<div>@include('errors.list')</div>	

		@if(count($groups))
			<div class="well">
			<h3 class="text-center">Select a Group</h3>
			@foreach ($groups as $group)
				<div class="text-center">
				<a class="btn btn-default btn-block" href="{{ url('groups', [$group->id]) }}">
					{{ $group->name }}
				</a>
				</div>
			@endforeach
			</div>
		@endif

		<div class="well">
			<button class="btn btn-primary btn-block" data-toggle="collapse" data-target="#showGroupForm">
				Create a New Group
			</button>
		</div>

		<div class="well collapse" id="showGroupForm">
			<h3 class="text-center">Create A New Group</h3>

			{!! Form::open(['url' => 'groups']) !!}

			@include('partials.groupForm', [
				'submitButtonText' => 'Create Group',
				'placeholder' => 'Name'
			])

			{!! Form::close() !!}
		</div>

	</div>
@stop