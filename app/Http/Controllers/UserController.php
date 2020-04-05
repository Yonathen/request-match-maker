<?php

namespace App\Http\Controllers;
use App\model\User; 
use Illuminate\Http\Request; 
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\Interfaces\PartnerRepositoryInterface;
use App\Repositories\Interfaces\NotificationRepositoryInterface;
use App\Http\Resources\ResponseResource;
use App\Http\Resources\ResponseCollection;
use App\Enums\ReturnType;
use League\Flysystem\Exception;
use App\Utility\R;

class UserController extends Controller
{
    use R;

    private $userRepository;
    private $partnerRepository;
    private $notificationRepository;
    protected $userRole;

    public function __construct(
        UserRepositoryInterface $userRepository, 
        PartnerRepositoryInterface $partnerRepository,
        NotificationRepositoryInterface $notificationRepository)
    {
        $this->userRepository = $userRepository;
        $this->partnerRepository = $partnerRepository;
        $this->notificationRepository = $notificationRepository;
    }
    
    public function profile() {
        $this->type = 'proifile';
        $this->returnType = ReturnType::SINGLE;
        try {
            $this->status = true;
            $retrievedUser = $this->userRepository->getAuthUser();
            if (is_null($retrievedUser)) {
                throw (new Exception("Failed to retrieve User.", 1));
            }
            
            $this->returnValue = $retrievedUser;
        } catch (Exception $e) {
            $this->failedRequest($e);
        }

        return $this->getResponse();
    }
    
    public function accessAccount(Request $request){ 
        $this->type = 'accessAccount';
        $this->returnType = ReturnType::SINGLE;
        try {
            $this->status = true;
            $user = $this->userRepository->getUser('email', $request->email);

            if ($user->email_verified !== 1) {
                throw (new Exception("Email not verified", 1));
            }

            $userToken = $this->userRepository->accessToken($request->all());
            if (is_null($userToken)) {
                throw (new Exception("Failed to access account.", 1));
            }
            
            $this->returnValue = $userToken;
        } catch (Exception $e) {
            $this->failedRequest($e);
        }

        return $this->getResponse();
    }

    public function logout(Request $request){ 
        $this->type = 'logoutAccount';
        $this->returnType = ReturnType::SINGLE;
        try {
            $this->status = true;
            $logedOut = $this->userRepository->logout();
            if (is_null($logedOut)) {
                throw (new Exception("User loged out.", 1));
            }
        } catch (Exception $e) {
            $this->failedRequest($e);
        }

        return $this->getResponse();
    }


    public function logoutFromAllDevice(Request $request){ 
        $this->type = 'logoutFromAllDevice';
        $this->returnType = ReturnType::SINGLE;
        try {
            $this->status = true;
            $logedOut = $this->userRepository->logoutFromAllDevice();
            if (is_null($logedOut)) {
                throw (new Exception("User loged out.", 1));
            }
        } catch (Exception $e) {
            $this->failedRequest($e);
        }

        return $this->getResponse();
    }

    public function verifyEmail($token = null) {
        $this->type = 'createAccount';
        $this->returnType = ReturnType::SINGLE;
        try {
            $this->status = true;
            if(is_null($token)){
                throw (new Exception("Invalid token", 1)); 
            }

            $user = $this->userRepository->getUser('email_verification_token', $token);
            if( is_null($user) ){
                throw (new Exception("Invalid token", 1)); 
            }

            if(!$this->userRepository->verifyEmail($user)) {
                throw (new Exception("Failed to verify", 1)); 
            }

            $this->returnValue = $user;
            
        } catch (Exception $e) {
            $this->failedRequest($e);
        }

        return $this->getResponse();
    }
    
    public function removeMyAccount(Request $request) {
        
    }

    public function forgotAccount(Request $request) {
        
    }

    /// -- My TRADER -- ///
    public function getMyRequests(Request $request) {

    }

    public function getMyOffers(Request $request) {

    }

    public function getMyMail(Request $request) {

    }

    public function getMyMatchmakers(Request $request) {
        
    }

    public function getMyArchives(Request $request) {
        
    }

    /// -- My PARTNERSHIP -- ///
    public function getPartnerData(Request $request) {
        $this->type = 'getPartnerdata';
        try {
            $user = $this->userRepository->getAuthUser();
            $this->returnType = ReturnType::COLLECTION;
            $result = null;
            switch($request->type)
            {
                case 'MyPartners':
                    $result = $this->partnerRepository->getConfirmedPatners($user);
                break;
                case 'MyPartnerRequests':
                    $result = $this->partnerRepository->getSelfPatnerRequests($user);
                break;
                case 'MyRecivedRequests':
                    $result = $this->partnerRepository->getReceivedPatnerRequests($user);
                break;
                case 'MyBlockedPartners':
                    $result = $this->partnerRepository->getBlockedPatners($user);
                break;
            }
            
            if (is_null($result)) {
                throw (new Exception("Failed to get data.", 1));
            }
            print_r($result);
            $this->returnValue = $result;
        } catch (Exception $e) {
            $this->failedRequest($e);
        }

        return $this->getResponse();
    }

    /// -- MISCELLANEOUS -- ///

    public function getMyInvitations(Request $request) {

    }

    public function getMyNotifications(Request $request) {
        $this->type = 'getMyInvitations';
        try {
            $user = $this->userRepository->getAuthUser();
            $this->returnValue = !is_null( $user->notifications ) ? $user->notifications : [];
        } catch (Exception $e) {
            $this->failedRequest($e);
        }

        return $this->getResponse();
    }

}
