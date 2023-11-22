<?php
declare(strict_types=1);

namespace Tests\ContactBookBot\Contact\UseCase;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use Sersid\ContactBookBot\Category\Domain\Entity\Category;
use Sersid\ContactBookBot\Category\Domain\Entity\Name as CategoryName;
use Sersid\ContactBookBot\Contact\Domain\Entity\Contact;
use Sersid\ContactBookBot\Contact\Domain\Entity\Name;
use Sersid\ContactBookBot\Contact\Domain\Entity\Phone;
use Sersid\ContactBookBot\Contact\Domain\Entity\Phones;
use Sersid\ContactBookBot\Contact\Domain\Event\ContactPhoneRemovedEvent;
use Sersid\ContactBookBot\Contact\UseCase\RemovePhone;
use Sersid\Shared\ValueObject\Uuid;

#[CoversClass(RemovePhone::class)]
#[TestDox('Тест use case: удаление телефона')]
final class RemovePhoneTest extends ContactTestCase
{
    public function test(): void
    {
        // arrange
        $uuid = '8db2f70d-f9ac-428a-ab21-6d42653e99e9';
        $index = 1;
        $phones = [
            new Phone('88005553535'),
            new Phone('222555'),
        ];
        $contact = new Contact(
            new Uuid($uuid),
            new Category(
                new Uuid('3fb7fe4b-77c6-4925-b958-f203c29adc34'),
                new CategoryName('Управляющая компания')
            ),
            new Name('Название контакта'),
            new Phones($phones)
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
                    static fn(ContactPhoneRemovedEvent $event) =>
                        $event->getContact() === $contact && $event->getPhone() === $phones[$index]
                )
            );

        // act
        $this->get(RemovePhone::class)->handle($uuid, $index);
    }
}
