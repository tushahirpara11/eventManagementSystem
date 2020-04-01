<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class user_master extends Model
{
    protected $fillable=['f_name','l_name','email','phone','password','gender','dob','u_type','enrollmentno','b_id', 's_id','d_id'];
}
