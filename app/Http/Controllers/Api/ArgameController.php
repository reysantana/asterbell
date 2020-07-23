<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Luckydraw;
use App\Models\Argame;
use App\Models\ArgameScore;
use App\Models\ArgameVoucher;
use App\Models\Voucher;
use App\Models\RedeemVoucher;
use App\Http\Resources\luckydrawResource;
use App\Http\Resources\ArgameResource;
use Illuminate\Support\Facades\DB;

class ArgameController extends Controller
{
    public function single(Request $request)
    {

      $argame = Argame::where('active', 1)
                  ->get();

      // if ($argame) {
      //   $argame = new ArgameResource($argame);
      // }

      return response()->json([ 'argame' => $argame ]);
    }

    public function getleaderboard(Request $request)
    {

      // $userId = $request->user('api') ? $request->user('api')->id : null;
      $userId = $request->user_id;
      $leaderboard = ArgameScore::where('argame_id', $request->argame_id)
                  ->join('argames', 'argame_scores.argame_id', '=', 'argames.id')
                  ->join('users', 'argame_scores.user_id', '=', 'users.id')
                  ->select('argame_scores.*', 'argames.name AS argame_name','users.name AS user_name')
                  ->orderBy('argame_scores.score', 'dsc')
                  ->orderBy('argame_scores.updated_at', 'asc')
                  ->limit(100)
                  ->get();

      $rankid = (int)1;
      $user_rank = array();
      foreach ($leaderboard as $rank){
        $rank["rank"] = $rankid;
        if($userId != null && $userId == $rank->user_id){
          $user_rank = $rank;
        }
        $rankid = $rankid+1;
      }

      return response()->json([ 'leaderboard' => $leaderboard, 'user_rank' => $user_rank]);
    }

