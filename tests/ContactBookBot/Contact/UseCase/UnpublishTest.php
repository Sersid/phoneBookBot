<?php
declare(strict_types=1);

namespace Tests\ContactBookBot\Contact\UseCase;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use Sersid\ContactBookBot\Category\Domain\Entity\Category;
use Sersid\ContactBookBot\Category\Domain\Entity\Name as CategoryName;
use Sersid\ContactBookBot\Contact\Domain\Entity\Contact;
use Sersid\ContactBookBot\Contact\Domain\Entity\Name;
use Sersid\ContactBookBot\Contact\Domain\Entity\Status;
use Sersid\ContactBookBot\Contact\Domain\Event\ContactUnpublishedEvent;
use Sersid\ContactBookBot\Contact\UseCase\Unpublish;
use Sersid\Shared\ValueObject\Uuid;
use function PHPUnit\Framework\assertSame;

#[CoversClass(Unpublish::class)]
#[TestDox('Тест use case: снятие с публикации')]
final class UnpublishTest extends ContactTestCase
{
    public function test(): void
    {
        // arrange
        $uuid = '8db2f70d-f9ac-428a-ab21-6d42653e99e9';
        $contact = new Contact(
            uuid: new Uuid($uuid),
            category: new Category(
                new Uuid('3fb7fe4b-77c6-4925-b958-f203c29adc34'),
                new CategoryName('Управляющая компания')
            ),
            name: new Name('Название контакта'),
            status: Status::Draft,
        );
        $oldStatus = $contact->getStatus();

        // assert
        $this->contactRepository
            ->expects(self::once())
            ->method('getByUuid')
            ->with(self::equalTo(new Uuid($uuid)))
            ->willReturn($contact);
        $this->contactRepository
            ->expects(self::once())
            ->method('update');
        $this->eventDispatcher->expects(self::once())
            ->method('dispatch')
            ->with(
                self::callback(
                    static fn(ContactUnpublishedEvent $event) =>
                        $event->getContact() === $contact && $event->getOldStatus() === $oldStatus
                )
            );

        // act
        $this->get(Unpublish::class)->handle($uuid);

        // assert
        assertSame(Status::Unpublished, $contact->getStatus());
    }
}
