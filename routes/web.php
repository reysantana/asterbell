<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::redirect('/', '/login');

Route::get('/login', 'Auth\LoginController@showLoginForm');
Route::post('/login', 'Auth\LoginController@login');
Route::post('/logout', 'Auth\LoginController@logout');

Route::get('/logout', function() {
  return redirect('/login');
});

Route::group(['middleware' => ['auth', 'admin']], function () {
  Route::resource('/users', 'UserController');
  Route::resource('/projects', 'ProjectController');
  Route::resource('/luckydraws', 'LuckydrawController');
  Route::resource('/argames', 'ArgameController');
  Route::get('/argames/edit/{slug}', 'ArgameController@edit');
  Route::get('/argames/highscore/{slug}', 'ArgameController@highscore');
  Route::get('/leaderboard/{slug}', 'ArgameController@leaderboard');
  Route::resource('/argames/{slug}/highscore', 'ArgameHighscoreController');
  Route::post('/argames/update/{slug}', 'ArgameController@update');
  Route::resource('/vouchers', 'VoucherController');
  Route::get('/registervoucher/edit', 'VoucherController@registervoucher');
  Route::post('/registervoucher/update', 'VoucherController@registervoucherupdate');
  Route::get('/vouchers/edit/{id}', 'VoucherController@edit');
  Route::post('/vouchers/update/{slug}', 'VoucherController@update');
  Route::resource('/adsbanners', 'AdsbannerController');
  Route::get('/adsbanners/edit/{id}', 'AdsbannerController@edit');
  Route::post('/adsbanners/update/{id}', 'AdsbannerController@update');
  Route::resource('/projects/{slug}/markers', 'MarkerController');
  Route::resource('/projects/{slug}/projectmarkers', 'ProjectmarkerController');
  Route::resource('/projects/{slug}/projectrewards', 'ProjectrewardController');
  Route::post('/projects/{slug}/markers/{id}/survey', 'SurveyController@updateSingle');
  Route::post('/projects/{slug}/markers/{id}/reward', 'RewardController@updateSingle');

  Route::resource('/survey-feedbacks', 'SurveyController');  
  Route::resource('/projects/{slug}/markers', 'MarkerController');  

  Route::resource('/settings/notification-templates', 'NotificationTemplateController');
});

Route::get('/password/reset/successful', 'Auth\ResetPasswordController@resetSuccessful');
Auth::routes();