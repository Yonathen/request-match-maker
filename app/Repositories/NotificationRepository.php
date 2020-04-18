<?php 
namespace App\Repositories;

use App\model\User;
use App\Utility\Notification;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Repositories\Interfaces\NotificationRepositoryInterface;

class NotificationRepository implements NotificationRepositoryInterface 
{

     /**
     * @param User $user
     * @param Notification $notification
     */
	public function sendNotification(User $user, Notification $notification)
	{
		$userNotifications = $user->notifications;
		if (!is_null($userNotifications)) {
			array_push($userNotifications, $notification);
		} else {
			$userNotifications = [$notification];
		}
		$user->notifications = $userNotifications;
		return $user->save();
	}

	/**
    * @param User $user
	* @param string $id
	*/
	public function removeNotification(User $user, string $id)
	{
		$notifications = $user->notifications;
		for ( $i = 0; $i < count($notifications); $i++ ) {
			if ($notifications[$i]['id'] === $id) {
				unset($notifications[$i]);
			}
		}
		$user->notifications = $notifications;
		return $user->save();
	}
	
	/**
    * @param User $user
	*/
	public function clearNotification(User $user)
	{
		$user->notifications = [];
		return $user->save();
	}
	
	/**
    * @param User $user
    * @param string $type
    * @param string $email
	*/
	public function searchNotification($user, $type, $email)
	{
		$userNotifications = $user->notifications;
		if ( is_null($userNotifications) || count($userNotifications) === 0 ) {
			return null;
		}

		$result = array_filter($userNotifications, function($value) use ($type, $email) {
			
			return ( 
				!is_null($value['type'] )  && 
				$value['type'] === $type  && 
				!is_null( $value['accessValue']['email'] ) && 
				$value['accessValue']['email'] === $email 
			);
		});

		if (count($result) === 0) {
			return null;
		}

		return $result[0];
	}

}