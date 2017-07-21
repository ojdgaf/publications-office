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

      @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
      @endif

      <form method="POST" action="{{ route('password.email') }}">
        <label>E-Mail Address</label>
        <input type="email" class="form-control" name="email"
         value="{{ $email or old('email') }}" required autofocus>

        <input type="submit" value="Send Password Reset Link"
        class="btn btn-info btn-lg btn-block indent">

        {{ csrf_field() }}
      </form>
    </div>
</div>
@endsection
