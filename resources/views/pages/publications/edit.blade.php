@extends('layouts/main')

@section('title', 'PO | Edit publication')

@section('activePublications')
	class="active"
@endsection

@section('css')
	<link rel="stylesheet" href="{{ asset('css/resource-edit.css') }}" type="text/css">
	<link rel="stylesheet" href="{{ asset('css/parsley.css') }}" type="text/css">
@endsection

@section('content')
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<h1>EDIT PUBLICATION</h1>
			
			<hr>

			<form id="update" method="POST" data-parsley-validate 
			enctype="multipart/form-data"
			action="{{ route('publications.update', $publication->id) }}">				
				<p id="id-publication" hidden>{{ $publication->id }}</p>

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

					<!-- DOCUMENT FORM -->
					<label title="doc, docx, pdf, txt, odt">File</label>
					<input type="file" name="document" class="form-control">
				</div>

				{{ csrf_field() }}
				{{ method_field('PUT') }} 
			</form>

			<!-- BUTTONS -->
			@include(
				'layouts/partials/_edit-form-buttons', 
				['created_at' => $publication->created_at,
				 'updated_at' => $publication->updated_at,
				 'model' => 'publications',
				 'id' => $publication->id,
			])
		</div>
	</div>﻿
@endsection

@section('js')
	<script src="{{ asset('js/publications/resource-edit.js') }}"></script>
	<script src="{{ asset('js/parsley.min.js') }}"></script>
@endsection