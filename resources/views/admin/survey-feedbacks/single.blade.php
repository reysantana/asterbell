@extends('layouts.app')

@section('content')
<div class="container-fluid">
  <div class="row">
    <div class="col-sm-10 offset-sm-1 col-md-8 offset-md-2">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ url('/survey-feedbacks') }}">Survey Feedbacks</a></li>        
          <li class="breadcrumb-item active" aria-current="page">Reply Feedback</li>
        </ol>
      </nav>

      @if (session('error'))
      <div class="alert alert-danger">{{ session('error') }}</div>
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

      <div class="card mb-3">
        <div class="card-body">
          <h5>Survey Question:</h5>
          <div>{{ $feedback->survey()->question }}</div>
        </div>
      </div>
      
      <div class="card">
        <div class="card-body">
          <div id="conversations" class="container-fluid">
            <div class="reply reply-user row">
              <div class="wrapper col-9">
                <div class="message">{{ $feedback->answer }}</div>
                <div class="date text-right">{{ date('j M, h:iA', strtotime($feedback->created_at)) }}</div>
              </div>
            </div>

            @foreach($adminReplies as $reply)
            <div class="reply reply-admin row">
              <div class="wrapper col-9 offset-3">
                <div class="message">{{ $reply->answer }}</div>
                <div class="date text-right">{{ date('j M, h:iA', strtotime($reply->created_at)) }}</div>
              </div>
            </div>
            @endforeach
          </div>
        </div>

        <form id="conversation-textarea" class="needs-validation" novalidate method="POST" action="{{ url('/survey-feedbacks/'.$feedback->id) }}">
          {{ csrf_field() }}
          {{ method_field('PUT') }}

          <div class="input-group">
            <input type="text" class="form-control" placeholder="Type a message" name="message" maxlength="255" required>
            <div class="input-group-append">
              <button class="btn btn-dark" type="submit">Send</button>
            </div>
            <div class="invalid-feedback">Please type your message</div>            
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(() => {
  $('.summernote').summernote({
    height: 150,
    toolbar: [
      ['style', ['bold', 'italic', 'underline']],
    ]
  });
});
</script>
@endpush