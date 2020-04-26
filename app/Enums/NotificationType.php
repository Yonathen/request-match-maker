<?php

namespace App\Enums;

use Rexlabs\Enum\Enum;

/**
 * The ReturnType enum.
 *
 * @method static self NEW_OFFER()
 * @method static self NEW_REQUEST_MAIL_SHARED()
 * @method static self NEW_REQUEST_MAIL_MATCH()
 * @method static self NEW_PARTNER_REQUEST()
 * @method static self NEW_PARTNER()
 */
class NotificationType extends Enum
{
    const NEW_OFFER = 'New Offer';
    
    const NEW_REQUEST_MAIL_SHARED = 'New Shared Request';
    const NEW_REQUEST_MAIL_MATCH = 'New Matched Request';

    const NEW_PARTNER_REQUEST = 'New Partner Request';
    const NEW_PARTNER = 'New Partner';
}
