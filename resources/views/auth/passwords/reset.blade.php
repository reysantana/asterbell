@extends('layouts.app')

@section('content')
<div class="container-fluid mt-5">
  <div class="row p-3">
    <div class="card p-0 col-sm-6 offset-sm-3 col-md-4 offset-md-4">
      <h5 class="card-header text-center">Reset Password</h5>

      <div class="card-body">
        @if ($errors->has('email'))
        <div class="alert alert-danger">{{ $errors->first('email') }}</div>
        @endif
        @if ($errors->has('password'))
        <div class="alert alert-danger">{{ $errors->first('password') }}</div>
        @endif
        @if ($errors->has('password_confirmation'))
        <div class="alert alert-danger">{{ $errors->first('password_confirmation') }}</div>
        @endif

        <form class="needs-validation" novalidate method="POST" action="{{ url('/password/reset') }}" autocomplete="off">
          {{ csrf_field() }}

          <input type="hidden" name="token" value="{{ $token }}">

          <div class="form-group row">
            <label for="email" class="col-form-label col-md-4">Email Address</label>

            <div class="col-md-8">
              <input id="email" type="email" class="form-control" name="email" value="{{ $email or old('email') }}" required autofocus>
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
            <label for="password_confirmation" class="col-form-label col-md-4">Confirm Password</label>

            <div class="col-md-8">
              <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" required>
              <div class="invalid-feedback">Please confirm your password</div>
            </div>
          </div>

          <div class="form-group row">
            <div class="col-md-4 offset-md-4">
              <button type="submit" class="btn btn-info">
                Reset Password
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
