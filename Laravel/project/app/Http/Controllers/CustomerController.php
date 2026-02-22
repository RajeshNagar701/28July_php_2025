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

                if ($data->status == "Unblock") {
                    //create session 
                    session()->put('user_id', $data->id);
                    session()->put('user_name', $data->name);

                    //session()->get('session_name') or session('session_name')  =>  get session

                    //session()->pull('session_name') or   =>  delete session

                    // if(session('session_name'))  or if(session()->has('session_name')) => check session

                    Alert::success('Success', 'Login Success');
                    return redirect('/');
                }
                else
                {
                    Alert::error('Failed', 'Account Blocked !');
                    return back();
                }
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
        Alert::success('Signup Success');
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

    public function user_profile(customer $customer)
    {
        $data = customer::where('id', session('user_id'))->first();
        return view('website.user_profile', ["data" => $data]);
    }

    public function edit(customer $customer, $id)
    {
        $data = customer::find($id);
        return view('website.edit_profile', ["data" => $data]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, customer $customer, $id)
    {
        $data = customer::find($id);
        $data->name = $request->name;
        $data->email = $request->email;
        $data->gender = $request->gender;
        $data->hobby = implode(",", $request->hobby);

        if ($request->hasFile('image')) {
            unlink('upload/customer/' . $data->image);

            $file = $request->file('image');
            $filename = time() . "_img." . $request->file('image')->getClientOriginalExtension(); //"125455565656_img.jpg"
            $file->move('upload/customer/', $filename); // upload image in public
            $data->image = $filename;
        }
        $data->update();
        Alert::success('Update Success');
        return redirect('/user_profile');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy(customer $customer, $id)
    {
        $data = customer::find($id)->delete();
        unlink('upload/customer/' . $data->image);
        Alert::success('Customer Deleted Success');
        return back();
    }

    public function status_customer(customer $customer, $id)
    {
        $data = customer::find($id);
        if ($data->status == "Block") {
            $data->status = "Unblock";
            $data->update();
            Alert::success('Customer Unblocked Success');
            return back();
        } else {
            $data->status = "Block";
            $data->update();
            session()->pull('user_id');
            session()->pull('user_name');
            Alert::success('Customer Block Success');
            return back();
        }
    }
}
