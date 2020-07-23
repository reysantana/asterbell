<?php

namespace App\Http\Controllers\Api;

//use App\Models\Marker;
use App\Models\Projectmarker;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\MarkerResource;

class ProjectmarkerController extends Controller
{
  public function index(Request $request, $markerName = null) {
    $userId = $request->user('api') ? $request->user('api')->id : null;
    
    $marker = Projectmarker::where('name', $markerName)
                      //->active()
                      //->activeProject()
                      ->with('project:id,name,slug')
                      // ->with([
                      //   'reward' => function($q) { $q->active(); },
                      //   'survey' => function($q) { $q->active(); },
                      //   'submission' => function($q) use ($userId) {
                      //     $q->where('user_id', $userId);
                      //   },
                      // ])
                      ->orderBy('created_at', 'desc')
                      ->first();

    if ($marker) {
      //$marker = new MarkerResource($marker);
    }

    return response()->json(['data' => array_except($marker, ['project_id'])]);
    // return response()->json(['data' => $marker]);
  }
}
