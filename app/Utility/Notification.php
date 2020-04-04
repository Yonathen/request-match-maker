<?php
namespace App\Utility;
use App\Enums\VisitStatus;

use Illuminate\Support\Str;

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

	public function __construct() {
		$this->id = Str::random(16);
		$this->status = VisitStatus::NEW;
	}
}