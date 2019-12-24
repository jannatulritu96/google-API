<?php

namespace App\Http\Controllers;

use App\Rules\MatchOldPassword;
use Illuminate\Http\Request;
use Auth;
use App\user;
use Illuminate\Support\Facades\Hash;

class DashboardController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {

        $data['title'] = 'Dashboard';
        return view('admin.dashboard', $data);
    }


    public function showResetForm()
    {
        return view('change_password');
    }

    public function updatepassword(Request $request){
        $password=User::find(Auth::id())->password;
        $oldpass=$request->oldpass;

        if(Hash::check($oldpass,$password)){
            $user=User::find(Auth::id());
            $user->password=Hash::make($request->password);
            $user->save();
            return Redirect()->route('login')->with('success', 'Product save successfully!');
        }else{
            return Redirect()->back()->with('error', 'Product insert failed!');
        }

    }
}
