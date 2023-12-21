<?php
declare(strict_types=1);

namespace Tests\ContactBookBot\Category\UseCase;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\UsesClass;
use Sersid\ContactBookBot\Category\Domain\Event\CategoryRenamedEvent;
use Sersid\ContactBookBot\Category\UseCase\Rename;
use Sersid\Shared\ValueObject\Uuid;
use function PHPUnit\Framework\assertSame;

#[CoversClass(Rename::class)]
#[UsesClass(CategoryRenamedEvent::class)]
#[TestDox('Тест use case: переименование категории')]
final class RenameTest extends CategoryTestCase
{
    public function test(): void
    {
        // assert
        $uuid = '3fb7fe4b-77c6-4925-b958-f203c29adc34';
        $name = 'Новое название категории';
        $category = $this->categoryFixture->getWithUuid(new Uuid($uuid));
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

        // assert
        assertSame($name, $category->getName()->getValue());
    }
}
