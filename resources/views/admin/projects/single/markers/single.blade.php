@extends('layouts.app')

@section('content')
<div class="container-fluid">
  <div class="row">
    <div class="col-sm-10 offset-sm-1 col-md-8 offset-md-2">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ url('/projects') }}">Projects</a></li>        
          <li class="breadcrumb-item"><a href="{{ url('/projects/'.$project->slug) }}">{{ $project->name }}</a></li>        
          <li class="breadcrumb-item active" aria-current="page">Edit Marker</li>
        </ol>
      </nav>

      <nav>
        <div class="nav nav-tabs" id="nav-tab" role="tablist">
          <a class="nav-item nav-link{{ $tab == 'general' ? ' active' : null }}" data-toggle="tab" href="#tab-general" role="tab">General</a>
          <a class="nav-item nav-link{{ $tab == 'survey' ? ' active' : null }}" data-toggle="tab" href="#tab-survey" role="tab">Survey</a>
          <a class="nav-item nav-link{{ $tab == 'reward' ? ' active' : null }}" data-toggle="tab" href="#tab-reward" role="tab">Reward</a>
        </div>
      </nav>

      <div class="tab-content">
        @include('admin.projects.single.markers.general')
        @include('admin.projects.single.markers.survey')
        @include('admin.projects.single.markers.reward')
      </div>
    </div>
  </div>
</div>
@endsection