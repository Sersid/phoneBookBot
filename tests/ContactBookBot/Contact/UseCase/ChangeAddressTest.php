<?php
declare(strict_types=1);

namespace Tests\ContactBookBot\Contact\UseCase;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use Sersid\ContactBookBot\Category\Domain\Entity\Category;
use Sersid\ContactBookBot\Category\Domain\Entity\Name as CategoryName;
use Sersid\ContactBookBot\Contact\Domain\Entity\Address;
use Sersid\ContactBookBot\Contact\Domain\Entity\Contact;
use Sersid\ContactBookBot\Contact\Domain\Entity\MapLocation;
use Sersid\ContactBookBot\Contact\Domain\Entity\Name;
use Sersid\ContactBookBot\Contact\Domain\Event\ContactChangedAddressEvent;
use Sersid\ContactBookBot\Contact\UseCase\ChangeAddress;
use Sersid\Shared\ValueObject\Uuid;
use function PHPUnit\Framework\assertEquals;

#[CoversClass(ChangeAddress::class)]
#[TestDox('Тест use case: изменение адреса контакта')]
final class ChangeAddressTest extends ContactTestCase
{
    public function test(): void
    {
        // arrange
        $uuid = '8db2f70d-f9ac-428a-ab21-6d42653e99e9';
        $address = 'ул. Пушкина, д. 1';
        $lat = 51.6607;
        $lon = 39.2003;
        $oldAddress = new Address('ул. Вл. Невского, 12');
        $contact = new Contact(
            new Uuid($uuid),
            new Category(
                new Uuid('3fb7fe4b-77c6-4925-b958-f203c29adc34'),
                new CategoryName('Управляющая компания')
            ),
            new Name('Название контакта'),
            address: $oldAddress,
        );

        // assert
        $this->contactRepository
            ->expects(self::once())
            ->method('getByUuid')
            ->with(self::equalTo(new Uuid($uuid)))
            ->willReturn($contact);
        $this->contactRepository
            ->expects(self::once())
            ->method('update');
        $this->eventDispatcher
            ->expects(self::once())
            ->method('dispatch')
            ->with(
                self::callback(
                    static fn(ContactChangedAddressEvent $event) =>
                        $event->getContact() === $contact
                        && $event->getOldAddress() === $oldAddress
                )
            );

        // act
        $this->get(ChangeAddress::class)->handle($uuid, $address, $lat, $lon);

        // assert
        assertEquals(new Address($address, new MapLocation($lat, $lon)), $contact->getAddress());
    }
}
