<?php

namespace App\Enums;

enum Gender: int
{
    case MALE = 0;
    case FEMALE = 1;

    public function name(): string
    {
        return __('enums.gender.'.$this->value);
    }
}
