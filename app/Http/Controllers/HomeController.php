<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('dashboard');
    }
    public function showResetForm()
    {
        return view('admin.change_password');
    }

    public function updatepassword(Request $request){
        // dd($request->all());
        $password=Auth::User()->password;
        $oldpass=$request->oldpass;

        if(Hash::check($oldpass,$password)){
            $user=User::find(Auth::id());
            $user->password=Hash::make($request->password);
            $user->save();
            Auth::logout();

            return Redirect()->route('login');
        }else{
            return Redirect()->back();
        }
    }
}
