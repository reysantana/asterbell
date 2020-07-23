@extends('layouts.app')

@section('content')
<div class="container-fluid">
  <div class="row">
    <div class="col-sm-10 offset-sm-1 col-md-8 offset-md-2">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ url('/argames') }}">AR Game</a></li>        
          <li class="breadcrumb-item active" aria-current="page">Edit AR Game</li>
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

          <form class="needs-validation" novalidate method="POST" enctype="multipart/form-data" action="{{ url('/argames/update/'.$argame->slug.'') }}">
            {{ csrf_field() }}
            {{ method_field('POST') }}

            <div class="form-group row">
              <label for="name" class="col-sm-4 col-md-3 col-form-label">Name <span class="text-danger">*<span></label>

              <div class="col-sm-8 col-md-9">
                <input id="name" type="text" maxlength="255" class="form-control" name="name" value="{{ old('name') ?: $argame->name }}" required>
                <div class="invalid-feedback">Please fill in the name</div>
              </div>
            </div>

            <div class="form-group row">
              <label for="slug" class="col-sm-4 col-md-3 col-form-label">Slug <span class="text-danger">*<span></label>

              <div class="col-sm-8 col-md-9">
                <input id="slug" type="text" maxlength="20" class="form-control" name="slug" value="{{ old('slug') ?: $argame->slug }}" required>
                <div class="invalid-feedback">Please fill in the slug</div>
              </div>
            </div>

            <div class="form-group row">
              <label for="status" class="col-sm-4 col-md-3 col-form-label">Status <span class="text-danger">*<span></label>

              <div class="col-sm-8 col-md-9">
                <select id="status" class="form-control" name="status" required>
                  <option value="1" @if (old('active') == '1' || $argame->active == '1') selected="selected" @endif>Active</option>
                  <option value="0" @if (old('active') == '0' || $argame->active == '0') selected="selected" @endif>Inactive</option>
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
              <label for="start-score" class="col-sm-4 col-md-3 col-form-label">Start Score Submit Time</label>

              <div class="col-sm-8 col-md-9">
                <input id="start-score" type="time" class="form-control datetimepicker-input" value="{{ old('startScore') ?: $argame->score_submit_start }}" name="startScore">
              </div>
            </div>

            <div class="form-group row">
              <label for="end-score" class="col-sm-4 col-md-3 col-form-label">End Score Submit Time</label>

              <div class="col-sm-8 col-md-9">
                <input id="end-score" type="time" class="form-control datetimepicker-input" value="{{ old('endScore') ?: $argame->score_submit_end }}" name="endScore">
              </div>
            </div>

            <div class="form-group row">
              <label for="description" class="col-sm-4 col-md-3 col-form-label">Description</label>

              <div class="col-sm-8 col-md-9">
                <textarea class="form-control" name="description" rows="5">{{ old('description') ?: $argame->description }}</textarea>
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
                @if ($argame && $argame->image_path)
                <div class="image-preview">
                  <img src="{{ asset($argame->image_path) }}" />
                </div>
                @endif
              </div>
            </div>

            <div class="form-group row">
              <label for="button_image" class="col-sm-4 col-md-3 col-form-label">Button Image</label>

              <div class="col-sm-8 col-md-9">
                <div class="input-group">
                  <div class="custom-file">
                    <input type="file" class="custom-file-input" id="button_image" name="button_image">
                    <label class="custom-file-label" for="button_image">Choose file</label>
                  </div>
                </div>
                @if ($argame && $argame->button_path)
                <div class="image-preview">
                  <img src="{{ asset($argame->button_path) }}" />
                </div>
                @endif
              </div>
            </div>

            <div class="form-group row">
              <label for="tnc" class="col-sm-4 col-md-3 col-form-label">Terms and Conditions</label>

              <div class="col-sm-8 col-md-9">
                <textarea class="form-control" name="tnc" rows="5">{{ old('tnc') ?: $argame->tnc }}</textarea>
              </div>
            </div>

<!--             <div class="form-group row">
              <label for="score" class="col-sm-4 col-md-3 col-form-label">Prize Score <span class="text-danger">*<span></label>

              <div class="col-sm-8 col-md-9">
                <input id="score" type="text" maxlength="255" class="form-control" name="score" value="{{ old('score') ?: $argame->score }}" required>
                <div class="invalid-feedback">Please fill in the score</div>
              </div>
            </div> -->

<!--             <div class="form-group row">
              <label for="status" class="col-sm-4 col-md-3 col-form-label">Voucher <span class="text-danger">*<span></label>

              <div class="col-sm-8 col-md-9">
                <select id="argamevoucherId" class="form-control" name="argamevoucherId[]" multiple="multiple">
                  @foreach ($argamevouchers as $argamevoucher)
                      <option value="{{ $argamevoucher->id }}" @foreach ($argame_vouchers as $argame_voucher) @if ($argamevoucher->id == $argame_voucher->voucher_id) selected="selected" @endif @endforeach>{{ $argamevoucher->name }}</option>
                  @endforeach
                </select>
              </div>

            </div> -->

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
  $('#start-date').datetimepicker({
    format: 'YYYY-MM-DD HH:mm:ss',
    date: '{{ old("startDate") ?: $argame->start_date }}'
  });

  $('#end-date').datetimepicker({
    format: 'YYYY-MM-DD HH:mm:ss',
    date: '{{ old("endDate") ?: $argame->end_date }}'
  });

  $('#name, #slug').keyup(function() {
    generateSlug($(this).val());
  });
});

function generateSlug(val) {
  let slug = $.trim(val).toLowerCase();
  slug = slug.replace(/[^a-z0-9- ]/g, '').replace(/ /g, '-');
  $('#slug').val(slug);
}
</script>
@endpush