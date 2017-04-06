@extends('layouts/main')

@section('title', 'PO | Edit Literature')

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
			<h1>EDIT LITERATURE</h1>
			
			<hr>

			<form id="update" method="POST" data-parsley-validate 
			enctype="multipart/form-data"
			action="{{ route('literature.update', $literature->id) }}">				
				<p id="id-literature" hidden>{{ $literature->id }}</p>

				<div class="form-group">
					<!-- FORM -->
					@include('pages/literature/create-update parts/_form')

					<!-- ADDITIONAL FORM -->
					<div id="div-literature"></div>

					<!-- BIBLIOGRAPHIC DATABASES -->
					@include('pages/literature/create-update parts/_form-databases')
				</div>

				{{ csrf_field() }}
				{{ method_field('PUT') }} 
			</form>

			<!-- BUTTONS -->
			@include(
				'layouts/partials/_edit-form-buttons', 
				['created_at' => $literature->created_at,
				 'updated_at' => $literature->updated_at,
				 'model' => 'literature',
				 'id' => $literature->id,
			])
		</div>
	</div>﻿
@endsection

@section('js')
	<script src="{{ asset('js/literature/resource-edit.js') }}"></script>
	<script src="{{ asset('js/parsley.min.js') }}"></script>
@endsection