<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
  public function submission() {
    return $this->belongsTo('App\Models\Submission');
  }

  public function template() {
    return $this->hasOne('App\Models\NotificationTemplate');
  }
}
