<?php

namespace App\Http\Controllers;

use App\model\User; 

use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\Interfaces\NotificationRepositoryInterface;

use Illuminate\Http\Request; 
use App\Http\Resources\ResponseResource;
use App\Http\Resources\ResponseCollection;
use League\Flysystem\Exception;

use App\Utility\R;
use App\Utility\Notification;

use App\Enums\ReturnType;
use App\Enums\NotificationType;

class NotificationController extends Controller
{
    use R;
    private $userRepository;
    private $notificationRepository;

    public function __construct(
        UserRepositoryInterface $userRepository,
        NotificationRepositoryInterface $notificationRepository)
    {
        $this->middleware('auth:api');
        $this->userRepository = $userRepository;
        $this->notificationRepository = $notificationRepository;
    }

    public function clearMyNotifications() {
        $this->type = 'clearNotifications';
        try {
            $user = $this->userRepository->getAuthUser();
            $this->notificationRepository->clearNotification($user);
            $this->returnValue = $user->notifications;
        } catch (Exception $e) {
            $this->failedRequest($e);
        }

        return $this->getResponse();
    }

    public function removeNotifications($id = null) {
        $this->type = 'removeNotifications';
        try {
            $user = $this->userRepository->getAuthUser();
            $this->notificationRepository->removeNotification($user, $id);
            $this->returnValue = $user->notifications;
        } catch (Exception $e) {
            $this->failedRequest($e);
        }

        return $this->getResponse();
    }
}
