@extends('layouts/main')

@section('title')
	{{ 'PO | ' . $publication->heading }}
@endsection

@section('css')
	<link rel="stylesheet" href="{{ asset('css/resource-edit.css') }}" type="text/css">
@endsection

@section('activePublications')
	class="active"
@endsection

@section('content')
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<h1>PUBLICATION REVIEW</h1>
			<hr>

			@include(
				'layouts/partials/_button-to-edit', 
				['model' => 'publications',
				'id' => $publication->id,
			])

			<label>Heading</label>
			<p>{{ $publication->heading }}</p>

			<label>Abstract</label>
			<p>{{ $publication->abstract }}</p>

			<label>Description</label>
			<p>{{ $publication->description }}</p>

			<label>Genre</label>
			<p>{{ ucwords($publication->genre) }}</p>

			<hr>

			<label>Type</label>
			<p>{{ ucwords($publication->type) }}</p>

			<label>Literature</label>
			<p>
				<a href="{{ route('literature.show', $publication->literature->id) }}">
					{{ $publication->literature->title }}
				</a>
			</p>

			@if ($publication->type == 'journal article')
				<p><strong>Issue year: </strong>{{ $publication->issue_year }}</p>
				<p><strong>Issue number: </strong>{{ $publication->issue_number }}</p>
			@endif

			<p>
				<strong>Page range: </strong>
				{{ $publication->page_initial }}
				 - 
				{{ $publication->page_final }}
			</p>

			<hr>

			<label>Authors</label>
			<ul>
			@foreach ($publication->authors as $author)
				<li>
					<a href="{{ route('authors.show', $author->id) }}">
						{{ $author->name }}
					</a>
					<span>
						 ({{ ucwords($author->pivot->status_author) }})
					</span>
				</li>
			@endforeach
			</ul>

			<hr>

			<div class="row indent">
				<div class="col-md-4 col-md-offset-4">
					<a href="{{ asset('storage/' . $publication->document_path) }}" 
					class="btn btn-primary btn-lg btn-block">
						Download publication
					</a>
				</div>
			</div>
		</div> 
	</div>﻿
@endsection