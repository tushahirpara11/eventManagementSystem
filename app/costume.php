<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class costume extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'costume_id', 's_e_id', 'u_id', 'issuer', 'returner', 'issue_date',
        'return_date', 'status', 's_e_id', 'u_id', 'issuer', 'returner'
    ];
}
