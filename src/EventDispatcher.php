<?php

declare(strict_types=1);

namespace App;

use App\Event\Event;
use App\Subscriber\SubscriberInterface;

interface EventDispatcher
{
    public function addListener(string $eventName, SubscriberInterface $listener): void;
    public function dispatch(Event $event): void;
    public function removeListener(string $eventName, SubscriberInterface $listenerToRemove): void;
}
