<?php
declare(strict_types=1);

namespace Tests\PhoneBookBot\Domain\Contact\Entity;

use PHPUnit\Framework\Attributes\Depends;
use Sersid\PhoneBookBot\Domain\Category\Entity\Category;
use Sersid\PhoneBookBot\Domain\Category\Entity\Name as CategoryName;
use Sersid\PhoneBookBot\Domain\Contact\Entity\Contact;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;
use Sersid\PhoneBookBot\Domain\Contact\Event;
use Sersid\PhoneBookBot\Domain\Contact\Entity\Name;
use Sersid\PhoneBookBot\Domain\Contact\Entity\Status;
use Sersid\Shared\ValueObject\Uuid;
use function PHPUnit\Framework\assertInstanceOf;
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
        $category = new Category(
            Uuid::next(),
            new CategoryName('Управляющая компания')
        );
        $name = new Name('Паспортный стол');

        $contact = new Contact(uuid: $uuid, category: $category, name: $name);

        assertSame($uuid, $contact->getUuid());
        assertSame($category, $contact->getCategory());
        assertSame($name, $contact->getName());
        assertSame(Status::Enable, $contact->getStatus());

        return $contact;
    }

    #[TestDox('Тест создания события при создании контакта')]
    #[Depends('testCreate')]
    public function testEventOnCreated(Contact $contact): void
    {
        $events = $contact->releaseEvents();

        assertInstanceOf(Event\ContactCreatedEvent::class, end($events));
    }
    #[TestDox('Тест изменения категории')]
    #[Depends('testCreate')]
    public function testChangeCategory(Contact $contact): Contact
    {
        $category = new Category(Uuid::next(), new CategoryName('Новая категория'));

        $contact->changeCategory($category);

        assertSame($category, $contact->getCategory());

        return $contact;
    }

    #[TestDox('Тест создания события при изменении категории')]
    #[Depends('testChangeCategory')]
    public function testEventOnChangeCategory(Contact $contact): void
    {
        $events = $contact->releaseEvents();

        assertInstanceOf(Event\ContactChangedCategoryEvent::class, end($events));
    }
}
