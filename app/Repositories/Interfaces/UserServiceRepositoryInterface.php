<?php
namespace App\Repositories\Interfaces;

use App\model\User;
use App\Utility\BaseUserService;

interface UserServiceRepositoryInterface
{

     /**
     * @param User $user
     * @param BaseUserService $userService
     */
	public function addUserService(User $user, BaseUserService $userService);

	/**
    * @param User $user
    * @param BaseUserService $userService
	*/
	public function updateUserService(User $user, BaseUserService $userService);

	/**
    * @param User $user
	* @param string $id
	*/
	public function removeUserService(User $user, string $id);
}
