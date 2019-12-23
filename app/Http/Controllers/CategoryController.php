<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $data['title'] = 'Category List';
        $sql = Category::get();
        $render = [];

        if (isset($request->name)) {
            $sql->where('name', 'like', '%'.$request->name.'%');
            $render['name'] = $request->name;
        }

        if (isset($request->status)) {
            $sql->where('status', $request->status);
            $render['status'] = $request->status;
        }


//        $categories = $sql->paginate(2);
//        $categories=$sql->appends($render);
        $data['categories'] = $sql;
        $data['status'] = (isset($request->status)) ? $request->status : '';

//         return response()->json($data);
        return view ('admin.category.index', $data);

    }
    public function create()
    {
        $data['title'] = 'Create category form';
        $data['categories'] = Category::where('status','Active')->get();

        return view('admin.category.create',$data);

    }
    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'name'=>'required',
            'details'=>'required',
            'status' => 'required',
            'image'=>'mimes:png,jpg,jpeg'
        ]);
        $category = new Category();
        $category->name= $request->name;
        $category->details= $request->details;
        $category->status= $request->status;
        if($request->hasFile('image'))
        {
            $image= $request->file('image');
            $image->move('assets/img/',$image->getClientOriginalName());
            $category->image = 'assets/img/'.$image->getClientOriginalName();
            $category->save();
        }
        $category->save();
        session()->flash('success','Category stored successfully');
        return redirect()->route('category.index');
    }

    public function edit($id)
    {
        $data['title'] = 'Edit category form';
        $data['category'] = Category::findOrFail($id);
        return view('admin.category.edit',$data);

    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'details' => 'required',
            'status' => 'required',
            'image' => 'mimes:png,jpg,jpeg'
        ]);
        $category = Category::findOrfail($id);
        $category -> name = $request -> name;
        $category -> details = $request->details;
        $category -> status = $request -> status;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $image->move('assets/img/', $image->getClientOriginalName());
            $category->image = 'assets/img/' . $image->getClientOriginalName();
            $category->save();
        }

//         dd($request->all());
        $category->save();
        session()->flash('success', 'Category stored successfully');
        return redirect()->route('category.index');

    }
    public function destroy($id)
    {
        $delete = Category::findOrFail($id)->delete();

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
