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

	<div class="list-group">
		@foreach ($literature as $key => $literatureSingle)
			@include('pages/literature/_index-item', [
				'literature' => $literatureSingle,
			])
		@endforeach
	</div>

	<div class="text-center">
		{{ $literature->links() }}
	</div>
@endsection