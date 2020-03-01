<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class sub_event_master extends Model
{
    public $timestamp = false;
    protected $fillable  = ['e_id', 's_e_name', 's_e_discription','status', 's_e_duration']; 
}
