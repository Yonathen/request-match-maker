<?php

namespace App\Http\Controllers;

use App\model\User; 
use App\model\RequestMailMatch;

use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\Interfaces\RequestMailRepositoryInterface;
use App\Repositories\Interfaces\NotificationRepositoryInterface;

use Illuminate\Http\Request; 
use App\Http\Resources\ResponseResource;
use App\Http\Resources\ResponseCollection;
use League\Flysystem\Exception;

use App\Utility\R;
use App\Utility\Notification;
use App\Utility\Address;

use App\Enums\NotificationType;
use App\Enums\RequestMailStatus;
use App\Enums\RequestMailType;
use App\Enums\ReturnType;

class RequestMailController extends Controller
{
    use R;
    private $userRepository;
    private $requestMailRepository;
    private $notificationRepository;

    public function __construct(
        UserRepositoryInterface $userRepository,
        RequestMailRepositoryInterface $requestMailRepository,
        NotificationRepositoryInterface $notificationRepository)
    {
        $this->middleware('auth:api');
        $this->userRepository = $userRepository;
        $this->requestMailRepository= $requestMailRepository;
        $this->notificationRepository = $notificationRepository;
    }

    /*
     Store a newly created resource in storage.
     
      @param  \Illuminate\Http\Request  $request
      @return \Illuminate\Http\Response
     
    public function store(Request $request)
    {
        $this->type = 'createMail';
        $this->returnType = ReturnType::SINGLE;
        try {
            
            $this->status = true;
            $input = $request->all();

            $sharingUser = null;
            if ($input->type === RequestMailType::SHARED) {
                $sharingUser = $this->userRepository->getUser('email', $input->sharedByEmail);
            }

            $user = $this->userRepository->getUser('email', $input->email);
            $validator = $this->requestMailRepository->validator($input);
            if ( is_null($user) || ( $input->type === RequestMailType::SHARED && is_null($sharingUser) ) ) {
                throw (new Exception("Failed to create request mail.", 1));
            }  else if($validator->fails()){
                throw (new Exception($validator->errors(), 1));   
            }

            $requestMail = new RequestMailMatch;

            $requestMail->user_id = $user->id;
            $requestMail->request_id = $input->request_id;
            $requestMail->type = $input->type;
            $requestMail->status = RequestMailStatus::NEW;
            if ( $input->type === RequestMailType::SHARED ) {
                $requestMail->shared_by = $sharingUser->id;
            }

            if ( !$this->requestMailRepository->saveRequestMail($requestMail) ) {
                throw (new Exception("Failed to create request mail.", 1));
            } 
            $this->sendNotification($requestMail);
            $this->returnValue = $requestMail;
        } catch (Exception $e) {
            $this->failedRequest($e);
        }

        return $this->getResponse();
    }

    public function sendNotification($requestMail) {
        $notificationType = null;
        $accessValue = [ 
            'mailId' => $requestMail->id, 
            'user' => ['name' => $requestMail->user->name, 'email' =>$requestMail->user->email], 
            'request' => ['id' => $requestMail->request->id, 'title' => $requestMail->request->title], 
        ];
        if ( $requestMail->type === RequestMailType::SHARED ) {
            $notificationType = NotificationType::NEW_REQUEST_MAIL_SHARED;
            $accessValue['sharedBy'] = ['name' => $requestMail->sharedBy->name, 'email' =>$requestMail->sharedBy->email];
        } elseif ( $requestMail->type === RequestMailType::MATCH ) {
            $notificationType = NotificationType::NEW_REQUEST_MAIL_MATCH;
        }

        if (  !is_null ($notificationType) ) {
            $notification = new Notification($notificationType, $accessValue );
            $this->notificationRepository->sendNotification($confirmingUser, $notification);
            Mail::to($accessValue["user"]["email"])->send(new RequestTraderMail($accessValue, $notificationType));
        }
    }*/

    public function store(Request $request)
    {
        $this->type = 'createMail';
        $this->returnType = ReturnType::SINGLE;
        try {
            
            $this->status = true;
            $requestMail = $this->requestMailRepository->createMail($request->all());
            
            if ( !is_null($requestMail) ) {
                throw (new Exception("Failed to create request mail.", 1));
            } 
            
            $this->returnValue = $requestMail;
        } catch (Exception $e) {
            $this->failedRequest($e);
        }

        return $this->getResponse();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->type = 'getRequestMail';
        $this->returnType = ReturnType::SINGLE;
        try {
            $requestMail = $this->requestMailRepository->getRequestMailByConditions(['id' =>  $id]);
            if(is_null($requestMail)){
                throw (new Exception("Failed to get request mail.", 1));   
            }
            $this->returnValue = $requestMail;

        } catch (Exception $e) {
            $this->failedRequest($e);
        }

        return $this->getResponse();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->type = 'updateRequestMail';
        $this->returnType = ReturnType::SINGLE;
        try {
            $input = $request->all();
            $requestMail = $this->requestMailRepository->getRequestMailByConditions(['id' =>  $id]);
            if(is_null($requestMail) || is_null($input->status)){
                throw (new Exception("Failed to update request mail.", 1));   
            }
            $requestMail->status = $input->status;

            if ( !$this->requestMailRepository->saveRequestMail($requestMail) ) {
                throw (new Exception("Failed to update request mail.", 1));
            }
            $this->returnValue = $requestMail;

        } catch (Exception $e) {
            $this->failedRequest($e);
        }

        return $this->getResponse();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->type = 'deleteRequestMail';
        $this->returnType = ReturnType::SINGLE;
        try {
            $this->status = false;
            $requestMail = $this->requestMailRepository->getRequestMailByConditions(['id' =>  $id]);
            if (!is_null($requestMail) && $this->requestMailRepository->removeRequestMail($requestMail) ) {
                $this->status = true;
            }

            if ( !$this->status ) {
                throw (new Exception("Failed to delete request mail.", 1));
            }

            $this->returnValue = $requestMail;
        
        } catch (Exception $e) {
            $this->failedRequest($e);
        }

        return $this->getResponse();
    }
}
