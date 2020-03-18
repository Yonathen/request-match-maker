<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class RequestMailMatch extends Model
{
    protected $table = "request_mail_match";

    public function user() 
    {
    	return $this->belongsTo('App\User');
    }

    public function request() 
    {
    	return $this->belongsTo('App\Request');
    }
}
