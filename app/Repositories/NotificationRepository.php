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
		$notifications = $user->notifications;
		if (!is_null($notifications)) {
			array_push($notifications, $notification);
		} else {
			$notifications = [$notification];
		}
		$user->notifications = $notification;
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

}