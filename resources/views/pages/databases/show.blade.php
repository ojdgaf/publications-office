@extends('layouts/main')

@section('title')
	{{ 'PO | ' . $database->name }}
@endsection

@section('css')
	<link rel="stylesheet" href="{{ asset('css/resource-edit.css') }}"
	type="text/css">
@endsection

@section('activeDatabases')
	class="active"
@endsection

@section('content')
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<h1>DATABASE REVIEW</h1>
			<hr>

      @if (Auth::user()->isStaff())
  			@include(
  				'layouts/partials/_button-to-edit',
  				['model' => 'databases',
  				'id' => $database->id,
  			])
      @endif

			<h2 class="text-center">{{ ucwords($database->name) }}</h2>

      @if ($database->url)
        <label>URL</label>
        <p><a href="{{ $database->url }}" target="_blank">{{ $database->url }}</a></p>
      @endif

			@if ($database->description)
				<label>Description</label>
				<p>{{ $database->description }}</p>
			@endif

			@if ($database->access_mode)
				<label>Access mode</label>
				<p>{{ $database->access_mode }}</p>
			@endif

			@if ($database->literature->isNotEmpty())
				<hr>
				<label>Relevant literature ({{ $database->literature->count() }})</label>
				<ul>
				@foreach($database->literature as $literature)
					<li>
						<a href="{{ route('literature.show', $literature->id) }}">
							{{ $literature->title }}
						</a>
					</li>
				@endforeach
				</ul>
			@endif

		</div>
	</div>﻿
@endsection
