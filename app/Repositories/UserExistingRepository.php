<?php 
namespace App\Repositories;

use App\Repositories\Interfaces\UserExistingRepositoryInterface;
use App\model\User;
use Illuminate\Support\Facades\Auth; 
use Carbon\Carbon;

class UserExistingRepository implements UserExistingRepositoryInterface 
{

	/**
     * @return User $user
     */
	public function getAuthUser()
	{
		return Auth::user();
	}

	/**
	 * @param string $column_name
	 * @param string $email
     * @return User $user
     */
	public function getUser($column_name, $email)
	{
		return User::where($column_name, $email)->first();
	}

	/**
     * @param array $data
     */
	public function accessToken($data)
    {
		if( Auth::attempt( [ 'email' => $data['email'], 'password' => $data['password'] ] ) ){ 
			$user = Auth::user(); 
			return [ 'token' => $user->createToken('MyYukel')-> accessToken]; 
		}
		return null;
    }

	public function logout()
    {
		if (Auth::check()) {
			$token = Auth::user()->token();
			$token->revoke();
			return true;
		}
		return null;
    }

    public function logoutFromAllDevice()
	{ 
	    if (Auth::check()) {
	       Auth::user()->AauthAcessToken()->delete();
	       return true;
	    }

		return null;
	}



    /**
     * @param User $user
     */
    public function verifyEmail(User $user)
    {
    	$user ->email_verified = 1;
        $user ->email_verified_at = Carbon::now();
        $user ->email_verification_token = '';
        return $user->save();
    }

}