<?php
declare(strict_types=1);

namespace Tests\ContactBookBot\Contact\UseCase;

use Sersid\ContactBookBot\Category\Domain\Entity\Category;
use Sersid\ContactBookBot\Category\Domain\Entity\Name;
use Sersid\ContactBookBot\Contact\Domain\Entity\Contact;
use Sersid\ContactBookBot\Contact\Domain\Event\ContactCreatedEvent;
use Sersid\ContactBookBot\Contact\UseCase\Create;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use Sersid\Shared\ValueObject\Uuid;

#[CoversClass(Create::class)]
#[TestDox('Тест use case: создание контакта')]
final class CreateTest extends ContactTestCase
{
    public function test(): void
    {
        // arrange
        $categoryUuid = '3fb7fe4b-77c6-4925-b958-f203c29adc34';
        $name = 'Название контакта';

        // assert
        $this->categoryRepository
            ->expects(self::once())
            ->method('getByUuid')
            ->willReturn(new Category(new Uuid($categoryUuid), new Name('Управляющая компания')));
        $this->contactRepository->expects(self::once())
            ->method('add')
            ->with(
                self::callback(
                    static fn(Contact $contact) =>
                        $categoryUuid === $contact->getCategory()->getUuid()->getValue()
                        && $name === $contact->getName()->getValue()
                )
            );
        $this->eventDispatcher
            ->expects(self::once())
            ->method('dispatch')
            ->with(self::isInstanceOf(ContactCreatedEvent::class));

        // act
        $this->get(Create::class)->handle($categoryUuid, $name);
    }
}
