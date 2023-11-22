<?php
declare(strict_types=1);

namespace Tests\ContactBookBot\Category\UseCase;

use Sersid\ContactBookBot\Category\Domain\Entity\Category;
use Sersid\ContactBookBot\Category\Domain\Entity\Name;
use Sersid\ContactBookBot\Category\Domain\Entity\Status;
use Sersid\ContactBookBot\Category\Domain\Event\CategoryTurnedOnEvent;
use Sersid\ContactBookBot\Category\UseCase\TurnOn;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use Sersid\Shared\ValueObject\Uuid;

#[CoversClass(TurnOn::class)]
#[TestDox('Тест use case: включение категории')]
final class TurnOnTest extends CategoryTestCase
{
    public function test(): void
    {
        // assert
        $uuid = '3fb7fe4b-77c6-4925-b958-f203c29adc34';
        $category = new Category(
            new Uuid($uuid),
            new Name('Управляющая компания'),
            Status::TurnedOff,
        );
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
