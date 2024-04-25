<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class UserRole extends Enum
{
    const ADMIN = 1;
    const STORE = 2;
    const STAFF = 3;
}