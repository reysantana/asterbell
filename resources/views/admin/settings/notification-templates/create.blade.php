@extends('layouts.app')

@section('content')
<div class="container-fluid">
  <div class="row">
    <div class="col-sm-10 offset-sm-1 col-md-8 offset-md-2">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ url('/settings/notification-templates') }}">Settings</a></li>        
          <li class="breadcrumb-item"><a href="{{ url('/settings/notification-templates') }}">Notification Templates</a></li>        
          <li class="breadcrumb-item active" aria-current="page">Create Template</li>
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

          <form class="needs-validation" novalidate method="POST" action="{{ url('/settings/notification-templates') }}">
            {{ csrf_field() }}

            <div class="form-group row">
              <label for="title" class="col-sm-4 col-md-3 col-form-label">Title <span class="text-danger">*<span></label>

              <div class="col-sm-8 col-md-9">
                <input id="title" type="text" maxlength="255" class="form-control" name="title" value="{{ old('title') }}" required>
                <div class="invalid-feedback">Please fill in the title</div>
              </div>
            </div>

            <div class="form-group row">
              <label for="category" class="col-sm-4 col-md-3 col-form-label">Category <span class="text-danger">*<span></label>

              <div class="col-sm-8 col-md-9">
                <select id="category" class="form-control" name="category" required>
                  <option value="reward" @if (old('category') == 'reward') selected="selected" @endif>Reward</option>
                  <option value="message" @if (old('category') == 'message') selected="selected" @endif>Message</option>
                </select>
                <div class="invalid-feedback">Please choose a category</div>
              </div>
            </div>

            <div class="form-group row">
              <label for="excerpt" class="col-sm-4 col-md-3 col-form-label">Excerpt <span class="text-danger">*<span></label>

              <div class="col-sm-8 col-md-9">
                <input id="excerpt" type="text" maxlength="255" class="form-control" name="excerpt" value="{{ old('excerpt') }}" required>
                <div class="invalid-feedback">Please fill in the excerpt</div>
              </div>
            </div>

            <div class="form-group row">
              <label for="fullMessage" class="col-sm-4 col-md-3 col-form-label">Full Message</label>

              <div class="col-sm-8 col-md-9">
                <textarea class="summernote" name="fullMessage">{{ old('fullMessage') }}</textarea>
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

@push('scripts')
<script>
$(document).ready(() => {
  $('.summernote').summernote({
    height: 150,
    toolbar: [
      ['style', ['bold', 'italic', 'underline']],
    ]
  });
});
</script>
@endpush