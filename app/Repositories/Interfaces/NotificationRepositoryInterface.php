<?php 
namespace App\Repositories\Interfaces;

use App\model\User;
use App\Utility\Notification;

interface NotificationRepositoryInterface
{

     /**
     * @param User $user
     * @param Notification $notification
     */
     public function sendNotification(User $user, Notification $notification);
     
     /**
     * @param User $user
	* @param string $id
	*/
	public function removeNotification(User $user, string $id);

     /**
     * @param User $user
	*/
	public function clearNotification(User $user);
     
}