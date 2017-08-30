@extends('layouts/main')

@section('title', 'PO | Publications')

@section('css')
	<link rel="stylesheet" href="{{ asset('css/resource-index.css') }}" type="text/css">
@endsection

@section('activePublications')
	class="active"
@endsection

@section('content')
	<h1>Publications</h1>

	<div class="list-group">
		@foreach ($publications as $publication)
			@include('pages/publications/_index-item', $publication)
		@endforeach
	</div>

	<div class="text-center">
		{{ $publications->links() }}
	</div>
@endsection
