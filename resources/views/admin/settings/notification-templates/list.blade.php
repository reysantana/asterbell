@extends('layouts.app')

@section('content')
<div class="container-fluid">
  <div class="row">
    <div class="col-sm-10 offset-sm-1 col-md-8 offset-md-2">
      <nav class="clearfix" aria-label="breadcrumb">
        <ol class="breadcrumb float-left">
          <li class="breadcrumb-item"><a href="{{ url('/settings/notification-templates') }}">Settings</a></li>
          <li class="breadcrumb-item active" aria-current="page">Notification Templates</li>
        </ol>

        <a class="btn btn-success btn-sm float-right" role="button" href="{{ url('/settings/notification-templates/create') }}">Create Template</a>
      </nav>

      <div class="card">
        <div class="card-body">
          @if (session('success'))
          <div class="alert alert-success">{{ session('success') }}</div>
          @endif
          @if (session('error'))
          <div class="alert alert-danger">{{ session('error') }}</div>
          @endif
          
          <table id="notifications-table" class="table table-striped table-bordered">
            <thead>
              <tr>
                <th>No.</th>
                <th>Title</th>
                <th>Category</th>
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
  const table = $('#notifications-table').DataTable({
    processing: true,
    serverSide: true,
    scrollX: true,
    ajax: '{!! url("/settings/notification-templates") !!}',
    columns: [
      { data: 'DT_Row_Index', orderable: false, searchable: false, width: '5%' },
      { data: 'title' },
      { data: 'category' },
      {
        width: '10%',
        orderable: false,
        searchable: false,
        data: null,
        render: function (data, type, row) {
          return "<a class='btn btn-view btn-sm btn-primary' href='{{ url('settings/notification-templates') }}/"+data.id+"'>View/Edit</a>";
        }
      },
    ],
  });
});
</script>
@endpush
