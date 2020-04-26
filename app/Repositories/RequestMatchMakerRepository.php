<?php 
namespace App\Repositories;

use Illuminate\Support\Facades\Auth; 
use Carbon\Carbon;

use App\model\User;
use App\model\RequestTrader;
use App\model\RequestMatchMaker;

use App\Repositories\Interfaces\RequestMatchMakerRepositoryInterface;

class RequestMatchMakerRepository implements RequestMatchMakerRepositoryInterface 
{
	/**
     * @param  array  $data
     */
    public function validator(array $data)
    {
        return Validator::make($data, [
            'title' => ['required', 'string', 'max:255'],
            'keywords' => ['required'],
            'location' => ['required'],
        ]);
    }

	/**
	 * @param RequestTrader $requestTrader
     */
	public function getRequestMatch(RequestTrader $requestTrader)
	{
		$matchMakers = [];
		$result = RequestMatchMaker::select()->with('user')->get();
		foreach ( $result as $value ) {
			foreach ( $value['keywords'] as $keyword ) {
				if ( preg_match ( $keyword, $requestTrader->title ) ||
					 preg_match ( $keyword, $requestTrader->what ) ) {
					array_push ( $matchMakers, $value );
				}
			}
		}

		return $matchMakkers;
	}

	/**
	 * @param User $user
     */
	public function getRequestMatchMakerByUser(User $user)
	{
		return RequestMatchMaker::select()
			->where('user_id', $user->id)
			->with('user')
			->paginate(10);
	}

	/**
	 * @param array $conditions
     */
	public function getRequestMatchMakerByConditions($conditions)
	{
		$query = RequestMatchMaker::select();
		foreach($conditions as $column => $value)
			{
				$query->where($column, '=', $value);
			}
		return $query->get();
	}

	/**
     * @param RequestMatchMaker $requestMatchMaker
     */
	public function saveRequestMatchMaker(RequestMatchMaker $requestMatchMaker)
	{
		return $requestMatchMaker->save();
	}

	/**
     * @param RequestMatchMaker $requestMatchMaker
     */
	public function removeRequestMatchMaker(RequestMatchMaker $requestMatchMaker)
	{
		return RequestMatchMaker::destroy($requestMatchMaker->id);
	}
	
}