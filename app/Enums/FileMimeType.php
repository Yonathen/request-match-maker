<?php

namespace App\Enums;

use Rexlabs\Enum\Enum;

/**
 * The FileMimeType enum.
 *
 * @method static self IMAGE()
 * @method static self VIDEO()
 * @method static self DOC()
 */
class FileMimeType extends Enum
{
    const ALL = 'mimes:jpeg,jpg,bmp,png,gif,avi,mpeg,quicktime,doc,pdf,docx,txt,zip';
    const IMAGE = 'mimes:jpeg,jpg,bmp,png,gif';
    const VIDEO = 'mimes:avi,mpeg,quicktime';
    const DOC = 'mimes:doc,pdf,docx,txt,zip';
}
