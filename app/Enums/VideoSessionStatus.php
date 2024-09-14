<?php

namespace App\Enums;

enum VideoSessionStatus: int
{
    case WAITING_FOR_START = 0;
    case TALKING = 1;
    case WAITING_FOR_NEXT_TALK = 2;
    case DONE = 3;

    public function name(): string
    {
        return match ($this) {
            VideoSessionStatus::WAITING_FOR_START => 'Waiting for start',
            VideoSessionStatus::TALKING => 'Talking',
            VideoSessionStatus::WAITING_FOR_NEXT_TALK => 'Waiting for next talk',
            default => 'Done',
        };
    }
}
