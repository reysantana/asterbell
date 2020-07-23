<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class SurveyResource extends Resource
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
        'question' => $this->question,
        'image_path' => $this->image_path,
      ];
    }
}
