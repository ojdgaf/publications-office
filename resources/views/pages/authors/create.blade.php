@extends('layouts/main')

@section('title', 'PO | Add Author')

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
			<h1>ADD NEW AUTHOR</h1>
			
			<hr>

			<form method="POST" data-parsley-validate 
			action="{{ route('authors.store') }}">
				<p id="id-author" hidden></p>
				
				<div class="form-group">
					<!-- FORM -->
					@include('pages/authors/create-update parts/_form')			

					<!-- ADDITIONAL FORM -->
					<div id="div-author-status"></div>
				</div>

				<input type="submit" value="Add Author" class="btn btn-success btn-lg btn-block">
				
				{{ csrf_field() }}
			</form>
		</div>
	</div>﻿
@endsection

@section('js')
	<script src="{{ asset('js/authors/resource-edit.js') }}"></script>
	<script src="{{ asset('js/parsley.min.js') }}"></script>
@endsection