<?php

namespace App\Enums;

enum ComplaintStatus: int
{
    case NEW = 0;
    case RESOLVING = 1;
    case RESOLVED = 2;
}
