<?php
declare(strict_types=1);

namespace Tests\PhoneBookBot\Domain\Category\Entity;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;
use Sersid\PhoneBookBot\Domain\Category\Entity\Category;
use Sersid\PhoneBookBot\Domain\Category\Entity\Name;
use Sersid\PhoneBookBot\Domain\Category\Entity\Status;
use Sersid\PhoneBookBot\Domain\Category\Event;
use Sersid\Shared\ValueObject\Uuid;
use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertNotSame;
use function PHPUnit\Framework\assertSame;

#[TestDox('Тесты категории')]
#[CoversClass(Category::class)]
final class CategoryTest extends TestCase
{
    private static Uuid $uuid;
    private static Name $name;
    private static Status $status;
    private static Category $category;

    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();

        self::$uuid = Uuid::next();
        self::$name = new Name('Управляющая компания');
        self::$status = Status::TurnedOn;

        self::$category = new Category(uuid: self::$uuid, name: self::$name, status: self::$status);
    }

    #[TestDox('Тест создания категории')]
    public function testCreate(): void
    {
        assertSame(self::$uuid, self::$category->getUuid());
        assertSame(self::$name, self::$category->getName());
        assertSame(Status::TurnedOn, self::$category->getStatus());
    }

    #[TestDox('Тест создания события при создании категории')]
    public function testEventOnCreated(): void
    {
        /** @var Event\CategoryCreatedEvent $event */
        $event = self::$category->releaseEvents()[0];

        assertInstanceOf(Event\CategoryCreatedEvent::class, $event);
        assertSame(self::$category, $event->getCategory());
    }

    #[TestDox('Тест попытки переименовать категорию в то же название')]
    public function testNotRename(): void
    {
        $name = new Name('Управляющая компания');

        self::$category->rename($name);

        assertNotSame($name, self::$category->getName());
    }

    #[TestDox('Тест переименования категории')]
    public function testRename(): void
    {
        $name = new Name('Новое название категории');

        self::$category->rename($name);

        assertSame($name, self::$category->getName());
    }

    #[TestDox('Тест создания события при переименовании категории')]
    public function testEventOnRenamed(): void
    {
        /** @var Event\CategoryRenamedEvent $event */
        $event = self::$category->releaseEvents()[0];

        assertInstanceOf(Event\CategoryRenamedEvent::class, $event);
        assertSame(self::$category, $event->getCategory());
        assertSame(self::$name, $event->getOldName());
    }

    #[TestDox('Тест отключения категории')]
    public function testTurnOff(): void
    {
        self::$category->turnOff();

        assertSame(Status::TurnedOff, self::$category->getStatus());
    }

    #[TestDox('Тест создания события при отключении категории')]
    public function testEventOnTurnedOff(): void
    {
        /** @var Event\CategoryTurnedOffEvent $event */
        $event = self::$category->releaseEvents()[0];

        assertInstanceOf(Event\CategoryTurnedOffEvent::class, $event);
        assertSame(self::$category, $event->getCategory());
        assertSame(Status::TurnedOn, $event->getOldStatus());
    }

    #[TestDox('Тест попытки повторного отключения категории')]
    public function testEventOnTurnedOffAgain(): void
    {
        self::$category->turnOff();

        assertSame([], self::$category->releaseEvents());
    }

    #[TestDox('Тест включения категории')]
    public function testTurnOn(): void
    {
        self::$category->turnOn();

        assertSame(Status::TurnedOn, self::$category->getStatus());
    }

    #[TestDox('Тест создания события при включении категории')]
    public function testEventOnTurnedOn(): void
    {
        /** @var Event\CategoryTurnedOnEvent $event */
        $event = self::$category->releaseEvents()[0];

        assertInstanceOf(Event\CategoryTurnedOnEvent::class, $event);
        assertSame(self::$category, $event->getCategory());
        assertSame(Status::TurnedOff, $event->getOldStatus());
    }

    #[TestDox('Тест попытки повторного включения категории')]
    public function testEventOnTurnedOnAgain(): void
    {
        self::$category->turnOn();

        assertSame([], self::$category->releaseEvents());
    }
}
