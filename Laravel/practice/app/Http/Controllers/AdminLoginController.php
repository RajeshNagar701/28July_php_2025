<?php

namespace App\Http\Controllers;

use App\Models\admin_login;
use Illuminate\Http\Request;

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
        //
    }
}
