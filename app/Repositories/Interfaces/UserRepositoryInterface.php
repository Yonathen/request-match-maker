<?php 
namespace App\Repositories\Interfaces;

use App\model\User;

interface UserRepositoryInterface
{

     /**
     * @return User $user
     */
     public function getAuthUser();

     /**
     * @param string $column_name
     * @param string $email
     * @return User $user
     */
     public function getUser($column_name, $email);

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

     /**
     * @param User $user
     * @param string keyword
     */
     public function searchUsersByKeyword(User $user, $keyword);

     /**
     * @param User $user
     */
     public function getAllUser(User $user);


}
