<?php

namespace App\Enums\User;

enum UserRolesEnum: string
{
    case ROLE_USER = 'user';
    case ROLE_MODERATOR = 'moderator';
    case ROLE_ADMIN = 'admin';

    public static function rolesList(): array
    {
        return [
            UserRolesEnum::ROLE_USER->value => 'User',
            UserRolesEnum::ROLE_MODERATOR->value => 'Moderator',
            UserRolesEnum::ROLE_ADMIN->value => 'Admin',
        ];
    }
}
