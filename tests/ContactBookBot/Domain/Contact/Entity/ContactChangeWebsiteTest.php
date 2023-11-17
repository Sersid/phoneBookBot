<?php
declare(strict_types=1);

namespace Tests\ContactBookBot\Domain\Contact\Entity;

use PHPUnit\Framework\Attributes\Depends;
use PHPUnit\Framework\Attributes\TestDox;
use Sersid\ContactBookBot\Domain\Contact\Entity\Website;
use Sersid\ContactBookBot\Domain\Contact\Event;
use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertSame;

#[TestDox('Тесты изменения вебсайта контакта')]
final class ContactChangeWebsiteTest extends ContactTestCase
{
    #[TestDox('Тест изменения вебсайта')]
    public function testChangeWebsite(): void
    {
        $website = new Website('www.website.com');

        self::$contact->releaseEvents();
        self::$contact->changeWebsite($website);

        assertSame(self::$contact->getWebsite(), $website);
    }

    #[TestDox('Тест создания события при изменении вебсайта')]
    #[Depends('testChangeWebsite')]
    public function testEventOnChangeWebsite(): void
    {
        /** @var Event\ContactChangedWebsiteEvent $event */
        $event = self::$contact->releaseEvents()[0];

        assertInstanceOf(Event\ContactChangedWebsiteEvent::class, $event);
        assertSame(self::$contact, $event->getContact());
        assertSame(self::$website, $event->getOldWebsite());
    }
}