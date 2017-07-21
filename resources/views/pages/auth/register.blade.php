@extends('layouts/main')

@section('title', 'PO | Registration')

@section('css')
	<link rel="stylesheet" href="{{ asset('css/resource-edit.css') }}">
@endsection

@section('content')
  <div class="row">
		<div class="col-md-6 col-md-offset-3">
      <h1>Registration</h1>

			<hr>

      <form class="form-horizontal" method="POST" action="{{ route('register') }}">
        <label>Name</label>
        <input class="form-control" name="name" value="{{ old('name') }}" required autofocus>

        <label>Email</label>
        <input type="email" class="form-control" name="email" value="{{ old('email') }}" required>

        <label>Password</label>
        <input type="password" class="form-control" name="password"  pattern=".{6,60}" placeholder="6 to 60 characters" required>

        <label>Confirm Password</label>
        <input type="password" class="form-control" name="password_confirmation" pattern=".{6,60}" placeholder="6 to 60 characters" required>

        <input type="submit" value="Register"
        class="btn btn-info btn-lg btn-block indent">
        {{ csrf_field() }}
      </form>
    </div>
</div>
@endsection