    public function setgamescore(Request $request)
    {
      try {
      // $argame = Argame::active()->find($request->argame_id);
        $argame = Argame::find($request->argame_id);
      
      if ($argame->active == 0) {
        return response()->json([
          'error' => 'An Error Occurred',
          'message' => 'Please try again later.',
        ]);
      }elseif($argame->start_date > date('Y-m-d H:i:s')){
        return response()->json([
          'error' => 'Unable to Submit',
          'message' => 'Game not yet start.',
        ]);
      }elseif($argame->end_date < date('Y-m-d H:i:s')){
        return response()->json([
          'error' => 'Unable to Submit',
          'message' => 'Game expired.',
        ]);
      }

      $userId = $request->user()->id;
      
      if (!count($userId)) {
        return response()->json([
          'error' => 'update_error',
          'message' => 'User error',
        ]);
      }
      // $voucher = [];

      
      // $findvoucher = RedeemVoucher::where('user_id', $userId)
      //             ->join('vouchers', 'redeem_vouchers.voucher_id', '=', 'vouchers.id')
      //             ->join('argame_vouchers', 'vouchers.id', '=', 'argame_vouchers.voucher_id')
      //             ->where('argame_vouchers.argame_id', '=', $request->argame_id)
      //             ->count();

      // if ($findvoucher < 1 && $request->score >= $argame->score){
        
      //     $voucher_random = ArgameVoucher::where('argame_id', $request->argame_id)
      //                     ->join('vouchers', 'argame_vouchers.voucher_id', '=', 'vouchers.id')
      //                     ->where('vouchers.available', '>', 0)
      //                     ->inRandomOrder()
      //                     ->first();

      //     $randstring = str_random(10);
      //     $voucher = new RedeemVoucher;
      //     $voucher->user_id = $userId;
      //     $voucher->voucher_id = $voucher_random->id;
      //     $voucher->serial = $randstring;
      //     $voucher->start_date = $voucher_random->start_date;
      //     $voucher->end_date = $voucher_random->end_date;
      //     $voucher->active = '1';
      //     $voucher->redeemed = '0';
      //     $voucher->save();
      //     $voucher->name = $voucher_random->name;
      //     $voucher->image_path = $voucher_random->image_path;
      //     $voucher->description = $voucher_random->description;
      //     $voucher->tnc = $voucher_random->tnc;

      //     $Voucher_available = Voucher::where('id', $voucher_random->id)->first();
      //     $Voucher_available->available = $Voucher_available->available - 1;
      //     $Voucher_available->save();
      // }
        
        if($argame->score_submit_start < $argame->score_submit_end){
            $thissessionstart = date('Y-m-d H:i:s', strtotime("$argame->score_submit_start"));
            $thissessionend = date('Y-m-d H:i:s', strtotime("$argame->score_submit_end"));

            $nextsessionstart = date('Y-m-d H:i:s', strtotime("tomorrow $argame->score_submit_start"));
            $nextsessionend = date('Y-m-d H:i:s', strtotime("tomorrow $argame->score_submit_end"));
        }else{
            if($argame->score_submit_end > date('H:i:s')){
                $thissessionstart = date('Y-m-d H:i:s', strtotime("yesterday $argame->score_submit_start"));
                $thissessionend = date('Y-m-d H:i:s', strtotime("$argame->score_submit_end"));

                $nextsessionstart = date('Y-m-d H:i:s', strtotime("$argame->score_submit_start"));
                $nextsessionend = date('Y-m-d H:i:s', strtotime("tomorrow $argame->score_submit_end"));
            }else{
                $thissessionstart = date('Y-m-d H:i:s', strtotime("$argame->score_submit_start"));
                $thissessionend = date('Y-m-d H:i:s', strtotime("tomorrow $argame->score_submit_end"));

                $nextsessionstart = date('Y-m-d H:i:s', strtotime("tomorrow $argame->score_submit_start"));
                $nextsessionend = date('Y-m-d H:i:s', strtotime("tomorrow $argame->score_submit_end"));
                $nextsessionend = date('Y-m-d H:i:s', strtotime("tomorrow $nextsessionend"));
            }
        }

        if($thissessionstart < date('Y-m-d H:i:s') && $thissessionend > date('Y-m-d H:i:s')){
          $findgamescore = ArgameScore::where('user_id', $userId)
                    ->where('argame_id', $argame->id)
                    ->count();
        
          if ($findgamescore > 0) {
            $setgamescore = ArgameScore::where('user_id', $userId)
                            ->where('argame_id', $argame->id)
                            ->first();

            if ($setgamescore->score < $request->score) {
              $setgamescore->score = $request->score;
              $setgamescore->save();
            }

          } else {
            $setgamescore = new ArgameScore;
            $setgamescore->argame_id = $argame->id;
            $setgamescore->user_id = $userId;
            $setgamescore->score = $request->score;
            $setgamescore->save();
          }          
        }else{

            $nextstarttime = $argame->score_submit_start;

            if($thissessionstart > date('Y-m-d H:i:s')){
                $nextstarttime = date('H:i:s', strtotime("$thissessionstart"));
                $nextstartdate = date('Y-m-d', strtotime("$thissessionstart"));
            }else{
                $nextstarttime = date('H:i:s', strtotime("$nextsessionstart"));
                $nextstartdate = date('Y-m-d', strtotime("$nextsessionstart"));
            }

            return response()->json([
                'error' => 'Unable to Submit',
                'message' => 'Game closed. Next session starts at '.$nextstarttime.', '.$nextstartdate,
            ]);
        }
    
    } catch (Exception $e){
        return response()->json([
          'error' => 'An Error Occurred ',
          // 'Exception' => $e,
          'message' => 'Please try again later.',
        ]);
    }
      
      return response()->json([
        'success' => 'Submitted Successfully',
        'message' => 'You have submitted your score succeessfully.',
        // 'voucher' => $voucher,
      ]);

    }

    // public function checkluckydraw(Request $request)
    // {

    //   $luckydraw = Luckydraw::active()->find($request->luckydraw_id);
    //   $userId = $request->user()->id;

    //   $checkluckydraw = Joinluckydraw::where('luckydraw_id', $luckydraw->id)
    //                   ->where('user_id', $userId)
    //                   ->first();
                      
    //   if($checkluckydraw){
    //     return response()->json([
    //       'message' => 'User joined luckydraw',
    //       'data' => $checkluckydraw,
    //     ]);
    //   }else{
    //     return response()->json([
    //       'message' => 'User did not join luckydraw',
    //       'data' => $checkluckydraw,
    //     ]);
    //   }
    // }
    //  public function truncate(Request $request)
    // { 
    //   DB::statement('SET FOREIGN_KEY_CHECKS=0');

    //   DB::table('argames')->truncate();

    //   DB::statement('SET FOREIGN_KEY_CHECKS=1;');
      
    //   // $setgamescore = Argame::truncate();
    //   return response()->json([
    //     'success' => 'Submitted Successfully',
    //     'message' => 'You have Successfully truncate.',
    //     // 'voucher' => $voucher,
    //   ]);
    // }
}
