<?php
namespace App\Utility;

use Illuminate\Support\Str;


class Address
{
    /** @var int */
	public $id;

	/** @var string */
	public $name;

	/** @var string */
	public $phone;

	/** @var string */
    public $email;

	/** @var string */
	public $address1;

	/** @var string */
	public $address2;

	/** @var string */
    public $postalCode;

	/** @var string */
	public $city;

	/** @var string */
	public $country;

	/** @var string */
    public $lon;

	/** @var string */
	public $lat;

	/** @var bool */
	public $default;

	public function __construct($address) {

		$this->id = Str::random(16);
		$this->name = $address["name"];
		$this->phone = $address["phone"];
		$this->email = $address["email"];
		$this->address1 = $address["address1"];
		$this->address2 = $address["address2"];
		$this->postalCode = $address["postalCode"];
		$this->city = $address["city"];
		$this->country = $address["country"];
		$this->lon = $address["lon"];
		$this->lat = $address["lat"];
		$this->default = $address[""];
	}
}