<?php 
namespace App\Repositories\Interfaces;

use App\model\User;
use App\model\RequestOffer;

interface RequestOfferRepositoryInterface
{
    /** 
	 * @param  array  $data
     */
    public function validator(array $data);

	/**
	 * @param string $columnName
	 * @param string $columnValue
     */
	public function getRequestOfferList($columnValue, $columnName);

	/**
	 * @param User $user
	 * @param string $columnName
	 * @param string $columnValue
     */
	public function getRequestOfferByUser(User $user, $columnValue, $columnName);

	/**
	 * @param int $id
     */
	public function getRequestOfferDetailById(int $id);

	/**
	 * @param array $conditions
     */
	public function getRequestOfferByConditions($conditions);

	/**
     * @param RequestOffer $requestOffer
     */
	public function saveRequestOffer(RequestOffer $requestOffer);

	/**
     * @param RequestOffer $requestOffer
     */
	public function removeRequestOffer(RequestOffer $requestOffer);

}
