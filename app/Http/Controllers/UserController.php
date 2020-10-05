<?php

namespace App\Http\Controllers;
use App\model\User;

use Illuminate\Http\Request;

use App\Http\Resources\ResponseResource;
use App\Http\Resources\ResponseCollection;

use League\Flysystem\Exception;

use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\Interfaces\UserSlideRepositoryInterface;
use App\Repositories\Interfaces\PartnerRepositoryInterface;
use App\Repositories\Interfaces\NotificationRepositoryInterface;
use App\Repositories\Interfaces\FileRepositoryInterface;
use App\Repositories\Interfaces\RequestTraderRepositoryInterface;
use App\Repositories\Interfaces\RequestOfferRepositoryInterface;
use App\Repositories\Interfaces\RequestMailRepositoryInterface;
use App\Repositories\Interfaces\RequestMatchMakerRepositoryInterface;

use App\Enums\ReturnType;
use App\Enums\FileLocations;
use App\Enums\RequestStatus;
use App\Enums\OperationType;

use App\Utility\R;
use App\Utility\BaseUserSlide;

class UserController extends Controller
{
    use R;

    private $fileRepository;
    private $userRepository;
    private $userSlideRepository;
    private $requestTraderRepository;
    private $requestOfferRepository;
    private $requestMailRepository;
    private $requestMatchMakerRepository;
    private $partnerRepository;
    private $notificationRepository;

    protected $userRole;

