<?php

namespace App\Enums;

use Rexlabs\Enum\Enum;

/**
 * The ReturnType enum.
 *
 * @method static self SINGLE()
 * @method static self COLLECTION()
 */
class ReturnType extends Enum
{
    const SINGLE = 0;
    const COLLECTION = 1;
}
