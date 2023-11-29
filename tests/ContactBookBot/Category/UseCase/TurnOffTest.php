<?php
declare(strict_types=1);

namespace Tests\ContactBookBot\Category\UseCase;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\UsesClass;
use Sersid\ContactBookBot\Category\Domain\Entity\Category;
use Sersid\ContactBookBot\Category\Domain\Entity\Name;
use Sersid\ContactBookBot\Category\Domain\Entity\Status;
use Sersid\ContactBookBot\Category\Domain\Event\CategoryTurnedOffEvent;
use Sersid\ContactBookBot\Category\UseCase\TurnOff;
use Sersid\Shared\ValueObject\Uuid;

#[CoversClass(TurnOff::class)]
#[TestDox('Тест use case: отключение категории')]
#[UsesClass(CategoryTurnedOffEvent::class)]
final class TurnOffTest extends CategoryTestCase
{
    public function test(): void
    {
        // assert
        $uuid = '3fb7fe4b-77c6-4925-b958-f203c29adc34';
        $category = new Category(
            new Uuid($uuid),
            new Name('Управляющая компания'),
            Status::TurnedOn,
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
                static fn(CategoryTurnedOffEvent $event) =>
                    $event->getCategory() === $category && $event->getOldStatus() === $oldStatus
            ));

        // act
        $this->get(TurnOff::class)->handle($uuid);
    }
}
