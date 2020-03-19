<?php 
namespace App\Repositories;

use App\Repositories\Interfaces\UserNewRepositoryInterface;
use App\model\User;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\Validator;

class UserNewRepository implements UserNewRepositoryInterface 
{

	/**
     * @param  array  $data
     */
    public function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:user'],
            'password' => ['required', 'string', 'min:8'],
        ]);
    }

    /**
     * @param  array  $data
     * @return \App\model\User
     */
    public function create(array $data)
    {
        return User::create($data);
    }

}