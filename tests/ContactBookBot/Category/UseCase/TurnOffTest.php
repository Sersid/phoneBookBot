<?php
declare(strict_types=1);

namespace Tests\ContactBookBot\Category\UseCase;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\UsesClass;
use Sersid\ContactBookBot\Category\Domain\Entity\Status;
use Sersid\ContactBookBot\Category\Domain\Event\CategoryTurnedOffEvent;
use Sersid\ContactBookBot\Category\UseCase\TurnOff;
use function PHPUnit\Framework\assertSame;

#[CoversClass(TurnOff::class)]
#[TestDox('Тест use case: отключение категории')]
#[UsesClass(CategoryTurnedOffEvent::class)]
final class TurnOffTest extends CategoryTestCase
{
    public function test(): void
    {
        // assert
        $category = $this->categoryFixture->getTurnedOn();
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
                static fn(CategoryTurnedOffEvent $event) =>
                    $event->getCategory() === $category && $event->getOldStatus() === $oldStatus
            ));

        // act
        $this->get(TurnOff::class)->handle($uuid);

        // assert
        assertSame(Status::TurnedOff, $category->getStatus());
    }
}
