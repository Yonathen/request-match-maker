<?php

namespace App\Enums;

use Rexlabs\Enum\Enum;

/**
 * The ReturnType enum.
 *
 * @method static self ADMIN()
 * @method static self USER()
 */
class NotificationType extends Enum
{
    const NEW_OFFER = 'New Offer';
    const NEW_REQUEST_MAIL = 'New Mail';
    const NEW_PARTNER_REQUEST = 'New Partner Rewquest';
    const NEW_PARTNER = 'New Partner';
}
