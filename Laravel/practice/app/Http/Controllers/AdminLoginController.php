<?php

namespace App\Http\Controllers;

use App\Models\admin_login;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;

class AdminLoginController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         return view('index');
    }

    public function admin_auth(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        $data = admin_login::where('email', $request->email)->first();
        if ($data) {                    // your value  === enc_value
            if (!(Hash::check($request->password, $data->password))) {
                Alert::error('Failed', 'Login Failed Due to Wrong Password');
                return back();
            } else {

                    session()->put('admin_id', $data->id);
                    session()->put('admin_email', $data->email);

                    Alert::success('Success', 'Login Success');
                    return redirect('/dashboard');
    
            }
        } else {
            Alert::error('Failed', 'Login Failed Due to Wrong Email');
            return back();
        }
    }


    public function admin_logout()
    {
        session()->pull('admin_id');
        session()->pull('admin_email');
        Alert::success('Success', 'Logout Success');
        return redirect('/');

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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\admin_login  $admin_login
     * @return \Illuminate\Http\Response
     */
    public function show(admin_login $admin_login)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\admin_login  $admin_login
     * @return \Illuminate\Http\Response
     */
    public function edit(admin_login $admin_login)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\admin_login  $admin_login
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, admin_login $admin_login)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\admin_login  $admin_login
     * @return \Illuminate\Http\Response
     */
    public function destroy(admin_login $admin_login)
    {
        
    }
}
