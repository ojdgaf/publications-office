@extends('layouts/main')

@section('title')
	{{ 'PO | ' . $author->name }}
@endsection

@section('css')
	<link rel="stylesheet" href="{{ asset('css/resource-edit.css') }}"
	type="text/css">
@endsection

@section('activeAuthors')
	class="active"
@endsection

@section('content')
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<h1>AUTHOR REVIEW</h1>
			<hr>

			@include(
				'layouts/partials/_button-to-edit',
				['model' => 'authors',
				'id' => $author->id,
			])

			<h2 class="text-center">{{ ucwords($author->name) }}</h2>

			@if ($author->email)
				<label>E-mail</label>
				<p>{{ $author->email }}</p>
			@endif

			<label>Status</label>
			<p>{{ ucwords($author->status) }}</p>

			@if ($author->degree)
				<label>Degree</label>
				<p>{{ ucwords($author->degree) }}</p>
			@endif

			@if ($author->rank)
				<label>Rank</label>
				<p>{{ ucwords($author->rank) }}</p>
			@endif

			@if ($author->post)
				<label>Post</label>
				<p>{{ $author->post }}</p>
			@endif

			@if ($author->publications->isNotEmpty())
				<hr>
				<label>Relevant publications ({{ $author->publications->count() }})</label>
				<ul>
				@foreach($author->publications as $publication)
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
