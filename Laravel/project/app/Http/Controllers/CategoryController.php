<?php

namespace App\Http\Controllers;

use App\Models\category;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cate_arr=category::all();
        return view('admin.manage_categories',["cate_arr"=>$cate_arr]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
         return view('admin.add_categories');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $table = new category();
        $table->name = $request->name;
      
        //image
        $file = $request->file('image');
        $filename = time() . "_img." . $request->file('image')->getClientOriginalExtension(); //"125455565656_img.jpg"
        $file->move('upload/category/', $filename); // upload image in public
        $table->image = $filename;
        $table->save();
        Alert::success('Category added success');
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(category $category)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, category $category)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(category $category,$id)
    {
        $data=category::find($id);
        unlink('upload/category/'.$data->image);
        $data->delete();
        Alert::success('Category Deleted Success');
        return back();
    }
}
