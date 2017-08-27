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

			<h2 class="fancy-align">{{ $publication->heading }}</h2>

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
        @php $literature = $publication->literature; @endphp
        @if (! $literature->trashed())
  				<a href="{{ route('literature.show', $literature->id) }}">
  					{{ $literature->title }}
  				</a>
        @else
          {{ $literature->title }}
        @endif
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

      @php $authors = $publication->authors()->withTrashed()->get(); @endphp

			@if ($authors->count() == 1)
        <label>Author</label>
      @else
        <label>Authors ({{ $authors->count() }})</label>
      @endif

			<ul>
			@foreach ($authors as $author)
				<li>
          @if (! $author->trashed())
  					<a href="{{ route('authors.show', $author->id) }}">
  						{{ $author->name }}
  					</a>
  					<span>
						 (as {{ $author->pivot->status_author }})
  					</span>
          @else
            <span>
						 {{ $author->name }} (as {{ $author->pivot->status_author }})
  					</span>
          @endif
				</li>
			@endforeach
			</ul>

			<hr>

			<div class="row indent">
				<div class="col-md-4 col-md-offset-4">
					<a download href="{{ asset('storage/' . $publication->document_path) }}" class="btn btn-primary btn-lg btn-block">
						Download publication
					</a>
				</div>
			</div>
		</div>
	</div>﻿
@endsection
