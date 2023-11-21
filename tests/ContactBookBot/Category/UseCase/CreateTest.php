<?php
declare(strict_types=1);

namespace Tests\ContactBookBot\Category\UseCase;

use Sersid\ContactBookBot\Category\Domain\Entity\Category;
use Sersid\ContactBookBot\Category\Domain\Event\CategoryCreatedEvent;
use Sersid\ContactBookBot\Category\UseCase\Create;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;

#[CoversClass(Create::class)]
#[TestDox('Тест use case: создание категории')]
final class CreateTest extends CategoryTestCase
{
    public function test(): void
    {
        // arrange
        $name = 'Новая категория';

        // assert
        $this->categoryRepository
            ->expects(self::once())
            ->method('add')
            ->with(self::callback(static fn(Category $category) => $name === $category->getName()->getValue()));
        $this->eventDispatcher
            ->expects(self::once())
            ->method('dispatch')
            ->with(self::isInstanceOf(CategoryCreatedEvent::class));

        // act
        $this->get(Create::class)->handle($name);
    }
}
