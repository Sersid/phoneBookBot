<?php
declare(strict_types=1);

namespace Tests\ContactBookBot\Domain\Contact\Entity;

use PHPUnit\Framework\Attributes\Depends;
use PHPUnit\Framework\Attributes\TestDox;
use Sersid\ContactBookBot\Domain\Contact\Entity\Address;
use Sersid\ContactBookBot\Domain\Contact\Entity\Phone;
use Sersid\ContactBookBot\Domain\Contact\Event;
use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertNotSame;
use function PHPUnit\Framework\assertSame;

#[TestDox('Тесты изменения телефонов контакта')]
final class ContactChangePhonesTest extends ContactTestCase
{
    #[TestDox('Тест добавления телефона')]
    public function testAddPhone(): void
    {
        $phone = new Phone('88005553535');

        self::$contact->releaseEvents();
        self::$contact->addPhone($phone);

        self::assertSame($phone, self::$phones[0]);
    }

    #[TestDox('Тест создания события при добавлении телефона')]
    #[Depends('testAddPhone')]
    public function testEventOnAddPhone(): void
    {
        /** @var Event\ContactPhoneAddedEvent $event */
        $event = self::$contact->releaseEvents()[0];

        assertInstanceOf(Event\ContactPhoneAddedEvent::class, $event);
        assertSame(self::$contact, $event->getContact());
        assertSame(self::$phones[0], $event->getPhone());
    }

    #[TestDox('Тест попытки изменить адрес без изменения содержимого адреса')]
    public function testNoChangeAddress(): void
    {
        $address = new Address();

        self::$contact->changeAddress($address);

        assertNotSame(self::$contact->getAddress(), $address);
        assertSame([], self::$contact->releaseEvents());
    }
}