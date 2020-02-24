<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class division_master extends Model
{
    public $timestamps = false;
    protected $fillable = ['s_id', 'd_name'];
}
