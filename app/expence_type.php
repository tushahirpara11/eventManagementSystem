<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class expence_type extends Model
{
    public $timestamps = false;
    protected $fillable = ['e_t_id', 'name'];
}
