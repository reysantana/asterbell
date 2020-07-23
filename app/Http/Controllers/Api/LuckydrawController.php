<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Project;
use App\Models\Luckydraw;
use App\Models\Joinluckydraw;
use App\Models\Submission;
use App\Http\Resources\ProjectResource;
use App\Http\Resources\LuckydrawResource;
use App\Http\Resources\SubmissionResource;

class LuckydrawController extends Controller
{
    public function single(Request $request)
    {
      // $userId = $request->user('api') ? $request->user('api')->id : null;
      // $userId = null;

      // Check if project is active and within start and end date range
      $luckydraw = Luckydraw::active()
                  ->first();

      if($luckydraw){
        $luckydraw = new LuckydrawResource($luckydraw);
      }

      return response()->json([ 'luckydraw' => $luckydraw ]);
    }

    // private function _getActiveMarkers($luckydraw) {
    //   $luckydraw->markers = $luckydraw->markers->filter(function($item, $key) {
    //     return $item->active;
    //   });

    //   return $luckydraw;
    // }

    public function joinluckydraw(Request $request)
    {

      $luckydraw = Luckydraw::active()->find($request->luckydraw_id);
      $userId = $request->user()->id;

      try {
        $joinluckydraw = new Joinluckydraw;
        $joinluckydraw->luckydraw_id = $luckydraw->id;
        $joinluckydraw->user_id = $userId;
        $joinluckydraw->save();
      } catch (\Exception $e){
        return response()->json([
          'error' => 'update_error',
          'message' => 'Failed to update user join luckydraw',
        ]);
      }
      
      return response()->json([
        'message' => 'User join luckydraw successfully',
      ]);

    }

    public function checkluckydraw(Request $request)
    {

      $luckydraw = Luckydraw::active()->find($request->luckydraw_id);
      $userId = $request->user()->id;

      $checkluckydraw = Joinluckydraw::where('luckydraw_id', $luckydraw->id)
                      ->where('user_id', $userId)
                      ->first();
                      
      if($checkluckydraw){
        return response()->json([
          'message' => 'User joined luckydraw',
          'data' => $checkluckydraw,
        ]);
      }else{
        return response()->json([
          'message' => 'User did not join luckydraw',
          'data' => $checkluckydraw,
        ]);
      }
    }

}
