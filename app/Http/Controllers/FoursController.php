<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Session;
use App\One;
use App\Two;
use App\Three;
use App\Four;
use App\Five;
use Illuminate\Http\Request;
use Auth;
use App\User;
class FoursController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $keyword = $request->get('search');
        $perPage = 25;

        if (!empty($keyword)) {
            $fours = Four::where('email_address', 'LIKE', "%$keyword%")
                ->orWhere('name', 'LIKE', "%$keyword%")
                ->orWhere('university_email_address', 'LIKE', "%$keyword%")
                ->orWhere('university_website', 'LIKE', "%$keyword%")
                ->orWhere('undergraduate_major', 'LIKE', "%$keyword%")
                ->orWhere('graduation_year', 'LIKE', "%$keyword%")
                ->orWhere('university_ambassadors', 'LIKE', "%$keyword%")
                ->orWhere('ethereum_address', 'LIKE', "%$keyword%")
                ->orWhere('terms_and_privacy_policy', 'LIKE', "%$keyword%")
                ->latest()->paginate($perPage);
        } else {
            $fours = Four::latest()->paginate($perPage);
        }

        return view('fours.index', compact('fours'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $user_id = Auth::id();
        $count = Four::where('user_id', $user_id)->count();
        if ($count == 0) {
            return view('fours.create');
        }else{
            $four = Four::where('user_id', $user_id)->first();
            return redirect(route('fours.show', array('id' => $four->id)));
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'g-recaptcha-response' => 'required|captcha'
        ]);
        $user_id = Auth::user()->id;
        
        $requestData = $request->all();
        
        $four = Four::create($requestData + ['user_id' => $user_id, 'ip' => $request->ip(), 'point' => 5]);

        $user = User::where('id', $user_id)->first();
        $current_point = $user->point;

        $this->recount();

        Session::flash('flash_message','Date successfully added.');

        return redirect(route('fours.show', array('id' => $four->id)));
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
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $four = Four::findOrFail($id);

        return view('fours.show', compact('four'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $four = Four::findOrFail($id);

        return view('fours.edit', compact('four'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, $id)
    {
        $user_id = Auth::id();
        $validatedData = $request->validate([
            'g-recaptcha-response' => 'required|captcha'
        ]);
        
        $requestData = $request->all();
        
        $four = Four::findOrFail($id);
        $four->update($requestData + ['user_id' => $user_id, 'ip' => $request->ip()]);

        $this->recount();

        Session::flash('flash_message','Date successfully updated.');

        return redirect(route('fours.show', array('id' => $four->id)));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        Four::destroy($id);

        return redirect('fours')->with('flash_message', 'Four deleted!');
    }
}
