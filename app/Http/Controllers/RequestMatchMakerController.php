<?php

namespace App\Http\Controllers;

use App\model\User; 
use App\model\RequestMatchMaker;

use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\Interfaces\RequestMatchMakerRepositoryInterface;

use Illuminate\Http\Request; 
use App\Http\Resources\ResponseResource;
use App\Http\Resources\ResponseCollection;
use League\Flysystem\Exception;

use App\Utility\R;
use App\Utility\Notification;
use App\Utility\Address;

use App\Enums\ReturnType;

class RequestMatchMakerController extends Controller
{
    use R;
    private $userRepository;
    private $matchMakerRepository;

    public function __construct(
        UserRepositoryInterface $userRepository,
        RequestMatchMakerRepositoryInterface $matchMakerRepository)
    {
        $this->middleware('auth:api');
        $this->userRepository = $userRepository;
        $this->matchMakerRepository= $matchMakerRepository;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->type = 'createMatchMaker';
        $this->returnType = ReturnType::SINGLE;
        try {
            
            $this->status = true;
            $input = $request->all();
            $validator = $this->matchMakerRepository->validator($input);
            if($validator->fails()){
                throw (new Exception($validator->errors(), 1));   
            }

            $user = $this->userRepository->getAuthUser();
            $requestMatchMaker = new RequestMatchMaker;


            $requestMatchMaker->user_id = $user->id;
            $requestMatchMaker->title = $input->title;
            $requestMatchMaker->keywords = $input->keywords;
            $requestMatchMaker->location = [];
            foreach ($input->location as $location ) {
                array_push($requestMatchMaker->location, new Address($location));
            }
            
            if ( !$this->matchMakerRepository->saveRequestMatchMaker($requestMatchMaker) ) {
                throw (new Exception("Failed to create match maker.", 1));
            }
            $this->returnValue = $requestMatchMaker;

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
        $this->type = 'getMatchMaker';
        $this->returnType = ReturnType::SINGLE;
        try {
            $this->status = true;
            $matchMaker = $this->matchMakerRepository->getRequestMatchMakerByConditions(['id' =>  $id]);
            if (is_null($matchMaker)) {
                throw (new Exception("Failed to get matchMaker.", 1));
            }
            $this->returnValue = $matchMaker;
        
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
        $this->type = 'updateRequestMatchMaker';
        $this->returnType = ReturnType::SINGLE;
        try {
            $input = $request->all();
            $validator = $this->matchMakerRepository->validator($input);
            $requestMatchMaker = $this->matchMakerRepository->getRequestMatchMakerByConditions(['id' =>  $id]);
            if($validator->fails()){
                throw (new Exception($validator->errors(), 1));   
            } else if (is_null($requestMatchMaker)) {
                throw (new Exception("Failed to update Request Match Maker.", 1));
            }

            $requestMatchMaker->title = $input->title;
            $requestMatchMaker->keywords = $input->keywords;
            $requestMatchMaker->location = [];
            foreach ($input->location as $location ) {
                array_push($requestMatchMaker->location, new Address($location));
            }

            if ( !$this->matchMakerRepository->saveRequestMatchMaker($requestMatchMaker) ) {
                throw (new Exception("Failed to update Request Match Maker.", 1));
            }

            $this->returnValue = $requestMatchMaker;

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
        $this->type = 'deleteMatchMaker';
        $this->returnType = ReturnType::SINGLE;
        try {
            $this->status = false;
            $matchMaker = $this->matchMakerRepository->getRequestMatchMakerByConditions(['id' =>  $id]);
            if (!is_null($matchMaker) && $this->matchMakerRepository->removeRequestMatchMaker($matchMaker) ) {
                $this->status = true;
            }

            if ( !$this->status ) {
                throw (new Exception("Failed to delete matchMaker.", 1));
            }

            $this->returnValue = $matchMaker;
        
        } catch (Exception $e) {
            $this->failedRequest($e);
        }

        return $this->getResponse();
    }
}
