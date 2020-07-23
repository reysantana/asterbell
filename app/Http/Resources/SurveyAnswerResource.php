<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class SurveyAnswerResource extends Resource
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
        'answer' => $this->answer,
        'answered_date' => (string)$this->created_at,
      ];
    }
}
