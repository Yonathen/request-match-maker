<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class UserAd extends Model
{
    protected $table = "user_ad";

    public function user() {
    	return $this->belongsTo('App\User');
    }

}
