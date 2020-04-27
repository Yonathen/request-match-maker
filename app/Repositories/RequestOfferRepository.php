<?php 
namespace App\Repositories;

use Illuminate\Support\Facades\Auth; 
use Carbon\Carbon;

use App\model\RequestTrader;
use App\model\RequestOffer;

use App\Enums\OfferStatus;
use App\Enums\RequestStatus;

use App\Utility\BaseOffer;

use App\Repositories\Interfaces\RequestOfferRepositoryInterface;

class RequestOfferRepository implements RequestOfferRepositoryInterface 
{

	/** 
	 * @param  array  $data
     */
    public function validator(array $data)
    {
        return Validator::make($data, [
            'price' => ['required', 'string', 'max:9'],
            'currency' => ['required', 'string', 'max:5'],
            'message_exchange' => ['required'],
            'request_id' => ['required'],
        ]);
	}

	/**
	 * @param string $columnName
	 * @param string $columnValue
     */
	public function getRequestOfferList($columnValue = OfferStatus::NEW, $columnName = 'status')
	{
		return RequestOffer::select(BaseOffer::getAttributes())
			->where($columnName, $columnValue)
			->with('user', 'request')
			->paginate(10);
	}

	/**
	 * @param User $user
	 * @param string $columnName
	 * @param string $columnValue
     */
	public function getRequestOfferByUser(User $user, $columnValue = OfferStatus::NEW, $columnName = 'status')
	{
		return RequestOffer::select(BaseOffer::getAttributes())
			->where($columnName, $columnValue)
			->where('user_id', $user->id)
			->with('user', 'request')
			->paginate(10);
	}

	/**
	 * @param int $id
     */
	public function getRequestOfferDetailById(int $id)
	{
		return RequestOffer::where('id', $id)
				->with('user', 'request')
				->paginate(10);
	}

	/**
	 * @param array $conditions
     */
	public function getRequestOfferByConditions($conditions)
	{
		$query = RequestOffer::select();
		foreach($conditions as $column => $value)
			{
				$query->where($column, '=', $value);
			}
		return $query->with('user', 'request')
			->first();
	}

	/**
     * @param RequestOffer $requestOffer
     */
	public function saveRequestOffer(RequestOffer $requestOffer)
	{
		return $requestOffer->save();
	}

	/**
     * @param RequestOffer $requestOffer
     */
	public function removeRequestOffer(RequestOffer $requestOffer)
	{
		return Request::destroy($requestOffer->id);
	}
	
}