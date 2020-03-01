<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class role extends Model
{

    public $timestamps = false;
    protected $fillable = [
        'r_name'
    ];
}
