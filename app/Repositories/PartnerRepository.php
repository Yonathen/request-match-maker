<?php 
namespace App\Repositories;

use Illuminate\Support\Facades\Auth; 
use Carbon\Carbon;

use App\model\User;
use App\model\UserPartner;
use App\Enums\PartnerStatus;

use App\Utility\UserBase;

use App\Repositories\Interfaces\PartnerRepositoryInterface;

class PartnerRepository implements PartnerRepositoryInterface 
{
	/**
	 * @param User $user
	 * @param User $userII
     */
	public function getPatner($userI, $userII)
	{
		return UserPartner::where('requested_by', $userI->id)
			->where('confirmed_by', $userII->id)
			->orWhere(function($query) use ($userI, $userII) {
				$query->where('requested_by', $userII->id)
					  ->where('confirmed_by', $userI->id);
			})
			->with('requestedUser', 'confirmedUser')
			->first();
		
	}

	/**
	 * @param User $user
     */
	public function getConfirmedPatners(User $user)
	{
		return UserPartner::where('status', $status = PartnerStatus::CONFIRMED)
				->where(function($query) use ($user) {
					$query->where('requested_by', $user->id)
						->orWhere('confirmed_by', $user->id);
				})
				->with('requestedUser', 'confirmedUser')
				->paginate(10);
	}

	/**
	 * @param User $user
     */
	public function getReceivedPatnerRequests(User $user)
	{
		return UserPartner::where('status', PartnerStatus::PENDING)
				->where('confirmed_by', $user->id)
				->with('requestedUser', 'confirmedUser')
				->paginate(10);
	}

	/**
	 * @param User $user
     */
	public function getSelfPatnerRequests(User $user)
	{
		return UserPartner::where('status', PartnerStatus::PENDING)
				->where('requested_by', $user->id)
				->with('requestedUser', 'confirmedUser')
				->paginate(10);
	}

	/**
	 * @param User $user
     */
	public function getBlockedPatners(User $user)
	{
		return UserPartner::where('status', PartnerStatus::BLOCKED)
				->where('requested_by', $user->id)
				->with('requestedUser', 'confirmedUser')
				->paginate(10);
	}

	/**
     * @param UserPartner $userPartner
     */
	public function savePartner(UserPartner $userPartner)
	{
		return $userPartner->save();
	}

	/**
     * @param UserPartner $userPartner
     */
	public function removePartner(UserPartner $userPartner)
	{
		return UserPartner::destroy($userPartner->id);
	}
	
}