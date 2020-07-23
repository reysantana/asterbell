<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectmarkerScan extends Model
{
  public function projectmarker() {
    return $this->belongsTo('App\Models\Projectmarker');
  }

  // public function reward() {
  //   return $this->marker->reward()->first();
  // }

  // public function surveyAnswers() {
  //   return $this->hasMany('App\Models\SurveyAnswer');
  // }
}
