@extends('layouts.app')

@section('content')
<div class="container-fluid">
  <div class="row">
    <div class="col-sm-10 offset-sm-1 col-md-8 offset-md-2">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item active" aria-current="page">Survey Feedbacks</li>
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
          
          <table id="surveys-table" class="table table-striped table-bordered">
            <thead>
              <tr>
                <th>No.</th>
                <th>Project</th>
                <th>Participant</th>
                <th>Submission Date</th>
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
  const table = $('#surveys-table').DataTable({
    processing: true,
    serverSide: true,
    scrollX: true,
    ajax: '{!! url("/survey-feedbacks") !!}',
    order: [[3, 'desc']],
    columns: [
      { data: 'DT_Row_Index', orderable: false, searchable: false, width: '5%' },
      { data: 'project_name' },
      { data: 'user_name' },
      { data: 'submission_date' },
      {
        width: '10%',
        data: null,
        render: function (data, type, row) {
          return '<span class="badge badge-pill badge-' + (data.replied == '0' ? 'success">New' : 'secondary">Replied') + '</span>';
        }
      },
      {
        width: '10%',
        orderable: false,
        searchable: false,
        data: null,
        render: function (data, type, row) {
          return "<a class='btn btn-view btn-sm btn-primary' href='{{ url('survey-feedbacks') }}/"+data.id+"'>View/Reply</a>";
        }
      },
    ],
  });
});
</script>
@endpush
