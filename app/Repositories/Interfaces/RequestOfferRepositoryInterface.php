<?php 
namespace App\Repositories\Interfaces;

use App\model\User;
use App\model\RequestOffer;

interface RequestOfferRepositoryInterface
{
    /**
	 * @param string $columnName
	 * @param string $columnValue
     */
	public function getRequestOfferList($columnName = 'status', $columnValue = OfferStatus::NEW);

	/**
	 * @param User $user
	 * @param string $columnName
	 * @param string $columnValue
     */
	public function getRequestOfferByUser(User $user, $columnName = 'status', $columnValue = OfferStatus::NEW);

	/**
	 * @param RequestOffer $requestOffer
     */
	public function getRequestOfferDetailById(RequestOffer $requestOffer);

	/**
	 * @param array $conditions
     */
	public function getRequestOfferDetailByConditions($conditions);

	/**
     * @param RequestOffer $requestOffer
     */
	public function saveRequest(RequestOffer $requestOffer);

	/**
     * @param RequestOffer $requestOffer
     */
	public function removeRequestOffer(RequestOffer $requestOffer);

}
