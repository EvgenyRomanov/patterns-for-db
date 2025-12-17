<?php

declare(strict_types=1);

namespace App;

use App\Event\Event;
use App\Subscriber\SubscriberInterface;

final class SimpleEventDispatcher implements EventDispatcher
{
    private array $listeners = [];

    public function addListener(string $eventName, SubscriberInterface $listener): void
    {
        $this->listeners[$eventName][] = $listener;
    }

    public function dispatch(Event $event): void
    {
        if (empty($this->listeners[$event::class])) {
            return;
        }

        foreach ($this->listeners[$event::class] as $listener) {
            $listener($event);
        }
    }

    public function removeListener(string $eventName, SubscriberInterface $listenerToRemove): void
    {
        if (empty($this->listeners[$eventName])) {
            return;
        }

        foreach ($this->listeners[$eventName] as $key => $listener) {
            if ($listener === $listenerToRemove) {
                unset($this->listeners[$eventName][$key]);
            }
        }
    }
}
