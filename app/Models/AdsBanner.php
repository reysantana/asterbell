<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdsBanner extends Model
{
 
  protected $table = 'adsbanners';

  public function scopeActive($query){
      return $query->where('active', 1);
    }
}
