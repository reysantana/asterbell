<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Device;
use App\Models\Voucher;
use App\Models\RedeemVoucher;
use App\Models\RegisterVoucher;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Facebook\Facebook;

class RegisterController extends Controller
{
    use RegistersUsers;

    protected $redirectTo = '/';

    public function __construct()
    {
        $this->middleware('guest');
    }

    protected function validator(array $data)
    {
      return Validator::make($data, [
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        // 'nric' => 'string|min:12|max:12|unique:users',
        'password' => 'required|string|min:6|max:20',
        'contact_number' => 'min:10|max:11',
      ]);
    }

    protected function create(Request $data)
    {
      try {
        $accessToken = null;

        // Register with Facebook    
        if (isset($data->fb_token)) {
          $fb = new Facebook([
            'app_id' => config('facebook.app.id'),
            'app_secret' => config('facebook.app.secret'),
            'default_graph_version' => 'v2.5',
          ]);
          $fb->setDefaultAccessToken($data->fb_token);
          $response = $fb->get('/me?locale=en_GB&fields=first_name,last_name,email');
          $fbUser = $response->getDecodedBody();
          $user = User::where('facebook_id', $fbUser['id'])->first();
  
          if (!$user) {
            if (isset($fbUser['email'])) {
              $email = $fbUser['email'];
            } else {
              $email = $data->email;
            }

            // check if user has registered earlier with the email
            $registeredUser = User::where('email', $email)->first();
  
            if ($registeredUser) {
              // update user's facebook id
              $user = $registeredUser;
              $user->facebook_id = $fbUser['id'];
            } else {
              // insert new user record
              $user = new User;
              $user->facebook_id = $fbUser['id'];
              $user->name = $fbUser['first_name'] . ' ' . $fbUser['last_name'];
              $user->email = $email;
              $user->password = bcrypt(uniqid('fb_', true)); // Random password.
            }

            $user->save();

            // $get_register_voucher = RegisterVoucher::where('id', '1')->first();
            
            // if($get_register_voucher){
            //   $signup_voucher = Voucher::where('id', $get_register_voucher->voucher_id)
            //           ->first();
            //   $randstring = str_random(10);

            //   $voucher = new RedeemVoucher;
            //   $voucher->user_id = $user->id;
            //   $voucher->voucher_id = $signup_voucher->id;
            //   $voucher->serial = $randstring;
            //   $voucher->start_date = $signup_voucher->start_date;
            //   $voucher->end_date = $signup_voucher->end_date;
            //   $voucher->active = '1';
            //   $voucher->redeemed = '0';
            //   $voucher->save();
            //   $voucher->name = $signup_voucher->name;
            //   $voucher->image_path = $signup_voucher->image_path;
            //   $voucher->description = $signup_voucher->description;
            //   $voucher->tnc = $signup_voucher->tnc;

            //   $Voucher_available = Voucher::where('id', $get_register_voucher->voucher_id)->first();
            //   $Voucher_available->available = $Voucher_available->available - 1;
            //   $Voucher_available->save();
            // }
          }
          
          $accessToken = $user->createToken('fb_registration_token', ['*'])->accessToken;
        } else {
          $validator = $this->validator($data->all());

          if ($validator->fails()) {
            $errors = $validator->getMessageBag();

            return response()->json([
              'error' => $errors->keys()[0],
              'message' => $errors->first(),
            ]);
          }

          // Create new user record
          $user = User::create([
              'name' => $data->name,
              'email' => $data->email,
              // 'nric' => $data->nric,
              'type' => '5',
              'contact_number' => $data->contact_number,
              'password' => bcrypt($data->password),
              'aeon_location' => $data->aeon_location,
          ]);

          $accessToken = $user->createToken('registration_token', ['*'])->accessToken;
            
            // $get_register_voucher = RegisterVoucher::where('id', '1')->first();
            
            // if($get_register_voucher){
            //   $signup_voucher = Voucher::where('id', $get_register_voucher->voucher_id)
            //           ->first();
            //   $randstring = str_random(10);

            //   $voucher = new RedeemVoucher;
            //   $voucher->user_id = $user->id;
            //   $voucher->voucher_id = $signup_voucher->id;
            //   $voucher->serial = $randstring;
            //   $voucher->start_date = $signup_voucher->start_date;
            //   $voucher->end_date = $signup_voucher->end_date;
            //   $voucher->active = '1';
            //   $voucher->redeemed = '0';
            //   $voucher->save();
            //   $voucher->name = $signup_voucher->name;
            //   $voucher->image_path = $signup_voucher->image_path;
            //   $voucher->description = $signup_voucher->description;
            //   $voucher->tnc = $signup_voucher->tnc;

            //   $Voucher_available = Voucher::where('id', $get_register_voucher->voucher_id)->first();
            //   $Voucher_available->available = $Voucher_available->available - 1;
            //   $Voucher_available->save();
            // }
        }

        // Insert or change device id owner
        if ( !empty($data->device_id) ) {
          $device = Device::where('device_id', $data->device_id)->first();

          if ( empty($device) ) {
            $device = new Device;
            $device->device_id = $data->device_id;
          }

          $device->user_id = $user->id;
          $device->save();
        }

        return response()->json([
          'data' => [
            'access_token' => $accessToken,
            // 'voucher' => $voucher,
          ]]);
      }
      catch(\Facebook\Exceptions\FacebookResponseException $e) {
        // When Graph returns an error
        return response()->json([
          'error' => 'facebook_graph_error',
          'message' => $e->getMessage(),
        ]);
      }
      catch(\Facebook\Exceptions\FacebookSDKException $e) {
        // When validation fails or other local issues
        return response()->json([
          'error' => 'facebook_sdk_error',
          'message' => $e->getMessage(),
        ]);
      }
      catch (\Exception $e){
        $response = [
          'error' => 'server_error',
          'message' => "Oh no! There's an error with your request. Please try again.",
        ];

        // if(strpos($e->errorInfo[2], 'users_email_unique')) {
        //   $response = [
        //     'error' => 'email',
        //     'message' => 'The email has already been taken',
        //   ];
        // } elseif(strpos($e->errorInfo[2], 'users_nric_unique')) {
        //   $response = [
        //     'error' => 'nric',
        //     'message' => 'The NRIC has already been taken',
        //   ];
        // }

        return response()->json($response);
      }
    }
}
