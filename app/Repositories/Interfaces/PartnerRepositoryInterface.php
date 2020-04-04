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
	public function getPatner($userI, $userII);

	/**
	 * @param User $user
     */
	public function getConfirmedPatners(User $user);

	/**
	 * @param User $user
     */
	public function getReceivedPatnerRequests(User $user);

	/**
	 * @param User $user
     */
	public function getSelfPatnerRequests(User $user);

	/**
	 * @param User $user
     */
	public function getBlockedPatners(User $user);

	/**
     * @param UserPartner $userPartner
     */
	public function savePartner(UserPartner $userPartner);

	/**
     * @param UserPartner $userPartner
     */
	public function removePartner(UserPartner $userPartner);

}
