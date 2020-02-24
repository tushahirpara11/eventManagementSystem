<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class venue extends Model
{
    public $timestamps = false;
    protected $fillable = ['v_name', 'v_address'];
}
