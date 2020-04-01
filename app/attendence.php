<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class attendence extends Model
{
    public $timestamps = false;
    protected $fillable = ['s_e_id', 'u_id', 'present', 'date'];
}
