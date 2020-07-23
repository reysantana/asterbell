<div class="tab-pane{{ (session('tab') == 'projectrewards' || $tab == 'projectrewards') ? ' active' : null }}" id="tab-projectrewards" role="tabpanel">
  <div class="card">
    <div class="card-body">
      @if (session('success-projectrewards'))
      <div class="alert alert-success">{{ session('success-projectrewards') }}</div>
      @endif
      @if (session('error-projectrewards'))
      <div class="alert alert-danger">{{ session('error-projectrewards') }}</div>
      @endif
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

      <table id="projectrewards-table" class="table table-striped table-bordered">
        <thead>
          <tr>
            <th>No.</th>
            <th>Name</th>
            <th>Marker scan</th>
            <th>Status</th>
            <th>Action</th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>

@push('scripts')
<script>
$(document).ready(() => {
  const table = $('#projectrewards-table').DataTable({
    processing: true,
    serverSide: true,
    scrollX: true,
    ajax: '{!! url("/projects/".$project->slug."/projectrewards") !!}',
    columns: [
      { data: 'DT_Row_Index', orderable: false, searchable: false, width: '5%' },
      { data: 'name' },
      { data: 'marker_scan' },
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
          return "<a class='btn btn-view btn-sm btn-primary' href='{{ url('projects/'.$project->slug.'/projectrewards') }}/"+data.id+"'>View/Edit</a>";
        }
      },
    ],
  });

  $('a[href="#tab-projectrewards"]').click(() => {
    setTimeout(() => {
      table.columns.adjust().draw();
    }, 0);
  });
});
</script>
@endpush