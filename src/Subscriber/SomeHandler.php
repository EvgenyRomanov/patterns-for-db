<?php

declare(strict_types=1);

namespace App\Subscriber;

use App\Event\Event;

final class SomeHandler implements SubscriberInterface
{
    public function __invoke(Event $event): void
    {
        echo "Event generated: " . $event::class . PHP_EOL;
        echo "Query: " . $event->getQueryResult()->getQuery() . PHP_EOL;
    }
}
