<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Auth;
use App\User;
use App\Three;
use Illuminate\Http\Request;

class ThreesController extends Controller
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
            $threes = Three::where('phone_number', 'LIKE', "%$keyword%")
                ->orWhere('code', 'LIKE', "%$keyword%")
                ->latest()->paginate($perPage);
        } else {
            $threes = Three::latest()->paginate($perPage);
        }

        return view('threes.index', compact('threes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $user_id = Auth::id();
        $count = Three::where('user_id', $user_id)->count();
        if ($count == 0) {
            return view('threes.create');
        }else{
            $three = Three::where('user_id', $user_id)->first();
            return redirect(route('threes.edit', array('id' => $three->id)));
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
        $code = rand ( 1000 , 9999 );

        $three = Three::create($requestData + ['user_id' => $user_id, 'code' => $code]);
        return view('threes.validation');
    }    

    public function submit_validation(Request $request)
    {        
        $user_id = Auth::user()->id;
        $three = Three::where('user_id', $user_id)->first();
        
        if($request->code == $three->code){
            $three = Three::find($three->id);
            $three->is_varified = 1;
            $three->save();
            return "done";
        }else{
            return view('threes.validation');
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
        $three = Three::findOrFail($id);

        return view('threes.show', compact('three'));
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
        $three = Three::findOrFail($id);

        return view('threes.edit', compact('three'));
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
        
        $three = Three::findOrFail($id);
        $three->update($requestData);

        return redirect('threes')->with('flash_message', 'Three updated!');
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
        Three::destroy($id);

        return redirect('threes')->with('flash_message', 'Three deleted!');
    }
}
