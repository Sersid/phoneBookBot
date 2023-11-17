<?php
declare(strict_types=1);

namespace Sersid\ContactBookBot\Domain\Contact\Event;

use DomainException;
use Sersid\ContactBookBot\Domain\Contact\Entity\Contact;

final class ContactEvent
{
    private const EVENTS = [
        'created' => ContactCreatedEvent::class,
        'changedCategory' => ContactChangedCategoryEvent::class,
        'renamed' => ContactRenamedEvent::class,
        'phoneAdded' => ContactPhoneAddedEvent::class,
        'phoneRemoved' => ContactPhoneRemovedEvent::class,
        'changedAddress' => ContactChangedAddressEvent::class,
        'changedWebsite' => ContactChangedWebsiteEvent::class,
    ];

    private static array $events = [];

    public static function recordEvent(Contact $contact, string $eventName, ...$params): void
    {
        $className = self::EVENTS[$eventName] ?? throw new DomainException('Событие ' . $eventName . ' не найдено');
        self::$events[] = new $className($contact, ...$params);
    }

    public static function releaseEvents(): array
    {
        $events = self::$events;
        self::$events = [];

        return $events;
    }
}