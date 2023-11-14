<?php
declare(strict_types=1);

namespace Tests\PhoneBookBot\Domain\Category\Entity;

use PHPUnit\Framework\Attributes\Depends;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;
use Sersid\PhoneBookBot\Domain\Category\Entity\Category;
use Sersid\PhoneBookBot\Domain\Category\Entity\Name;
use Sersid\PhoneBookBot\Domain\Category\Entity\Status;
use Sersid\PhoneBookBot\Domain\Category\Event;
use Sersid\Shared\ValueObject\Uuid;
use function PHPUnit\Framework\assertFalse;
use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertNotSame;
use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertTrue;

/**
 * @covers Category
 */
final class CategoryTest extends TestCase
{
    #[TestDox('Тест создания категории')]
    public function testCreate(): Category
    {
        $uuid = Uuid::next();
        $name = new Name('Управляющая компания');
        $status = Status::Enable;

        $category = new Category($uuid, $name, $status);

        assertSame($uuid, $category->getUuid());
        assertSame($name, $category->getName());
        assertSame(Status::Enable, $category->getStatus());
        assertTrue($category->isEnable());
        assertFalse($category->isDisable());

        return $category;
    }

    #[TestDox('Тест создания события при создании категории')]
    #[Depends('testCreate')]
    public function testEventOnCreated(Category $category): void
    {
        $events = $category->releaseEvents();

        assertInstanceOf(Event\CategoryCreatedEvent::class, end($events));
    }

    #[TestDox('Тест попытки переименовать категорию в то же название')]
    #[Depends('testCreate')]
    public function testNotRename(Category $category): void
    {
        $name = new Name('Управляющая компания');

        $category->rename($name);

        assertNotSame($name, $category->getName());
    }

    #[TestDox('Тест переименования категорию')]
    #[Depends('testCreate')]
    public function testRename(Category $category): Category
    {
        $name = new Name('Новое название категории');

        $category->rename($name);

        assertSame($name, $category->getName());

        return $category;
    }

    #[TestDox('Тест создания события при переименовании категории')]
    #[Depends('testRename')]
    public function testEventOnRenamed(Category $category): Category
    {
        $events = $category->releaseEvents();

        assertInstanceOf(Event\CategoryRenamedEvent::class, end($events));

        return $category;
    }

    #[TestDox('Тест отключения категории')]
    #[Depends('testEventOnRenamed')]
    public function testDisable(Category $category): Category
    {
        $category->disable();

        assertFalse($category->isEnable());
        assertTrue($category->isDisable());

        return $category;
    }

    #[TestDox('Тест создания события при отключении категории')]
    #[Depends('testDisable')]
    public function testEventOnDisabled(Category $category): Category
    {
        $events = $category->releaseEvents();

        assertInstanceOf(Event\CategoryDisabledEvent::class, end($events));

        return $category;
    }

    #[TestDox('Тест попытки повторного отключения категории')]
    #[Depends('testEventOnDisabled')]
    public function testEventOnDisableAgain(Category $category): void
    {
        $category->disable();
        $events = $category->releaseEvents();

        assertSame([], $events);
    }

    #[TestDox('Тест включения категории')]
    #[Depends('testDisable')]
    public function testEnable(Category $category): Category
    {
        $category->enable();

        assertTrue($category->isEnable());
        assertFalse($category->isDisable());

        return $category;
    }

    #[TestDox('Тест создания события при включении категории')]
    #[Depends('testEnable')]
    public function testEventOnEnabled(Category $category): Category
    {
        $events = $category->releaseEvents();

        assertInstanceOf(Event\CategoryEnabledEvent::class, end($events));

        return $category;
    }

    #[TestDox('Тест попытки повторного включения категории')]
    #[Depends('testEventOnEnabled')]
    public function testEventOnEnableAgain(Category $category): void
    {
        $category->enable();
        $events = $category->releaseEvents();

        assertSame([], $events);
    }
}
