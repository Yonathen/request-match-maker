<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

use App\Utility\BaseUser;
use App\Utility\BaseRequest;

class RequestMailMatch extends Model
{
    protected $table = "request_mail_match";

    protected $hidden = [ 'request_id', 'user_id', 'shared_by', ];

    public function user() 
    {
    	return $this->belongsTo('App\model\User')->select(BaseUser::getAttributes());
    }

    public function sharedByUser() 
    {
    	return $this->belongsTo('App\model\User')->select(BaseUser::getAttributes());
    }

    public function request() 
    {
    	return $this->belongsTo('App\model\RequestTrader')->select(BaseRequest::getAttributes());
    }
}
