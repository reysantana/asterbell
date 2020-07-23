<?php

namespace App\Http\Controllers;

use App\Models\Project;
// use App\Models\Marker;
use App\Models\Projectmarker;
use App\Models\Survey;
use App\Models\Reward;
use App\Models\NotificationTemplate;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ProjectmarkerController extends Controller
{
  public function index(Request $request, $slug) {
    $project = Project::where('slug', $slug)->first();
    if (!count($project)) {
      return redirect('/projects')->with('error', 'The project you requested was not found.');
    }

    if($request->ajax()){
      return DataTables::of(Projectmarker::where('project_id', $project->id)->get())->addIndexColumn()->make(true);
    }

    return view('admin.projects.single.project_markers.list', compact('project'));
  }
  
  public function create($slug) {
    $project = Project::where('slug', $slug)->first();
    if (!count($project)) {
      return redirect('/projects')->with('error', 'The project you requested was not found.');
    }

    return view('admin.projects.single.project_markers.create', compact('project'));
  }

  public function store(Request $request, $slug) {
    $this->_validateRequest($request);

    $project = Project::where('slug', $slug)->first();
    if (!count($project)) {
      return redirect('/projects')->with('error', 'The project you requested was not found.');
    }
      
    $marker = new Projectmarker;
    $marker->project_id = $project->id;
    $marker->name = $request->name;
    $marker->active = $request->status;
    $marker->save();

    return redirect('/projects/'.$slug.'/projectmarkers/'.$marker->id)
      ->with('success-general', 'Project Marker is created successfully.')
      ->with('tab', 'general');
  }
  
  public function show($slug, $id) {
    $marker = Projectmarker::find($id);
    if (!count($marker)) {
      return redirect('/projects/'.$slug.'/projectmarkers')->with('error', 'The marker you requested was not found.');
    }

    // $templates = NotificationTemplate::where('category', 'reward')->get();
    $tab = session('tab') ?: 'general';

    return view('admin.projects.single.project_markers.single', [
      'marker' => $marker,
      'project' => $marker->project
    ])->with('tab', $tab);
  }

  public function update(Request $request, $slug, $id) {
    $marker = Projectmarker::find($id);
    if (!count($marker)) {
      return redirect('/projects/'.$slug.'/projectmarkers')->with('error', 'The marker you requested was not found.');
    }

    $this->_validateRequest($request);    
  
    $marker->name = $request->name;
    $marker->active = $request->status;
    $marker->save();

    return redirect('/projects/'.$slug.'/projectmarkers/'.$id)
      ->with('success-general', 'Project Marker is updated successfully.')
      ->with('tab', 'general');
  }

  private function _validateRequest($request) {
    $request->validate([
      'name' => 'required|string|max:255',
    ]);
  }
}
