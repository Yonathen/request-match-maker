<?php

namespace App\Enums;

use Rexlabs\Enum\Enum;

/**
 * The OfferStatus enum.
 *
 * @method static self NEW()
 * @method static self VIEWED()
 * @method static self SELECTED()
 * @method static self REJECTED()
 * @method static self AWARDED()
 */
class OfferStatus extends Enum
{
    const NEW = 'New';
    const VIEWED = 'Viewed';
    const SELECTED = 'Selected';
    const REJECTED = 'Rejected';
    const AWARDED = 'Awarded';
}
