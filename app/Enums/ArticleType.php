<?php

namespace App\Enums;

enum ArticleType: int
{
    case NEWS = 0;
    case POST = 1;
    case ANNOUNCEMENT = 2;
}
