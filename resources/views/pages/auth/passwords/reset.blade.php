@extends('layouts/main')

@section('title', 'PO | Reset Password')

@section('css')
	<link rel="stylesheet" href="{{ asset('css/resource-edit.css') }}">
@endsection

@section('content')
  <div class="row">
		<div class="col-md-6 col-md-offset-3">
      <h1>Reset Password</h1>

			<hr>

      <form method="POST" action="{{ route('password.request') }}">
        <label>Email</label>
        <input type="email" class="form-control" name="email"
         value="{{ $email or old('email') }}" required autofocus>

        <label>Password</label>
        <input type="password" class="form-control" name="password" required>

        <label>Confirm Password</label>
        <input type="password" class="form-control" name="password_confirmation" required>

        <input type="submit" value="Reset" class="btn btn-info btn-lg btn-block indent">

        <input type="hidden" name="token" value="{{ $token }}">
        {{ csrf_field() }}
      </form>
    </div>
</div>
@endsection
