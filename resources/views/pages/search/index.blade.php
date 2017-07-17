@extends('layouts/main')

@section('title', 'Advanced search')

@section('css')
  <link rel="stylesheet" href="{{ asset('css/jquery-ui.min.css') }}" type="text/css">
  <link rel="stylesheet" href="{{ asset('css/parsley.css') }}" type="text/css">
	<link rel="stylesheet" href="{{ asset('css/resource-edit.css') }}" type="text/css">
@endsection

@section('content')
  <div class="row">
		<div class="col-md-8 col-md-offset-2">
      <h1>Advanced search</h1>

			<hr>

			<form method="POST" data-parsley-validate action="{{ route('search.advanced') }}">
				<div class="form-group">
          <label>I am looking for</label>
          <select name="entity" class="form-control" required>
            <option selected disabled value="">Choose where you want to search</option>
            <option value="publication">Publications</option>
            <option value="literature">Literature</option>
            <option value="author">Authors</option>
            <option value="database">Bibliographic databases</option>
          </select>

          <!-- ADDITIONAL FORM -->
					<div id="div-form"></div>
				</div>

				<input type="submit" value="Search" class="btn btn-info btn-lg btn-block">

				{{ csrf_field() }}
			</form>
		</div>
	</div>﻿
@endsection

@section('js')
  <script src="{{ asset('js/jquery-ui.min.js') }}"></script>
	<script src="{{ asset('js/parsley.min.js') }}"></script>
  <script src="{{ asset('js/other/search-index.js') }}"></script>
@endsection
