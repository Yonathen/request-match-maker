<?php
namespace App\Repositories\Interfaces;

use App\model\User;
use App\Utility\BaseUserInterview;

interface UserInterviewRepositoryInterface
{

     /**
     * @param User $user
     * @param BaseUserInterview $userInterview
     */
	public function addUserInterview(User $user, BaseUserInterview $userInterview);

	/**
    * @param User $user
    * @param BaseUserInterview $userInterview
	*/
	public function updateUserInterview(User $user, BaseUserInterview $userInterview);

	/**
    * @param User $user
	* @param string $id
	*/
	public function removeUserInterview(User $user, string $id);
}
