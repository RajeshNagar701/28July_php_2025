<?php

namespace App\Http\Controllers;

use App\Models\admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function admin_login()
    {
        return view('admin.index');
    }

    public function admin_auth(Request $request)
    {
        $data = admin::where('email', $request->email)->first();
        if ($data) {                    // your value  === enc_value
            if (!(Hash::check($request->password, $data->password))) {
                Alert::error('Failed', 'Login Failed Due to Wrong Password');
                return back();
            } else {
                //create session 
                session()->put('admin_id', $data->id);
                session()->put('admin_name', $data->name);

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
        session()->pull('admin_name');
        Alert::success('Success', 'Logout Success');
        return redirect('/admin_login');
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
     * @param  \App\Models\admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function show(admin $admin)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function edit(admin $admin)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, admin $admin)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function destroy(admin $admin)
    {
        //
    }
}
