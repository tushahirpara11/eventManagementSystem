<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class branchMaster extends Model
{
    public $timestamps = false;
    protected $fillable = ['b_code', 'b_name'];
}
