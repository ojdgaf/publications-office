@extends('layouts/main')

@section('title', 'Publications Office')

@section('content')
	<div class="jumbotron">
		<h1>Publications Database</h1>
	</div>

	<div class="row">
		@foreach ($publications as $key => $publication)
			@include('pages/_index-item', $publication)
		@endforeach
	</div>

  @if ($publications->isNotEmpty())
  	<div class="row text-center">
  		<a class="btn btn-default btn-primary" href="{{ route('publications.index') }}" role="button">
  			More publications <span aria-hidden="true">&rarr;</span>
  		</a>
  	</div>
  @endif
@endsection
