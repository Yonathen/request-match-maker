<?php 
namespace App\Repositories\Interfaces;

use App\model\User;

interface UserExistingRepositoryInterface
{


	/**
     * @return User $user
     */
	public function getAuthUser();

	/**
	 * @param string $email
     * @return User $user
     */
	public function getUser($email);
	
	/**
     * @param User $user
     */
    public function verifyEmail(User $user);

	/**
     * @param array $data
     */
	public function accessToken($data);

	public function logout();

    public function logoutFromAllDevice();



}