<?php

namespace App\Enums;

use Rexlabs\Enum\Enum;

/**
 * The RequestMailType enum.
 *
 * @method static self MATCH()
 * @method static self SHARED()
 * @method static self IMPORTED()
 */
class RequestMailType extends Enum
{
    const MATCH = 'Match';
    const SHARED = 'Shared';
    const IMPORTED = '"Imported';
}
