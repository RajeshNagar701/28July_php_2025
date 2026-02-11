<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class contact extends Model
{
    // if you not follow rules 

    //public $table="con";  => custom table name
    //public $primarykey="con_id";  => custom primary key 
    //public $timestamps=false;  => no created_at & updated_at
    
    use HasFactory;
}
