<?php
namespace App\Utility;
use App\Enums\VisitStatus;

use Illuminate\Support\Str;

use App\model\User; 

class BaseOffer
{
    /** @var int */
	public $created_at;

	/** @var string */
	public $price;

	/** @var string */
	public $currency;
    
    /** @var array */
    public $offer_no;

	/** @var string */
	public $staus;
    
    /** @var array */
    public $user;

	public function __construct() {
	}
	
	public static function getAttributes() 
	{
		return ['created_at', 'price', 'currency', 'offer_no', 'staus'];
	}

}