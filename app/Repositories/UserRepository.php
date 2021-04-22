<?php
namespace App\Repositories;

use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Support\Facades\Validator;
use App\model\User;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

use App\Utility\BaseUser;

class UserRepository implements UserRepositoryInterface
{

	/**
     * @return User $user
     */
	public function getAuthUser()
	{
		return Auth::user();
    }

    /**
	 * @param  array  $data
     */
    public function validator(array $data)
    {
        return Validator::make($data, [
			'name' => ['required', 'string', 'max:200'],
            'email' => ['required', 'string'],
            'account_created_by' => ['required']
        ]);
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

     /**
     * @param User $user
     */
	public function saveUser(User $user)
	{
		return $user->save();
	}
	
     /**
     * @param User $user
	 * @param string keyword
     */
	public function searchUsersByKeyword(User $user, $keyword)
	{
		$blockedAccounts = $user->blocked_accounts;
		if (is_null($blockedAccounts)) {
			$blockedAccounts = array();
		} else {
			$blockedAccounts = json_decode($blockedAccounts);
		}
		return User::select(BaseUser::getAttributes())
			->where('id', '!=', $user->id)
			->whereNotIn('id', $blockedAccounts)
			->where(function($query) use ($keyword) {
				$query->where('name', 'LIKE', "%{$keyword}%") 
					->orWhere('email', 'LIKE', "%{$keyword}%") 
					->orWhere('website', 'LIKE', "%{$keyword}%");
			})
			->paginate(10);
	}
	
	/**
	* @param User $user
	*/
   public function getAllUser(User $user)
   {
	   return User::select(BaseUser::getAttributes())
		   ->where('id', '!=', $user->id)
		   ->paginate(10);
   }

}
