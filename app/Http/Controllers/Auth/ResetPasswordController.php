<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/password/reset/successful';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }
    
    protected function resetPassword($user, $password)
    {
      $user->password = Hash::make($password);
      $user->setRememberToken(Str::random(60));
      $user->save();
      return redirect('/password/reset/successful')->with('success', 'Your password has been reset');      
    }

    public function resetSuccessful(Request $request) {
      if ($request->session()->get('success')) {
        return view('auth.passwords.reset-successful');
      } else {
        return redirect('/password/reset');
      }
    }
}
