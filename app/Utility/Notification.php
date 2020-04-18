<?php
namespace App\Utility;

use App\Enums\VisitStatus;

use Illuminate\Support\Str;

use App\Enums\NotificationType;

class Notification
{
    /** @var int */
	public $id;

	/** @var string */
	public $type;

	/** @var string */
	public $title;

	/** @var string */
    public $content;
    
    /** @var array */
    public $accessValue;

	/** @var bool */
	public $status;

	public function __construct($type, $accessValue) {

		$this->type = $type;
		$this->id = Str::random(16);
		$this->status = VisitStatus::NEW;
		$this->accessValue = $accessValue;

		switch($type) {
			case NotificationType::NEW_PARTNER:
				$this->title = "New partner";
            	$this->content = "Your request for partnership to ".$accessValue['name']." has been accepted.";
			break;
			case NotificationType::NEW_PARTNER_REQUEST;
            	$this->title = "New partner request";
            	$this->content = "You have new partner request from ".$accessValue['name'];
			break;
		}
	}
}