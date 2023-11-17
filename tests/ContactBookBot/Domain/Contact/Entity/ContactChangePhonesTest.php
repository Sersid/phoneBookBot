<?php
declare(strict_types=1);

namespace Tests\ContactBookBot\Domain\Contact\Entity;

use PHPUnit\Framework\Attributes\Depends;
use PHPUnit\Framework\Attributes\TestDox;
use Sersid\ContactBookBot\Domain\Contact\Entity\Phone;
use Sersid\ContactBookBot\Domain\Contact\Event;
use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertTrue;

#[TestDox('Тесты изменения телефонов контакта')]
final class ContactChangePhonesTest extends ContactTestCase
{
    private static Phone $phone;

    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();
        self::$phone = new Phone('88005553535');
    }

    #[TestDox('Тест добавления телефона')]
    public function testAddPhone(): void
    {
        self::$contact->releaseEvents();
        self::$contact->addPhone(self::$phone);

        self::assertSame(self::$phone, self::$phones[0]);
    }

    #[TestDox('Тест создания события при добавлении телефона')]
    #[Depends('testAddPhone')]
    public function testEventOnAddPhone(): void
    {
        /** @var Event\ContactPhoneAddedEvent $event */
        $event = self::$contact->releaseEvents()[0];

        assertInstanceOf(Event\ContactPhoneAddedEvent::class, $event);
        assertSame(self::$contact, $event->getContact());
        assertSame(self::$phone, $event->getPhone());
    }

    #[TestDox('Тест удаления телефона')]
    public function testRemovePhone(): void
    {
        self::$contact->removePhone(0);

        assertTrue(self::$contact->getPhones()->isEmpty());
    }

    #[TestDox('Тест создания события при удалении телефона')]
    #[Depends('testRemovePhone')]
    public function testEventOnRemovePhone(): void
    {
        /** @var Event\ContactPhoneRemovedEvent $event */
        $event = self::$contact->releaseEvents()[0];

        assertInstanceOf(Event\ContactPhoneRemovedEvent::class, $event);
        assertSame(self::$contact, $event->getContact());
        assertSame(self::$phone, $event->getPhone());
    }

    #[TestDox('Тест попытки удаления несуществующего телефона')]
    #[Depends('testRemovePhone')]
    public function testRemoveUndefinedPhone(): void
    {
        $this->expectExceptionMessage('Телефон не найден');

        self::$contact->removePhone(100);
    }
}