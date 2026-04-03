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


    function search($key) 	
    {
         $data=user::where('name','LIKE',"%$key%")->orWhere('email','LIKE','%'.$key.'%')->get();
		 return response()->json([
		 'status'=>200,
		 'users'=>$data
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
			$data=user::find($id);
			$data->name=$request->name;
			$data->email=$request->email;
            $data->password=Hash::make($request->password);	
			$data->mobile=$request->mobile;

            if ($request->hasFile('image')) {
                unlink('upload/customer/' . $data->image);
                $file = $request->file('image');
                $filename = time() . "_img." . $request->file('image')->getClientOriginalExtension(); //"125455565656_img.jpg"
                $file->move('upload/customer/', $filename); // upload image in public
                $data->image = $filename;
            }
			$data->update();
			return response()->json([
			'status'=>200,
			'message'=>"Update Success"
			]);
		}
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        user::find($id)->delete();
		return response()->json([
		'status'=>200,
		'msg'=>"Delete Success"
		]);
    }


    //==========================================================
    
	
	
	public function login(Request $request)
	{
		$validate=Validator::make($request->all(),[
            'email'=>'Required|email',
            'password'=>'Required'
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
			//$user=user::where('email',$request->email)->first();
			$user=user::where('email' , '=' , $request->email)->first();	
			if(! $user || ! Hash::check($request->password,$user->password))
			{
				return response()->json([
					'status'=>201,
					'msg'=>"user Login Failed due to Wrong Creadantial"
					]);
			}
			else
			{
				
				if($user->status=="Unblock")
				{
					return response()->json([
					'status'=>200,
					'msg'=>"user Login Success",
					'name'=>$user->name,
					'id'=>$user->id,
					]);
				}
				else
				{
					return response()->json([
					'status'=>201,
					'msg'=>"user Blocked so Login Failed"
					]);
				}	
			}
		}
	
	}

    public function updatestatus(Request $request,$id)
    {
        $data=user::find($id);
		$status=$data->status;
		if($status === "Block")
		{	
			$data->status="Unblock";
			$data->save();
			return response()->json([
			'status'=>200,
			'msg'=>"Unblock Success"
			]);
		}
		else
		{
			$data->status="Block";
			$data->save();
			return response()->json([
			'status'=>200,
			'msg'=>"Block Success"
			]);
		}
    }

	


}
