<?php

namespace App\Enums;

enum Sexuality: int
{
    case STRAIGHT = 0;
    case LESBIAN = 1;
    case GAY = 2;
    case BI = 3;

    public function name(): string
    {
        return __('enums.sexuality.'.$this->value);
    }

    public function toString(): string
    {
        $res = $this->value === 0 ? 'straight' : ($this->value === 1 ? 'lesbian' : 'gay');
        if ($this->value === 3) $res = 'straight';
        return $res;
    }
}
