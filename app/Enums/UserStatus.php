<?php

namespace App\Enums;

enum UserStatus: int
{
    case ACTIVE = 1;
    case BANNED = 2;
    case DELETED = 3;
}
