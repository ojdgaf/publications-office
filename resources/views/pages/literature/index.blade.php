@extends('layouts/main')

@section('title', 'PO | Literature')

@section('css')
	<link rel="stylesheet" href="{{ asset('css/resource-index.css') }}"
	type="text/css">
@endsection

@section('activeLiterature')
	class="active"
@endsection

@section('content')
	<h1>Literature</h1>

  <p>
    @if (Auth::check() && Auth::user()->isAdmin())
      @if ($itemType === 'index')
        <a href="{{ route('literature.archive') }}">Show archival</a>
      @else
        <a href="{{ route('literature.index') }}">Show active</a>
      @endif
    @endif
  </p>

	<div class="list-group">
		@foreach ($literature as $key => $literatureSingle)
			@include('pages/literature/_' . $itemType . '-item', [
				'literature' => $literatureSingle,
			])
		@endforeach
	</div>

	<div class="text-center">
		{{ $literature->links() }}
	</div>
@endsection
