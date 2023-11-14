<?php
declare(strict_types=1);

namespace Sersid\Shared;

trait EventTrait
{
    /** @var object[] */
    private array $events = [];

    /**
     * @return object[]
     */
    public function releaseEvents(): array
    {
        $events = $this->events;
        $this->events = [];

        return $events;
    }

    protected function recordEvent(object $event): void
    {
        $this->events[] = $event;
    }
}
