<?php

namespace App\Http\Controllers;


use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;

use App\User;
use App\Mail\Welcome;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Session;


class UsersController extends Controller
{



    public function store(Request $request)
    {

        $request->validate([
            'email' => 'required|unique:users',
            'name' => 'required',
            'password' => 'min:6',
            'password_confirmation' => 'required_with:password|same:password|min:6'
        ]);

        $user = User::create(
            [
             'name'             => $request->input('name'),
             'email'            => $request->input('email'),
             'password'         => bcrypt($request->input('password')),
             'company'          => $request->input('company'),
             'contact_number'   => $request->input('contact_number'),
             'ip'               => $request->ip()
            ]);
        if($user){
            if(auth()->attempt(['email' => $request->input('email'), 'password' => $request->input('password')])){
                Mail::to($user->email)->send(new Welcome());
                return redirect()->to('/select-type');
            }
        }
        
        Session::flash('success','New user successfully created.');
        return back();
    }
}
