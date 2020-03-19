<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class UserActivity extends Model
{
    protected $table = "user_activity";

    public function user() {
    	return $this->belongsTo('App\User');
    }

}
