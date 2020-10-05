<?php

namespace App\Enums;

use Rexlabs\Enum\Enum;

/**
 * The VisitStatus enum.
 *
 * @method static self ADD()
 * @method static self UPDATE()
 * @method static self REMOVE()
 * @method static self SHOW()
 */
class OperationType extends Enum
{
    const ADD = '';
    const UPDATE = '';
    const REMOVE = '';
    const SHOW = '';
}
