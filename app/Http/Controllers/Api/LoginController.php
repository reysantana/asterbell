<?php

namespace App\Http\Controllers\Api;


use App\Models\User;
use App\Models\Device;
use App\Models\Voucher;
use App\Http\Controllers\Controller;
use Exception;
use Response;
use Facebook\Facebook;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use League\OAuth2\Server\Exception\OAuthServerException;
use Psr\Http\Message\ServerRequestInterface;
use \Laravel\Passport\Http\Controllers\AccessTokenController as ATC;

class LoginController extends ATC
{
  public function index(ServerRequestInterface $request) {
    try {
      $requestBody = $request->getParsedBody();
      $accessToken = null;

      // Login with Facebook
      if (isset($requestBody['fb_token'])) {
        $fbToken = $requestBody['fb_token'];
        $fb = new Facebook([
          'app_id' => config('facebook.app.id'),
          'app_secret' => config('facebook.app.secret'),
          'default_graph_version' => 'v2.5',
        ]);
        $fb->setDefaultAccessToken($fbToken);
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
        }

        $accessToken = $user->createToken('fb_login_token', ['*'])->accessToken;
      } else {
        $email = $requestBody['username'];
        $user = User::where('email', '=', $email)->first();
        $tokenResponse = parent::issueToken($request);
        $content = $tokenResponse->getContent();
        $data = json_decode($content, true);

        if(isset($data['error'])) {
          return response()->json([
            'error' => 'invalid_credentials',
            'message' => 'The user credentials were incorrect',
          ]);
        }

        $accessToken = $data['access_token'];
      }

      // Insert or update device id owner
      if ( isset($requestBody['device_id']) && !empty($requestBody['device_id']) ) {
        $device_id = $requestBody['device_id'];
        $device = Device::where('device_id', $device_id)->first();

        if ( empty($device) ) {
          $device = new Device;
          $device->device_id = $device_id;
        }

        $device->user_id = $user->id;
        $device->save();
      }

      return response()->json([
        'data' => [
          'access_token' => $accessToken,
        ]]);
    }
    catch (ModelNotFoundException $e) { // email not found
        //return error message
        return response()->json([
          'error' => 'invalid_user',
          'message' => 'User not found',
        ]);
    }
    catch (OAuthServerException $e) { //password not correct..token not granted
        //return error message
        return response()->json([
          'error' => 'invalid_credentials',
          'message' => 'The user credentials were incorrect',
        ]);
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
    catch (Exception $e) {
        //return error message
        return response()->json([
          'error' => 'server_error',
          'message' => 'Internal server error',
        ]);
    }
  }
}
