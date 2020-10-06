<?php
namespace App\Utility;

use Illuminate\Support\Str;

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

	/** @var string */
	public $titleColor;

	/** @var string */
	public $contentColor;

	/** @var string */
	public $captionBackgroundColor;

	public function __construct( $title, $image, $content, $titleColor, $contentColor, $captionBackgroundColor, $id) {
        $this->title = $title;
        $this->image = $image;
        $this->content = $content;
        $this->titleColor = $titleColor;
        $this->contentColor = $contentColor;
        $this->captionBackgroundColor = $captionBackgroundColor;

        if ( is_null($id) ) {
            $this->id = Str::random(16);
        } else {
            $this->id = $id;
        }
	}
}
?>
