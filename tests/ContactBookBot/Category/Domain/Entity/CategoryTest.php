<?php
declare(strict_types=1);

namespace Tests\ContactBookBot\Category\Domain\Entity;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;
use Sersid\ContactBookBot\Category\Domain\Entity\Category;
use Sersid\ContactBookBot\Category\Domain\Entity\Name;
use Sersid\ContactBookBot\Category\Domain\Entity\Status;
use Sersid\Shared\ValueObject\Uuid;
use Tests\ContactBookBot\Category\CategoryFixture;
use function PHPUnit\Framework\assertSame;

#[TestDox('Тесты категории')]
#[CoversClass(Category::class)]
final class CategoryTest extends TestCase
{
    protected CategoryFixture $categoryFixture;

    protected function setUp(): void
    {
        parent::setUp();
        $this->categoryFixture = new CategoryFixture();
    }

    #[TestDox('Тест создания категории')]
    public function testCreate(): void
    {
        $uuid = Uuid::next();
        $name = new Name('Управляющая компания');
        $status = Status::TurnedOn;

        $category = new Category(uuid: $uuid, name: $name, status: $status);

        assertSame($uuid, $category->getUuid());
        assertSame($name, $category->getName());
        assertSame($status, $category->getStatus());
    }

    #[TestDox('Тест попытки переименовать категорию в то же название')]
    public function testNotRename(): void
    {
        $name = new Name('Управляющая компания');
        $category = $this->categoryFixture->getWithName($name);

        $this->expectExceptionMessage('Название категории не изменилось');

        $category->rename($name);
    }

    #[TestDox('Тест переименования категории')]
    public function testRename(): void
    {
        $category = $this->categoryFixture->getDefault();
        $name = new Name('Новое название категории');

        $category->rename($name);

        assertSame($name, $category->getName());
    }

    #[TestDox('Тест отключения категории')]
    public function testTurnOff(): void
    {
        $category = $this->categoryFixture->getTurnedOn();

        $category->turnOff();

        assertSame(Status::TurnedOff, $category->getStatus());
    }

    #[TestDox('Тест попытки повторного отключения категории')]
    public function testEventOnTurnedOffAgain(): void
    {
        $category = $this->categoryFixture->getTurnedOff();

        $this->expectExceptionMessage('Категория уже выключена');

        $category->turnOff();
    }

    #[TestDox('Тест включения категории')]
    public function testTurnOn(): void
    {
        $category = $this->categoryFixture->getTurnedOff();

        $category->turnOn();

        assertSame(Status::TurnedOn, $category->getStatus());
    }

    #[TestDox('Тест попытки повторного включения категории')]
    public function testEventOnTurnedOnAgain(): void
    {
        $category = $this->categoryFixture->getTurnedOn();

        $this->expectExceptionMessage('Категория уже включена');

        $category->turnOn();
    }
}
