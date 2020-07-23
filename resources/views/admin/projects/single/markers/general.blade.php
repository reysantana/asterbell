<div class="tab-pane{{ $tab == 'general' ? ' active' : null }}" id="tab-general" role="tabpanel">
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

      <form class="needs-validation" novalidate method="POST" action="{{ url('/projects/'.$project->slug.'/markers/'.$marker->id) }}">
        {{ csrf_field() }}
        {{ method_field('PUT') }}

        <div class="form-group row">
          <label for="name" class="col-sm-4 col-md-3 col-form-label">Name <span class="text-danger">*<span></label>

          <div class="col-sm-8 col-md-9">
            <input id="name" type="text" maxlength="255" class="form-control" name="name" value="{{ old('name') ?: $marker->name }}" required>
            <div class="invalid-feedback">Please fill in the name</div>
          </div>
        </div>

        <div class="form-group row">
          <label for="status" class="col-sm-4 col-md-3 col-form-label">Status <span class="text-danger">*<span></label>

          <div class="col-sm-8 col-md-9">
            <select id="status" class="form-control" name="status" required>
              <option value="1" @if (old('active') == '1' || $marker->active == '1') selected="selected" @endif>Active</option>
              <option value="0" @if (old('active') == '0' || $marker->active == '0') selected="selected" @endif>Inactive</option>
            </select>
            <div class="invalid-feedback">Please choose a status</div>
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