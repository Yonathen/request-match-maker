<?php 
namespace App\Repositories;

use Illuminate\Support\Facades\Auth; 
use Carbon\Carbon;

use App\model\User;
use App\model\UserPartner;
use App\Enums\PartnerStatus;

use App\Utility\BaseUser;

use App\Repositories\Interfaces\PartnerRepositoryInterface;

class PartnerRepository implements PartnerRepositoryInterface 
{
	/**
	 * @param User $user
	 * @param User $userII
     */
	public function getPartner($userI, $userII)
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
	public function getConfirmedPartners(User $user)
	{
		return UserPartner::where('status', $status = PartnerStatus::CONFIRMED)
				->where(function($query) use ($user) {
					$query->where('requested_by', $user->id)
						->orWhere('confirmed_by', $user->id);
				})
				->with('requestedUser', 'confirmedUser')
				->get();
	}

	/**
	 * @param User $user
     */
	public function getReceivedPartnerRequests(User $user)
	{
		return UserPartner::where('status', PartnerStatus::PENDING)
				->where('confirmed_by', $user->id)
				->with('requestedUser', 'confirmedUser')
				->get();
	}

	/**
	 * @param User $user
     */
	public function getReceivedPartnerRequest($userI, $userII)
	{
		return UserPartner::where('status', PartnerStatus::PENDING)
				->where('requested_by', $userI->id)
				->where('confirmed_by', $userII->id)
				->with('requestedUser', 'confirmedUser')
				->first();
	}

	/**
	 * @param User $user
     */
	public function getSelfPartnerRequests(User $user)
	{
		return UserPartner::where('status', PartnerStatus::PENDING)
				->where('requested_by', $user->id)
				->with('requestedUser', 'confirmedUser')
				->get();
	}

	/**
	 * @param User $user
     */
	public function getBlockedPartners(User $user)
	{
		return UserPartner::where('status', PartnerStatus::BLOCKED)
				->where('requested_by', $user->id)
				->with('requestedUser', 'confirmedUser')
				->get();
	}

	public function blockPartner(User $user, User $partner, UserPartner $partnership)
	{
		$blockedAccounts = $user->blocked_accounts;
		if (!is_null($blockedAccounts)) {
			array_push($blockedAccounts, $partner->id);
		} else {
			$blockedAccounts = [ $partner->id ];
		}
		$user->blocked_accounts = $blockedAccounts;
		$user->save();


		$blockedAccounts = $partner->blocked_accounts;
		if (!is_null($blockedAccounts)) {
			array_push($blockedAccounts, $user->id);
		} else {
			$blockedAccounts = [ $user->id ];
		}
		$partner->blocked_accounts = $blockedAccounts;
		$partner->save();

		$partnership->status = PartnerStatus::BLOCKED;
		return $partnership->save();
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