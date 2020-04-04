<?php

namespace App\Enums;

use Rexlabs\Enum\Enum;

/**
 * The PartnerStatus enum.
 *
 * @method static self CONFIRMED()
 * @method static self PENDING()
 * @method static self BLOCKED()
 */
class PartnerStatus extends Enum
{
    const CONFIRMED = 'Confirmed';
    const PENDING = 'Pending';
    const BLOCKED = 'Blocked';
}
