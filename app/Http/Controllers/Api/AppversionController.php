<?php

namespace App\Http\Controllers\Api;

use App\Models\Appversion;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class AppversionController extends Controller
{
  public function minappversion(Request $request) {
     
     $minappversion = Appversion::first();

      return response()->json([ 'data' => $minappversion ]);
  }

}
