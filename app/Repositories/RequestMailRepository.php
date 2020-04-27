<?php 
namespace App\Repositories;

use Illuminate\Support\Facades\Auth; 
use Carbon\Carbon;

use App\model\User;
use App\model\RequestMailMatch;

use App\Enums\NotificationType;
use App\Enums\RequestMailStatus;
use App\Enums\RequestMailType;

use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\Interfaces\RequestMailRepositoryInterface;
use App\Repositories\Interfaces\RequestTraderRepositoryInterface;
use App\Repositories\Interfaces\NotificationRepositoryInterface;

use App\Mail\RequestTraderMail;
use Illuminate\Support\Facades\Mail;

class RequestMailRepository implements RequestMailRepositoryInterface 
{
	private $userRepository;
    private $notificationRepository;

    public function __construct( UserRepositoryInterface $userRepository,
        NotificationRepositoryInterface $notificationRepository ) {
        $this->userRepository = $userRepository;
        $this->notificationRepository = $notificationRepository;
    }

    /**
     * @param  array $input
     * @return RequestMailMatch | null
     */
    public function createMail(array $input)
    {
        $sharingUser = null;
		if ($input->type === RequestMailType::SHARED) {
			$sharingUser = $this->userRepository->getUser('email', $input->sharedByEmail);
		}

		$user = $this->userRepository->getUser('email', $input->email);
		$validator = $this->validator($input);
		if ( is_null($user) || 
			 ($input->type === RequestMailType::SHARED && is_null($sharingUser) ) ||
			 $validator->fails()) {
			return null;
		}

		$requestMail = new RequestMailMatch;

		$requestMail->user_id = $user->id;
		$requestMail->request_id = $input->request_id;
		$requestMail->type = $input->type;
		$requestMail->status = RequestMailStatus::NEW;
		if ( $input->type === RequestMailType::SHARED ) {
			$requestMail->shared_by = $sharingUser->id;
		}

		if ( $requestMail->save() && $this->sendNotification($requestMail, $user)) {
			return $requestMail;
		}
		return null;
    }

    public function sendNotification($requestMail, $user) {
        $notificationType = null;
        $accessValue = [ 
            'mailId' => $requestMail->id, 
            'user' => ['name' => $requestMail->user->name, 'email' =>$requestMail->user->email], 
            'request' => ['id' => $requestMail->request->id, 'title' => $requestMail->request->title], 
        ];
        if ( $requestMail->type === RequestMailType::SHARED ) {
            $notificationType = NotificationType::NEW_REQUEST_MAIL_SHARED;
            $accessValue['sharedBy'] = ['name' => $requestMail->sharedBy->name, 'email' =>$requestMail->sharedBy->email];
        } elseif ( $requestMail->type === RequestMailType::MATCH ) {
            $notificationType = NotificationType::NEW_REQUEST_MAIL_MATCH;
        }

        if (  !is_null ($notificationType) ) {
            $notification = new Notification($notificationType, $accessValue );
            $this->notificationRepository->sendNotification($user, $notification);
			Mail::to($accessValue["user"]["email"])->send(new RequestTraderMail($accessValue, $notificationType));
			return true;
		}
		return false;
    }

	/**
     * @param  array  $data
     */
    public function validator(array $data)
    {
        return Validator::make($data, [
            'type' => ['required'],
            'request_id' => ['required'],
        ]);
	}
	
	/** 
	 * @param User $user
	 * @param string $columnName
	 * @param string $columnValue
     */
	public function getRequestMailByUser(User $user, $columnValue = RequestMailType::MATCH, $columnName = 'type')
	{
		return RequestMailMatch::where($columnName, $columnValue)
			->where('user_id', $user->id)
			->with('user', 'request', 'sharedByUser')
			->paginate(10);
	}

	/**
	 * @param array $conditions
     */
	public function getRequestMailByConditions($conditions)
	{
		$query = RequestMailMatch::select();
		foreach($conditions as $column => $value)
			{
				$query->where($column, '=', $value);
			}
		return $query->with('user', 'offers')
			->first();
	}

	/**
     * @param RequestMailMatch $requestMail
     */
	public function saveRequestMail(RequestMailMatch $requestMail)
	{
		return $requestMail->save();
	}

	/**
     * @param RequestMailMatch $requestMail
     */
	public function removeRequestMail(RequestMailMatch $requestMail)
	{
		return RequestMailMatch::destroy($requestMail->id);
	}
	
}