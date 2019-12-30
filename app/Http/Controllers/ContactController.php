<?php

namespace App\Http\Controllers;

use App\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index(Request $request)
    {
        $data['title'] =  "Contact list";
        $contacts = Contact::get();
        $data['contacts'] = $contacts;
        return view('admin.contact.index',$data);


//        $data['title'] = 'Cv list';
//        $cvs= CV::get();
////        dd($cvs);
//        $data['cvs']=$cvs;
//        return view ('admin.cv.index', $data);

    }

    public function create()
    {
        $data['title'] = 'Create Contact Form';
        $data['contacts'] = Contact::get();

        return view('admin.contact.create',$data);

    }

    public function store(Request $request)
    {
        request()->validate([
            'name' => 'required',
            'email' => 'required',
            'mobile_number' => 'required'
        ]);

        $data = $request->all();
        $check = Contact::insert($data);
        $arr = array('msg' => 'Something goes to wrong. Please try again later', 'status' => false);
        if($check){
            $arr = array('msg' => 'Successfully submit form using ajax', 'status' => true);
        }
        return Response()->json($arr);

    }
    public function destroy($id)
    {
        $delete = Contact::findOrFail($id)->delete();

        if ($delete == 1) {
            $success = true;
            $message = "User deleted successfully";
        } else {
            $success = true;
            $message = "User not found";
        }

        //  Return response
        return response()->json([
            'success' => $success,
            'message' => $message,
        ]);


    }

}
