<?php

namespace App\Http\Controllers;

use App\Category;
use App\Product;
use App\ProductColor;
use App\ProductImage;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $data['title'] = 'product Information';
        $products=  Product::select('*');
        $products= $products->with(['relProductColor','relProductImage','relCategory']);
        $render=[];

        if (isset($request->title)) {
            $products->where('name', 'like', '%'.$request->name.'%');
            $render['name'] = $request->name;
        }
        if (isset($request->status)) {
            $products->where('status', $request->status);
            $render['status'] = $request->status;
        }

        $data['status'] = (isset($request->status)) ? $request->status : '';
        $products= $products->paginate(2);
        $products= $products->appends($render);

        $data['products'] = $products;
        return view('admin.product.index',$data);
    }

    public function create()
    {
        $data['title'] = 'Create Product form';
        $data['categories'] = Category::where('status','Active')->get();
        return view('admin.product.create',$data);
    }

    public function store(Request $request)
    {
        $data = $request->all();
        // dd($request->all());
        $productData = Product::create($data);
        if ($productData->id){
            // ########### After Product Insert ##############

            if (!empty($data['product_color'])) {
                //array filter for zero empty value check
                $productColors = $data['product_color'];
                $productColors = !empty($productColors) ? array_values(array_filter($productColors)) : array();
                $colorData = [];
                foreach ($productColors as $k => $color) {
                    $colorData[] = [
                        'product_id'   => $productData->id,
                        'color_name' => $color,
                    ];
                }
                if (!empty($colorData)) {
                    ProductColor::insert($colorData);
                }else{
                    return redirect()->back()->with('error', 'Product color insert failed!');
                }
            }

            if ($request->hasFile('product_image')) {
                $images = [];
                foreach($request->file('product_image') as $key => $image)
                {
                    $filename = time().'.'.$image->getClientOriginalExtension();
                    $image->move(public_path('media/product'), $filename);
                    $images[] = [
                        'product_id' => $productData->id,
                        'image' => $filename,
                    ];
                }
                if (!empty($images)) {
                    ProductImage::insert($images);
                }
            }

            return redirect()->back()->with('success', 'Product save successfully!');
        }else{
            return redirect()->back()->with('error', 'Product insert failed!');
        }
        return redirect()->route('product.index');
    }

    public function show($id)
    {
        $data['title'] = 'Product show';
        $product = Product::findOrFail($id);
        $data['product'] = $product;
        return view('admin.product.show',$data);

    }

    public function edit($id)
    {
        $data['title'] = 'Edit form';
        $data['product'] = Product::findOrFail($id);
        $data['categories'] = Category::where('status','Active')->get();
        return view('admin.product.edit',$data);
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();
        Product::find($id)->update($data);
        return  redirect()->route('product.index');

    }

    public function destroy($id)
    {
        $delete = Product::findOrFail($id)->delete();

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
