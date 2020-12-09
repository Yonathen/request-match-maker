<?php
namespace App\Repositories;

use App\model\User;
use App\Utility\BaseUserContact;
use App\Enums\FileOperationType;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Repositories\Interfaces\UserContactRepositoryInterface;

class UserContactRepository implements UserContactRepositoryInterface
{

     /**
     * @param User $user
     * @param BaseUserContact $userContact
     */
	public function addUserContact(User $user, BaseUserContact $userContact)
	{
		$userContacts = $user->contacts;
		if (!is_null($userContacts)) {
			array_push($userContacts, $userContact);
		} else {
			$userContacts = [$userContact];
		}
		$user->contacts = $userContacts;
		return $user->save();
	}

	/**
    * @param User $user
    * @param BaseUserContact $userContact
	*/
	public function updateUserContact(User $user, BaseUserContact $userContact)
	{
		$userContacts = $user->contacts;
		foreach ( $userContacts as $key => $value) {
            if ($value['id'] === $userContact->id) {
                if ( $userContact->personPhoto === FileOperationType::Unchanged) {
                    $userContact->personPhoto = $userContacts[$key]['personPhoto'];
                }
				$userContacts[$key] = $userContact;
			}
		}
		$user->contacts = $userContacts;
		return $user->save();
	}

	/**
    * @param User $user
	* @param string $id
	*/
	public function removeUserContact(User $user, string $id)
	{
		$userContacts = $user->contacts;
		foreach ( $userContacts as $key => $value) {
			if ($value['id'] === $id) {
				unset($userContacts[$key]);
				break;
			}
		}
		$user->contacts = $userContacts;
		return $user->save();
	}

}
