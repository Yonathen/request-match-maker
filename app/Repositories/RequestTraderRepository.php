<?php 
namespace App\Repositories;

use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

use App\model\User;
use App\model\RequestTrader;

use App\Enums\RequestStatus;
use App\Enums\FileMimeType;

use App\Utility\BaseRequest;

use App\Repositories\Interfaces\RequestTraderRepositoryInterface;

class RequestTraderRepository implements RequestTraderRepositoryInterface 
{
	/** 
	 * @param  array  $data
     */
    public function validator(array $data)
    {
        return Validator::make($data, [
			'title' => ['required', 'string', 'max:250'],
            'who' => ['required', 'string', 'max:250'],
            'what' => ['required'],
            'where' => ['required'],
            'when' => ['required'],
        ]);
	}

	/**
	 * @param string $columnName
	 * @param string $columnValue
     */
	public function getRequestTraderList($columnValue = RequestStatus::OPEN, $columnName = 'status')
	{
		return RequestTrader::select(BaseRequest::getAttributes())
			->where($columnName, $columnValue)
			->withCount('offers')
			->with('user')
			->paginate(10);
	}

	/**
	 * @param User $user
	 * @param string $columnValue
	 * @param string $columnName
     */
	public function getRequestTraderByUser(User $user, $columnValue = RequestStatus::OPEN, $columnName = 'status')
	{
		return RequestTrader::select(BaseRequest::getAttributes())
			->where($columnName, $columnValue)
			->where('user_id', $user->id)
			->withCount('offers')
			->with('user')
			->paginate(10);
	}

	/**
	 * @param int $id
     */
	public function getRequestTraderById(int $id)
	{
		return RequestTrader::where('id', $request->id)
				->with('user', 'offers')
				->first();
	}

	/**
	 * @param array $conditions
     */
	public function getRequestTraderByConditions($conditions)
	{
		$query = RequestTrader::select();
		foreach($conditions as $column => $value)
			{
				$query->where($column, '=', $value);
			}
		return $query->with('user', 'offers')
			->first();
	}

	/**
     * @param RequestTrader $request
     */
	public function saveRequestTrader(RequestTrader $request)
	{
		return $request->save();
	}

	/**
     * @param RequestTrader $request
     */
	public function removeRequestTrader(RequestTrader $request)
	{
		return RequestTrader::destroy($request->id);
	}
	
}