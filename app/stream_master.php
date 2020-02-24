<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class stream_master extends Model
{
    public $timestamps = false;
    protected $fillable = ['b_id','s_name'];
}
