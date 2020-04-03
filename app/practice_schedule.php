<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class practice_schedule extends Model
{
    public $timestamps = false;
    protected $fillable = ['p_id', 's_e_id', 'participants', 'u_id', 'description', 'date', 'time'];
}
