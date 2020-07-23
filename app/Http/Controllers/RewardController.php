<?php

namespace App\Http\Controllers;

use App\Models\Reward;
use Illuminate\Http\Request;

class RewardController extends Controller
{
  public function updateSingle(Request $request, $slug, $markerId) {    
    $this->_validateRequest($request);
    $reward = Reward::where('marker_id', $markerId)->first();

    if (!count($reward)) {
      $reward = new Reward;
      $reward->marker_id = $markerId;
    }
  
    $reward->name = $request->name;
    $reward->serial_code = $request->serialCode;
    $reward->notification_template_id = $request->notificationTemplateId;
    $reward->active = $request->status;
    $reward->save();

    // upload image
    if ($request->hasFile('image') && $request->file('image')->isValid()) {
      $reward->image_path = 'storage/'.str_replace('public/', '', $request->file('image')->store('public/images'));
      $reward->save();
    }

    return redirect('/projects/'.$slug.'/markers/'.$markerId)
      ->with('success-reward', 'Reward is updated successfully.')
      ->with('tab', 'reward');
  }

  private function _validateRequest($request) {
    $request->validate([
      'name' => 'required|string|max:255',
      'serialCode' => 'required|string|max:10',
      'notificationTemplateId' => 'required',
    ]);
  }
}
