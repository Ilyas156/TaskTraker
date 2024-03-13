<?php

namespace App\Enums\User;

enum UserStatusEnum: string
{
    case STATUS_WAIT = 'wait';
    case STATUS_ACTIVE = 'active';
}
