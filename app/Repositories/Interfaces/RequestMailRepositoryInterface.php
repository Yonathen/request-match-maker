<?php 
namespace App\Repositories\Interfaces;

use App\model\User;
use App\model\RequestMailMatch;

interface RequestMailRepositoryInterface
{
	/**
     * @param  array  $data
     */
	public function validator(array $data);
	
    /** 
	 * @param User $user
	 * @param string $columnName
	 * @param string $columnValue
     */
	public function getRequestMailByUser(User $user, $columnName = 'type', $columnValue = RequestMailType::MATCH);

	/**
	 * @param array $conditions
     */
	public function getRequestMailByConditions($conditions);

	/**
     * @param RequestMailMatch $requestMail
     */
	public function saveRequestMail(RequestMailMatch $requestMail);

	/**
     * @param RequestMailMatch $requestMail
     */
	public function removeRequestMail(RequestMailMatch $requestMail);

}
