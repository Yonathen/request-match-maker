<?php

namespace App\Http\Controllers;

use App\model\User; 
use App\model\UserPartner;

use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\Interfaces\PartnerRepositoryInterface;
use App\Repositories\Interfaces\NotificationRepositoryInterface;

use Illuminate\Http\Request; 
use App\Http\Resources\ResponseResource;
use App\Http\Resources\ResponseCollection;
use League\Flysystem\Exception;

use App\Utility\R;
use App\Utility\Notification;

use App\Enums\PartnerStatus;
use App\Enums\ReturnType;
use App\Enums\NotificationType;

use App\Mail\PartnerEmail;
use Illuminate\Support\Facades\Mail;

class PartnerController extends Controller
{
    use R;
    private $userRepository;
    private $partnerRepository;
    private $notificationRepository;

    public function __construct(
        UserRepositoryInterface $userRepository,
        PartnerRepositoryInterface $partnerRepository,
        NotificationRepositoryInterface $notificationRepository)
    {
        $this->middleware('auth:api');
        $this->userRepository = $userRepository;
        $this->partnerRepository = $partnerRepository;
        $this->notificationRepository = $notificationRepository;
    }

    public function validateRequest($requestingUser, $confirmingUser)
    {
        return ( !is_null($confirmingUser) &&
            is_null( $this->partnerRepository->getPartner( $requestingUser, $confirmingUser ) ) &&
            $requestingUser->email !== $confirmingUser->email );
    }

    public function requestPartnership(Request $request) {
        $this->type = 'requestPartnership';
        try {
            $requestingUser = $this->userRepository->getAuthUser();
            $confirmingUser = $this->userRepository->getUser('email', $request->email);
            if ( !$this->validateRequest( $requestingUser, $confirmingUser ) ) {
                throw (new Exception("Failed to request partnership.", 1));
            }

            $newPartner = new UserPartner;
            $newPartner->requested_by = $requestingUser->id;
            $newPartner->confirmed_by = $confirmingUser->id;
            $newPartner->status = PartnerStatus::PENDING;
            if ( !$this->partnerRepository->savePartner($newPartner) ) {
                throw (new Exception("Failed to request partnership.", 1));
            }

            $notification = new Notification(NotificationType::NEW_PARTNER_REQUEST, [ "name" => $requestingUser->name, "email" =>$requestingUser->email ]);
            $this->notificationRepository->sendNotification($confirmingUser, $notification);

            Mail::to($confirmingUser->email)->send(new PartnerEmail($requestingUser, $confirmingUser, NotificationType::NEW_PARTNER_REQUEST));

            $this->returnValue = $newPartner;
        } catch (Exception $e) {
            $this->failedRequest($e);
        }

        return $this->getResponse();
    }

    public function validateConfirm($requestingUser, $confirmingUser, $partnerToConfrim)
    {
        $partnerToConfrim = $this->partnerRepository->getPartner( $requestingUser, $confirmingUser );
        return ( 
            !is_null($requestingUser) &&
            !( is_null( $partnerToConfrim ) && $partnerToConfrim->confirmed_by !== $confirmingUser->id ) &&
            $requestingUser->email !== $confirmingUser->email &&
            $partnerToConfrim->confirmed_by 
        );
    }

    public function confirmPartner(Request $request) {
        $this->type = 'confirm_request';
        try {
            $confirmingUser = $this->userRepository->getAuthUser();
            $requestingUser = $this->userRepository->getUser( 'email', $request->email );
            $partnerToConfrim = $this->partnerRepository->getReceivedPartnerRequest( $requestingUser, $confirmingUser );
            if ( is_null($partnerToConfrim) ) {
                throw (new Exception("Failed to confirm partnership.", 1));
            }

            $partnerToConfrim->status = PartnerStatus::CONFIRMED;
            if ( !$this->partnerRepository->savePartner( $partnerToConfrim ) ) {
                throw (new Exception("Failed to confirm partnership.", 1));
            }

            $notification = new Notification(NotificationType::NEW_PARTNER, [ "name" => $confirmingUser->name, "email" =>$confirmingUser->email ]);
            $this->notificationRepository->sendNotification($requestingUser, $notification);


            Mail::to($requestingUser->email)->send(new PartnerEmail($requestingUser, $confirmingUser, NotificationType::NEW_PARTNER));

            $this->returnValue = $partnerToConfrim;
        } catch (Exception $e) {
            $this->failedRequest($e);
        }

        return $this->getResponse();
    }

    public function removePartner(Request $request) {
        $this->type = 'removePartner';
        try {
            $authUser = $this->userRepository->getAuthUser();
            $partnerUser = $this->userRepository->getUser( 'email', $request->email );
            $partnerToRemove = $this->partnerRepository->getPartner( $authUser, $partnerUser );
            if (is_null($partnerUser) || is_null( $partnerToRemove ) ) {
                throw (new Exception("Failed to remove partnership.", 1));
            }

            if ( !$this->partnerRepository->removePartner($partnerToRemove) ) {
                throw (new Exception("Failed to remove partnership.", 1));
            }
            
            $this->removePartnerNotifications($partnerUser, $authUser->email);
            $this->removePartnerNotifications($authUser, $partnerUser->email);
            
            $this->returnValue = $partnerToRemove;
        } catch (Exception $e) {
            $this->failedRequest($e);
        }

        return $this->getResponse();

    }

    public function removePartnerNotifications($user, $email) {
        $notificationResult = $this->notificationRepository->searchNotification($user, NotificationType::NEW_PARTNER, $email);
        if ( is_null ( $notificationResult ) ) {
            $notificationResult = $this->notificationRepository->searchNotification($user, NotificationType::NEW_PARTNER_REQUEST, $email);
        }

        
        if ( !is_null ( $notificationResult ) ) {
            $this->notificationRepository->removeNotification($user, $notificationResult['id']);
        }
    }

    public function blockPartner(Request $request) {
        $this->type = 'blockPartner';
        try {
            $authUser = $this->userRepository->getAuthUser();
            $partnerUser = $this->userRepository->getUser( 'email', $request->email );
            $partnerToBlock = $this->partnerRepository->getPartner( $authUser, $partnerUser );
            if (is_null($partnerUser) || is_null( $partnerToBlock ) ) {
                throw (new Exception("Failed to confirm partnership.", 1));
            }

            $partnerToBlock->status = PartnerStatus::BLOCKED;
            if ( !$this->partnerRepository->savePartner( $partnerToBlock ) ) {
                throw (new Exception("Failed to confirm partnership.", 1));
            }

            $this->returnValue = $partnerToBlock;
        } catch (Exception $e) {
            $this->failedRequest($e);
        }

        return $this->getResponse();
    }
}
