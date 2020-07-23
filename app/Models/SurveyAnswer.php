<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SurveyAnswer extends Model
{
  public function submission() {
    return $this->belongsTo('App\Models\Submission');
  }

  public function user() {
    return $this->belongsTo('App\Models\User');
  }

  public function project() {
    return $this->submission->marker->project;
  }

  public function survey() {
    return $this->submission->marker->survey;
  }
}
