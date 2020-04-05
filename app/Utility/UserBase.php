<?php
namespace App\Utility;
use App\Enums\VisitStatus;

use Illuminate\Support\Str;

use App\model\User; 

class UserBase
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
	
	public function __construct(User $user) {
		$this->name = $user->name;
		$this->email = $user->email;
		$this->logo = $user->logo;
		$this->address = $user->address;
		$this->website = $user->website;
		$this->language = $user->language;
	}

}