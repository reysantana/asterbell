<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Marker;
use App\Models\Submission;
use App\Models\Notification;
use App\Models\NotificationTemplate;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\SubmissionResource;
use App\Http\Resources\SurveyResource;
use App\Helpers\Helper;

class SubmissionController extends Controller
{
  public function store(Request $request) {
    $response = [
      'error' => 'server_error',
      'message' => "Oh no! There's an error with your request. Please try again.",
    ];

    $marker = Marker::active()->find($request->marker_id);
    
    if (isset($marker->project)) {
      $project = $marker->project->active()->first();
      $userId = $request->user()->id;

      if (isset($project)) {
        $submission = Submission::where('marker_id', $request->marker_id)
                        ->where('user_id', $userId)
                        ->first();
                        
        $survey = $marker->survey->active()->first();

        if (empty($submission)) {
          $completed = (bool)$survey ? false : true;

          // Insert new submission
          $submission = new Submission;
          $submission->marker_id = $marker->id;
          $submission->user_id = $userId;
          $submission->completed = $completed;
          $submission->save();

          // Insert new notification
          if ($completed) {
            $template = NotificationTemplate::find($marker->reward()->first()->notification_template_id);
            $notification = new Notification;
            $notification->submission_id = $submission->id;
            $notification->notification_template_id = $template->id;
            $notification->user_id = $userId;
            $notification->save();

            // send push notification
            Helper::sendNotification($userId, $template);
          }

          return response()->json([
            'data' => [
              'submission' => new SubmissionResource($submission),
              'survey' => new SurveyResource($survey),
            ]]);
          
        } else {
          return response()->json([
            'error' => 'submission_exists',
            'message' => 'Submission exists',
            'data' => [
              'submission' => new SubmissionResource($submission),
              'survey' => new SurveyResource($survey),
            ],
          ]);
        }

      } else {
        return response()->json([
          'error' => 'invalid_project',
          'message' => 'Project not found',
        ]);
      }
    } else {
      return response()->json([
        'error' => 'invalid_marker',
        'message' => 'Marker not found',
      ]);
    }

    return response()->json($response);
  }
}
