@extends('layouts.app')

@section('content')
<div class="container-fluid">
  <div class="row">
    <div class="col-sm-10 offset-sm-1 col-md-8 offset-md-2">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ url('/users') }}">Users</a></li>        
          <li class="breadcrumb-item active" aria-current="page">Edit User</li>
        </ol>
      </nav>
      
      <div class="card">
        <div class="card-body">
        @if ($errors->any())
          <div class="alert alert-danger">
            <strong>Errors found:</strong>
            <ul class="m-0">
              @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif

          <form class="needs-validation" novalidate method="POST" action="{{ url('/users/'.$user->id) }}">
            {{ csrf_field() }}
            {{ method_field('PUT') }}

            <div class="form-group row">
              <label for="name" class="col-sm-4 col-md-3 col-form-label">Name <span class="text-danger">*<span></label>

              <div class="col-sm-8 col-md-9">
                <input id="name" type="text" maxlength="255" class="form-control" name="name" value="{{ old('name') ?: $user->name }}" required autofocus>
                <div class="invalid-feedback">Please fill in the name</div>
              </div>
            </div>

            <div class="form-group row">
              <label for="email" class="col-sm-4 col-md-3 col-form-label">Email</label>

              <div class="col-sm-8 col-md-9">
                <input id="email" type="text" maxlength="255" class="form-control" name="email" value="{{ old('email') ?: $user->email }}" disabled>
              </div>
            </div>

            <div class="form-group row">
              <label for="nric" class="col-sm-4 col-md-3 col-form-label">NRIC</label>

              <div class="col-sm-8 col-md-9">
                <input id="nric" type="text" maxlength="12" class="form-control" name="nric" value="{{ old('nric') ?: $user->nric }}">
              </div>
            </div>

            <div class="form-group row">
              <label for="contact_number" class="col-sm-4 col-md-3 col-form-label">Contact Number</label>

              <div class="col-sm-8 col-md-9">
                <input id="contact_number" type="text" maxlength="11" class="form-control" name="contact_number" value="{{ old('contact_number') ?: $user->contact_number }}">
              </div>
            </div>

            <div class="form-group row">
              <label for="facebook_id" class="col-sm-4 col-md-3 col-form-label">Facebook ID</label>

              <div class="col-sm-8 col-md-9">
                <input id="facebook_id" type="text" maxlength="255" class="form-control" name="facebook_id" value="{{ old('facebook_id') ?: $user->facebook_id }}" disabled>
              </div>
            </div>

            <hr />

            <div class="form-group row">
              <label for="password" class="col-sm-4 col-md-3 col-form-label">Password</label>

              <div class="col-sm-8 col-md-9">
                <input id="password" type="password" maxlength="255" class="form-control" name="password">
                <small class="font-italic">Leave this field blank unless reset</small>
              </div>
            </div>

            <div class="form-group row">
              <label for="password_confirmation" class="col-sm-4 col-md-3 col-form-label">Confirm Password</label>

              <div class="col-sm-8 col-md-9">
                <input id="password_confirmation" type="password" maxlength="255" class="form-control" name="password_confirmation">
                <small class="font-italic">Leave this field blank unless reset</small>
              </div>
            </div>

            <div class="form-group row">
              <div class="col-sm-4 offset-sm-4 col-md-2 offset-md-3">
                <button type="submit" class="btn btn-info btn-block">
                  Update
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection