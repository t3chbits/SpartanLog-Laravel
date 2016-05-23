@extends('app')

@section('content')
	<div class="container">

		<div>@include('errors.list')</div>

		<div class="well">
			<h1 class="text-center">{{ $set->name }}</h1>
		</div>

		<div class="well">
			{!! Form::model($set, ['method' => 'PATCH', 'action' => ['SetController@update', $set->id]]) !!}
				@include('partials.setForm', [
					'submitButtonText' => 'Edit Set'
				])
			{!! Form::close() !!}
		</div>

		<div class="well">
			{!! Form::open(array('url' => 'sets/' . $set->id)) !!}
                {!! Form::hidden('_method', 'DELETE') !!}
                {!! Form::button('Delete Set', array('type' => 'submit', 'class' => 'btn btn-block btn-danger')) !!}
            {!! Form::close() !!}
		</div>
	</div>
@stop