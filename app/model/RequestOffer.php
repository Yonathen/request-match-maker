<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class RequestOffer extends Model
{
	protected $table = "request_offer";

    public function user() 
    {
    	return $this->belongsTo('App\User');
    }

    public function request() 
    {
    	return $this->belongsTo('App\Request');
    }
}
