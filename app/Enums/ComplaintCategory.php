<?php

namespace App\Enums;

enum ComplaintCategory: int
{
    case VIDEO_SESSION = 0;
    case HARASSMENT = 1;
    case TECH = 2;
    case PROPOSITION = 3;
}
