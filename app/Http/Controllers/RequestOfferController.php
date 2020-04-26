<?php

namespace App\Http\Controllers;

use App\model\User; 
use App\model\RequestTraderMail;
use App\model\RequestOffer;

use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\Interfaces\RequestOfferRepositoryInterface;

use Illuminate\Http\Request; 
use App\Http\Resources\ResponseResource;
use App\Http\Resources\ResponseCollection;
use League\Flysystem\Exception;

use App\Utility\R;

use App\Enums\ReturnType;

class RequestOfferController extends Controller
{
    use R;
    private $userRepository;
    private $requestOfferRepository;

    public function __construct(
        UserRepositoryInterface $userRepository,
        RequestOfferRepositoryInterface $requestOfferRepository)
    {
        $this->middleware('auth:api');
        $this->userRepository = $userRepository;
        $this->requestOfferRepository= $requestOfferRepository;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->type = 'updateRequestOffer';
        $this->returnType = ReturnType::SINGLE;
        try {
            $input = $request->json()->all();
            $validator = $this->requestOfferRepository->validator($input);
            $offeringUser = $this->userRepository->getAuthUser();
            if( $validator->fails() ){
                throw (new Exception("Failed to create request offer.", 1));   
            }

            $requestOffer = new RequestOffer;
            $requestOffer->price = $input["price"];
            $requestOffer->currency = $input["currency"];
            $requestOffer->message_exchange = $input["message_exchange"];
            $requestOffer->user_id = $offeringUser->id;
            $requestOffer->request_id = $input["request"]["id"];

            if ( !$this->requestOfferRepository->saveRequestOffer($requestOffer) ) {
                throw (new Exception("Failed to create request offer.", 1));
            } 
            $this->sendOfferNotification($requestOffer, $input);
            $this->returnValue = $requestOffer;

        } catch (Exception $e) {
            $this->failedRequest($e);
        }

        return $this->getResponse();
    }

    public function sendOfferNotification($savedOffer, $input) {
        $notificationType = null;
        $accessValue = [ 
            'offerId' => $savedOffer->id, 
            'user' => ['name' => $input["request"]["user"]["name"], 'email' =>$input["request"]["user"]["email"]], 
            'request' => ['id' => $input["request"]["id"], 'title' => $input["request"]["title"]], 
        ];

        $requestUser =  $this->userRepository->getUser('email', $accessValue["user"]["email"]);
        $notification = new Notification(NotificationType::NEW_OFFER, $accessValue );
        $this->notificationRepository->sendNotification($requestUser, $notification);
        Mail::to($accessValue["user"]["email"])->send(new RequestTraderMail($accessValue, NotificationType::NEW_OFFER));
            
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->type = 'getRequestOffer';
        $this->returnType = ReturnType::SINGLE;
        try {
            $requestOffer = $this->requestOfferRepository->getRequestOfferByConditions(['id' =>  $id]);
            if(is_null($requestOffer)){
                throw (new Exception("Failed to get request offer.", 1));   
            }
            $this->returnValue = $requestOffer;

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
        $this->type = 'updateRequestOffer';
        $this->returnType = ReturnType::SINGLE;
        try {
            $input = $request->json()->all();
            $requestOffer = $this->requestOfferRepository->getRequestOfferByConditions(['id' =>  $id]);
            $validator = $this->requestOfferRepository->validator($input);
            if( is_null($requestOffer) || $validator->fails() ){
                throw (new Exception("Failed to update request offer.", 1));   
            }
            $requestOffer->price = $input["price"];
            $requestOffer->currency = $input["currency"];
            $requestOffer->message_exchange = $input["message_exchange"];

            if ( !$this->requestOfferRepository->saveRequestOffer($requestOffer) ) {
                throw (new Exception("Failed to update request offer.", 1));
            }
            $this->returnValue = $requestOffer;

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
        $this->type = 'deleteRequestOffer';
        $this->returnType = ReturnType::SINGLE;
        try {
            $this->status = false;
            $requestOffer = $this->requestOfferRepository->getRequestOfferByConditions(['id' =>  $id]);
            if (!is_null($requestOffer) && $this->requestOfferRepository->removeRequestOffer($requestOffer) ) {
                $this->status = true;
            }

            if ( !$this->status ) {
                throw (new Exception("Failed to delete request.", 1));
            }

            $this->returnValue = $requestOffer;
        
        } catch (Exception $e) {
            $this->failedRequest($e);
        }

        return $this->getResponse();
    }
}
