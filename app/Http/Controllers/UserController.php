<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
      if($request->ajax()){
        return DataTables::of(User::query())->addIndexColumn()->make(true);      
      }
      return view('admin.users.list');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
      $user = User::find($id);
      if (!count($user)) {
        return redirect('/users')->with('error', 'The user profile you requested was not found.');
      }
  
      return view('admin.users.single', compact('user'));
    }

    public function update(Request $request, $id) {
      $user = User::find($id);
      if (!count($user)) {
        return redirect('/users')->with('error', 'The user profile you requested was not found.');
      }
      
      // validate nric
      if (!empty($request->nric) ) {
        $request->validate([
          'nric' => 'string|min:12|max:12|unique:users,id,'.$user->id,
        ]);
        $user->nric = $request->nric;        
      }
      
      // validate contact number
      if (!empty($request->nric) ) {
        $request->validate([
          'contact_number' => 'required|string|min:10|max:11',
        ]);
        $user->contact_number = $request->contact_number;        
      }

      // validate password
      if (!empty($request->password) || !empty($request->password_confirmation)) {
        $request->validate([
          'password' => 'required|string|min:6|max:20|confirmed',
        ]);
        $user->password = bcrypt($request->password);
      }
    
      $user->name = $request->name;
      $user->save();
  
      return redirect('/users')->with('success', 'User profile is updated successfully.');
    }
}
