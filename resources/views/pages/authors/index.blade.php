@extends('layouts/main')

@section('title', 'PO | Authors')

@section('css')
	<link rel="stylesheet" href="{{ asset('css/resource-index.css') }}" 
	type="text/css">
@endsection

@section('activeAuthors')
	class="active"
@endsection

@section('content')
	<h1>Authors</h1>

	<div class="list-group">
		@foreach ($authors as $author)
			@include('pages/authors/_index-item', $author)
		@endforeach
	</div>

	<div class="text-center">
		{{ $authors->links() }}
	</div>
@endsection