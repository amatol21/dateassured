<?php

namespace App\Enums;

enum ArticleStatus: int
{
    case NOT_PUBLISHED = 0;
    case PUBLISHED = 1;
    case DELETED = 2;
}
