@extends('layouts/main')

@section('title', 'PO | Add publication')

@section('activePublications')
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
			<h1>ADD NEW PUBLICATION</h1>
			<hr>
			<!-- NEW AUTHOR MODAL FORM -->
			{{-- @include('pages/publications/create parts/modals/_modal-author') --}}
			<!-- NEW LITERATURE MODAL FORM -->
			{{-- @include('pages/publications/create parts/modals/_modal-literature') --}}

			<form method="POST" data-parsley-validate enctype="multipart/form-data"
			action="{{ route('publications.store') }}">

				<p id="id-publication" hidden></p>

				<div class="form-group">
					<!-- FORM -->
					@include('pages/publications/create-update parts/_form')

					<hr>

					<!-- LITERATURE FORM -->
					@include('pages/publications/create-update parts/_form-type')

					<div id="div-literature-name"></div>
					<div id="div-literature-form"></div>

					<hr>

					 <!-- AUTHORS FORM -->
					@include('pages/publications/create-update parts/_form-authors')

					<hr>

					<!-- DOCUMENT FORM -->
					<label title="doc, docx, pdf, txt, odt">File</label>
					<input type="file" name="document" class="form-control" required>
				</div>

				<input type="submit" value="Add Publication" class="btn btn-success btn-lg btn-block">
				{{ csrf_field() }}

			</form>
		</div>
	</div>﻿
@endsection

@section('js')
	<script src="{{ asset('js/publications/resource-edit.js') }}"></script>
	{{-- <script src="{{ URL::asset('js/authors/create.js') }}"></script> --}}
	{{-- <script src="{{ URL::asset('js/literature/create.js') }}"></script> --}}
	<script src="{{ asset('js/parsley.min.js') }}"></script>
@endsection
