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
        $product= new product();
        $render=[];
        $product= $product->paginate(10);
        $product= $product->appends($render);
        $data['$product'] = $product;
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
//        dd($request->all());
//        $request->validate([
//
//            'category_id'=>'required',
//            'name'=>'required',
//            'details'=>'required',
//            'original_price'=>'required',
//            'discount_percentage'=>'required',
//            'discount_amount' => 'required',
//            'price' => 'required',
//            'status' => 'required',
//        ]);
//dd($request->all());
        $data = [
            'category_id' => $request->category_id,
            'name' => $request->name,
            'details' => $request->details,
            'original_price' => $request->original_price,
            'discount_percentage' => $request->discount_percentage,
            'discount_amount' => $request->{($request->original_price*$request->discount_percentage)/100},
            'price' => $request->{($request->original_price-$request->discount_amount)},
            'status' => $request->status
        ];
        $productData = Product::create($data);

        if ($productData->id) {
            // ########### After Product Insert ##############
            if (isset($request->colors) && !empty($request->colors)) {
                foreach ($request->colors as $color) {
                    $colorData = [
                        'product_id' => $productData->id,
                        'color_name' => $color,
                    ];
                    ProductColor::create($data);
                }
            }

//            if (isset($data['check_image'])) {
//                if ($request->hasFile('product_image')) {
//                    $images = [];
//                    foreach ($request->file('product_image') as $key => $image) {
//                        $fileNameMt = imageUpload($image, "_$request->name", "$this->_moduleImagePath", '1200', '1200');
//                        $images[] = [
//                            'product_id' => $productData->id,
//                            'image' => $fileNameMt,
//                        ];
//                    }
//                    if (!empty($images)) {
//                        ProductImage::insert($images);
//                    }
//                }
//            }


        }


            $productData->save();
        session()->flash('success','Information stored successfully');
        return redirect()->route('product.index');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $data['title'] = 'Edit form';
        $data['product'] = product::findOrFail($id);
        return view('admin.product.edit',$data);
    }

    public function update(Request $request, $id)
    {
        $request->validate([

            'product_id'=>'required',
            'image'=>'mimes:png,jpg,jpeg'
        ]);
        $product = product::findOrfail($id);

        $product->product_id= $request->product_id;
        if($request->hasFile('image'))
        {

            $image= $request->file('image');
            $image->move('assets/img/',$image->getClientOriginalName());
            $product->image = 'assets/img/'.$image->getClientOriginalName();
            $product->save();
        }
        $product->save();
        session()->flash('success','Information stored successfully');
        return redirect()->route('product.index');
    }

    public function destroy($id)
    {
        product::findOrFail($id)->delete();
        session()->flash('success','product deleted successfully');
        return redirect()->route('product.index');
    }
}
