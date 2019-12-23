<?php

namespace App\Http\Controllers;

use App\Product;
use App\product_images;
use Illuminate\Http\Request;

class product_imagesController extends Controller
{
    public function index(Request $request)
    {
        $data['title'] = 'product Information';
        $product_images= new product_images();
        $render=[];
        $product_images= $product_images->paginate(10);
        $product_images= $product_images->appends($render);
        $data['$product_images'] = $product_images;
        return view('admin.product_image.index',$data);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['title'] = 'Create Product form';
        $data['products'] = Product::where('status','Active')->get();
        return view('admin.product_image.create',$data);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([

            'product_id'=>'required',
            'image'=>'mimes:png,jpg,jpeg'
        ]);
        $product = new product_images();

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
        return redirect()->route('product_image.index');
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['title'] = 'Edit form';
        $data['product'] = product_images::findOrFail($id);
        return view('admin.product_image.edit',$data);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([

            'product_id'=>'required',
            'image'=>'mimes:png,jpg,jpeg'
        ]);
        $product = product_images::findOrfail($id);

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
        return redirect()->route('product_image.index');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        product_images::findOrFail($id)->delete();
        session()->flash('success','product deleted successfully');
        return redirect()->route('product_image.index');
    }
}
