<?php

namespace App\model;

use App\model\User;

use Illuminate\Database\Eloquent\Model;

class UserPartner extends Model
{
    protected $table = "user_partner";

    protected $hidden = [ 'id', 'requested_by', 'confirmed_by', ];

    private $userBase = ['id', 'name', 'email', 'logo', 'address', 'website', 'language'];
    
    public function requestedUser() {
    	return $this->belongsTo('App\model\User', 'requested_by')->select($this->userBase);
    }

    public function confirmedUser() {
    	return $this->belongsTo('App\model\User', 'confirmed_by')->select($this->userBase);
    }
    
}
