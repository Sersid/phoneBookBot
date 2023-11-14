<?php
declare(strict_types=1);

namespace Tests\PhoneBookBot\Domain\Contact\Entity;

use Sersid\PhoneBookBot\Domain\Contact\Entity\Contact;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;
use Sersid\PhoneBookBot\Domain\Contact\Entity\Name;
use Sersid\PhoneBookBot\Domain\Contact\Entity\Status;
use Sersid\Shared\ValueObject\Uuid;
use function PHPUnit\Framework\assertSame;

/**
 * @covers Contact
 */
final class ContactTest extends TestCase
{
    #[TestDox('Тест создания контакта')]
    public function testCreate(): Contact
    {
        $uuid = Uuid::next();
        $name = new Name('Сантехник');

        $contact = new Contact($uuid, $name);

        assertSame($uuid, $contact->getUuid());
        assertSame($name, $contact->getName());
        assertSame(Status::Enable, $contact->getStatus());

        return $contact;
    }
}