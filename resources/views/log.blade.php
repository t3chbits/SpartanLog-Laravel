@extends('app')

@section('content')
	<div class="container-fluid">	

		<div>@include('errors.list')</div>	

		<div class="well">
			<h3 class="text-center">{{$workout->name}}</h3>
		</div>

		@if(count($exercises))
			@foreach($exercises as $exercise)
				<div class="panel panel-default">
				  <div class="panel-heading">
				  	<div class="row">
					  	<div class="col-xs-9 col-sm-10 col-md-11">
					    	<h3>{{$exercise->name}}</h3>
					    </div>
					    <div class="col-xs-3 col-sm-2 col-md-1">
					    	@include('partials.detachExercise')
					    </div>
					   </div>
				  </div>
				  <div class="panel-body">
						<div class="row">
							<div class="col-xs-12 col-sm-6 col-md-6">
									@if(count($exercise->sets))
										<table class="table table-condensed table-responsive text-center borderless">
											<tr>
												<th></th>
												<th>Reps</th>
												<th>Weight</th>
											<tr>
											@foreach($exercise->sets as $counter => $set)
												<tr>
													<td>
														{{ $counter=$counter+1 }}
													</td>
													<td>
														<a class="btn btn-default btn-block btn-xs" 
														   href="{{ url('/sets', [$set->id, 'edit']) }}">
															<h5>{{$set->repetitions}}</h5>
														</a>
													</td>
													<td>
														<a class="btn btn-default btn-block btn-xs" 
														   href="{{ url('/sets', [$set->id, 'edit']) }}">
															<h5>{{$set->weight}}</h5>
														</a>
													<td>
												</tr>
											@endforeach
										</table>
									@else 
							      <p>No sets have been logged for this exercise</p>
							    @endif
						  </div>
						  <div class="col-xs-12 col-sm-6 col-md-6">
						  	<div class="well">
									@include('partials.createSet')
								</div>
							</div>
						</div>
					</div>
				</div>
			@endforeach
		@else 
      <p>This workout does not contain any exercises</p>
    @endif

    <div class="well text-center">
    	@include('pagination.default', ['paginator' => $exercises])
    </div>
	</div>
@stop