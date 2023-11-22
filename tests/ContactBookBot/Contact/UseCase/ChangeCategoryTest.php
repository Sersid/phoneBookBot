<?php
declare(strict_types=1);

namespace Tests\ContactBookBot\Contact\UseCase;

use Sersid\ContactBookBot\Category\Domain\Entity\Category;
use Sersid\ContactBookBot\Category\Domain\Entity\Name as CategoryName;
use Sersid\ContactBookBot\Contact\Domain\Entity\Contact;
use Sersid\ContactBookBot\Contact\Domain\Entity\Name;
use Sersid\ContactBookBot\Contact\Domain\Event\ContactChangedCategoryEvent;
use Sersid\ContactBookBot\Contact\UseCase\ChangeCategory;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use Sersid\Shared\ValueObject\Uuid;

#[CoversClass(ChangeCategory::class)]
#[TestDox('Тест use case: изменение категории контакта')]
final class ChangeCategoryTest extends ContactTestCase
{
    public function test(): void
    {
        // arrange
        $uuid = '8db2f70d-f9ac-428a-ab21-6d42653e99e9';
        $categoryUuid = 'f3190be0-ecd2-4cd0-bf09-9d999bd17620';
        $contact = new Contact(
            new Uuid($uuid),
            new Category(
                new Uuid('3fb7fe4b-77c6-4925-b958-f203c29adc34'),
                new CategoryName('Управляющая компания')
            ),
            new Name('Название контакта'),
        );
        $oldCategory = $contact->getCategory();

        // assert
        $this->contactRepository
            ->expects(self::once())
            ->method('getByUuid')
            ->with(self::equalTo(new Uuid($uuid)))
            ->willReturn($contact);
        $this->categoryRepository
            ->expects(self::once())
            ->method('getByUuid')
            ->with(self::equalTo(new Uuid($categoryUuid)))
            ->willReturn(
                new Category(
                    new Uuid($categoryUuid),
                    new CategoryName('Название категории')
                )
            );
        $this->contactRepository
            ->expects(self::once())
            ->method('update');
        $this->eventDispatcher->expects(self::once())
            ->method('dispatch')
            ->with(
                self::callback(
                    static fn(ContactChangedCategoryEvent $event) =>
                        $event->getContact() === $contact && $event->getOldCategory() === $oldCategory
                )
            );

        // act
        $this->get(ChangeCategory::class)->handle($uuid, $categoryUuid);
    }
}
