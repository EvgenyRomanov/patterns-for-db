<?php

declare(strict_types=1);

namespace App\Subscriber;

use App\Event\Event;

interface SubscriberInterface
{
    public function __invoke(Event $event): void;
}
