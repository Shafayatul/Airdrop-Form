<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Session;
use Auth;
use App\One;
use App\User;
use Illuminate\Http\Request;

class OnesController extends Controller
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
            $ones = One::where('name', 'LIKE', "%$keyword%")
                ->orWhere('address', 'LIKE', "%$keyword%")
                ->latest()->paginate($perPage);
        } else {
            $ones = One::latest()->paginate($perPage);
        }

        return view('ones.index', compact('ones'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $user_id = Auth::id();
        $count = One::where('user_id', $user_id)->count();
        if ($count == 0) {
            return view('ones.create');
        }else{
            $one = One::where('user_id', $user_id)->first();
            return redirect(route('ones.show', array('id' => $one->id)));
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
            'g-recaptcha-response' => 'required|captcha',
            'name' => ["required"],
            
        ]);
        $requestData = $request->all();
        $user_id = Auth::user()->id;
        $one = One::create($requestData + ['user_id' => $user_id, 'ip' => $request->ip()]);

        $user = User::find($user_id);
        $user->point = 0.3;
        $user->save();

        Session::flash('flash_message','Date successfully added.');

        return redirect(route('ones.show', array('id' => $one->id)));
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
        $one = One::findOrFail($id);

        return view('ones.show', compact('one'));
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
        $one = One::findOrFail($id);

        return view('ones.edit', compact('one'));
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
            'g-recaptcha-response' => 'required|captcha',
            'name' => ["required"],
            
        ]);

        $requestData = $request->all();
        
        $one = One::findOrFail($id);
        $one->update($requestData + ['user_id' => $user_id, 'ip' => $request->ip()]);

        Session::flash('flash_message','Date successfully updated.');

        return redirect(route('ones.show', array('id' => $one->id)));
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
        One::destroy($id);

        return redirect('ones')->with('flash_message', 'One deleted!');
    }
}
