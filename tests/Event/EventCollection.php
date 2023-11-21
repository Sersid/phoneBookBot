<?php
declare(strict_types=1);

namespace Tests\Event;

use Ramsey\Collection\AbstractCollection;
use Sersid\Shared\Event;

/**
 * @extends AbstractCollection<Event>
 */
final class EventCollection extends AbstractCollection
{

    public function getType(): string
    {
        return Event::class;
    }
}