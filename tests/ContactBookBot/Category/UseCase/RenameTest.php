<?php
declare(strict_types=1);

namespace Tests\ContactBookBot\Category\UseCase;

use Sersid\ContactBookBot\Category\Domain\Entity\Category;
use Sersid\ContactBookBot\Category\Domain\Entity\Name;
use Sersid\ContactBookBot\Category\Domain\Entity\Status;
use Sersid\ContactBookBot\Category\Domain\Event\CategoryRenamedEvent;
use Sersid\ContactBookBot\Category\UseCase\Rename;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use Sersid\Shared\ValueObject\Uuid;

#[CoversClass(Rename::class)]
#[TestDox('Тест use case: переименование категории')]
final class RenameTest extends CategoryTestCase
{
    public function test(): void
    {
        // assert
        $uuid = '3fb7fe4b-77c6-4925-b958-f203c29adc34';
        $name = 'Новое название категории';
        $category = new Category(
            new Uuid($uuid),
            new Name('Предыдущее название категории'),
            Status::TurnedOn,
        );
        $oldName = $category->getName();

        // assert
        $this->categoryRepository
            ->expects(self::once())
            ->method('getByUuid')
            ->with(self::equalTo($category->getUuid()))
            ->willReturn($category);
        $this->categoryRepository
            ->expects(self::once())
            ->method('update')
            ->with(self::equalTo($category));
        $this->eventDispatcher
            ->expects(self::once())
            ->method('dispatch')
            ->with(self::callback(
                static fn(CategoryRenamedEvent $event) =>
                    $event->getCategory() === $category && $event->getOldName() === $oldName
            ));

        // act
        $this->get(Rename::class)->handle($uuid, $name);
    }
}
