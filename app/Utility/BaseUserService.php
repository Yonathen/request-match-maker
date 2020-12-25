<?php
namespace App\Utility;

use Illuminate\Support\Str;

class BaseUserService
{
    /** @var int */
    public $id;

	/** @var string */
    public $name;

	/** @var string */
    public $description;
    
	public function __construct( $name, $description, $id = null) {
        $this->name = $name;
        $this->description = $description;

        if ( is_null($id) ) {
            $this->id = Str::random(16);
        } else {
            $this->id = $id;
        }
	}
}
?>
