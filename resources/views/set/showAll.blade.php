@extends('app')

@section('content')
	<div class="container">	

		<div>@include('errors.list')</div>	

		@if(count($sets))
			<div class="well">
			<h3 class="text-center">Select a Set</h3>
			@foreach ($sets as $set)
				<div class="text-center">
				<a class="btn btn-default btn-block" href="{{ url('sets', [$set->id]) }}">
					{{ $set->name }}
				</a>
				</div>
			@endforeach
			</div>
		@endif

		<div class="well">
			<button class="btn btn-primary btn-block" data-toggle="collapse" data-target="#showSetForm">
				Create a New Set
			</button>
		</div>

		<div class="well collapse" id="showSetForm">
			<h3 class="text-center">Create a New Set</h3>

			{!! Form::open(['url' => 'sets']) !!}

			@include('partials.setForm', [
				'submitButtonText' => 'Create Set'
			])

			{!! Form::close() !!}
		</div>

	</div>
@stop