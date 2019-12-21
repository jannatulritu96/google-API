<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $data['title'] = 'Category List';
        $categorys = Category::get();

//        $render = [];

        if (isset($request->name)) {
            $categorys->where('name', 'like', '%'.$request->name.'%');
            $render['name'] = $request->name;
        }

        if (isset($request->status)) {
            $categorys->where('categorys.status', $request->status);
            $render['status'] = $request->status;
        }

//        $categorys = $categorys->paginate(2);
//        $categorys->appends($render);
//        $data['categorys'] = $categorys;
//        $data['status'] = (isset($request->status)) ? $request->status : '';

        // return response()->json($data);
        return view ('admin.category.index', $data);



    }
}
