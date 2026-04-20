<?php

namespace App\Http\Controllers;

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
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('add_product');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = new product();

        $data->name=$request->name;
        $data->price=$request->price;
        $data->short_description=$request->short_description;
        $data->long_description=$request->long_description;

        // image upload
        $file=$request->file('image');
                                          // get file extension
        $filename=time().'_img.'.$request->file('image')->getClientOriginalExtension();//1222344544_img.png       
        $file->move('upload/',$filename);
        $data->image=$filename;

        $data->save();
        return back()->with('Success','Product add success');  // flash session

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(product  $product)
    {
        $data = product::all();
        return view('dashboard', ['prod_arr' => $data]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(product $product,$id)
    {
        $data = product::find($id);
        return view('edit_product', ['data' => $data]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, product $product,$id)
    {
        $data = product::find($id);

        $data->name=$request->name;
        $data->price=$request->price;
        $data->short_description=$request->short_description;
        $data->long_description=$request->long_description;

        // image upload
        if($request->hasFile('image'))
            {
            $file=$request->file('image');
            $filename=time().'_img.'.$request->file('image')->getClientOriginalExtension();//1222344544_img.png       
            $file->move('upload/',$filename);
            $data->image=$filename;
            }

        $data->update();
        Alert::success('Product Updated Success');
        return redirect('/dashboard');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(product $product,$id)
    {
        $data = product::find($id);
        unlink('upload/' . $data->image);
        $data->delete();
        Alert::success('Customer Deleted Success');
        return back();
    }
}
