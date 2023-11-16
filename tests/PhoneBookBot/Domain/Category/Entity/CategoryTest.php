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
        self::$status = Status::Enable;

        self::$category = new Category(uuid: self::$uuid, name: self::$name, status: self::$status);
    }

    #[TestDox('Тест создания категории')]
    public function testCreate(): void
    {
        assertSame(self::$uuid, self::$category->getUuid());
        assertSame(self::$name, self::$category->getName());
        assertSame(Status::Enable, self::$category->getStatus());
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
    public function testDisable(): void
    {
        self::$category->disable();

        assertSame(Status::Disable, self::$category->getStatus());
    }

    #[TestDox('Тест создания события при отключении категории')]
    public function testEventOnDisabled(): void
    {
        /** @var Event\CategoryDisabledEvent $event */
        $event = self::$category->releaseEvents()[0];

        assertInstanceOf(Event\CategoryDisabledEvent::class, $event);
        assertSame(self::$category, $event->getCategory());
        assertSame(Status::Enable, $event->getOldStatus());
    }

    #[TestDox('Тест попытки повторного отключения категории')]
    public function testEventOnDisableAgain(): void
    {
        self::$category->disable();

        assertSame([], self::$category->releaseEvents());
    }

    #[TestDox('Тест включения категории')]
    public function testEnable(): void
    {
        self::$category->enable();

        assertSame(Status::Enable, self::$category->getStatus());
    }

    #[TestDox('Тест создания события при включении категории')]
    public function testEventOnEnabled(): void
    {
        /** @var Event\CategoryEnabledEvent $event */
        $event = self::$category->releaseEvents()[0];

        assertInstanceOf(Event\CategoryEnabledEvent::class, $event);
        assertSame(self::$category, $event->getCategory());
        assertSame(Status::Disable, $event->getOldStatus());
    }

    #[TestDox('Тест попытки повторного включения категории')]
    public function testEventOnEnableAgain(): void
    {
        self::$category->enable();

        assertSame([], self::$category->releaseEvents());
    }
}
