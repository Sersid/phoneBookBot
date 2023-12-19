<?php
declare(strict_types=1);

namespace Tests\ContactBookBot\Category\UseCase;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\UsesClass;
use Sersid\ContactBookBot\Category\Domain\Event\CategoryTurnedOnEvent;
use Sersid\ContactBookBot\Category\UseCase\TurnOn;

#[CoversClass(TurnOn::class)]
#[UsesClass(CategoryTurnedOnEvent::class)]
#[TestDox('Тест use case: включение категории')]
final class TurnOnTest extends CategoryTestCase
{
    public function test(): void
    {
        // assert
        $category = $this->categoryFixture->getTurnedOff();
        $uuid = $category->getUuid()->getValue();
        $oldStatus = $category->getStatus();

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
                static fn(CategoryTurnedOnEvent $event) =>
                    $event->getCategory() === $category && $event->getOldStatus() === $oldStatus
            ));

        // act
        $this->get(TurnOn::class)->handle($uuid);
    }
}
