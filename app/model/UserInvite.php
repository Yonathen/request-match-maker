<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class UserInvite extends Model
{
    protected $table = "user_invite";
    
    public function user() {
    	return $this->belongsTo('App\User');
    }
}
