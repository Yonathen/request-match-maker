<?php

namespace App\Enums;

use Rexlabs\Enum\Enum;

/**
 * The RequestMailStatus enum.
 *
 * @method static self NEW()
 * @method static self VIEWED()
 * @method static self ARCHIVED()
 */
class RequestMailStatus extends Enum
{
    const NEW = 'New';
    const VIEWED = 'Viewed';
    const ARCHIVED = 'Archived';
}
