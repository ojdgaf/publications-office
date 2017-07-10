@extends('layouts/main')

@section('title', 'PO | Bibliographic databases')

@section('css')
	<link rel="stylesheet" href="{{ asset('css/resource-index.css') }}"
	type="text/css">
@endsection

@section('activeDatabases')
	class="active"
@endsection

@section('content')
	<h1>Bibliographic databases</h1>

	<div class="list-group">
		@foreach ($databases as $database)
			@include('pages/databases/_index-item', $database)
		@endforeach
	</div>

	<div class="text-center">
		{{ $databases->links() }}
	</div>
@endsection
