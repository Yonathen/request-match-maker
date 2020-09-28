<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

use App\Utility\BaseUser;

class RequestTrader extends Model
{
    protected $table = "request";

    protected $hidden = [ 'user_id', ];

    public function user() 
    {
    	return $this->belongsTo('App\model\User', 'user_id')->select(BaseUser::getAttributes());
    }

    public function offers()
    {
        return $this->hasMany('App\model\RequestOffer');
    }
}
