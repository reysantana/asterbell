<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class ProjectrewardResource extends Resource
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
        'marker_scan' => $this->marker_scan,
        'serial_code' => $this->serial_code,
        'image_path' => $this->image_path,
        //'reward' => new RewardResource($this->whenLoaded('reward')),
        //'survey' => new SurveyResource($this->whenLoaded('survey')),
        //'submission' => new SubmissionResource($this->whenLoaded('submission')),
        'project' => new ProjectResource($this->whenLoaded('project')),
      ];
    }
}
