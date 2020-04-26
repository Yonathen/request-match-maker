<?php
namespace App\Utility;
use App\Enums\VisitStatus;

use Illuminate\Support\Str;

use App\model\User; 

class BaseRequest
{
    /** @var int */
	public $id;

    /** @var int */
	public $created_at;

	/** @var string */
	public $title;

	/** @var string */
	public $who;
    
    /** @var array */
    public $user;

	/** @var string */
	public $views;

	/** @var int */
	public $offers;

	public function __construct() {
	}
	
	public function getAttributes() 
	{
		return ['id', 'title', 'created_at', 'who', 'views'];
	}

}