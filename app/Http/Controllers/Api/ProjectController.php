<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Submission;
use App\Http\Resources\ProjectResource;
use App\Http\Resources\SubmissionResource;

class ProjectController extends Controller
{
    public function single(Request $request, $slug)
    {
      // $userId = $request->user('api') ? $request->user('api')->id : null;
      $userId = null;

      // Check if project is active and within start and end date range
      $project = Project::where('slug', $slug)
                  ->active()
                  ->with(['markers' => function($marker) use ($userId) {
                    $marker->active()
                      ->with([
                        'reward' => function($q) { $q->active(); },
                        'survey' => function($q) { $q->active(); },
                        'submission' => function($q) use ($userId) {
                          $q->where('user_id', $userId);
                        },
                      ]);
                  }])
                  ->with([
                        'projectmarkers' => function($q) { $q->active(); },
                      ])
                  ->with([
                        'projectrewards' => function($q) { $q->active(); },
                      ])
                  ->first();

      if ($project) {
        $project = new ProjectResource($project);
      }

      return response()->json([ 'data' => $project ]);
    }

    private function _getActiveMarkers($project) {
      $project->markers = $project->markers->filter(function($item, $key) {
        return $item->active;
      });

      return $project;
    }
}
