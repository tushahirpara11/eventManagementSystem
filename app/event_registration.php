<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class event_registration extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'e_r_id', 's_e_id', 'u_id', 'r_id', 'g_id', 'status'
    ];
}
