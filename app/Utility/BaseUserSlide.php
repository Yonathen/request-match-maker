<?php
namespace App\Utility;

class BaseUserSlide
{
    /** @var int */
    public $id;

	/** @var string */
	public $image;

	/** @var string */
	public $title;

	/** @var string */
    public $content;

	public function __construct($title, $image, $content) {
		$this->id = Str::random(16);
        $this->title = $title;
        $this->image = $image;
		$this->content = $content;
	}
}
?>
