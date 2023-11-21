<?php
declare(strict_types=1);

namespace Tests\Event;

use Psr\EventDispatcher\EventDispatcherInterface;

final readonly class EventDispatcher implements EventDispatcherInterface
{
    private EventCollection $events;

    public function __construct()
    {
        $this->events = new EventCollection();
    }

    public function dispatch(object $event): void
    {
        $this->events->add($event);
    }

    public function getAll(): EventCollection
    {
        return $this->events;
    }
}