<?php 
namespace App\Repositories\Interfaces;

use App\model\User;
use App\model\RequestMatchMaker;

interface RequestMatchMakerRepositoryInterface
{

	/**
     * @param  array  $data
     */
	public function validator(array $data);
	
	/**
	 * @param User $user
     */
	public function getRequestMatchMakerByUser(User $user);

	/**
	 * @param array $conditions
     */
	public function getRequestMatchMakerByConditions($conditions);

	/**
     * @param RequestMatchMaker $requestMatchMaker
     */
	public function saveRequestMatchMaker(RequestMatchMaker $requestMatchMaker);

	/**
     * @param RequestMatchMaker $requestMatchMaker
     */
	public function removeRequestMatchMaker(RequestMatchMaker $requestMatchMaker);
}
