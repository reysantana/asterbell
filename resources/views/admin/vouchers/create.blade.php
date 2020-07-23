@extends('layouts.app')

@section('content')
<div class="container-fluid">
  <div class="row">
    <div class="col-sm-10 offset-sm-1 col-md-8 offset-md-2">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ url('/vouchers') }}">Voucher</a></li>        
          <li class="breadcrumb-item active" aria-current="page">Create Voucher</li>
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

          <form class="needs-validation" novalidate method="POST" action="{{ url('/vouchers') }}">
            {{ csrf_field() }}

            <div class="form-group row">
              <label for="name" class="col-sm-4 col-md-3 col-form-label">Name <span class="text-danger">*<span></label>

              <div class="col-sm-8 col-md-9">
                <input id="name" type="text" maxlength="255" class="form-control" name="name" value="{{ old('name') }}" required>
                <div class="invalid-feedback">Please fill in the name</div>
              </div>
            </div>

            <div class="form-group row">
              <label for="description" class="col-sm-4 col-md-3 col-form-label">Description</label>

              <div class="col-sm-8 col-md-9">
                <textarea class="form-control" name="description" rows="5">{{ old('description') }}</textarea>
              </div>
            </div>

            <div class="form-group row">
              <label for="tnc" class="col-sm-4 col-md-3 col-form-label">Terms and Conditions</label>

              <div class="col-sm-8 col-md-9">
                <textarea class="form-control" name="tnc" rows="5">{{ old('tnc') }}</textarea>
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
              <label for="start-date" class="col-sm-4 col-md-3 col-form-label">Start Date</label>

              <div class="col-sm-8 col-md-9">
                <input id="start-date" data-toggle="datetimepicker" data-target="#start-date" type="text" class="form-control datetimepicker-input" name="startDate">
              </div>
            </div>

            <div class="form-group row">
              <label for="end-date" class="col-sm-4 col-md-3 col-form-label">End Date</label>

              <div class="col-sm-8 col-md-9">
                <input id="end-date" data-toggle="datetimepicker" data-target="#end-date" type="text" class="form-control datetimepicker-input" name="endDate">
              </div>
            </div>

            <div class="form-group row">
              <label for="limit" class="col-sm-4 col-md-3 col-form-label">Limit</label>

              <div class="col-sm-8 col-md-9">
                <input id="limit" type="text" maxlength="255" class="form-control" name="limit" value="{{ old('limit') }}" required>
                <div class="invalid-feedback">Please fill in the limit</div>
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
              <label for="thumbnail" class="col-sm-4 col-md-3 col-form-label">Thumbnail</label>

              <div class="col-sm-8 col-md-9">
                <div class="input-group">
                  <div class="custom-file">
                    <input type="file" class="custom-file-input" id="thumbnail" name="thumbnail">
                    <label class="custom-file-label" for="thumbnail">Choose file</label>
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

@push('scripts')
<script>
$(document).ready(() => {
  $('#start-date').datetimepicker({
    format: 'YYYY-MM-DD HH:mm:ss',
    date: '{{ old("startDate") }}'
  });

  $('#end-date').datetimepicker({
    format: 'YYYY-MM-DD HH:mm:ss',
    date: '{{ old("endDate") }}'
  });

});

</script>
@endpush