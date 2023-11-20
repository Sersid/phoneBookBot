<?php
declare(strict_types=1);

namespace Tests\ContactBookBot\Contact\Domain\Entity;

use PHPUnit\Framework\Attributes\Depends;
use PHPUnit\Framework\Attributes\TestDox;
use Sersid\ContactBookBot\Category\Domain\Entity\Category;
use Sersid\ContactBookBot\Contact\Domain\Event;
use Sersid\ContactBookBot\Category\Domain\Entity\Name;
use Sersid\Shared\ValueObject\Uuid;
use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertNotSame;
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

        self::$contact->releaseEvents();
        self::$contact->changeCategory($category);

        assertNotSame(self::$contact->getCategory(), $category);
        assertSame([], self::$contact->releaseEvents());
    }

    #[TestDox('Тест изменения категории')]
    public function testChangeCategory(): void
    {
        $category = new Category(Uuid::next(), new Name('Новая категория'));

        self::$contact->changeCategory($category);

        assertSame($category, self::$contact->getCategory());
    }

    #[TestDox('Тест создания события при изменении категории')]
    #[Depends('testChangeCategory')]
    public function testEventOnChangeCategory(): void
    {
        /** @var Event\ContactChangedCategoryEvent $event */
        $event = self::$contact->releaseEvents()[0];

        assertInstanceOf(Event\ContactChangedCategoryEvent::class, $event);
        assertSame(self::$contact, $event->getContact());
        assertSame(self::$category, $event->getOldCategory());
    }
}