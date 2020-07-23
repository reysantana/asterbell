<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Projectreward extends Model
{
  protected $table = 'project_rewards';
  
  public function scopeActive($query){
    return $query->where('active', 1);
  }

  public function project() {
    return $this->belongsTo('App\Models\Project');
  }
    
}
