<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ProjectController extends Controller
{
  public function index(Request $request) {
    // if($request->ajax()){
    //   return DataTables::of(Project::query())->addIndexColumn()->make(true);      
    // }
    // return view('admin.projects.list');
    return redirect('/argames');
  }
  
  public function create() {
    return view('admin.projects.create');
  }

  public function store(Request $request) {
    $this->_validateRequest($request);    
      
    $project = new Project;
    $project->name = $request->name;
    $project->slug = $request->slug;
    $project->start_date = $request->startDate;
    $project->end_date = $request->endDate;
    $project->description = $request->description;
    $project->active = $request->status;
    $project->save();

    return redirect('/projects/'.$project->slug)
      ->with('success-general', 'Project is created successfully.')
      ->with('tab', 'general');
  }
  
  public function show($slug) {
    $project = Project::where('slug', $slug)->first();
    if (!count($project)) {
      return redirect('/projects')->with('error', 'The project you requested was not found.');
    }

    return view('admin.projects.single.main', compact('project'))->with('tab', 'general');
  }

  public function update(Request $request, $slug) {
    $project = Project::where('slug', $slug)->first();
    if (!count($project)) {
      return redirect('/projects')->with('error', 'The project you requested was not found.');
    }

    $this->_validateRequest($request, $project->id);    
  
    $project->name = $request->name;
    $project->slug = $request->slug;
    $project->start_date = $request->startDate;
    $project->end_date = $request->endDate;
    $project->description = $request->description;
    $project->active = $request->status;
    $project->save();

    return redirect('/projects/'.$project->slug)
      ->with('success-general', 'Project is updated successfully.')
      ->with('tab', 'general');
  }

  private function _validateRequest($request, $projectId = null) {
    $slugRule = 'required|string|max:20|unique:projects';

    if ($projectId) {
      $slugRule .= ',slug,'.$projectId;
    }

    $request->validate([
      'name' => 'required|string|max:255',
      'slug' => $slugRule,
    ]);
  }
}
