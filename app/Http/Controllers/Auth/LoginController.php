<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Mail\Welcome;
use Illuminate\Support\Facades\Mail;
use Socialite;
use App\User;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }


    /**
     * Redirect the user to the google authentication page.
     *
     * @return Response
     */
    public function redirectToProvider()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Obtain the user information from google.
     *
     * @return Response
     */
    public function handleProviderCallback(Request $request)
    {
        try {
            $user = Socialite::driver('google')->stateless()->user();
        } catch (\Exception $e) {
            return redirect('/')->to('/');
        }

        // only allow people with @company.com to login
        if(explode("@", $user->email)[1] !== 'gmail.com'){
            return redirect()->to('/');
        }
        // check if they're an existing user
        $existingUser = User::where('email', $user->email)->first();
        if($existingUser){
            // log them in
            auth()->login($existingUser, true);
            if ($existingUser->type == null) {
                return redirect()->to('/select-type');
            }

        } else {
            // create a new user
            $newUser                  = new User;
            $newUser->name            = $user->name;
            $newUser->email           = $user->email;
            $newUser->avatar          = $user->avatar;
            $newUser->password        = bcrypt(rand(100000,100000000));
            $newUser->ip              = $request->ip();
            $newUser->save();
            auth()->login($newUser, true);

            Mail::to($user->email)->send(new Welcome());
            return redirect()->to('/select-type');
        }
        return redirect()->to('/home');
    }

}
