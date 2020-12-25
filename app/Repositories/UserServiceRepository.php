<?php
namespace App\Repositories;

use App\model\User;
use App\Utility\BaseUserService;
use App\Enums\FileOperationType;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Repositories\Interfaces\UserServiceRepositoryInterface;

class UserServiceRepository implements UserServiceRepositoryInterface
{

     /**
     * @param User $user
     * @param BaseUserService $userService
     */
	public function addUserService(User $user, BaseUserService $userService)
	{
		$userServices = $user->service;
		if (!is_null($userServices)) {
			array_push($userServices, $userService);
		} else {
			$userServices = [$userService];
		}
		$user->service = $userServices;
		return $user->save();
	}

	/**
    * @param User $user
    * @param BaseUserService $userService
	*/
	public function updateUserService(User $user, BaseUserService $userService)
	{
		$userServices = $user->service;
		foreach ( $userServices as $key => $value) {
            if ($value['id'] === $userService->id) {
				$userServices[$key] = $userService;
			}
		}
		$user->service = $userServices;
		return $user->save();
	}

	/**
    * @param User $user
	* @param string $id
	*/
	public function removeUserService(User $user, string $id)
	{
		$userServices = $user->service;
		foreach ( $userServices as $key => $value) {
			if ($value['id'] === $id) {
				unset($userServices[$key]);
				break;
			}
		}
		$user->service = $userServices;
		return $user->save();
	}

}
