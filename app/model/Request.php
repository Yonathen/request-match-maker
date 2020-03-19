<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    protected $table = "request";

    public function user() 
    {
    	return $this->belongsTo('App\User');
    }
}
