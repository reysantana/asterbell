<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class MarkerResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
      if (!isset($this->id)) {
        return null;
      }

      return [
        'id' => $this->id,
        'name' => $this->name,
        'reward' => new RewardResource($this->whenLoaded('reward')),
        'survey' => new SurveyResource($this->whenLoaded('survey')),
        'submission' => new SubmissionResource($this->whenLoaded('submission')),
        'project' => new ProjectResource($this->whenLoaded('project')),
      ];
    }
}
