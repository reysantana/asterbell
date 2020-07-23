<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


// Login/Get access token is currently utilizing Passport default implementation
// Route::post('/oauth/token', ...);
Route::get('/ping', function (Request $request) { echo 'Pong!'; });
Route::post('/login', 'Api\LoginController@index');
Route::post('/register', 'Api\RegisterController@create');

Route::get('/projects/{slug}', 'Api\ProjectController@single');
Route::get('/luckydraws/active', 'Api\LuckydrawController@single');
Route::get('/argames/active', 'Api\ArgameController@single');
Route::get('/vouchers/active', 'Api\VoucherController@listallvoucher');
Route::get('/adsbanner/active', 'Api\AdsbannerController@listallads');
Route::get('/vouchers/create', 'Api\VoucherController@createvoucher');
Route::get('/appversion', 'Api\AppversionController@minappversion');
Route::get('/argames/getleaderboard', 'Api\ArgameController@getleaderboard');

// Route::post('/truncate', 'Api\ArgameController@truncate');

 Route::group(['middleware' => ['auth:api']], function () {
  Route::get('/test', function (Request $request) {
    return 'User is authenticated';
  });
  Route::post('/luckydraws/join', 'Api\LuckydrawController@joinluckydraw');
  Route::get('/luckydraws/check', 'Api\LuckydrawController@checkluckydraw');
  Route::post('/argames/sethighscore', 'Api\ArgameController@setgamescore');
  Route::post('/submissions', 'Api\SubmissionController@store');
  Route::post('/surveys', 'Api\SurveyController@store');
  Route::get('/notifications', 'Api\NotificationController@list');
  Route::delete('/notifications', 'Api\NotificationController@delete');
  Route::get('/account', 'Api\AccountController@index');
  Route::post('/account', 'Api\AccountController@updateDetails');
  Route::post('/account/password', 'Api\AccountController@updatePassword');
  Route::get('/markers/{name}', 'Api\MarkerController@index');
  Route::get('/projectmarkers/{name}', 'Api\ProjectmarkerController@index');
  Route::get('/vouchers/user', 'Api\VoucherController@listuservoucher');
 });
