@extends('layouts/main')

@section('title', 'PO | Edit Author')

@section('activeAuthors')
	class="active"
@endsection

@section('css')
	<link rel="stylesheet" href="{{ asset('css/resource-edit.css') }}" 
	type="text/css">
	<link rel="stylesheet" href="{{ asset('css/parsley.css') }}" type="text/css">
@endsection

@section('content')
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<h1>EDIT AUTHOR</h1>
			
			<hr>

			<form id="update" method="POST" data-parsley-validate 
			action="{{ route('authors.update', $author->id) }}">
				<p id="id-author" hidden>{{ $author->id }}</p>

				<div class="form-group">
					<!-- FORM -->
					@include('pages/authors/create-update parts/_form')			

					<!-- ADDITIONAL FORM -->
					<div id="div-author-status"></div>
				</div>

				{{ csrf_field() }}
				{{ method_field('PUT') }} 
			</form>

			<!-- BUTTONS -->
			@include(
				'layouts/partials/_edit-form-buttons', 
				['created_at' => $author->created_at,
				 'updated_at' => $author->updated_at,
				 'model' => 'authors',
				 'id' => $author->id,
			])
		</div>
	</div>﻿
@endsection

@section('js')
	<script src="{{ asset('js/authors/resource-edit.js') }}"></script>
	<script src="{{ asset('js/parsley.min.js') }}"></script>
@endsection