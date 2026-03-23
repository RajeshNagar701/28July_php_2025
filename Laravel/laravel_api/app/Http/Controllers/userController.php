<?php

namespace App\Http\Controllers;

use App\Models\user;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class userController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function display()
    {
        $data=user::all();
        return view('welcome',['users'=>$data]);
    }

    public function index()
    {
        $data = user::all();
        return response()->json([
            'users' => $data,
            'status'=> 200
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validate=validator::make($request->all(),[
            'name'=>'Required',
            'email'=>'Required|email',
            'password'=>'Required',
			'mobile'=>'Required',
            'image'=> 'Required'
        ]);
		
		if($validate->fails())
		{
			return [
				'success' => 0, 
				'message' => $validate->messages(),
			];
		}
		else
		{
			$data=new user;
			$data->name=$request->name;
			$data->email=$request->email;
			$data->password=Hash::make($request->password);	
			$data->mobile=$request->mobile;
           
			if($request->hasFile('image'))
			{
				$image=$request->file('image');		
				$filename=time().'_img.'.$request->file('image')->getClientOriginalExtension();
				$image->move('upload/customer/',$filename);  // use move for move image in public/images
				$data->image=$filename;
			}
			$data->save();
			return response()->json([
			'status'=>200,
			'message'=>"Regioster Success"
			]);
		}
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = user::find($id);
        return response()->json([
            'users' => $data,
            'status'=> 200
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    //==========================================================



}
