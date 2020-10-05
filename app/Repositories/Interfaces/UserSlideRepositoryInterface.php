<?php
namespace App\Repositories\Interfaces;

use App\model\User;
use App\Utility\BaseUserSlide;

interface UserSlideRepositoryInterface
{

     /**
     * @param User $user
     * @param BaseUserSlide $userSlide
     */
	public function addUserSlide(User $user, BaseUserSlide $userSlide);

	/**
    * @param User $user
    * @param BaseUserSlide $userSlide
	*/
	public function updateUserSlide(User $user, BaseUserSlide $userSlide);

	/**
    * @param User $user
	* @param string $id
	*/
	public function removeUserSlide(User $user, string $id);
}
