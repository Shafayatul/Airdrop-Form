<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use App\Five;
use Illuminate\Http\Request;
use Auth;
use App\User;
use Session;
class FivesController extends Controller
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
            return redirect(route('fives.show', array('id' => $five->id)));
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
            // 'g-recaptcha-response' => 'required|captcha'
        ]);

        $requestData = $request->all();
        $user_id = Auth::user()->id;

        // upload video file and get the link
        if (($request->hasFile('video')) ) {
            $image = $request->file('video');
            $filename = rand(10,100).time().'.'.$image->getClientOriginalExtension();
            $location = public_path('selfie/'.$filename);
            $path = $request->file('video')->store('selfie');
            $filename = Storage::url($path);
        }else{
            $filename="";
        }
        
        $five = new Five;
        $five->user_id = $user_id;
        $five->video = $filename;
        $five->referral_emails = $request->referral_emails;
        $five->ip = $request->ip();
        $five->point = 7;
        $five->save();

        $LastInsertId = $five->id;


        $user = User::where('id', $user_id)->first();
        $current_point = $user->point;

        $this->recount();

        Session::flash('flash_message','Date successfully added.');
        return redirect(route('fives.show', array('id' => $LastInsertId)));
    }

    public function recount()
    {

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
        

        $validatedData = $request->validate([
            // 'g-recaptcha-response' => 'required|captcha'
        ]);
        
        $requestData = $request->all();

        $user_id = Auth::user()->id;
        $old_data = Five::where('id', $id)->first();

        // upload video file and get the link
        if (($request->hasFile('video')) ) {
            $path = $request->file('video')->store('selfie');
            $filename = Storage::url($path);
            if($old_data->video !=""){
                Storage::delete(str_replace("storage/","",substr($old_data->video, strpos($old_data->video, "storage/"))));
            }            
        }elseif($old_data->video != ""){
            $filename=$old_data->video;
        }else{
            $filename="";
        }
        
        $five = Five::find($id);
        if ($filename !="") {
            $five->video = $filename;
        }
        $five->referral_emails = $request->referral_emails;
        $five->ip = $request->ip();
        $five->save();

        $this->recount();

        Session::flash('flash_message','Date successfully updated.');

        return redirect(route('fives.show', array('id' => $five->id)));
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
