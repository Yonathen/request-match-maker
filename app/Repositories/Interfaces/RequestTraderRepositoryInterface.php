<?php 
namespace App\Repositories\Interfaces;

use App\model\User;
use App\model\RequestTrader;

interface RequestTraderRepositoryInterface
{
	/** 
	 * @param  array  $data
     */
    public function validator(array $data);

	/**
	 * @param string $columnName
	 * @param string $columnValue
     */
	public function getRequestTraderList($columnName = 'status', $columnValue = RequestStatus::OPEN);

	/**
	 * @param User $user
	 * @param string $columnName
	 * @param string $columnValue
     */
	public function getRequestTraderByUser(User $user, $columnName = 'status', $columnValue = RequestStatus::OPEN);

	/**
	 * @param int $id
     */
	public function getRequestTraderById(int $id);

	/**
	 * @param array $conditions
     */
	public function getRequestTraderByConditions($conditions);

	/**
     * @param RequestTrader $request
     */
	public function saveRequestTrader(RequestTrader $request);

	/**
     * @param RequestTrader $request
     */
	public function removeRequestTrader(RequestTrader $request);

}
