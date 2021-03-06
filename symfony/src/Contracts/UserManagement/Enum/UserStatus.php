<?php

namespace App\Contracts\UserManagement\Enum;

use Elao\Enum\AutoDiscoveredValuesTrait;
use Elao\Enum\Enum;

class UserStatus extends Enum
{
    use AutoDiscoveredValuesTrait;

    public const SIGNED_UP = 'SIGNED_UP';
    public const SIGNED_UP_OAUTH = 'SIGNED_UP_OAUTH';
    public const ONBOARDED = 'ONBOARDED';
}
