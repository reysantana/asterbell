<div class="tab-pane{{ $tab == 'survey' ? ' active' : null }}" id="tab-survey" role="tabpanel">
  <div class="card">
    <div class="card-body">
      @if (session('success-survey'))
      <div class="alert alert-success">{{ session('success-survey') }}</div>
      @endif
      @if (session('error-survey'))
      <div class="alert alert-danger">{{ session('error-survey') }}</div>
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

      <form class="needs-validation" novalidate enctype="multipart/form-data" method="POST" action="{{ url('/projects/'.$project->slug.'/markers/'.$marker->id.'/survey') }}">
        {{ csrf_field() }}

        <div class="form-group row">
          <label for="question" class="col-sm-4 col-md-3 col-form-label">Question <span class="text-danger">*<span></label>

          <div class="col-sm-8 col-md-9">
            <textarea id="question" class="form-control" name="question" rows="5" required>{{ old('question') ?: ($survey?$survey->question:null) }}</textarea>
            <div class="invalid-feedback">Please fill in the question</div>
          </div>
        </div>

        <div class="form-group row">
          <label for="status" class="col-sm-4 col-md-3 col-form-label">Status <span class="text-danger">*<span></label>

          <div class="col-sm-8 col-md-9">
            <select id="status" class="form-control" name="status" required>
              <option value="1" @if (old('active') == '1' || ($survey && $survey->active == '1')) selected="selected" @endif>Active</option>
              <option value="0" @if (old('active') == '0' || ($survey && $survey->active == '0')) selected="selected" @endif>Inactive</option>
            </select>
            <div class="invalid-feedback">Please choose a status</div>
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
            @if ($survey && $survey->image_path)
            <div class="image-preview">
              <img src="{{ asset($survey->image_path) }}" />
            </div>
            @endif
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