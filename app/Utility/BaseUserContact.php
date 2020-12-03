<?php
namespace App\Utility;

use Illuminate\Support\Str;

class BaseUserContact
{
    /** @var int */
    public $id;

	/** @var string */
    public $personName;

	/** @var string */
    public $personPhoto;
    
    /** @var array */
    public $address;

	public function __construct( $personName, $personPhoto, $address, $id = null) {
        $this->personName = $personName;
        $this->personPhoto = $personPhoto;
        $this->address = $address;

        if ( is_null($id) ) {
            $this->id = Str::random(16);
        } else {
            $this->id = $id;
        }
	}
}
?>
