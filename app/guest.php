<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class guest extends Model
{
    public $timestamps = false;
    protected $fillable = ['id', 'name', 'phome', 'email'];
}
