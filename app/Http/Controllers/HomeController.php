<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\User;
use Session;
use App\One;
use App\Two;
use App\Three;
use App\Four;
use App\Five;
class HomeController extends Controller
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
        return view('home');
    }

    public function select_type()
    {
        return view('selectType');
    }

    public function save_type($type)
    {

        $id = Auth::id();
        $user = User::find($id);
        $user->type = $type;
        $user->save();
        $this->recount();
        return redirect()->to('/home');
    }

    public function recount()
    {
        $user = Auth::user();
        if($user->type == 'advance'){
            if((One::where('user_id', $user->id)->count() == 1) && (Two::where('user_id', $user->id)->count() == 1) && (Three::where('user_id', $user->id)->count() == 1) && (Four::where('user_id', $user->id)->count() == 1) && (Five::where('user_id', $user->id)->count() == 1) ){


                $point = One::where('user_id', $user->id)->first()->point + Two::where('user_id', $user->id)->first()->point + Three::where('user_id', $user->id)->first()->point + Four::where('user_id', $user->id)->first()->point + Five::where('user_id', $user->id)->first()->point;

                $update_user = User::find($user->id);
                $update_user->point = $point;
                $update_user->is_locked = 1;
                $update_user->save();

            }else{
                $update_user = User::find($user->id);
                $update_user->point = 0;
                $update_user->is_locked = 0;
                $update_user->save();
            }
        }else{
            
            if((One::where('user_id', $user->id)->count() == 1) && (Two::where('user_id', $user->id)->count() == 1) && (Three::where('user_id', $user->id)->count() == 1) ){


                $point = One::where('user_id', $user->id)->first()->point + Two::where('user_id', $user->id)->first()->point + Three::where('user_id', $user->id)->first()->point;

                $update_user = User::find($user->id);
                $update_user->point = $point;
                $update_user->is_locked = 1;
                $update_user->save();

            }else{
                $update_user = User::find($user->id);
                $update_user->point = 0;
                $update_user->is_locked = 0;
                $update_user->save();
            }
        }
        
    }

}
