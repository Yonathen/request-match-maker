<?php
namespace App\Repositories\Interfaces;

use App\model\User;
use App\Utility\BaseUserContact;

interface UserContactRepositoryInterface
{

     /**
     * @param User $user
     * @param BaseUserContact $userContact
     */
	public function addUserContact(User $user, BaseUserContact $userContact);

	/**
    * @param User $user
    * @param BaseUserContact $userContact
	*/
	public function updateUserContact(User $user, BaseUserContact $userContact);

	/**
    * @param User $user
	* @param string $id
	*/
	public function removeUserContact(User $user, string $id);
}
