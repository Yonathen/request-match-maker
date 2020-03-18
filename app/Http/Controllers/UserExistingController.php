<?php

namespace App\Http\Controllers;

use App\Utility\R;
use App\model\User; 
use Illuminate\Http\Request; 
use App\Repositories\Interfaces\UserExistingRepositoryInterface;
use App\Http\Resources\ResponseResource;
use App\Http\Resources\ResponseCollection;
use App\Enums\ReturnType;
use League\Flysystem\Exception;


class UserExistingController extends Controller
{
    use R;
    private $userExistingRepository;

    public function __construct(UserExistingRepositoryInterface $userExistingRepository)
    {
        $this->userExistingRepository = $userExistingRepository;
    }

    public function retrieveUser() {
        $this->type = 'retrieveUser';
        $this->returnType = ReturnType::SINGLE;
        try {
            $this->status = true;
            $retrievedUser = $this->userExistingRepository->getAuthUser();
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
            $user = $this->userExistingRepository->getUser('email', $request->email);

            if ($user->email_verified !== 1) {
                throw (new Exception("Email not verified", 1));
            }

            $useToken = $this->userExistingRepository->accessToken($request->all());
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
            $logedOut = $this->userExistingRepository->logout();
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
            $logedOut = $this->userExistingRepository->logoutFromAllDevice();
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

            $user = $this->userExistingRepository->getUser('email_verification_token', $token);
            if( is_null($user) ){
                throw (new Exception("Invalid token", 1)); 
            }

            if(!$this->userExistingRepository->verifyUser($user)) {
                throw (new Exception("Failed to verify", 1)); 
            }

            $this->returnValue = $user;
            
        } catch (Exception $e) {
            $this->failedRequest($e);
        }

        return $this->getResponse();
    }
}
