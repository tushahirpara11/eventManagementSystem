<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class event_master extends Model
{
	public $timestamps = false;
	protected $fillable = [
		'e_name', 'e_discription', 'b_id', 'v_id', 'e_start_date', 'e_end_date', 'e_start_time', 'e_end_time', 'e_status',
	];
}
