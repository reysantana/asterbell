<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Argame;
use App\Models\Voucher;
use App\Models\RedeemVoucher;
use App\Models\RegisterVoucher;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class VoucherController extends Controller
{
  public function index(Request $request) {
    if($request->ajax()){
      return DataTables::of(Voucher::query())->addIndexColumn()->make(true);      
    }
    return view('admin.vouchers.list');
  }
  
  public function create() {
    return view('admin.vouchers.create');
  }

  public function edit($id) {
    $voucher = Voucher::where('id', $id)->first();

    if (!count($voucher)) {
      return redirect('/vouchers')->with('error', 'The voucher you requested was not found.');
    }

    return view('admin.vouchers.edit', compact('voucher'));
  }

  public function registervoucher() {
    $voucher = RegisterVoucher::where('id', 1)->first();
    $allvouchers = Voucher::where('active', 1)
                      ->get();

    if (!count($voucher)) {
      return redirect('/vouchers')->with('error', 'The voucher you requested was not found.');
    }

    return view('admin.vouchers.registervoucher', compact('voucher','allvouchers'));
  }

  public function registervoucherupdate(Request $request) {
    
    $voucher = RegisterVoucher::where('id', 1)->first();
    if (!count($voucher)) {
      return redirect('/vouchers')->with('error', 'The voucher you requested was not found.');
    }
  
    $voucher->voucher_id = $request->register;
    $voucher->save();

    return redirect('/vouchers')
      ->with('success-general', 'Voucher is updated successfully.')
      ->with('tab', 'general');
  }

  public function store(Request $request) {   
      
    $voucher = new Voucher;
    $voucher->name = $request->name;
    $voucher->description = $request->description;
    $voucher->tnc = $request->tnc;
    $voucher->start_date = $request->startDate;
    $voucher->end_date = $request->endDate;
    $voucher->limit = $request->limit;
    $voucher->available = $request->limit;
    $voucher->active = $request->status;
    $voucher->save();

    if ($request->hasFile('image') && $request->file('image')->isValid()) {
      $voucher->image_path = 'storage/'.str_replace('public/', '', $request->file('image')->store('public/images'));
      $voucher->save();
    }

    if ($request->hasFile('thumbnail') && $request->file('thumbnail')->isValid()) {
      $voucher->thumbnail_path = 'storage/'.str_replace('public/', '', $request->file('thumbnail')->store('public/images'));
      $voucher->save();
    }

    return redirect('/vouchers')
      ->with('success-general', 'Voucher is created successfully.')
      ->with('tab', 'general');
  }
  
  public function show($id) {
    $voucher = Voucher::where('id', $id)->first();
    if (!count($voucher)) {
      return redirect('/vouchers')->with('error', 'The voucher you requested was not found.');
    }

    return view('admin.vouchers.list', compact('voucher'));
  }

  public function update(Request $request, $id) {
    $voucher = Voucher::where('id', $id)->first();
    if (!count($voucher)) {
      return redirect('/vouchers')->with('error', 'The voucher you requested was not found.');
    }
  
    $voucher->name = $request->name;
    $voucher->description = $request->description;
    $voucher->tnc = $request->tnc;
    $voucher->start_date = $request->startDate;
    $voucher->end_date = $request->endDate;
    $voucher->limit = $request->limit;
    $voucher->available = $request->available;
    $voucher->active = $request->status;
    $voucher->save();

    if ($request->hasFile('image') && $request->file('image')->isValid()) {
      $voucher->image_path = 'storage/'.str_replace('public/', '', $request->file('image')->store('public/images'));
      $voucher->save();
    }

    if ($request->hasFile('thumbnail') && $request->file('thumbnail')->isValid()) {
      $voucher->thumbnail_path = 'storage/'.str_replace('public/', '', $request->file('thumbnail')->store('public/images'));
      $voucher->save();
    }

    return redirect('/vouchers')
      ->with('success-general', 'Voucher is updated successfully.')
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
