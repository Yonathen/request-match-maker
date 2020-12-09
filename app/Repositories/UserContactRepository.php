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
		for ( $i = 0; $i < count($userContacts); $i++ ) {
            if ($userContacts[$i]['id'] === $userContact->id) {
                if ( $userContact->personPhoto === FileOperationType::Unchanged) {
                    $userContact->personPhoto = $userContacts[$i]['personPhoto'];
                }
				$userContacts[$i] = $userContact;
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
		for ( $i = 0; $i < count($userContacts); $i++ ) {
			print_r($userContacts[$i]);
			if ($userContacts[$i]['id'] === $id) {
				unset($userContacts[$i]);
				break;
			}
		}
		$user->contacts = $userContacts;
		return $user->save();
	}

}
