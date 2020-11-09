<?php


namespace App\Models\Enums;

class UserRolesEnums
{
    public const ROLE_USER = 'user';
    public const ROLE_CLIENT_ADMIN = 'client_admin';
    public const ROLE_SUPER_ADMIN = 'super_admin';

    public const ALL_ROLES = [
        self::ROLE_SUPER_ADMIN,
        self::ROLE_CLIENT_ADMIN,
        self::ROLE_USER
    ];
}
