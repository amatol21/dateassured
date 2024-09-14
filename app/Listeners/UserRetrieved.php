<?php

namespace App\Listeners;

use App\Enums\UserStatus;
use App\Events\UserRetrievedEvent;

class UserRetrieved
{
    /**
     * Handle the event.
     */
    public function handle(UserRetrievedEvent $event): void
    {
        if ($event->user->status === UserStatus::BANNED
            && ($event->user->banned_to === null || strtotime($event->user->banned_to) < time())) {
            $event->user->status = UserStatus::ACTIVE;
            $event->user->banned_to = null;
            $event->user->save();
        }
    }
}
