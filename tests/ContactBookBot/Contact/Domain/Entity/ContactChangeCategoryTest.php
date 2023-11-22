<?php
declare(strict_types=1);

namespace Tests\ContactBookBot\Contact\Domain\Entity;

use PHPUnit\Framework\Attributes\TestDox;
use Sersid\ContactBookBot\Category\Domain\Entity\Category;
use Sersid\ContactBookBot\Category\Domain\Entity\Name;
use Sersid\Shared\ValueObject\Uuid;
use function PHPUnit\Framework\assertSame;

#[TestDox('Тесты изменения категории контакта')]
final class ContactChangeCategoryTest extends ContactTestCase
{
    #[TestDox('Тест попытки изменения категории на такую же категорию')]
    public function testNoChangeCategory(): void
    {
        $category = new Category(
            new Uuid('f3190be0-ecd2-4cd0-bf09-9d999bd17620'),
            new Name('Управляющая компания')
        );

        $this->expectExceptionMessage('Категория не изменилась');

        self::$contact->changeCategory($category);
    }

    #[TestDox('Тест изменения категории')]
    public function testChangeCategory(): void
    {
        $category = new Category(Uuid::next(), new Name('Новая категория'));

        self::$contact->changeCategory($category);

        assertSame($category, self::$contact->getCategory());
    }
}