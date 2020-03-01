<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class choreographer extends Model
{
    public $timestamps = false;
    protected $fillable = ['s_e_id', 'c_name', 'c_phone','c_email']; 
}
