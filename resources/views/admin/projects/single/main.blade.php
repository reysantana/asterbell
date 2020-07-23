@extends('layouts.app')

@section('content')
<div class="container-fluid">
  <div class="row">
    <div class="col-sm-10 offset-sm-1 col-md-8 offset-md-2">
      <nav class="clearfix" aria-label="breadcrumb">
        <ol class="breadcrumb float-left">
          <li class="breadcrumb-item"><a href="{{ url('/projects') }}">Projects</a></li>
          <li class="breadcrumb-item active" aria-current="page">Edit Project</li>
        </ol>

      <ol class="float-right">
        <a class="btn btn-success btn-sm" role="button" href="{{ url('/projects/'.$project->slug.'/markers/create') }}">Create Marker</a>
        <a class="btn btn-success btn-sm" role="button" href="{{ url('/projects/'.$project->slug.'/projectmarkers/create') }}">Create Project Marker</a>
        <a class="btn btn-success btn-sm" role="button" href="{{ url('/projects/'.$project->slug.'/projectrewards/create') }}">Create Project Reward</a>
      </ol>    
      </nav>
      
      <nav>
        <div class="nav nav-tabs" id="nav-tab" role="tablist">
          <a class="nav-item nav-link{{ (session('tab') == 'general' || $tab == 'general') ? ' active' : null }}" data-toggle="tab" href="#tab-general" role="tab">General</a>
          <a class="nav-item nav-link{{ (session('tab') == 'markers' || $tab == 'markers') ? ' active' : null }}" data-toggle="tab" href="#tab-markers" role="tab">Markers</a>
          <a class="nav-item nav-link{{ (session('tab') == 'projectmarkers' || $tab == 'projectmarkers') ? ' active' : null }}" data-toggle="tab" href="#tab-projectmarkers" role="tab">Project Markers</a>
          <a class="nav-item nav-link{{ (session('tab') == 'projectrewards' || $tab == 'projectrewards') ? ' active' : null }}" data-toggle="tab" href="#tab-projectrewards" role="tab">Project Rewards</a>
        </div>
      </nav>

      <div class="tab-content">
        @include('admin.projects.single.general')
        @include('admin.projects.single.markers.list')
        @include('admin.projects.single.project_markers.list')
        @include('admin.projects.single.project_rewards.list')
      </div>
    </div>
  </div>
</div>
@endsection