<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\AdsBanner;

class AdsbannerController extends Controller
{
  
  public function listallads(Request $request) {
  
    $adsbanner = AdsBanner::where('active', 1)
                      ->get();

      return response()->json([
        'adsbanner' => $adsbanner,
      ]);
  }


}
