<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use App\User;


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
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){
        $this->middleware('guest')->except('logout');
        $this->user = new User;
    }

    public function login(Request $request){
         $this->validate($request, [
            'email' => 'required',
            'password' => 'required|min:4'
        ]);

        $remember_me = false;

        if(isset($request->remember))
            $remember_me = true;


        if (Auth::attempt(['email'=>$request->input('email'), 'password'=>$request->input('password')], $remember_me)) {

            return redirect('/');
        }
        
        return redirect()->back()->withInput();
    }

}
