@extends('layouts/main')

@section('title', 'PO | Edit Database')

@section('activeDatabases')
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
			<h1>EDIT DATABASE</h1>

			<hr>

			<form id="update" method="POST" data-parsley-validate action="{{ route('databases.update', $database->id) }}">
				<div class="form-group">
					<!-- FORM -->
					@include('pages/databases/_form')
				</div>

				{{ csrf_field() }}
				{{ method_field('PUT') }}
			</form>

			<!-- BUTTONS -->
			@include(
				'layouts/partials/_edit-form-buttons',
				['created_at' => $database->created_at,
				 'updated_at' => $database->updated_at,
				 'model' => 'databases',
				 'id' => $database->id,
			])
		</div>
	</div>﻿
@endsection

@section('js')
	<script src="{{ asset('js/parsley.min.js') }}"></script>
@endsection
