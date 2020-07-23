<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\User;
use App\Models\Argame;
use App\Models\ArgameVoucher;
use App\Models\ArgameScore;
use App\Models\Voucher;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ArgameController extends Controller
{
  public function index(Request $request) {
    if($request->ajax()){
      return DataTables::of(Argame::query())->addIndexColumn()->make(true);      
    }
    return view('admin.argames.list');
  }
  
  public function create() {
    return view('admin.argames.create');
  }

  public function edit($slug) {
    $argame = Argame::where('slug', $slug)->first();

    if (!count($argame)) {
      return redirect('/argames')->with('error', 'The ar game you requested was not found.');
    }

    $argamevouchers = Voucher::where('active', 1)
                      ->get();

    $argame_vouchers = ArgameVoucher::where('argame_id', $argame->id)
                      ->get();

    return view('admin.argames.edit', compact('argame','argamevouchers','argame_vouchers'));
  }

  public function highscore($slug) {
    $argame = Argame::where('slug', $slug)->first();

    if (!count($argame)) {
      return redirect('/argames')->with('error', 'The ar game you requested was not found.');
    }

    $leaderboard = ArgameScore::where('argame_id', $argame->id)
                  ->join('argames', 'argame_scores.argame_id', '=', 'argames.id')
                  ->join('users', 'argame_scores.user_id', '=', 'users.id')
                  ->select('argame_scores.*', 'argames.name AS argame_name','users.name AS user_name')
                  ->orderBy('argame_scores.score', 'desc')
                  ->orderBy('argame_scores.updated_at', 'asc')
                  ->get();

    return view('admin.argames.highscore', compact('argame','leaderboard'));
  }

  public function leaderboard($slug) {
    $argame = Argame::where('slug', $slug)->first();

    if (!count($argame)) {
      return redirect('/argames')->with('error', 'The ar game you requested was not found.');
    }

    $leaderboard = ArgameScore::where('argame_id', $argame->id)
                  ->join('argames', 'argame_scores.argame_id', '=', 'argames.id')
                  ->join('users', 'argame_scores.user_id', '=', 'users.id')
                  ->select('argame_scores.*', 'argames.name AS argame_name','users.name AS user_name','users.email AS user_email','users.contact_number AS user_contact')
                  ->orderBy('argame_scores.score', 'desc')
                  ->orderBy('argame_scores.updated_at', 'asc')
                  ->get();

    return view('admin.argames.leaderboard', compact('argame','leaderboard'));
  }

  public function store(Request $request) {
    $this->_validateRequest($request);    
      
    $argame = new Argame;
    $argame->name = $request->name;
    $argame->slug = $request->slug;
    $argame->start_date = $request->startDate;
    $argame->end_date = $request->endDate;
    $argame->score_submit_start = $request->startScore;
    $argame->score_submit_end = $request->endScore;
    $argame->description = $request->description;
    // $argame->score = $request->score;
    $argame->tnc = $request->tnc;
    $argame->active = $request->status;
    $argame->save();

    if ($request->hasFile('image') && $request->file('image')->isValid()) {
      $argame->image_path = 'http://localhost/storage/'.str_replace('public/', '', $request->file('image')->store('public/images'));
      $argame->save();
    }

    if ($request->hasFile('button_image') && $request->file('button_image')->isValid()) {
      $argame->button_path = 'http://localhost/storage/'.str_replace('public/', '', $request->file('button_image')->store('public/images'));
      $argame->save();
    }

    return redirect('/argames/'.$argame->slug)
      ->with('success-general', 'Argame is created successfully.')
      ->with('tab', 'general');
  }
  
  public function show($slug) {
    $argame = Argame::where('slug', $slug)->first();
    if (!count($argame)) {
      return redirect('/argames')->with('error', 'The ar game you requested was not found.');
    }

    return view('admin.argames.list', compact('argame'));
  }

  public function update(Request $request, $slug) {
    $argame = Argame::where('slug', $slug)->first();
    
    if (!count($argame)) {
      return redirect('/argames')->with('error', 'The argame you requested was not found.');
    }

    $argame->name = $request->name;
    $argame->slug = $request->slug;
    $argame->start_date = $request->startDate;
    $argame->end_date = $request->endDate;
    $argame->score_submit_start = $request->startScore;
    $argame->score_submit_end = $request->endScore;
    $argame->description = $request->description;
    $argame->tnc = $request->tnc;
    $argame->active = $request->status;
    $argame->save();

    if ($request->hasFile('image') && $request->file('image')->isValid()) {
      $argame->image_path = 'http://localhost/storage/'.str_replace('public/', '', $request->file('image')->store('public/images'));
      $argame->save();
    }

    if ($request->hasFile('button_image') && $request->file('button_image')->isValid()) {
      $argame->button_path = 'http://localhost/storage/'.str_replace('public/', '', $request->file('button_image')->store('public/images'));
      $argame->save();
    }

    // $argame_vouchers = ArgameVoucher::where('argame_id', $argame->id)
    //                   ->get();
    // $array1 = array();
    // for ($x = 0; $x < count($argame_vouchers); $x++) {
    //   array_push($array1,$argame_vouchers[$x]->voucher_id);
    // }

    // $array2 = array();
    // for ($y = 0; $y < count($request->argamevoucherId); $y++) {
    //   array_push($array2,(int)$request->argamevoucherId[$y]);
    // }

    // $result = array();
    // $result = array_diff($array2, $array1);
    // $result = array_merge($result,[]);

    // for ($z = 0; $z < count($result); $z++) {
    //   $newargamevoucher = new ArgameVoucher;
    //   $newargamevoucher->argame_id = $argame->id;
    //   $newargamevoucher->voucher_id = $result[$z];
    //   $newargamevoucher->save();
    // }  

    // $result2 = array();
    // $result2 = array_diff($array1, $array2);
    // $result2 = array_merge($result2,[]);

    // for ($a = 0; $a < count($result2); $a++) {
    //   $delargamevoucher = ArgameVoucher::where('argame_id', $argame->id)
    //                   ->where('voucher_id', $result2[$a])
    //                   ->delete();
    // }  

    return redirect('/argames/'.$argame->slug)
      ->with('success', 'Argame is updated successfully.');
  }

  private function _validateRequest($request, $argameId = null) {
    $slugRule = 'required|string|max:20|unique:argames';

    if ($argameId) {
      $slugRule .= ',slug,'.$argameId;
    }

    $request->validate([
      'name' => 'required|string|max:255',
      'slug' => $slugRule,
    ]);
  }
}
