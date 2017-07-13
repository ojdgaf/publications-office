@extends('layouts/main')

@section('title', 'Search')

@section('content')
	<h1>Advanced search</h1>

  <p>
    I am looking for
    <select name="access_mode" class="form-control" style="display:inline;" required>
      <option value="1">1</option>
      <option value="2">2</option>
    </select>
  </p>
@endsection
