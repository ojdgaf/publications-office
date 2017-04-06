@extends('layouts/main')

@section('title', 'PO | Add Literature')

@section('activeLiterature')
	class="active"
@endsection

@section('css')
	<link rel="stylesheet" href="{{ asset('css/resource-edit.css') }}" type="text/css">
	<link rel="stylesheet" href="{{ asset('css/parsley.css') }}" type="text/css">
@endsection

@section('content')
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<h1>ADD NEW LITERATURE</h1>

			<hr>

			<form method="POST" data-parsley-validate enctype="multipart/form-data"
			action="{{ route('literature.store') }}">
				<p id="id-literature" hidden></p>
				
				<div class="form-group">
					<!-- FORM -->
					@include('pages/literature/create-update parts/_form')

					<hr>

					<!-- ADDITIONAL FORM -->
					<div id="div-literature"></div>

					<!-- BIBLIOGRAPHIC DATABASES -->
					@include('pages/literature/create-update parts/_form-databases')
				</div>

				<input type="submit" value="Add Literature" class="btn btn-success btn-lg btn-block">

				{{ csrf_field() }}
			</form>
		</div> 
	</div>﻿
@endsection

@section('js')
	<script src="{{ asset('js/literature/resource-edit.js') }}"></script>
	<script src="{{ asset('js/parsley.min.js') }}"></script>
@endsection