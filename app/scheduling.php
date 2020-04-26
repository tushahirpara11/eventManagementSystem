<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class scheduling extends Model
{
	public $timestamps = false;
	protected $fillable = ['sched_id','e_id', 'sched_details', 'time'];
}
