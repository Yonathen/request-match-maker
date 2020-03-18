<?php

namespace App\Http\Controllers;

use App\Utility\R;
use App\model\User; 
use Illuminate\Http\Request; 
use App\Repositories\Interfaces\UserNewRepositoryInterface;
use App\Http\Resources\ResponseResource;
use App\Http\Resources\ResponseCollection;
use App\Enums\ReturnType;
use League\Flysystem\Exception;
use App\Mail\VerificationEmail;
use Illuminate\Support\Facades\Mail;

class UserNewController extends Controller
{
    use R;
    private $userNewRepository;

    public function __construct(UserNewRepositoryInterface $userNewRepository)
    {
        $this->userNewRepository = $userNewRepository;
    }

    public function createAccount(Request $request) {
        $this->type = 'createAccount';
        $this->returnType = ReturnType::SINGLE;
        try {
            $this->status = true;
            $input = $request->all();
            $validator = $this->userNewRepository->validator($input);
            if($validator->fails()){
                throw (new Exception($validator->errors(), 1));   
            }

            $input['password'] = bcrypt($input['password']);
            $input['email_verification_token'] = Str::random(32);
            $createdUser = $this->userNewRepository->create($input);
            if (is_null($createdUser)) {
                throw (new Exception("Failed to create User.", 1));
            }

            Mail::to($createdUser->email)->send(new VerificationEmail($createdUser))
            
            $this->returnValue = $createdUser;
        } catch (Exception $e) {
            $this->failedRequest($e);
        }

        return $this->getResponse();
    }
    
}
