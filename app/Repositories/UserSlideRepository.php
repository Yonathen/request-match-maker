<?php
namespace App\Repositories;

use App\model\User;
use App\Utility\BaseBaseUserSlide;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Repositories\Interfaces\UserSlideRepositoryInterface;

class UserSlideRepository implements UserSlideRepositoryInterface
{

     /**
     * @param User $user
     * @param BaseUserSlide $userSlide
     */
	public function addUserSlide(User $user, BaseUserSlide $userSlide)
	{
		$userSlides = $user->slides;
		if (!is_null($userSlides)) {
			array_push($userSlides, $userSlide);
		} else {
			$userSlides = [$userSlide];
		}
		$user->slides = $userSlides;
		return $user->save();
	}

	/**
    * @param User $user
	* @param string $id
    * @param BaseUserSlide $userSlide
	*/
	public function updateUserSlide(User $user, BaseUserSlide $userSlide)
	{
		$userSlides = $user->slides;
		for ( $i = 0; $i < count($userSlides); $i++ ) {
			if ($userSlides[$i]['id'] === $userSlide->id) {
				$userSlides[$i] = $userSlide;
			}
		}
		$user->slides = $userSlides;
		return $user->save();
	}

	/**
    * @param User $user
	* @param string $id
	*/
	public function removeUserSlide(User $user, string $id)
	{
		$userSlides = $user->slides;
		for ( $i = 0; $i < count($userSlides); $i++ ) {
			if ($userSlides[$i]['id'] === $id) {
				unset($userSlides[$i]);
			}
		}
		$user->slides = $userSlides;
		return $user->save();
	}

}
