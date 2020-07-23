<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Marker extends Model
{
  public function project() {
    return $this->belongsTo('App\Models\Project');
  }

  public function reward() {
    return $this->hasOne('App\Models\Reward');
  }

  public function survey() {
    return $this->hasOne('App\Models\Survey');
  }

  public function submission() {
    return $this->hasOne('App\Models\Submission');
  }

  public function scopeActive($query){
    return $query->where('active', 1);
  }

  public function scopeActiveProject($query){
    return $query->whereHas('project', function($q) {
      $q->active();
    });
  }
}
