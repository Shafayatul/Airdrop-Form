<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Image;
use App\Five;
use Illuminate\Http\Request;
use Auth;
use App\User;
class FivesController extends Controller
{
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
            $fives = Five::where('email_address', 'LIKE', "%$keyword%")
                ->orWhere('name', 'LIKE', "%$keyword%")
                ->orWhere('video', 'LIKE', "%$keyword%")
                ->orWhere('referral_emails', 'LIKE', "%$keyword%")
                ->orWhere('ethereum_address', 'LIKE', "%$keyword%")
                ->latest()->paginate($perPage);
        } else {
            $fives = Five::latest()->paginate($perPage);
        }

        return view('fives.index', compact('fives'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $user_id = Auth::id();
        $count = Five::where('user_id', $user_id)->count();
        if ($count == 0) {
            return view('fives.create');
        }else{
            $five = Five::where('user_id', $user_id)->first();
            return redirect(route('fives.edit', array('id' => $five->id)));
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
        
        $requestData = $request->all();
        $user_id = Auth::user()->id;

        // upload video file and get the link
        if (($request->hasFile('video')) ) {
            $image = $request->file('video');
            $filename = rand(10,100).time().'.'.$image->getClientOriginalExtension();
            $location = public_path('selfie/'.$filename);
            $image = Image::make($image->getRealPath());
            Image::make($image)->save($location);
        }else{
            $filename="";
        }
        
        $five = new Five;
        $five->user_id = $user_id;
        $five->email_address = $request->email_address;
        $five->name = $request->name;
        $five->video = $filename;
        $five->referral_emails = $request->referral_emails;
        $five->ethereum_address = $request->ethereum_address;
        $five->save();


        $user = User::where('id', $user_id)->first();
        $current_point = $user->point;

        $user = User::find($user_id);
        $user->point = $current_point+7;
        $user->save();
        return redirect('fives')->with('flash_message', 'Five added!');
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
        $five = Five::findOrFail($id);

        return view('fives.show', compact('five'));
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
        $five = Five::findOrFail($id);

        return view('fives.edit', compact('five'));
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
        
        $requestData = $request->all();

        $user_id = Auth::user()->id;
        $old_data = Five::where('id', $id)->first();

        // upload video file and get the link
        if (($request->hasFile('video')) ) {
            if(file_exists('selfie/'.$old_data->video)){
                unlink('selfie/'.$old_data->video);
            }
            $image = $request->file('video');
            $filename = rand(10,100).time().'.'.$image->getClientOriginalExtension();
            $location = public_path('selfie/'.$filename);
            $image = Image::make($image->getRealPath());
            Image::make($image)->save($location);
        }else{
            $filename="";
        }
        
        $five = Five::find($id);
        $five->email_address = $request->email_address;
        $five->name = $request->name;
        if ($filename !="") {
            $five->video = $filename;
        }
        $five->referral_emails = $request->referral_emails;
        $five->ethereum_address = $request->ethereum_address;
        $five->save();

        return redirect('fives')->with('flash_message', 'Five updated!');
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
        Five::destroy($id);

        return redirect('fives')->with('flash_message', 'Five deleted!');
    }
}
