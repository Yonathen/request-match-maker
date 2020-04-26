<?php

namespace App\Http\Controllers;

use App\model\User; 
use App\model\RequestTrader;

use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\Interfaces\RequestTraderRepositoryInterface;

use Illuminate\Http\Request; 
use App\Http\Resources\ResponseResource;
use App\Http\Resources\ResponseCollection;
use League\Flysystem\Exception;

use App\Utility\R;
use App\Utility\Address;

use App\Enums\ReturnType;

class RequestTraderController extends Controller
{
    use R;
    private $userRepository;
    private $requestTraderRepository;
    private $requestMatchMakerRepository;

    public function __construct(
        UserRepositoryInterface $userRepository,
        RequestMatchMakerRepositoryInterface $requestMatchMakerRepository,
        RequestTraderRepositoryInterface $requestTraderRepository)
    {
        $this->middleware('auth:api');
        $this->userRepository = $userRepository;
        $this->requestTraderRepository = $requestTraderRepository;
        $this->requestMatchMakerRepository = $requestMatchMakerRepository;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->type = 'updateRequestTrader';
        $this->returnType = ReturnType::SINGLE;
        try {
            $input = $request->json()->all();
            $validator = $this->requestTraderRepository->validator($input);
            if( $validator->fails() ){
                throw (new Exception("Failed to update request trader.", 1));   
            }
            
            $requestTrader = new RequestTrader;
            $user = $this->userRepository->getAuthUser();
            $location = FileLocations::UPLOADS . '/'  . $user->id . '/' . FileLocations::TRADER;
            if ( !is_null( $input["images"] ) ) {
                $fileUpload = $this->fileRepository->upload($input["images"], $location, FileMimeType::IMAGE);
                if ( $fileUpload['status'] ) {
                    $requestTrader->images = $fileUpload["content"];
                } else {
                    throw ($fileUpload['content']);
                }
            }
            
            $requestTrader->user_id = $user->id;
            $requestTrader->title = $input["title"];
            $requestTrader->what = $input["what"];
            $requestTrader->where = $input["where"];
            $requestTrader->when = new Address($input["when"]);
            $requestTrader->who = $input["who"];

            if ( !$this->requestTraderRepository->saveRequestTrader($requestTrader) ) {
                throw (new Exception("Failed to update request trader.", 1));
            }

            $requestMatchMakers  = $this->requestMatchMakerRepository->getRequestMatch($requestTrader);
            foreach ( $requestMatchMakers as $value ) {
                
            }

            $this->returnValue = $requestTrader;

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
        try {
            $input = $request->json()->all();
            $requestTrader = $this->requestTraderRepository->getRequestTraderById($id);
            $user = $this->userRepository->getAuthUser();
            $location = FileLocations::UPLOADS . '/'  . $user->id . '/' . FileLocations::TRADER;
            if ( !is_null( $requestTrader->images ) ) {
                $fileUpload = $this->fileRepository->getFile( $location . $requestTrader->images );
                if ( $fileUpload['status'] ) {
                    $requestTrader->images = $fileUpload["content"];
                } else {
                    throw ($fileUpload['content']);
                }
            }
            
            $requestTrader->user_id = $user->id;
            $requestTrader->title = $input["title"];
            $requestTrader->what = $input["what"];
            $requestTrader->where = $input["where"];
            $requestTrader->when = new Address($input["when"]);
            $requestTrader->who = $input["who"];

            if ( !$this->requestTraderRepository->saveRequestTrader($requestTrader) ) {
                throw (new Exception("Failed to update request trader.", 1));
            }
            $this->returnValue = $requestTrader;

        } catch (Exception $e) {
            $this->failedRequest($e);
        }

        return $this->getResponse();
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->type = 'updateRequestTrader';
        $this->returnType = ReturnType::SINGLE;
        try {
            $input = $request->json()->all();
            $requestTrader = $this->requestTraderRepository->getRequestTraderById($id);
            $validator = $this->requestTraderRepository->validator($input);
            if( is_null($requestTrader) || $validator->fails() ){
                throw (new Exception("Failed to update request trader.", 1));   
            }
            
            $user = $this->userRepository->getAuthUser();
            $location = FileLocations::UPLOADS . '/'  . $user->id . '/' . FileLocations::TRADER;
            if ( !is_null( $input["images"] ) ) {
                $fileUpload = $this->fileRepository->upload($input["images"], $location, FileMimeType::IMAGE);
                if ( $fileUpload['status'] ) {
                    $requestTrader->images = $fileUpload["content"];
                } else {
                    throw ($fileUpload['content']);
                }
            }
            
            $requestTrader->user_id = $user->id;
            $requestTrader->title = $input["title"];
            $requestTrader->what = $input["what"];
            $requestTrader->where = $input["where"];
            $requestTrader->when = new Address($input["when"]);
            $requestTrader->who = $input["who"];

            if ( !$this->requestTraderRepository->saveRequestTrader($requestTrader) ) {
                throw (new Exception("Failed to update request trader.", 1));
            }
            $this->returnValue = $requestTrader;

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
        $this->type = 'deleteRequestTrader';
        $this->returnType = ReturnType::SINGLE;
        try {
            $this->status = false;
            $requestTrader = $this->requestTraderRepository->getRequestTraderById($id);
            if (!is_null($requestTrader) && $this->requestTraderRepository->removeRequestTrader($requestTrader) ) {
                $this->status = true;
            }

            if ( !$this->status ) {
                throw (new Exception("Failed to delete request.", 1));
            }

            $this->returnValue = $requestTrader;
        
        } catch (Exception $e) {
            $this->failedRequest($e);
        }

        return $this->getResponse();
    }
}
