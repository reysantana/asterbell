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

class ArgameHighscoreController extends Controller
{
  public function index(Request $request, $slug) {
    $argame = Argame::where('slug', $slug)->first();
    if (!count($argame)) {
      return redirect('/argames')->with('error', 'The ar game you requested was not found.');
    }

    if($request->ajax()){
      return DataTables::of(ArgameScore::where('argame_id', $argame->id)
                  ->join('argames', 'argame_scores.argame_id', '=', 'argames.id')
                  ->join('users', 'argame_scores.user_id', '=', 'users.id')
                  ->select('argame_scores.*', 'argames.name AS argame_name','users.name AS user_name','users.email AS user_email','users.contact_number AS user_contact')
                  ->orderBy('argame_scores.score', 'desc')
                  ->orderBy('argame_scores.updated_at', 'asc')
                  ->get())->addIndexColumn()->make(true);      
    }

    return view('admin.argames.highscore', compact('argame','leaderboard'));
  }
  
  public function create() {

  }

  public function edit($slug) {
 
  }

}
