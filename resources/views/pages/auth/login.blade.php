@extends('layouts/main')

@section('title', 'PO | Authorization')

@section('css')
	<link rel="stylesheet" href="{{ asset('css/resource-edit.css') }}">
@endsection

@section('content')
  <div class="row">
		<div class="col-md-6 col-md-offset-3">
      <h1>Login</h1>

			<hr>

      <form method="POST" action="{{ route('login') }}">
        <div class="form-group">
          <label>Email</label>
          <input type="email" class="form-control" name="email"
          value="{{ old('email') }}" required autofocus>

          <label>Password</label>
          <input type="password" class="form-control" name="password" required>

          <label>
            <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
             remember me
          </label>

          <input type="submit" value="Login" class="btn btn-info btn-lg btn-block">

          <p class="text-right">
            <a class="btn btn-link" href="{{ route('password.request') }}">
              forgot password
            </a>
          </p>
        </div>

        {{ csrf_field() }}

      </form>
    </div>
</div>
@endsection
