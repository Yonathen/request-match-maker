<?php
namespace App\Utility;

use Illuminate\Support\Str;

class BaseUserService
{
    /** @var string */
    public $id;

	/** @var string */
    public $question;

	/** @var string */
    public $answer;
    
	public function __construct( $question, $answer, $id = null) {
        $this->question = $question;
        $this->answer = $answer;

        if ( is_null($id) ) {
            $this->id = Str::random(16);
        } else {
            $this->id = $id;
        }
	}
}
?>
