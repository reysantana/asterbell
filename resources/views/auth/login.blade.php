@extends('layouts.app')

@section('content')
<div class="container-fluid mt-5">
  <div class="row p-3">
    <div class="card p-0 col-sm-6 offset-sm-3 col-md-4 offset-md-4">
      <h5 class="card-header text-center">Management Login</h5>

      <div class="card-body">
        @if ($errors->has('email'))
        <div class="alert alert-danger">{{ $errors->first('email') }}</div>
        @endif
        @if ($errors->has('password'))
        <div class="alert alert-danger">{{ $errors->first('password') }}</div>
        @endif
        @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <form class="needs-validation" novalidate method="POST" action="{{ url('/login') }}">
          {{ csrf_field() }}

          <div class="form-group row">
            <label for="email" class="col-form-label col-md-4">Email Address</label>

            <div class="col-md-8">
              <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>
              <div class="invalid-feedback">Please enter your email address</div>
            </div>
          </div>

          <div class="form-group row">
            <label for="password" class="col-form-label col-md-4">Password</label>

            <div class="col-md-8">
              <input id="password" type="password" class="form-control" name="password" required>
              <div class="invalid-feedback">Please enter your password</div>
            </div>
          </div>

          <div class="form-group row">
            <div class="col-md-4 offset-md-4">
              <button type="submit" class="btn btn-info btn-block">
                Login
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
