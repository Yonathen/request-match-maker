<?php 
namespace App\Repositories\Interfaces;

use App\model\User;

interface UserNewRepositoryInterface
{

	/**
     * @param  array  $data
     */
    public function validator(array $data);

    /**
     * @param  array  $data
     * @return \App\model\User
     */
    public function create(array $data);

}