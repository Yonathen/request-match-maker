<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

use App\Utility\BaseUser;

class RequestMatchMaker extends Model
{
    protected $table = "request_match_maker";

    protected $hidden = [ 'user_id', ];

    protected $casts = [
        'keywords' => 'array', 'location' => 'array',
    ];

    public function user() 
    {
    	return $this->belongsTo('App\model\User')->select(BaseUser::getAttributes());
    }
}
