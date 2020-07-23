<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class LuckydrawResource extends Resource
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
        'description' => $this->description,
        'image_path' => $this->image_path,
        'start_date' => (string)$this->start_date,
        'end_date' => (string)$this->end_date,
        'tnc' => $this->tnc,
      ];
    }
}
