<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class RequestMatchMaker extends Model
{
    protected $table = "request_match_maker";

    public function user() 
    {
    	return $this->belongsTo('App\User');
    }
}
