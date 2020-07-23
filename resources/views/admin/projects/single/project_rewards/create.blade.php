@extends('layouts.app')

@section('content')
<div class="container-fluid">
  <div class="row">
    <div class="col-sm-10 offset-sm-1 col-md-8 offset-md-2">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ url('/projects') }}">Projects</a></li>        
          <li class="breadcrumb-item"><a href="{{ url('/projects/'.$project->slug) }}">{{ $project->name }}</a></li>
          <li class="breadcrumb-item active" aria-current="page">Create Project Reward</li>
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

          <form class="needs-validation" novalidate method="POST" action="{{ url('/projects/'.$project->slug.'/projectrewards') }}">
            {{ csrf_field() }}

            <div class="form-group row">
              <label for="name" class="col-sm-4 col-md-3 col-form-label">Name <span class="text-danger">*<span></label>

              <div class="col-sm-8 col-md-9">
                <input id="name" type="text" maxlength="255" class="form-control" name="name" value="{{ old('name') }}" required>
                <div class="invalid-feedback">Please fill in the name</div>
              </div>
            </div>

            <div class="form-group row">
              <label for="markerscan" class="col-sm-4 col-md-3 col-form-label">Marker Scan <span class="text-danger">*<span></label>

              <div class="col-sm-8 col-md-9">
                <input id="markerscan" type="text" maxlength="10" class="form-control" name="markerscan" value="{{ old('markerscan') }}" required>
                <div class="invalid-feedback">Please fill in the number of marker</div>
              </div>
            </div>

            <div class="form-group row">
              <label for="serialCode" class="col-sm-4 col-md-3 col-form-label">Serial Code <span class="text-danger">*<span></label>

              <div class="col-sm-8 col-md-9">
                <input id="serialCode" type="text" maxlength="10" class="form-control" name="serialCode" value="{{ old('serialCode') }}" required>
                <div class="invalid-feedback">Please fill in the serial code</div>
              </div>
            </div>

            <div class="form-group row">
              <label for="notificationTemplateId" class="col-sm-4 col-md-3 col-form-label">Notification Template <span class="text-danger">*<span></label>

              <div class="col-sm-8 col-md-9">
                <select id="notificationTemplateId" class="form-control" name="notificationTemplateId" required>
                  @foreach ($templates as $template)
                  <option value="{{ $template->id }}" @if (old('notificationTemplateId') == $template->id) selected="selected" @endif>{{ $template->title }}</option>
                  @endforeach
                </select>
                <div class="invalid-feedback">Please choose a notification template</div>
              </div>
            </div>

            <div class="form-group row">
              <label for="status" class="col-sm-4 col-md-3 col-form-label">Status <span class="text-danger">*<span></label>

              <div class="col-sm-8 col-md-9">
                <select id="status" class="form-control" name="status" required>
                  <option value="1" @if (old('active') == '1') selected="selected" @endif>Active</option>
                  <option value="0" @if (old('active') == '0') selected="selected" @endif>Inactive</option>
                </select>
                <div class="invalid-feedback">Please choose a status</div>
              </div>
            </div>

            <div class="form-group row">
              <label for="image" class="col-sm-4 col-md-3 col-form-label">Image</label>

              <div class="col-sm-8 col-md-9">
                <div class="input-group">
                  <div class="custom-file">
                    <input type="file" class="custom-file-input" id="image" name="image">
                    <label class="custom-file-label" for="image">Choose file</label>
                  </div>
                </div>
              </div>
            </div>

            <div class="form-group row">
              <div class="col-sm-4 offset-sm-4 col-md-2 offset-md-3">
                <button type="submit" class="btn btn-info btn-block">
                  Create
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