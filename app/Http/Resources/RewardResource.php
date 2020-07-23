<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class RewardResource extends Resource
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
        'serial_code' => $this->serial_code,
        'image_path' => $this->image_path,
      ];
    }
}
