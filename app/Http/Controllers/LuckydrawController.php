<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Luckydraw;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class LuckydrawController extends Controller
{
  public function index(Request $request) {
    if($request->ajax()){
      return DataTables::of(Luckydraw::query())->addIndexColumn()->make(true);      
    }
    return view('admin.luckydraws.list');
  }
  
  public function create() {
    return view('admin.luckydraws.create');
  }

  public function store(Request $request) {
    $this->_validateRequest($request);    
      
    $luckydraw = new Luckydraw;
    $luckydraw->name = $request->name;
    $luckydraw->slug = $request->slug;
    $luckydraw->start_date = $request->startDate;
    $luckydraw->end_date = $request->endDate;
    $luckydraw->description = $request->description;
    $luckydraw->tnc = $request->tnc;
    $luckydraw->active = $request->status;
    $luckydraw->save();

    if ($request->hasFile('image') && $request->file('image')->isValid()) {
      $luckydraw->image_path = 'storage/'.str_replace('public/', '', $request->file('image')->store('public/images'));
      $luckydraw->save();
    }

    return redirect('/luckydraws/'.$luckydraw->slug)
      ->with('success-general', 'Luckydraw is created successfully.')
      ->with('tab', 'general');
  }
  
  // public function show($slug) {
  //   $project = Project::where('slug', $slug)->first();
  //   if (!count($project)) {
  //     return redirect('/projects')->with('error', 'The project you requested was not found.');
  //   }

  //   return view('admin.projects.single.main', compact('project'))->with('tab', 'general');
  // }

  // public function update(Request $request, $slug) {
  //   $project = Project::where('slug', $slug)->first();
  //   if (!count($project)) {
  //     return redirect('/projects')->with('error', 'The project you requested was not found.');
  //   }

  //   $this->_validateRequest($request, $project->id);    
  
  //   $project->name = $request->name;
  //   $project->slug = $request->slug;
  //   $project->start_date = $request->startDate;
  //   $project->end_date = $request->endDate;
  //   $project->description = $request->description;
  //   $project->active = $request->status;
  //   $project->save();

  //   return redirect('/projects/'.$project->slug)
  //     ->with('success-general', 'Project is updated successfully.')
  //     ->with('tab', 'general');
  // }

  private function _validateRequest($request, $luckydrawId = null) {
    $slugRule = 'required|string|max:20|unique:luckydraws';

    if ($luckydrawId) {
      $slugRule .= ',slug,'.$luckydrawId;
    }

    $request->validate([
      'name' => 'required|string|max:255',
      'slug' => $slugRule,
    ]);
  }
}
