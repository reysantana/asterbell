<?php

namespace App\Http\Controllers;

use App\Models\Survey;
use App\Models\SurveyAnswer;
use App\Models\Notification;
use App\Models\NotificationTemplate;
use App\Http\Resources\SurveyListResource;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Helpers\Helper;

class SurveyController extends Controller
{
  public function index(Request $request) {
    if($request->ajax()){
      $submissions = [];
      $arr = SurveyAnswer::where('user_id', '<>', '1')->get();
  
      foreach($arr as $submission) {
        array_push($submissions, [
          'id' => $submission->id,
          'project_name' => $submission->project()->name,
          'user_name' => $submission->user->name,
          'replied' => $submission->replied,
          'submission_date' => (string)$submission->created_at
        ]);
      }

      return DataTables::of($submissions)->addIndexColumn()->make(true);      
    }
    return view('admin.survey-feedbacks.list');
  }

  public function show($id) {
    $feedback = SurveyAnswer::where('id', $id)->where('user_id', '<>', '1')->first();
    if (!count($feedback)) {
      return redirect('/survey-feedbacks')->with('error', 'The feedback you requested was not found.');
    }

    $adminReplies = SurveyAnswer::where('submission_id', $feedback->submission_id)
                      ->where('user_id', '1')
                      ->get();

    return view('admin.survey-feedbacks.single', compact('feedback', 'adminReplies'));
  }

  public function update(Request $request, $id) {
    $feedback = SurveyAnswer::where('id', $id)->where('user_id', '<>', '1')->first();
    if (!count($feedback)) {
      return redirect('/survey-feedbacks')->with('error', 'The feedback you requested was not found.');
    }

    $request->validate([
      'message' => 'required|string|max:255',
    ]);

    $userId = $feedback->user_id;
      
    // update feedback as replied
    $feedback->replied = 1;
    $feedback->save();

    // insert new reply
    $newReply = new SurveyAnswer;
    $newReply->submission_id = $feedback->submission_id;
    $newReply->user_id = 1;
    $newReply->answer = $request->message;
    $newReply->save();

    // insert new notification
    $template = NotificationTemplate::where('category', 'message')->first();
    $notification = new Notification;
    $notification->submission_id = $feedback->submission_id;
    $notification->notification_template_id = $template->id;
    $notification->user_id = $userId;
    $notification->save();
    
    // send push notification
    Helper::sendNotification($userId, $template);

    return redirect('/survey-feedbacks/'.$feedback->id)->with('success', 'Feedback is replied successfully.');
  }

  public function updateSingle(Request $request, $slug, $markerId) {   
    $request->validate([
      'question' => 'required|string|max:255',
    ]);
    $survey = Survey::where('marker_id', $markerId)->first();

    if (!count($survey)) {
      $survey = new Survey;
      $survey->marker_id = $markerId;
    }

    $survey->question = $request->question;
    $survey->active = $request->status;
    $survey->save();

    // upload image
    if ($request->hasFile('image') && $request->file('image')->isValid()) {
      $survey->image_path = 'storage/'.str_replace('public/', '', $request->file('image')->store('public/images'));
      $survey->save();
    }

    return redirect('/projects/'.$slug.'/markers/'.$markerId)
      ->with('success-survey', 'Survey is updated successfully.')
      ->with('tab', 'survey');
  }

  private function _validateRequest($request) {
    $request->validate([
      'question' => 'required|string|max:255',
    ]);
  }
}
