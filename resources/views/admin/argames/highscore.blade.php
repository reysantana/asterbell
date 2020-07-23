@extends('layouts.app')

@section('content')
<div class="container-fluid">
  <div class="row">
    <div class="col-sm-10 offset-sm-1 col-md-8 offset-md-2">
      <nav class="clearfix" aria-label="breadcrumb">
        <ol class="breadcrumb float-left">
          <li class="breadcrumb-item active" aria-current="page">High Score</li>
        </ol>
      </nav>

      <div class="card">
        <div class="card-body">
          @if (session('success'))
          <div class="alert alert-success">{{ session('success') }}</div>
          @endif
          @if (session('error'))
          <div class="alert alert-danger">{{ session('error') }}</div>
          @endif
          
          <table id="argame-table" class="table table-striped table-bordered">
            <thead>
              <tr>
                <th>No.</th>
                <th>Name</th>
                <th>E-mail</th>
                <th>Contact</th>
                <th>Score</th>
                <th>DateTime</th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(() => {
  const table = $('#argame-table').DataTable({
    processing: true,
    serverSide: true,
    scrollX: true,
    ajax: '{!! url("/argames/".$argame->slug."/highscore") !!}',
    columns: [
      { data: 'DT_Row_Index', orderable: false, searchable: false, width: '5%' },
      { data: 'user_name' },
      { data: 'user_email' },
      { data: 'user_contact' },
      { data: 'score' },
      { data: 'updated_at' },
    ],
  });
});
</script>
@endpush
