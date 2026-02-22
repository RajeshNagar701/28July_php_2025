<?php

namespace App\Http\Controllers;

use App\Models\category;
use App\Models\product;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $prod_arr=product::all();
        return view('admin.manage_products',['prod_arr'=>$prod_arr]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
         $cate_arr=category::all();
         return view('admin.add_products',['cate_arr'=>$cate_arr]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $table = new product();
        $table->cate_id = $request->cate_id;
        $table->name = $request->name;
        $table->description = $request->description;
        $table->price = $request->price;
      
        //image
        $file = $request->file('image');
        $filename = time() . "_img." . $request->file('image')->getClientOriginalExtension(); //"125455565656_img.jpg"
        $file->move('upload/package/', $filename); // upload image in public
        $table->image = $filename;
        $table->save();
        Alert::success('Package added success');
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(product $product,$id)
    {
        $data=product::find($id);  // only find ID data
        unlink('upload/package/'.$data->image);
        $data->delete();
        Alert::success('Package Deleted Success');
        return back();
    }
}
