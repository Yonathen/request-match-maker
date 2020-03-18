<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class UserFeedback extends Model
{
    protected $table = "user_feedback";

    
    public function user() {
    	return $this->belongsTo('App\User');
    }
}
