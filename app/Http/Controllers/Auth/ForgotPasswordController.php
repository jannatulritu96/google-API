<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }
    public function updatepass(Request $request){
        // dd($request->all());
        $email=$request->email;
        $password=$request->password;
        $password_confirmation=$request->password_confirmation;

        if($password ==  $password_confirmation){
            $passHash = Hash::make($password);
            User::where('email',$email)->update(['password'=>$passHash]);

            return Redirect()->route('login');

        }else{
            return Redirect()->back();
        }

    }
}
