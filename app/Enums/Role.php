<?php

namespace App\Enums;

use Rexlabs\Enum\Enum;

/**
 * The ReturnType enum.
 *
 * @method static self ADMIN()
 * @method static self USER()
 */
class Role extends Enum
{
    const ADMIN = 'Admin';
    const USER = 'User';
}
