<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Submission;
use App\Models\SurveyAnswer;
use App\Models\Notification;
use App\Models\NotificationTemplate;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\SurveyAnswerResource;
use App\Helpers\Helper;

class SurveyController extends Controller
{
  public function store(Request $request) {
    $response = [
      'error' => 'server_error',
      'message' => "Oh no! There's an error with your request. Please try again.",
    ];

    $userId = $request->user()->id;
    $submission = Submission::find($request->submission_id);
    
    if (
      $submission &&
      $submission->user_id == $userId
    ) {
      $feedback = $submission->surveyAnswers()
                    ->where('user_id', $userId)
                    ->first();

      $survey = $submission->marker()->first()
                  ->survey()->active()->first();

      if (!(bool)$submission->completed) {
        $submission->completed = true;
        $submission->save();
      }

      if (!$feedback && $survey) {
        $feedback = new SurveyAnswer;
        $feedback->submission_id = $submission->id;
        $feedback->user_id = $userId;
        $feedback->answer = $request->answer;
        $feedback->save();
        
        // Insert new notification        
        $template = NotificationTemplate::find($submission->reward()->notification_template_id);
        $notification = new Notification;
        $notification->submission_id = $submission->id;
        $notification->notification_template_id = $template->id;
        $notification->user_id = $userId;
        $notification->save();

        // send push notification
        Helper::sendNotification($userId, $template);

        return response()->json([
          'data' => [
            'feedback' => new SurveyAnswerResource($feedback),
          ]]);
      } else {
        return response()->json([
          'error' => 'feedback_exists',
          'message' => 'User has submitted the feedback earlier',
          'data' => [
            'feedback' => new SurveyAnswerResource($feedback),
          ]]);
      }
    } else {
      return response()->json([
        'error' => 'invalid_submission',
        'message' => 'Submission not found',
      ]);
    }

    return response()->json($response);
  }
}
