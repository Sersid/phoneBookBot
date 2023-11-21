<?php
declare(strict_types=1);

namespace Tests\ContactBookBot\Category\UseCase;

use Sersid\ContactBookBot\Category\Domain\Event\CategoryCreatedEvent;
use Sersid\ContactBookBot\Category\UseCase\Create;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use function PHPUnit\Framework\assertCount;
use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertSame;

#[CoversClass(Create::class)]
#[TestDox('Тест use case: создание категории')]
final class CreateTest extends CategoryUseCaseTestCase
{
    public function test(): void
    {
        $name = 'Новая категория';
        $categories = $this->repository->getAll();
        $expectedCategoriesCount = $categories->count() + 1;
        $events = $this->eventDispatcher->getAll();
        $expectedEventsCount = $events->count() + 1;

        $this->get(Create::class)->handle($name);

        assertCount($expectedCategoriesCount, $categories);
        assertCount($expectedEventsCount, $events);
        assertSame($name, $categories->last()->getName()->getValue());
        assertInstanceOf(CategoryCreatedEvent::class, $events->last());
        assertSame($categories->last(), $events->last()->getCategory());
    }
}
