<?php

namespace App\Http\Controllers;

use App\Models\country;
use Illuminate\Http\Request;

class ajaxController extends Controller
{
    
    function ajax(){
        $data=country::all();
        return view('ajax',['data'=>$data]);
    }

}
