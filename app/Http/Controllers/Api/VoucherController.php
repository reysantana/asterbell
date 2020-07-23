<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Voucher;
use App\Models\RedeemVoucher;

class VoucherController extends Controller
{
  
  public function listallvoucher(Request $request) {

    //$userId = $request->user('api') ? $request->user('api')->id : null;    
    $vouchers = Voucher::where('active', 1)
                      ->get();

      return response()->json([
        'vouchers' => $vouchers,
      ]);
  }

  public function listuservoucher(Request $request) {

    $userId = $request->user('api') ? $request->user('api')->id : null;  

    $vouchers = RedeemVoucher::where('user_id', $userId)
                ->join('vouchers', 'redeem_vouchers.voucher_id', '=', 'vouchers.id')
                ->select('vouchers.name', 'vouchers.description','vouchers.tnc', 'vouchers.image_path', 'vouchers.thumbnail_path', 'vouchers.available', 'vouchers.limit','redeem_vouchers.serial','redeem_vouchers.start_date','redeem_vouchers.end_date','redeem_vouchers.active','redeem_vouchers.redeemed','redeem_vouchers.redeemed_date')
                ->get();

      return response()->json([
        'vouchers' => $vouchers,
      ]);
  }

  // public function redeemvoucher(Request $request) {

  //   $signup_voucher = RedeemVoucher::where('id', 1)
  //                     ->first();

  //   $randstring = str_random(10);

  //   $voucher = new RedeemVoucher;
  //   $voucher->user_id = '4';
  //   $voucher->voucher_id = '1';
  //   $voucher->serial = $randstring;
  //   $voucher->start_date = $signup_voucher->start_date;
  //   $voucher->end_date = $signup_voucher->end_date;
  //   $voucher->active = '1';
  //   $voucher->redeemed = '0';
  //   $voucher->save();

  //   return response()->json([
  //       'message' => 'Voucher create successfully',
  //       'voucher' => $voucher
  //   ]);

  // }

}
