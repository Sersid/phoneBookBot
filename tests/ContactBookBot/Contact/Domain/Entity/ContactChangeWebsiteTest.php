<?php
declare(strict_types=1);

namespace Tests\ContactBookBot\Contact\Domain\Entity;

use PHPUnit\Framework\Attributes\TestDox;
use Sersid\ContactBookBot\Contact\Domain\Entity\Website;
use function PHPUnit\Framework\assertSame;

#[TestDox('Тесты изменения вебсайта контакта')]
final class ContactChangeWebsiteTest extends ContactTestCase
{
    #[TestDox('Тест попытки изменить вебсайт на тот же')]
    public function testNoChangeWebsite(): void
    {
        $website = new Website();

        $this->expectExceptionMessage('Вебсайта контакта не изменился');

        self::$contact->changeWebsite($website);
    }

    #[TestDox('Тест изменения вебсайта')]
    public function testChangeWebsite(): void
    {
        $website = new Website('www.website.com');

        self::$contact->changeWebsite($website);

        assertSame(self::$contact->getWebsite(), $website);
    }
}