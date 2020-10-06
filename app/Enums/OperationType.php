<?php

namespace App\Enums;

use Rexlabs\Enum\Enum;

/**
 * The OperationType enum.
 *
 * @method static self ADD()
 * @method static self UPDATE()
 * @method static self REMOVE()
 * @method static self SHOW()
 */
class OperationType extends Enum
{
    const ADD = 'ADD';
    const UPDATE = 'UPDATE';
    const REMOVE = 'REMOVE';
    const SHOW = 'SHOW';
}
