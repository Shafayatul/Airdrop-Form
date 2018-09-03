<?php

namespace App\Http\Controllers;

class OauthController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (auth()->user()->email !== 'admin@projectoblio.com') {
            return abort(404);
        }
        return view('oauth');
    }
}
