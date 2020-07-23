<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class AccountController extends Controller
{
  public function index(Request $request) {
    //$userId = $request->user()->id;
    $userId = $request->user('api') ? $request->user('api')->id : null;
    $userDetails = User::where('id', $userId)->first(['name', 'email', 'nric', 'contact_number']);

    return response()->json(['data' => $request->user('api') ]);
    //return response()->json(['data' => $request->user()->id]);
  }

  protected function validator(array $data, $userId = null)
  {
    $nricRule = 'string|min:12|max:12|unique:users';

    if ($userId) {
      $nricRule .= ',id,'.$userId;
    }
    
    return Validator::make($data, [
      'name' => 'string|max:255',
      'nric' => $nricRule,
      'contact_number' => 'string|min:10|max:11',
    ]);
  }

  public function updateDetails(Request $request) {
    // $userId = $request->user()->id;
    $userId = $request->user('api') ? $request->user('api')->id : null;
    $validator = $this->validator($request->all(), $userId);

    if ($validator->fails()) {
      $errors = $validator->getMessageBag();

      return response()->json([
        'error' => $errors->keys()[0],
        'message' => $errors->first(),
      ]);
    }

    try {
      $userDetails = User::where('id', $userId)->first();
      
      if (isset($request->name)) {
        $userDetails->name = trim($request->name);
      }
      if (isset($request->nric)) {
        $userDetails->nric = trim($request->nric);
      }
      if (isset($request->contact_number)) {
        $userDetails->contact_number = trim($request->contact_number);
      }
      $userDetails->save();
    } catch (\Exception $e){
      return response()->json([
        'error' => 'update_error',
        'message' => 'Failed to update user account details',
      ]);
    }
    
    return response()->json([
      'message' => 'User account details are updated successfully',
    ]);
  }

  public function updatePassword(Request $request) {
    // $userId = $request->user()->id;
    $userId = $request->user('api') ? $request->user('api')->id : null;
    $validator = Validator::make($request->all(), [
      'password' => 'required|min:6|max:20',
    ]);

    if ($validator->fails()) {
      $errors = $validator->getMessageBag();

      return response()->json([
        'error' => $errors->keys()[0],
        'message' => $errors->first(),
      ]);
    }

    try {
      $userDetails = User::where('id', $userId)->first();
      $userDetails->password = bcrypt($request->password);
      $userDetails->save();
    } catch (\Exception $e){
      return response()->json([
        'error' => 'update_error',
        'message' => 'Failed to update user password',
      ]);
    }
    
    return response()->json([
      'message' => 'User password is updated successfully',
    ]);
  }
}
