<?php
namespace App\Repositories;

use App\model\User;
use App\Utility\BaseUserInterview;
use App\Enums\FileOperationType;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Repositories\Interfaces\UserInterviewRepositoryInterface;

class UserInterviewRepository implements UserInterviewRepositoryInterface
{

     /**
     * @param User $user
     * @param BaseUserInterview $userInterview
     */
	public function addUserInterview(User $user, BaseUserInterview $userInterview)
	{
		$userInterviews = $user->representative;
		if (!is_null($userInterviews)) {
			array_push($userInterviews, $userInterview);
		} else {
			$userInterviews = [$userInterview];
		}
		$user->representative = $userInterviews;
		return $user->save();
	}

	/**
    * @param User $user
    * @param BaseUserInterview $userInterview
	*/
	public function updateUserInterview(User $user, BaseUserInterview $userInterview)
	{
		$userInterviews = $user->representative;
		foreach ( $userInterviews as $key => $value) {
            if ($value['id'] === $userInterview->id) {
				$userInterviews[$key] = $userInterview;
			}
		}
		$user->representative = $userInterviews;
		return $user->save();
	}

	/**
    * @param User $user
	* @param string $id
	*/
	public function removeUserInterview(User $user, string $id)
	{
		$userInterviews = $user->representative;
		foreach ( $userInterviews as $key => $value) {
			if ($value['id'] === $id) {
				unset($userInterviews[$key]);
				break;
			}
		}
		$user->representative = $userInterviews;
		return $user->save();
	}

}
