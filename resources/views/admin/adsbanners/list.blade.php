@extends('layouts.app')

@section('content')
<div class="container-fluid">
  <div class="row">
    <div class="col-sm-10 offset-sm-1 col-md-8 offset-md-2">
      <nav class="clearfix" aria-label="breadcrumb">
        <ol class="breadcrumb float-left">
          <li class="breadcrumb-item active" aria-current="page">Ads Banner</li>
        </ol>
        <ol class="float-right">
          <a class="btn btn-success btn-sm" role="button" href="{{ url('/adsbanners/create') }}">Create Ads Banner</a>
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
          
          <table id="adsbanner-table" class="table table-striped table-bordered">
            <thead>
              <tr>
                <th>No.</th>
                <th>Name</th>
                <th>URL</th>
                <th>Metadata</th>
                <th>Status</th>
                <th>Action</th>
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
  const table = $('#adsbanner-table').DataTable({
    processing: true,
    serverSide: true,
    scrollX: true,
    ajax: '{!! url("/adsbanners") !!}',
    columns: [
      { data: 'DT_Row_Index', orderable: false, searchable: false, width: '5%' },
      { data: 'name' },
      { data: 'url' },
      { data: 'metadata' },
      {
        width: '10%',
        data: null,
        render: function (data, type, row) {
          return '<span class="badge badge-pill badge-' + (data.active == '1' ? 'success">Active' : 'danger">Inactive') + '</span>';
        }
      },
      {
        width: '10%',
        orderable: false,
        searchable: false,
        data: null,
        render: function (data, type, row) {
          return "<a class='btn btn-view btn-sm btn-primary' href='{{ url('adsbanners/edit') }}/"+data.id+"'>View/Edit</a>";
        }
      },
    ],
  });
});
</script>
@endpush
