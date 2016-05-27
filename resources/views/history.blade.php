@extends('app')

@section('content')

<div class="row" id="exerciseCharts">
	@if(count($exercises))
		@foreach($exercises as $counter => $exercise)
			<div id="chart{{ $counter }}"class="col-xs-12 col-sm-6">
			</div>
		@endforeach
	@else 
		<h3 class="text-center">You do not have any history to display.</h3>
	@endif
</div>

@stop

@section('footer')

@include ('partials.footer') <!-- include js from controller -->

@stop