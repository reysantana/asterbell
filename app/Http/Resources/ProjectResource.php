<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class ProjectResource extends Resource
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
        'start_date' => (string)$this->start_date,
        'end_date' => (string)$this->end_date,
        'markers' => MarkerResource::collection($this->whenLoaded('markers')),
        'projectmarkers' => ProjectmarkerResource::collection($this->whenLoaded('projectmarkers')),
        'projectrewards' => ProjectrewardResource::collection($this->whenLoaded('projectrewards')),
      ];
    }
}
