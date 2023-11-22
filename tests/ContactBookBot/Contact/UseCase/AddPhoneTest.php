<?php
declare(strict_types=1);

namespace Tests\ContactBookBot\Contact\UseCase;

use Sersid\ContactBookBot\Category\Domain\Entity\Category;
use Sersid\ContactBookBot\Category\Domain\Entity\Name as CategoryName;
use Sersid\ContactBookBot\Contact\Domain\Entity\Contact;
use Sersid\ContactBookBot\Contact\Domain\Entity\Name;
use Sersid\ContactBookBot\Contact\Domain\Event\ContactPhoneAddedEvent;
use Sersid\ContactBookBot\Contact\Domain\Event\ContactRenamedEvent;
use Sersid\ContactBookBot\Contact\UseCase\AddPhone;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use Sersid\Shared\ValueObject\Uuid;

#[CoversClass(AddPhone::class)]
#[TestDox('Тест use case: добавление телефона')]
final class AddPhoneTest extends ContactTestCase
{
    public function test(): void
    {
        // arrange
        $uuid = '8db2f70d-f9ac-428a-ab21-6d42653e99e9';
        $phoneName = 'Сантехник';
        $phoneNumber = '88005553535';
        $contact = new Contact(
            new Uuid($uuid),
            new Category(
                new Uuid('3fb7fe4b-77c6-4925-b958-f203c29adc34'),
                new CategoryName('Управляющая компания')
            ),
            new Name('Название контакта'),
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
                    static fn(ContactPhoneAddedEvent $event) =>
                        $event->getContact() === $contact
                        && $event->getPhone()->getName() === $phoneName
                        && $event->getPhone()->getNumber() === $phoneNumber
                )
            );

        // act
        $this->get(AddPhone::class)->handle($uuid, $phoneName, $phoneNumber);
    }
}
