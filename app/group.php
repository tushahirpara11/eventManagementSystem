<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class group extends Model
{
    protected $fillable = ['e_id', 's_e_id', 'u_id', 'r_id'];
    public $timestamps = false;
}
