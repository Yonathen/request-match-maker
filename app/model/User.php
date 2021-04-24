<?php

namespace App\model;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Support\Facades\Auth; 

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, Notifiable;

    protected $table = "user";

    protected $attributes = [
        'gender' => 'Male',
    ];

    protected $fillable = [
        'name', 'account_created_by', 'email', 'password', 'gender', 'email_verification_token',
    ];

    protected $hidden = [ 'password', 'remember_token', 'email_verification_token', ];

    protected $casts = [
        'representative' => 'array', 'service' => 'array', 'address' => 'array',
        'slides' => 'array', 'blocked_accounts' => 'array', 'contacts' => 'array', 
        'notifications' => 'array',
    ];

    public function AauthAcessToken(){
        return $this->hasMany('App\model\OauthAccessToken');
    }

    public function userActivity()
    {
    	return $this->hasMany('App\model\UserActivity');
    }

    public function userAd()
    {
    	return $this->hasMany('App\model\UserAd');
    }

    public function userFeedback()
    {
    	return $this->hasMany('App\model\UserFeedback');
    }

    public function userInvite()
    {
    	return $this->hasMany('App\model\UserInvite');
    }

    public function userConfirmedPartner()
    {
    	return $this->hasMany('App\model\UserPartner', 'confirmed_by');
    }

    public function userRequestedPartner()
    {
    	return $this->hasMany('App\model\UserPartner', 'requested_by');
    }

    public function userRequestMatchMaker()
    {
        return $this->hasMany('App\model\RequestMatchMaker');
    }

    public function userRequestMailMatch()
    {
        return $this->hasMany('App\model\RequestMailMatch');
    }

    public function userRequestOffer()
    {
        return $this->hasMany('App\model\RequestOffer');
    }

    public function userRequest()
    {
        return $this->hasMany('App\model\RequestTrader');
    }

}
