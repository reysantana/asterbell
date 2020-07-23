<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class SubmissionResource extends Resource
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
        'completed' => $this->completed,
        'submission_date' => (string)$this->created_at,
        'completion_date' => $this->completed ? (string)$this->updated_at : null,
      ];
    }
}
