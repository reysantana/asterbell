<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
  public function markers() {
    return $this->hasMany('App\Models\Marker');
  }

  public function projectmarkers() {
    return $this->hasMany('App\Models\Projectmarker');
  }

  public function projectrewards() {
    return $this->hasMany('App\Models\Projectreward');
  }

  public function scopeActive($query){
    // return $query->where('active', 1)
    //         ->whereDate('start_date', '<=', date('Y-m-d'))
    //         ->whereDate('end_date', '>=', date('Y-m-d'));

    return $query->where('active', 1)
            ->where(function($q) {
              $q->whereDate('start_date', '<=', date('Y-m-d'))
                ->orWhereNull('start_date');
            })
            ->where(function($q) {
              $q->whereDate('end_date', '>=', date('Y-m-d'))
                ->orWhereNull('end_date');
            });
  }
}
