<div class="tab-pane{{ $tab == 'projectreward' ? ' active' : null }}" id="tab-projectreward" role="tabpanel">
  <div class="card">
    <div class="card-body">
      @if (session('success-reward'))
      <div class="alert alert-success">{{ session('success-reward') }}</div>
      @endif
      @if (session('error-reward'))
      <div class="alert alert-danger">{{ session('error-reward') }}</div>
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

      <form class="needs-validation" novalidate enctype="multipart/form-data" method="POST" action="{{ url('/projects/'.$project->slug.'/projectreward') }}">
        {{ csrf_field() }}

        <div class="form-group row">
          <label for="name" class="col-sm-4 col-md-3 col-form-label">Name <span class="text-danger">*<span></label>

          <div class="col-sm-8 col-md-9">
            <input id="name" type="text" maxlength="255" class="form-control" name="name" value="{{ old('name') ?: ($reward?$reward->name:null) }}" required>
            <div class="invalid-feedback">Please fill in the name</div>
          </div>
        </div>

        <div class="form-group row">
          <label for="serialCode" class="col-sm-4 col-md-3 col-form-label">Serial Code <span class="text-danger">*<span></label>

          <div class="col-sm-8 col-md-9">
            <input id="serialCode" type="text" maxlength="10" class="form-control" name="serialCode" value="{{ old('serialCode') ?: ($reward?$reward->serial_code:null) }}" required>
            <div class="invalid-feedback">Please fill in the serial code</div>
          </div>
        </div>

        <div class="form-group row">
          <label for="notificationTemplateId" class="col-sm-4 col-md-3 col-form-label">Notification Template <span class="text-danger">*<span></label>

          <div class="col-sm-8 col-md-9">
            <select id="notificationTemplateId" class="form-control" name="notificationTemplateId" required>
              @foreach ($templates as $template)
              <option value="{{ $template->id }}" @if (old('notificationTemplateId') == $template->id || ($reward && $reward->notification_template_id == $template->id)) selected="selected" @endif>{{ $template->title }}</option>
              @endforeach
            </select>
            <div class="invalid-feedback">Please choose a notification template</div>
          </div>
        </div>

        <div class="form-group row">
          <label for="status" class="col-sm-4 col-md-3 col-form-label">Status <span class="text-danger">*<span></label>

          <div class="col-sm-8 col-md-9">
            <select id="status" class="form-control" name="status" required>
              <option value="1" @if (old('active') == '1' || ($reward && $reward->active == '1')) selected="selected" @endif>Active</option>
              <option value="0" @if (old('active') == '0' || ($reward && $reward->active == '0')) selected="selected" @endif>Inactive</option>
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
            @if ($reward && $reward->image_path)
            <div class="image-preview">
              <img src="{{ asset($reward->image_path) }}" />
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