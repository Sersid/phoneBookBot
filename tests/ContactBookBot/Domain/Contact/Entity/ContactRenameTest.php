<?php
declare(strict_types=1);

namespace Tests\ContactBookBot\Domain\Contact\Entity;

use PHPUnit\Framework\Attributes\Depends;
use PHPUnit\Framework\Attributes\TestDox;
use Sersid\ContactBookBot\Domain\Contact\Entity\Name;
use Sersid\ContactBookBot\Domain\Contact\Event;
use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertNotSame;
use function PHPUnit\Framework\assertSame;

#[TestDox('Тесты изменения названия контакта')]
final class ContactRenameTest extends ContactTestCase
{
    #[TestDox('Тест попытки переименовать контакт в то же имя')]
    public function testNoRename(): void
    {
        $newName = new Name();

        self::$contact->releaseEvents();
        self::$contact->rename($newName);

        assertNotSame(self::$contact->getName(), $newName);
        assertSame([], self::$contact->releaseEvents());
    }

    #[TestDox('Тест переименования контакта')]
    public function testRename(): void
    {
        $newName = new Name('Новое имя контакта');

        self::$contact->rename($newName);

        assertSame(self::$contact->getName(), $newName);
    }

    #[TestDox('Тест создания события при переименовании контакта')]
    #[Depends('testRename')]
    public function testEventOnRename(): void
    {
        /** @var Event\ContactRenamedEvent $event */
        $event = self::$contact->releaseEvents()[0];

        assertInstanceOf(Event\ContactRenamedEvent::class, $event);
        assertSame(self::$contact, $event->getContact());
        assertSame(self::$name, $event->getOldName());
    }
}