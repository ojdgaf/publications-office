@extends('layouts/main')

@section('title')
	{{ 'PO | ' . $literature->title }}
@endsection

@section('css')
	<link rel="stylesheet" href="{{ asset('css/resource-edit.css') }}"
	type="text/css">
@endsection

@section('activeLiterature')
	class="active"
@endsection

@section('content')
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<h1>LITERATURE REVIEW</h1>
			<hr>

			@include(
				'layouts/partials/_button-to-edit',
				['model' => 'literature',
				'id' => $literature->id,
			])

			@if (!is_null($literature->cover_path))
				<div class="row indent">
					<div class="col-md-6">
						<h2 class="text-center">{{ $literature->title }}</h2>
					</div>
					<div class="col-md-6">
						<img class="cover"
						src="{{ asset('storage/' . $literature->cover_path) }}">
					</div>
				</div>
			@else
				<h2 class="fancy-align">{{ $literature->title }}</h2>
			@endif

			@if (isset($literature->description))
				<label>Description</label>
				<p>{{ $literature->description }}</p>
			@endif

			<label>Publisher</label>
			<p>{{ $literature->publisher }}</p>

			<hr>

			<label>Type</label>
			<p>{{ ucwords($literature->type) }}</p>

			@if ($literature->type == 'journal')
				<label>Periodicity</label>
				<p>{{ $literature->periodicity }} edition(s) per year</p>

				@if ($literature->issn)
					<label>ISSN</label>
					<p>{{ $literature->issn }}</p>
				@endif
			@endif

			@if ($literature->type == 'book' ||
				 $literature->type == 'conference proceedings')
				<label>Size</label>
				<p>{{ $literature->size }}</p>

				<label>Year of issue</label>
				<p>{{ $literature->issue_year }}</p>

				@if ($literature->isbn)
					<label>ISBN</label>
					<p>{{ $literature->isbn }}</p>
				@endif
			@endif

			@if (isset($literature->databases) && $literature->databases->count() != 0)
				<hr>
				<label>Relevant bibliographic databases</label>
				<ul>
				@foreach ($literature->databases as $database)
					<li>
						<a href="{{ route('databases.show', $database->id) }}">
							{{ $database->name }}
						</a>
						<span>
							 - from {{ $database->pivot->date }}
						</span>
					</li>
				@endforeach
				</ul>
			@endif

			@if (isset($literature->publications) &&
			     $literature->publications->count() != 0)
				<hr>
				<label>Available publications</label>
				<ul>
				@foreach ($literature->publications as $publication)
					<li>
						<a href="{{ route('publications.show', $publication->id) }}">
							{{ $publication->heading }}
						</a>
					</li>
				@endforeach
				</ul>
			@endif
		</div>
	</div>﻿
@endsection
