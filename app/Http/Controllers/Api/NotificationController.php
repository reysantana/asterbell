<?php

namespace App\Http\Controllers\Api;

use App\Models\Notification;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\NotificationResource;

class NotificationController extends Controller
{
  public function list(Request $request) {
    $userId = $request->user('api') ? $request->user('api')->id : null;    
    $notifications = Notification::where('user_id', $userId)
                      ->where('deleted', 0)
                      ->get();

    return response()->json([
      'data' => [
        'notifications' => NotificationResource::collection($notifications),
      ]]);
  }

  public function delete(Request $request) {
    try {
      $notification = Notification::find($request->id)
                        ->where('user_id', $request->user()->id)->first();

      $notification->deleted = 1;
      $notification->save();
    } catch (\Exception $e){
      return response()->json([
        'error' => 'update_error',
        'message' => 'Failed to update user account details',
      ]);
    }

    return response()->json([
      'message' => 'Notification is deleted successfully',
    ]);
  }  
}
