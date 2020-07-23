<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Argame;
use App\Models\Voucher;
use App\Models\RedeemVoucher;
use App\Models\RegisterVoucher;
use App\Models\User;
use App\Models\AdsBanner;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class AdsbannerController extends Controller
{
  public function index(Request $request) {
    if($request->ajax()){
      return DataTables::of(AdsBanner::query())->addIndexColumn()->make(true);      
    }
    return view('admin.adsbanners.list');
  }
  
  public function create() {
    return view('admin.adsbanners.create');
  }

  public function edit($id) {
    $adsbanner = AdsBanner::where('id', $id)->first();

    if (!count($adsbanner)) {
      return redirect('/adsbanners')->with('error', 'The adsbanner you requested was not found.');
    }

    return view('admin.adsbanners.edit', compact('adsbanner'));
  }

  public function store(Request $request) {   
      
    $adsbanner = new AdsBanner;
    $adsbanner->name = $request->name;
    $adsbanner->url = $request->url;
    $adsbanner->metadata = $request->metadata;
    $adsbanner->active = $request->status;
    $adsbanner->save();

    if ($request->hasFile('image') && $request->file('image')->isValid()) {
      $adsbanner->image_path = 'storage/'.str_replace('public/', '', $request->file('image')->store('public/images'));
      $adsbanner->save();
    }

    return redirect('/adsbanners')
      ->with('success-general', 'ads banner is created successfully.')
      ->with('tab', 'general');
  }
  
  public function show($id) {
    $adsbanner = AdsBanner::where('id', $id)->first();
    if (!count($adsbanner)) {
      return redirect('/adsbanners')->with('error', 'The ads banner you requested was not found.');
    }

    return view('admin.adsbanners.list', compact('adsbanner'));
  }

  public function update(Request $request, $id) {
    $adsbanner = AdsBanner::where('id', $id)->first();
    if (!count($adsbanner)) {
      return redirect('/adsbanners')->with('error', 'The ads banner you requested was not found.');
    }
  
    $adsbanner->name = $request->name;
    $adsbanner->url = $request->url;
    $adsbanner->metadata = $request->metadata;
    $adsbanner->active = $request->status;
    $adsbanner->save();

    if ($request->hasFile('image') && $request->file('image')->isValid()) {
      $adsbanner->image_path = 'storage/'.str_replace('public/', '', $request->file('image')->store('public/images'));
      $adsbanner->save();
    }

    return redirect('/adsbanners')
      ->with('success-general', 'ads banner is updated successfully.')
      ->with('tab', 'general');
  }

  // private function _validateRequest($request, $argameId = null) {
  //   $slugRule = 'required|string|max:20|unique:argames';

  //   if ($argameId) {
  //     $slugRule .= ',slug,'.$argameId;
  //   }

  //   $request->validate([
  //     'name' => 'required|string|max:255',
  //     'slug' => $slugRule,
  //   ]);
  // }
}