    public function __construct(
        UserRepositoryInterface $userRepository,
        UserSlideRepositoryInterface $userSlideRepository,
        RequestTraderRepositoryInterface $requestTraderRepository,
        RequestOfferRepositoryInterface $requestOfferRepository,
        RequestMailRepositoryInterface $requestMailRepository,
        RequestMatchMakerRepositoryInterface $requestMatchMakerRepository,
        PartnerRepositoryInterface $partnerRepository,
        NotificationRepositoryInterface $notificationRepository,
        FileRepositoryInterface $fileRepository)
    {
        $this->userRepository = $userRepository;
        $this->userSlideRepository = $userSlideRepository;
        $this->partnerRepository = $partnerRepository;
        $this->notificationRepository = $notificationRepository;
        $this->fileRepository = $fileRepository;
        $this->requestTraderRepository = $requestTraderRepository;
        $this->requestOfferRepository = $requestOfferRepository;
        $this->requestMailRepository = $requestMailRepository;
        $this->requestMatchMakerRepository = $requestMatchMakerRepository;
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

    public function profileById($id = null) {
        $this->type = 'get_profile_by_id';
        $this->returnType = ReturnType::SINGLE;
        try {
            $this->status = true;
            $retrievedUser = $this->userRepository->getUser('id', $id);
            if (is_null($retrievedUser)) {
                throw (new Exception("Failed to retrieve User.", 1));
            }

            $this->returnValue = $retrievedUser;
        } catch (Exception $e) {
            $this->failedRequest($e);
        }

        return $this->getResponse();
    }

    /**
     * @OA\Post(
     *     path="/pet",
     *     tags={"pet"},
     *     summary="Add a new pet to the store",
     *     operationId="addPet",
     *     @OA\Response(
     *         response=405,
     *         description="Invalid input"
     *     ),
     *     security={
     *         {"petstore_auth": {"write:pets", "read:pets"}}
     *     },
     *     requestBody={"$ref": "#/components/requestBodies/Pet"}
     * )
     */
    public function accessAccount(Request $request){
        $this->type = 'accessAccount';
        $this->returnType = ReturnType::SINGLE;
        try {
            $this->status = true;
            $user = $this->userRepository->getUser('email', $request->email);

            if ( is_null($user)) {
                throw (new Exception("Account with this email does not exist.", 1));
            } elseif ($user->email_verified !== 1) {
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
            if( is_null($token) ){
                throw (new Exception("Invalid token", 1));
            }

            $user = $this->userRepository->getUser('email_verification_token', $token);
            if ( is_null($user) ){
                throw (new Exception("Invalid token", 1));
            }

            if ( !$this->userRepository->verifyEmail($user) ) {
                throw (new Exception("Failed to verify", 1));
            }

            $directoryPrefix = FileLocations::PUBLIC . '/'  . $user->id . '/';
            $this->fileRepository->createDirectory($directoryPrefix . FileLocations::PROFILE);
            $this->fileRepository->createDirectory($directoryPrefix . FileLocations::TRADER);

            $this->returnValue = $user;

        } catch (Exception $e) {
            $this->failedRequest($e);
        }

        return $this->getResponse();
    }

      /**
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateProfileDetail(Request $request)
    {
        $this->type = 'updateProfile';
        $this->returnType = ReturnType::SINGLE;
        try {
            $input = $request->json()->all();

            $retrievedUser = $this->userRepository->getAuthUser();
            if( is_null($retrievedUser) ){
                throw (new Exception("Failed to get user.", 1));
            }

            $location = FileLocations::PUBLIC . '/'  . $retrievedUser->id . '/' . FileLocations::PROFILE;
            if ( array_key_exists("logo", $input) ) {
                $fileUpload = $this->fileRepository->fileUploadCroppedImage($input["logo"], $location, 'profile_logo_' . $retrievedUser->id, 'png');
                if ( $fileUpload['status'] ) {
                    $retrievedUser->logo = $fileUpload["content"];
                } else {
                    throw ($fileUpload['content']);
                }
            }

            $retrievedUser->name = $input["name"];
            $retrievedUser->account_created_by = $input["accountCreatedBy"];
            $retrievedUser->email = $input["email"];
            $retrievedUser->gender = $input["gender"];
            $retrievedUser->established_on = $input["establishedOn"];
            $retrievedUser->established_by = $input["establishedBy"];
            $retrievedUser->website = $input["website"];

            if ( !$this->userRepository->saveUser($retrievedUser) ) {
                throw (new Exception("Failed to update user.", 1));
            }
            $this->returnValue = $retrievedUser;

        } catch (Exception $e) {
            $this->failedRequest($e);
        }

        return $this->getResponse();
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateProfileSlide(Request $request)
    {
        $this->type = 'updateProfile';
        $this->returnType = ReturnType::SINGLE;
        try {
            $input = $request->json()->all();

            $retrievedUser = $this->userRepository->getAuthUser();
            if( is_null($retrievedUser) ){
                throw (new Exception("Failed to get user.", 1));
            }

            if ( array_key_exists("image", $input) ) {
                $uploadResult = $this->uploadNewSlide($input["image"]);
                if ($uploadResult["status"]) {
                    $input["image"] = $uploadResult["content"];
                } else {
                    throw (new Exception("Failed to upload image.", 1));
                }
            } else if ($input["action"] === OperationType.ADD) {
                throw (new Exception("Image is mandatory for adding slides.", 1));
            }

            switch ( $input["action"] ) {
                case OperationType.ADD:
                    $userSlide = new BaseUserSlide($input["title"], $input["image"], $input["content"]);
                    if ( !$this->userSlideRepository->addUserSlide($retrievedUser, $userSlide) ) {
                        throw (new Exception("Failed to update slide.", 1));
                    }
                break;
                case OperationType.UPDATE:
                    $userSlide = new BaseUserSlide($input["title"], $input["image"], $input["content"]);
                    $userSlide->id = $input["id"];
                    if ( !$this->userSlideRepository->updateUserSlide($retrievedUser, $userSlide) ) {
                        throw (new Exception("Failed to update slide.", 1));
                    }
                break;
                case OperationType.REMOVE:
                    if ( !$this->userSlideRepository->removeUserSlide($retrievedUser, $input["id"]) ) {
                        throw (new Exception("Failed to remove slide.", 1));
                    }
                break;
            }

            $this->returnValue = $retrievedUser;

        } catch (Exception $e) {
            $this->failedRequest($e);
        }

        return $this->getResponse();
    }

    public function uploadNewSlide($image) {
        $location = FileLocations::PUBLIC . '/'  . $retrievedUser->id . '/' . FileLocations::PROFILE;
        $fileUpload = $this->fileRepository->fileUploadCroppedImage($image, $location, 'profile_slide_' . $retrievedUser->id, 'png');
        return $fileUpload;
    }

    public function removeMyAccount(Request $request) {

    }

    public function forgotAccount(Request $request) {

    }

    /// -- My TRADER -- ///
    public function getMyRequests(Request $request) {
        $this->type = 'getMyRequests';
        try {
            $user = $this->userRepository->getAuthUser();
            $this->returnType = ReturnType::COLLECTION;

            $result = $this->requestTraderRepository->getRequestTraderByUser($user, $request->type);

            if (is_null($result)) {
                throw (new Exception("Failed to get data.", 1));
            }
            $this->returnValue = $result;
        } catch (Exception $e) {
            $this->failedRequest($e);
        }

        return $this->getResponse();
    }

    public function getMyOffers(Request $request) {
        $this->type = 'getMyOffer';
        try {
            $user = $this->userRepository->getAuthUser();
            $this->returnType = ReturnType::COLLECTION;

            $result = $this->requestOfferRepository->getRequestOfferByUser($user, $request->type);

            if (is_null($result)) {
                throw (new Exception("Failed to get data.", 1));
            }
            $this->returnValue = $result;
        } catch (Exception $e) {
            $this->failedRequest($e);
        }

        return $this->getResponse();
    }

    public function getMyMail(Request $request) {
        // This is for archive and mail
        $this->type = 'getMyMail';
        try {
            $user = $this->userRepository->getAuthUser();
            $this->returnType = ReturnType::COLLECTION;

            $result = $this->requestMailRepository->getRequestMailByUser($user, $request->type);

            if (is_null($result)) {
                throw (new Exception("Failed to get data.", 1));
            }
            $this->returnValue = $result;
        } catch (Exception $e) {
            $this->failedRequest($e);
        }

        return $this->getResponse();
    }

    public function getMyMatchmakers(Request $request) {
        $this->type = 'getMyMatchmakers';
        try {
            $user = $this->userRepository->getAuthUser();
            $this->returnType = ReturnType::COLLECTION;

            $result = $this->requestMatchMakerRepository->getRequestMatchMakerByUser($user);

            if (is_null($result)) {
                throw (new Exception("Failed to get data.", 1));
            }
            $this->returnValue = $result;
        } catch (Exception $e) {
            $this->failedRequest($e);
        }

        return $this->getResponse();
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
