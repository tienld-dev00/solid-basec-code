<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * Enum representing user roles in the system.
 */
final class UserRole extends Enum
{
    /**
     * Administrator role.
     */
    const ADMIN = 1;

    /**
     * Store manager role.
     */
    const STORE = 2;

    /**
     * Staff role.
     */
    const STAFF = 3;
}