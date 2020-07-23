<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Submission extends Model
{
  public function marker() {
    return $this->belongsTo('App\Models\Marker');
  }

  public function reward() {
    return $this->marker->reward()->first();
  }

  public function surveyAnswers() {
    return $this->hasMany('App\Models\SurveyAnswer');
  }
}
