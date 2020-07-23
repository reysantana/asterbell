<?php

namespace App\Http\Controllers;

use App\Models\NotificationTemplate;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class NotificationTemplateController extends Controller
{
  public function index(Request $request) {
    if($request->ajax()){
      return DataTables::of(NotificationTemplate::query())->addIndexColumn()->make(true);      
    }
    return view('admin.settings.notification-templates.list');
  }
  
  public function create() {
    return view('admin.settings.notification-templates.create');
  }

  public function store(Request $request) {
    $this->_validateRequest($request);
      
    $template = new NotificationTemplate;
    $template->title = $request->title;
    $template->category = $request->category;
    $template->message_excerpt = $request->excerpt;
    $template->message_content = $request->fullMessage;
    $template->save();

    return redirect('/settings/notification-templates')->with('success', 'Template is created successfully.');
  }
  
  public function show($id) {
    $template = NotificationTemplate::find($id);
    if (!count($template)) {
      return redirect('/settings/notification-templates')->with('error', 'The template you requested was not found.');
    }

    return view('admin.settings.notification-templates.single', compact('template'));
  }

  public function update(Request $request, $id) {
    $template = NotificationTemplate::find($id);
    if (!count($template)) {
      return redirect('/settings/notification-templates')->with('error', 'The template you requested was not found.');
    }
    
    $this->_validateRequest($request);
  
    $template->title = $request->title;
    $template->category = $request->category;
    $template->message_excerpt = $request->excerpt;
    $template->message_content = $request->fullMessage;
    $template->save();

    return redirect('/settings/notification-templates')->with('success', 'Template is updated successfully.');
  }

  private function _validateRequest($request) {
    $request->validate([
      'title' => 'required|string|max:255',
      'category' => 'required',
      'excerpt' => 'required|string|max:255',
    ]);
  }
}
