<?php

namespace App\Enums;

use Rexlabs\Enum\Enum;

/**
 * The FileOperationType enum.
 *
 * @method static self SINGLE()
 * @method static self Multiple()
 * @method static self Unchanged()
 */
class FileOperationType extends Enum
{
    const SINGLE = 'Single';
    const Multiple = 'Multiple';
    const Unchanged = 'Unchanged';
}
