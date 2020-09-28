<?php

namespace App\Enums;

use Rexlabs\Enum\Enum;

/**
 * The RequestStatus enum.
 *
 * @method static self OPEN()
 * @method static self CLOSED()
 * @method static self NEW_OFFER()
 */
class RequestStatus extends Enum
{
    const OPEN = 'Open';
    const CLOSED = 'Closed';
}
