<?php

namespace App\Enums;

use Rexlabs\Enum\Enum;

/**
 * The VisitStatus enum.
 *
 * @method static self NEW()
 * @method static self SEEN()
 */
class VisitStatus extends Enum
{
    const NEW = 'New';
    const SEEN = 'Seen';
}
