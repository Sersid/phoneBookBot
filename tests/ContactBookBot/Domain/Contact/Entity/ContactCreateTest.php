<?php
declare(strict_types=1);

namespace Tests\ContactBookBot\Domain\Contact\Entity;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Depends;
use Sersid\ContactBookBot\Domain\Contact\Entity\Contact;
use PHPUnit\Framework\Attributes\TestDox;
use Sersid\ContactBookBot\Domain\Contact\Event;
use Sersid\ContactBookBot\Domain\Contact\Entity\Status;
use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertSame;

#[CoversClass(Contact::class)]
#[TestDox('Тесты создания контакта')]
final class ContactCreateTest extends ContactTestCase
{
    #[TestDox('Тест создания контакта')]
    public function testCreate(): void
    {
        assertSame(self::$uuid, self::$contact->getUuid());
        assertSame(self::$category, self::$contact->getCategory());
        assertSame(self::$name, self::$contact->getName());
        assertSame(Status::Draft, self::$contact->getStatus());
    }

    #[TestDox('Тест создания события при создании контакта')]
    #[Depends('testCreate')]
    public function testEventOnCreated(): void
    {
        /** @var Event\ContactCreatedEvent $event */
        $event = self::$contact->releaseEvents()[0];

        assertInstanceOf(Event\ContactCreatedEvent::class, $event);
        assertSame(self::$contact, $event->getContact());
    }
}
