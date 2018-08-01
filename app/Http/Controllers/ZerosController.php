<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;

use Auth;
use App\Zero;
use Illuminate\Http\Request;

class ZerosController extends Controller
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
            $zeros = Zero::where('ethereum_address', 'LIKE', "%$keyword%")
                ->orWhere('ip', 'LIKE', "%$keyword%")
                ->latest()->paginate($perPage);
        } else {
            $zeros = Zero::latest()->paginate($perPage);
        }

        return view('zeros.index', compact('zeros'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $user_id = Auth::id();
        $count = Zero::where('user_id', $user_id)->count();
        if ($count == 0) {
            return view('zeros.create');
        }else{
            $zero = Zero::where('user_id', $user_id)->first();
            return redirect(route('zeros.edit', array('id' => $zero->id)));
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
            'ethereum_address' => ["required" , "regex:/^0x/"],
            'ip' => ["required", "unique:zeros", "ip"],
        ]);
            
        $requestData = $request->all();
        
        Zero::create($requestData + ['user_id' => Auth::user()->id]);

        return redirect('zeros')->with('flash_message', 'Zero added!');
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
        $zero = Zero::findOrFail($id);

        return view('zeros.show', compact('zero'));
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
        $zero = Zero::findOrFail($id);

        return view('zeros.edit', compact('zero'));
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
            'ethereum_address' => ["required" , "regex:/^0x/"],
            'ip' => ["required", Rule::unique('zeros')->ignore($id), "ip"],
        ]);

        $requestData = $request->all();
        
        $zero = Zero::findOrFail($id);
        $zero->update($requestData);

        return redirect('zeros')->with('flash_message', 'Zero updated!');
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
        Zero::destroy($id);

        return redirect('zeros')->with('flash_message', 'Zero deleted!');
    }
}
