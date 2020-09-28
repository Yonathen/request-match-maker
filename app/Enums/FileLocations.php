<?php

namespace App\Enums;

use Rexlabs\Enum\Enum;

/**
 * The FileLocations enum.
 *
 * @method static self TRADER()
 * @method static self PROFILE()
 */
class FileLocations extends Enum
{
    const UPLOADS = 'Uploads';
    const TRADER = 'trader';
    const PROFILE = 'profile';
}
