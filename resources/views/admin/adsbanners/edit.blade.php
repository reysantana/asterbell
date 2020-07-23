@extends('layouts.app')

@section('content')
<div class="container-fluid">
  <div class="row">
    <div class="col-sm-10 offset-sm-1 col-md-8 offset-md-2">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ url('/adsbanners') }}">Ads Banner</a></li>        
          <li class="breadcrumb-item active" aria-current="page">Edit Ads Banner</li>
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

          <form class="needs-validation" novalidate method="POST" action="{{ url('/adsbanners/update/'.$adsbanner->id.'') }}">
            {{ csrf_field() }}
            {{ method_field('POST') }}

            <div class="form-group row">
              <label for="name" class="col-sm-4 col-md-3 col-form-label">Name <span class="text-danger">*<span></label>

              <div class="col-sm-8 col-md-9">
                <input id="name" type="text" maxlength="255" class="form-control" name="name" value="{{ old('name') ?: $adsbanner->name  }}" required>
                <div class="invalid-feedback">Please fill in the name</div>
              </div>
            </div>

            <div class="form-group row">
              <label for="url" class="col-sm-4 col-md-3 col-form-label">URL</label>

              <div class="col-sm-8 col-md-9">
                <textarea class="form-control" name="url" rows="2">{{ old('url') ?: $adsbanner->url }}</textarea>
              </div>
            </div>


            <div class="form-group row">
              <label for="status" class="col-sm-4 col-md-3 col-form-label">Status <span class="text-danger">*<span></label>

              <div class="col-sm-8 col-md-9">
                <select id="status" class="form-control" name="status" required>
                  <option value="1" @if (old('active') == '1' || $adsbanner->active == '1') selected="selected" @endif>Active</option>
                  <option value="0" @if (old('active') == '0' || $adsbanner->active == '0') selected="selected" @endif>Inactive</option>
                </select>
                <div class="invalid-feedback">Please choose a status</div>
              </div>
            </div>

            <div class="form-group row">
              <label for="metadata" class="col-sm-4 col-md-3 col-form-label">Metadata</label>

              <div class="col-sm-8 col-md-9">
                <textarea class="form-control" name="metadata" rows="5">{{ old('metadata') ?: $adsbanner->metadata }}</textarea>
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
                @if ($adsbanner && $adsbanner->image_path)
                <div class="image-preview">
                  <img src="{{ asset($adsbanner->image_path) }}" />
                </div>
                @endif
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

@push('scripts')
<script>
$(document).ready(() => {

});

</script>
@endpush