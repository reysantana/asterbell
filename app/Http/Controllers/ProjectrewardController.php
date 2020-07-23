<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Projectreward;
use App\Models\Projectmarker;
use App\Models\Survey;
use App\Models\Reward;
use App\Models\NotificationTemplate;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;


class ProjectrewardController extends Controller
{

  public function index(Request $request, $slug) {
    $project = Project::where('slug', $slug)->first();
    if (!count($project)) {
      return redirect('/projects')->with('error', 'The project you requested was not found.');
    }

    if($request->ajax()){
      return DataTables::of(Projectreward::where('project_id', $project->id)->get())->addIndexColumn()->make(true);
    }

    return view('admin.projects.single.project_rewards.list', compact('project'));
  }

  // public function updateSingle(Request $request, $slug, $projectId) {    
  //   $this->_validateRequest($request);
  //   $reward = Projectreward::where('project_id', $projectId)->first();

  //   if (!count($reward)) {
  //     $reward = new Projectreward;
  //     $reward->project_id = $projectId;
  //   }
  
  //   $reward->name = $request->name;
  //   $reward->serial_code = $request->serialCode;
  //   $reward->notification_template_id = $request->notificationTemplateId;
  //   $reward->active = $request->status;
  //   $reward->save();

  //   // upload image
  //   if ($request->hasFile('image') && $request->file('image')->isValid()) {
  //     $reward->image_path = 'storage/'.str_replace('public/', '', $request->file('image')->store('public/images'));
  //     $reward->save();
  //   }

  //   return redirect('/projects/'.$slug.'/projectrewards/'.$projectId)
  //     ->with('success-reward', 'Project Reward is updated successfully.')
  //     ->with('tab', 'projectreward');
  // }

  public function create($slug) {
    $project = Project::where('slug', $slug)->first();
    if (!count($project)) {
      return redirect('/projects')->with('error', 'The project you requested was not found.');
    }

    $templates = NotificationTemplate::where('category', 'reward')->get();
    return view('admin.projects.single.project_rewards.create', ['project' => $project,'templates' => $templates]);
    //return view('admin.projects.single.project_rewards.create', compact('project'));
  }

  public function store(Request $request, $slug) {
    $this->_validateRequest($request);

    $project = Project::where('slug', $slug)->first();
    if (!count($project)) {
      return redirect('/projects')->with('error', 'The project you requested was not found.');
    }
        
    $reward = new Projectreward;
    $reward->project_id = $project->id;
    $reward->name = $request->name;
    $reward->marker_scan = $request->markerscan;
    $reward->serial_code = $request->serialCode;
    $reward->notification_template_id = $request->notificationTemplateId;
    $reward->active = $request->status;
    $reward->save();

    if ($request->hasFile('image') && $request->file('image')->isValid()) {
      $reward->image_path = 'storage/'.str_replace('public/', '', $request->file('image')->store('public/images'));
      $reward->save();
    }    

    return redirect('/projects/'.$slug.'/projectrewards/'.$reward->id)
      ->with('success-projectrewards', 'Project Reward is created successfully.')
      ->with('tab', 'projectrewards');
  }

  public function show($slug, $id) {
    $reward = Projectreward::find($id);
    if (!count($reward)) {
      return redirect('/projects/'.$slug.'/projectrewards')->with('error', 'The reward you requested was not found.');
    }

    $templates = NotificationTemplate::where('category', 'reward')->get();
    $tab = session('tab') ?: 'general';

    return view('admin.projects.single.project_rewards.single', [
      'reward' => $reward,
      'project' => $reward->project,
      'templates' => $templates
    ])->with('tab', $tab);
  }

  public function update(Request $request, $slug, $id) {
    $reward = Projectreward::find($id);
    if (!count($reward)) {
      return redirect('/projects/'.$slug.'/projectrewards')->with('error', 'The reward you requested was not found.');
    }

    $this->_validateRequest($request);    
  
    $reward->name = $request->name;
    $reward->marker_scan = $request->markerscan;
    $reward->serial_code = $request->serialCode;
    $reward->notification_template_id = $request->notificationTemplateId;
    $reward->active = $request->status;
    $reward->save();

    return redirect('/projects/'.$slug.'/projectrewards/'.$id)
      ->with('success-general', 'Project Reward is updated successfully.')
      ->with('tab', 'general');
  }

  private function _validateRequest($request) {
    $request->validate([
      'name' => 'required|string|max:255',
      'serialCode' => 'required|string|max:10',
      'notificationTemplateId' => 'required',
    ]);
  }
}
