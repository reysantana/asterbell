@extends('layouts.app')

@section('content')
<div class="container-fluid">
  <div class="row">
    <div class="col-sm-10 offset-sm-1 col-md-8 offset-md-2">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ url('/vouchers') }}">Voucher</a></li>        
          <li class="breadcrumb-item active" aria-current="page">Register Voucher</li>
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

          <form class="needs-validation" novalidate method="POST" action="{{ url('/registervoucher/update') }}">
            {{ csrf_field() }}

            <div class="form-group row">
              <label for="register" class="col-sm-4 col-md-3 col-form-label">Register Voucher <span class="text-danger">*<span></label>

              <div class="col-sm-8 col-md-9">
                <select id="register" class="form-control" name="register" required>
                  @foreach ($allvouchers as $allvoucher)
                  <option value="{{ $allvoucher->id }}" @if ($allvoucher->id == $voucher->voucher_id) selected="selected" @endif>{{ $allvoucher->name }}</option>
                  @endforeach
                </select>
                <div class="invalid-feedback">Please choose a voucher</div>
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

</script>
@endpush