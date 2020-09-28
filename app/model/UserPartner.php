<?php

namespace App\model;

use App\model\User;

use Illuminate\Database\Eloquent\Model;

use App\Utility\BaseUser;

class UserPartner extends Model
{
    protected $table = "user_partner";

    protected $hidden = [ 'id', 'requested_by', 'confirmed_by', ];
    
    public function requestedUser() {
    	return $this->belongsTo('App\model\User', 'requested_by')->select(BaseUser::getAttributes());
    }

    public function confirmedUser() {
    	return $this->belongsTo('App\model\User', 'confirmed_by')->select(BaseUser::getAttributes());
    }
    
}
