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

  <p>
    @if ($itemType === 'index')
      <a href="{{ route('authors.archive') }}">Show archival</a>
    @else
      <a href="{{ route('authors.index') }}">Show active</a>
    @endif
  </p>

	<div class="list-group">
		@foreach ($authors as $author)
			@include('pages/authors/_' . $itemType . '-item', $author)
		@endforeach
	</div>

	<div class="text-center">
		{{ $authors->links() }}
	</div>
@endsection
