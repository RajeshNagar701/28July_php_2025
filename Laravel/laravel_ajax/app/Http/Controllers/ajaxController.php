<?php

namespace App\Http\Controllers;

use App\Models\city;
use App\Models\country;
use App\Models\state;
use Illuminate\Http\Request;

class ajaxController extends Controller
{

    function ajax()
    {
        $data = country::all();
        return view('ajax', ['data' => $data]);
    }

    public function getstate($id)
    {
        
        $state_arr = state::where('cid',$id)->get();
        ?>
        <option>---------Select State--------</option>
        <?php
        foreach($state_arr as $r)
        {
        ?>
            <option value="<?php echo $r->id; ?>">
                            <?php echo $r->sname; ?>
            </option>
        <?php 
        }
    }

    public function getcity($id)
    {
        $city_arr = city::where('sid',$id)->get();
        ?>
        <option>---------Select City--------</option>
        <?php
        foreach($city_arr as $r)
        {
        ?>
            <option value="<?php echo $r->id; ?>">
                            <?php echo $r->city_name; ?>
            </option>
        <?php 
        }
   
    }
}
