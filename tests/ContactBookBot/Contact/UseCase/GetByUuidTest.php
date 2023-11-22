<?php
declare(strict_types=1);

namespace Tests\ContactBookBot\Contact\UseCase;

use Sersid\ContactBookBot\Category\Domain\Entity\Category;
use Sersid\ContactBookBot\Category\Domain\Entity\Name as ContactName;
use Sersid\ContactBookBot\Contact\Domain\Entity\Contact;
use Sersid\ContactBookBot\Contact\Domain\Entity\Name;
use Sersid\ContactBookBot\Contact\UseCase\GetByUuid;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;
use Sersid\Shared\ValueObject\Uuid;

#[CoversClass(GetByUuid::class)]
#[TestDox('Тест use case: получение контакта по uuid')]
final class GetByUuidTest extends ContactTestCase
{
    public function test(): void
    {
        // arrange
        $uuid = '8db2f70d-f9ac-428a-ab21-6d42653e99e9';
        $contact = new Contact(
            new Uuid($uuid),
            new Category(
                new Uuid('3fb7fe4b-77c6-4925-b958-f203c29adc34'),
                new ContactName('Управляющая компания')
            ),
            new Name('Название контакта'),
        );

        // assert
        $this->contactRepository
            ->expects(self::once())
            ->method('getByUuid')
            ->with(self::equalTo(new Uuid($uuid)))
            ->willReturn($contact);

        // act
        $this->get(GetByUuid::class)->handle($uuid);
    }
}
