<?php

namespace App\model;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, Notifiable;
    
    protected $table = "user";

    protected $attributes = [
        'gender' => 'Male',
    ];

    protected $fillable = [ 
        'name', 'account_created_on', 'email', 'password', 'gender', 'email_verification_token',
    ];

    public function AauthAcessToken(){
        return $this->hasMany('App\model\OauthAccessToken');
    }

    protected $hidden = [ 'password', 'remember_token', ];

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
        return $this->hasMany('App\model\Request');
    }

    
}
