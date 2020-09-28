<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

use App\model\User;

use App\Utility\BaseUser;
use App\Utility\BaseRequest;

class RequestOffer extends Model
{
    protected $table = "request_offer";

    protected $hidden = [ 'user_id', ];

    public function user() 
    {
    	return $this->belongsTo('App\model\User')->select(BaseUser::getAttributes());
    }

    public function request() 
    {
    	return $this->belongsTo('App\model\RequestTrader')->select(BaseRequest::getAttributes());
    }
}
