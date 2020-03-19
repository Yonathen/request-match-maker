<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class UserPartner extends Model
{
    protected $table = "user_partner";
    
    public function user() {
    	return $this->belongsTo('App\User');
    }
}
