<?php
namespace App\Utility;
use App\Enums\VisitStatus;

use Illuminate\Support\Str;

use App\model\User; 

class BaseUser
{
    /** @var int */
	public $name;

	/** @var string */
	public $email;

	/** @var string */
	public $logo;
    
    /** @var array */
    public $address;

	/** @var string */
	public $website;

	/** @var string */
	public $language;

	public function __construct() {
	}
	
	public static function getAttributes() 
	{
		return ['id', 'name', 'email', 'logo', 'address', 'website', 'language'];
	}

}