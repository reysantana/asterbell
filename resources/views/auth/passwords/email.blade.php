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
        @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        @if (session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
        @endif

        <form class="needs-validation" novalidate method="POST" action="{{ url('/password/email') }}" autocomplete="off">
          {{ csrf_field() }}

          <div class="form-group row">
            <label for="email" class="col-form-label col-md-4">Email Address</label>

            <div class="col-md-8">
              <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>
              <div class="invalid-feedback">Please enter your email address</div>
            </div>
          </div>

          <div class="form-group row">
            <div class="col-md-4 offset-md-4">
              <button type="submit" class="btn btn-info">
                Send Password Reset Link
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
