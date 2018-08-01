<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Auth;
use App\User;
use App\Two;
use Illuminate\Http\Request;

class TwosController extends Controller
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
            $twos = Two::where('privacy', 'LIKE', "%$keyword%")
                ->orWhere('type', 'LIKE', "%$keyword%")
                ->orWhere('number', 'LIKE', "%$keyword%")
                ->latest()->paginate($perPage);
        } else {
            $twos = Two::latest()->paginate($perPage);
        }

        return view('twos.index', compact('twos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $user_id = Auth::id();
        $count = Two::where('user_id', $user_id)->count();
        if ($count == 0) {
            return view('twos.create');
        }else{
            $two = Two::where('user_id', $user_id)->first();
            return redirect(route('twos.edit', array('id' => $two->id)));
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
        
        Two::create($requestData + ['user_id' => $user_id, 'point' => $point]);

        $user = User::where('id', $user_id)->first();
        $current_point = $user->point;

        $user = User::find($user_id);
        $user->point = $current_point+$point;
        $user->save();

        return redirect('twos')->with('flash_message', 'Two added!');
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
        $two = Two::findOrFail($id);

        return view('twos.show', compact('two'));
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
        $two = Two::findOrFail($id);

        return view('twos.edit', compact('two'));
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
        $two = Two::findOrFail($id);
        $last_point = $two->point;
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

        $two->update($requestData + ['user_id' => $user_id, 'point' => $point]);

        $user = User::where('id', $user_id)->first();
        $current_point = $user->point;

        $user = User::find($user_id);
        $user->point = $current_point+$point-$last_point;
        $user->save();


        return redirect('twos')->with('flash_message', 'Two updated!');
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
        Two::destroy($id);

        return redirect('twos')->with('flash_message', 'Two deleted!');
    }
}
