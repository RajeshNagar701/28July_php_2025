<?php

namespace App\Http\Controllers;

use App\Models\customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function login()
    {
        return view('website.login');
    }

    //->get() multiple_data in arr 
    //->first() single data in string

    public function login_auth(Request $request)
    {
        $data = customer::where('email', $request->email)->first();
        if ($data) {                    // your value  === enc_value
            if (!(Hash::check($request->password, $data->password))) {
                Alert::error('Failed', 'Login Failed Due to Wrong Password');
                return back();
            } else {
                //create session 
                session()->put('user_id', $data->id);
                session()->put('user_name', $data->name);

                //session()->get('session_name') or session('session_name')  =>  get session

                //session()->pull('session_name') or   =>  delete session

                // if(session('session_name'))  or if(session()->has('session_name')) => check session

                Alert::success('Success', 'Login Success');
                return redirect('/');
            }
        } else {
            Alert::error('Failed', 'Login Failed Due to Wrong Email');
            return back();
        }
    }

    public function user_logout()
    {
        session()->pull('user_id');
        session()->pull('user_name');
        Alert::success('Success', 'Logout Success');
        return redirect('/');
    }

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
        return view('website.signup');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $table = new customer();
        $table->name = $request->name;
        $table->email = $request->email;
        $table->password = Hash::make($request->password); // pass enc
        $table->gender = $request->gender;
        $table->hobby = implode(",", $request->hobby);      // arr to string

        //image
        $file = $request->file('image');
        $filename = time() . "_img." . $request->file('image')->getClientOriginalExtension(); //"125455565656_img.jpg"
        $file->move('upload/customer/', $filename); // upload image in public
        $table->image = $filename;

        $table->save();
        return redirect('/login');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function show(customer $customer)
    {
        $data = customer::all();
        return view('admin.manage_customer', ["cust_arr" => $data]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function edit(customer $customer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, customer $customer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy(customer $customer)
    {
        //
    }
}
