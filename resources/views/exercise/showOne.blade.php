@extends('app')

@section('content')
		<div>@include('errors.list')</div>

		<div class="well">
			<h1 class="text-center">{!! $exercise->name !!}</h1>
		</div>

		<div class="well">

			{!! Form::model($exercise, ['method' => 'PATCH', 'action' => ['ExerciseController@update', $exercise->id]]) !!}
				@include('partials.exerciseForm', [
					'submitButtonText' => 'Edit Exercise',
					'placeholder' => 'Name'
				])
			{!! Form::close() !!}
		</div>


		<div class="text-center well">
			{!! Form::open(array('url' => 'exercises/' . $exercise->id)) !!}
                {!! Form::hidden('_method', 'DELETE') !!}
                {!! Form::button('Delete Exercise', array('type' => 'submit', 'class' => 'btn btn-block btn-danger')) !!}
            {!! Form::close() !!}
        </div>
@stop