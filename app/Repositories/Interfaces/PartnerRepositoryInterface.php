<?php 
namespace App\Repositories\Interfaces;

use App\model\User;
use App\model\UserPartner;

interface PartnerRepositoryInterface
{
    /**
	 * @param User $userI
	 * @param User $userII
     */
	public function getPartner($userI, $userII);

	/**
	 * @param User $user
     */
	public function getConfirmedPartners(User $user);

	/**
	 * @param User $user
     */
	public function getReceivedPartnerRequests(User $user);

	/**
	 * @param User $user
     */
	public function getSelfPartnerRequests(User $user);

	/**
	 * @param User $user
     */
	public function getBlockedPartners(User $user);

	/**
     * @param UserPartner $userPartner
     */
	public function savePartner(UserPartner $userPartner);

	/**
     * @param UserPartner $userPartner
     */
	public function removePartner(UserPartner $userPartner);

}
