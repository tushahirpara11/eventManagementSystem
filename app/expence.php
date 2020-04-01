<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class expence extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'expence_id', 'e_t_id', 'e_id', 's_e_id', 'u_id', 'description',
        'amount', 'status'
    ];
}
