<?php

namespace App\Enums;

enum Purpose: int
{
    case CASUAL_FUN = 0;
    case FRIENDSHIP_ONLY = 1;
    case SERIOUS_RELATIONSHIP = 2;
    case MARRIAGE = 3;

    public function name(): string
    {
        return __('enums.purpose.'.$this->value);
    }
}
