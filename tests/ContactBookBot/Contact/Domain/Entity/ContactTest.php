<?php
declare(strict_types=1);

namespace Tests\ContactBookBot\Contact\Domain\Entity;

use PHPUnit\Framework\Attributes\CoversClass;
use Sersid\ContactBookBot\Contact\Domain\Entity\Contact;
use PHPUnit\Framework\Attributes\TestDox;
use Sersid\ContactBookBot\Contact\Domain\Entity\Status;
use function PHPUnit\Framework\assertSame;

#[CoversClass(Contact::class)]
#[TestDox('Тесты контакта')]
final class ContactTest extends ContactTestCase
{
    #[TestDox('Тест создания контакта')]
    public function testCreate(): void
    {
        assertSame(self::$uuid, self::$contact->getUuid());
        assertSame(self::$category, self::$contact->getCategory());
        assertSame(self::$name, self::$contact->getName());
        assertSame(Status::Draft, self::$contact->getStatus());
    }
}
