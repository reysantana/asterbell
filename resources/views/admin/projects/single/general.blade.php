<div class="tab-pane{{ (session('tab') == 'general' || $tab == 'general') ? ' active' : null }}" id="tab-general" role="tabpanel">
  <div class="card">
    <div class="card-body">
      @if (session('success-general'))
      <div class="alert alert-success">{{ session('success-general') }}</div>
      @endif
      @if (session('error-general'))
      <div class="alert alert-danger">{{ session('error-general') }}</div>
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

      <form class="needs-validation" novalidate method="POST" action="{{ url('/projects/'.$project->slug) }}">
        {{ csrf_field() }}
        {{ method_field('PUT') }}

        <div class="form-group row">
          <label for="name" class="col-sm-4 col-md-3 col-form-label">Name <span class="text-danger">*<span></label>

          <div class="col-sm-8 col-md-9">
            <input id="name" type="text" maxlength="255" class="form-control" name="name" value="{{ old('name') ?: $project->name }}" required>
            <div class="invalid-feedback">Please fill in the name</div>
          </div>
        </div>

        <div class="form-group row">
          <label for="slug" class="col-sm-4 col-md-3 col-form-label">Slug <span class="text-danger">*<span></label>

          <div class="col-sm-8 col-md-9">
            <input id="slug" type="text" maxlength="20" class="form-control" name="slug" value="{{ old('slug') ?: $project->slug }}" required>
            <div class="invalid-feedback">Please fill in the slug</div>
          </div>
        </div>

        <div class="form-group row">
          <label for="status" class="col-sm-4 col-md-3 col-form-label">Status <span class="text-danger">*<span></label>

          <div class="col-sm-8 col-md-9">
            <select id="status" class="form-control" name="status" required>
              <option value="1" @if (old('active') == '1' || $project->active == '1') selected="selected" @endif>Active</option>
              <option value="0" @if (old('active') == '0' || $project->active == '0') selected="selected" @endif>Inactive</option>
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
          <label for="description" class="col-sm-4 col-md-3 col-form-label">Description</label>

          <div class="col-sm-8 col-md-9">
            <textarea class="form-control" name="description" rows="5">{{ old('description') ?: $project->description }}</textarea>
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

@push('scripts')
<script>
$(document).ready(() => {
  $('#start-date').datetimepicker({
    format: 'YYYY-MM-DD HH:mm:ss',
    date: '{{ old("startDate") ?: $project->start_date }}'
  });

  $('#end-date').datetimepicker({
    format: 'YYYY-MM-DD HH:mm:ss',
    date: '{{ old("endDate") ?: $project->end_date }}'
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