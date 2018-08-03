<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Auth;
use App\User;
use App\Anonymouse;
use Illuminate\Http\Request;

class AnonymousesController extends Controller
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
            $anonymouses = Anonymouse::where('email', 'LIKE', "%$keyword%")
                ->orWhere('ethereum_address', 'LIKE', "%$keyword%")
                ->orWhere('number', 'LIKE', "%$keyword%")
                ->latest()->paginate($perPage);
        } else {
            $anonymouses = Anonymouse::latest()->paginate($perPage);
        }

        return view('anonymouses.index', compact('anonymouses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $user_id = Auth::id();
        $count = Anonymouse::where('user_id', $user_id)->count();
        if ($count == 0) {
            return view('anonymouses.create');
        }else{
            $anonymouse = Anonymouse::where('user_id', $user_id)->first();
            return redirect(route('anonymouses.edit', array('id' => $anonymouse->id)));
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
            
        $requestData = $request->all();
        $user_id = Auth::user()->id;

        $number = $request->number;
        if ($request->privacy == "Anonymous") {

            if ($request->type == "Audio") {
                $point = $number*0.1;
            }elseif ($request->type == "Video") {
                $point = $number*0.3;
            }

        }elseif ($request->privacy == "Raw") {

            if ($request->type == "Audio") {
                $point = $number*0.3;
            }elseif ($request->type == "Video") {
                $point = $number*0.6;
            }
            
        }
        
        Anonymouse::create($requestData + ['user_id' => $user_id, 'point' => $point]);

        $user = User::where('id', $user_id)->first();
        $current_point = $user->point;

        $user = User::find($user_id);
        $user->point = $current_point+$point;
        $user->save();

        return redirect('anonymouses')->with('flash_message', 'Anonymouse added!');
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
        $anonymouse = Anonymouse::findOrFail($id);

        return view('anonymouses.show', compact('anonymouse'));
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
        $anonymouse = Anonymouse::findOrFail($id);

        return view('anonymouses.edit', compact('anonymouse'));
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
            'g-recaptcha-response' => 'required|captcha'
        ]);
            
        $requestData = $request->all();
        $anonymouse = Anonymouse::findOrFail($id);
        $last_point = $anonymouse->point;
        $user_id = Auth::user()->id;

        $number = $request->number;
        if ($request->privacy == "Anonymous") {

            if ($request->type == "Audio") {
                $point = $number*0.1;
            }elseif ($request->type == "Video") {
                $point = $number*0.3;
            }

        }elseif ($request->privacy == "Raw") {

            if ($request->type == "Audio") {
                $point = $number*0.3;
            }elseif ($request->type == "Video") {
                $point = $number*0.6;
            }
            
        }

        $anonymouse->update($requestData + ['user_id' => $user_id, 'point' => $point]);

        $user = User::where('id', $user_id)->first();
        $current_point = $user->point;

        $user = User::find($user_id);
        $user->point = $current_point+$point-$last_point;
        $user->save();
        
        return redirect('anonymouses')->with('flash_message', 'Anonymouse updated!');
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
        Anonymouse::destroy($id);

        return redirect('anonymouses')->with('flash_message', 'Anonymouse deleted!');
    }
}
