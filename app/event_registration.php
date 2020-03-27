<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class event_registration extends Model
{
    protected $fillable=['s_e_id','u_id','r_id','g_id','status'];
}
