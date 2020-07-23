@extends('layouts.app')

@section('content')
<div class="container-fluid">
  <div class="row">
    <div class="col-sm-10 offset-sm-1 col-md-8 offset-md-2">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ url('/projects') }}">Projects</a></li>        
          <li class="breadcrumb-item"><a href="{{ url('/projects/'.$project->slug) }}">{{ $project->name }}</a></li>        
          <li class="breadcrumb-item active" aria-current="page">Edit Project Reward</li>
        </ol>
      </nav>

      <nav>
        <div class="nav nav-tabs" id="nav-tab" role="tablist">
          <a class="nav-item nav-link{{ $tab == 'general' ? ' active' : null }}" data-toggle="tab" href="#tab-general" role="tab">General</a>
        </div>
      </nav>

      <div class="tab-content">
        @include('admin.projects.single.project_rewards.general')
      </div>
    </div>
  </div>
</div>
@endsection