@extends('layouts/main')

@section('title', 'PO | Add Database')

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
			<h1>ADD NEW DATABASE</h1>

			<hr>

			<form method="POST" data-parsley-validate action="{{ route('databases.store') }}">
				<div class="form-group">
					<!-- FORM -->
          @include('pages/databases/_form')
				</div>

				<input type="submit" value="Add Database" class="btn btn-success btn-lg btn-block">

				{{ csrf_field() }}
			</form>
		</div>
	</div>﻿
@endsection

@section('js')
	<script src="{{ asset('js/parsley.min.js') }}"></script>
@endsection
